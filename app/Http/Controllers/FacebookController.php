<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class FacebookController extends Controller
{
    protected $guzzleClient;

    public function __construct()
    {
        // Configure Guzzle client with SSL verification disabled for local development
        $this->guzzleClient = new Client([
            'verify' => false,
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]
        ]);
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        try {
            Session::put('state', $state = Str::random(40));
            
            $facebook = Socialite::driver('facebook')
                ->setHttpClient($this->guzzleClient)
                ->stateless()
                ->scopes(['email', 'public_profile', 'pages_manage_posts', 'pages_read_engagement', 'pages_manage_metadata'])
                ->with([
                    'auth_type' => 'rerequest',
                    'display' => 'popup',
                    'state' => $state,
                    'response_type' => 'code'
                ]);

            Log::info('Redirecting to Facebook', [
                'scopes' => ['email', 'public_profile', 'pages_manage_posts', 'pages_read_engagement', 'pages_manage_metadata'],
                'state' => $state,
                'redirect_uri' => config('services.facebook.redirect')
            ]);

            return $facebook->redirect();

        } catch (Exception $e) {
            Log::error('Facebook redirect error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('login')
                ->with('error', 'Could not connect to Facebook: ' . $e->getMessage());
        }
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            Log::info('Facebook callback received', [
                'request' => $request->all(),
                'has_error' => $request->has('error'),
                'error' => $request->error,
                'error_description' => $request->error_description
            ]);

            if ($request->has('error')) {
                throw new Exception($request->error_description ?? $request->error);
            }

            if (!$request->has('code')) {
                throw new Exception('No authorization code provided');
            }

            $fbUser = Socialite::driver('facebook')
                ->setHttpClient($this->guzzleClient)
                ->stateless()
                ->user();

            Log::info('Facebook user data received', [
                'id' => $fbUser->id,
                'name' => $fbUser->name,
                'email' => $fbUser->email,
                'token_exists' => !empty($fbUser->token)
            ]);

            if (empty($fbUser->token)) {
                throw new Exception('No access token received from Facebook');
            }

            // First try to find user by Facebook ID
            $user = User::where('facebook_id', $fbUser->id)->first();

            // If not found by Facebook ID, try to find by email
            if (!$user) {
                $user = User::where('email', $fbUser->email)->first();
                
                // If user exists with this email but different Facebook ID, update the Facebook ID
                if ($user) {
                    $user->update([
                        'facebook_id' => $fbUser->id,
                        'facebook_token' => $fbUser->token
                    ]);
                } else {
                    // Create new user if not found
                    $user = User::create([
                        'facebook_id' => $fbUser->id,
                        'name' => $fbUser->name,
                        'email' => $fbUser->email,
                        'facebook_token' => $fbUser->token,
                        'password' => encrypt(Str::random(16))
                    ]);
                }
            } else {
                // Update existing user's token
                $user->update([
                    'facebook_token' => $fbUser->token
                ]);
            }

            Log::info('User authenticated', [
                'user_id' => $user->id,
                'is_new' => $user->wasRecentlyCreated
            ]);

            Auth::login($user, true);

            return redirect()
                ->route('dashboard.pages')
                ->with('success', $user->wasRecentlyCreated ? 
                    'Successfully connected with Facebook!' : 
                    'Welcome back ' . $user->name . '!'
                );

        } catch (Exception $e) {
            Log::error('Facebook callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Facebook login failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the user's Facebook pages dashboard
     */
    public function pagesDashboard()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                Log::warning('Unauthenticated user tried to access dashboard');
                return redirect()
                    ->route('login')
                    ->with('error', 'Please log in to access the dashboard.');
            }

            // Get user's Facebook pages using Guzzle client directly
            try {
                $response = $this->guzzleClient->get('https://graph.facebook.com/v19.0/me/accounts', [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'query' => [
                        'access_token' => $user->facebook_token,
                        'fields' => 'id,name,username,picture,access_token,category,fan_count,followers_count'
                    ]
                ]);
                
                $pagesData = json_decode((string) $response->getBody(), true);
                $pages = $pagesData['data'] ?? [];
                
                Log::info('Retrieved Facebook pages', [
                    'count' => count($pages),
                    'pages' => $pages
                ]);

                // Save or update each page in the database
                foreach ($pages as $pageData) {
                    \Log::info('Saving page:', $pageData);
                    
                    try {
                        $page = \App\Models\FacebookPage::updateOrCreate(
                            ['page_id' => $pageData['id']],
                            [
                                'name' => $pageData['name'],
                                'username' => $pageData['username'] ?? null,
                                'access_token' => $pageData['access_token'],
                                'category' => $pageData['category'] ?? null,
                                'profile_picture' => $pageData['picture']['data']['url'] ?? null,
                                'likes' => $pageData['fan_count'] ?? 0,
                                'followers' => $pageData['followers_count'] ?? 0,
                                'is_active' => true
                            ]
                        );
                        
                        \Log::info('Page saved successfully', [
                            'page_id' => $page->page_id,
                            'name' => $page->name
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to save page', [
                            'error' => $e->getMessage(),
                            'page_data' => $pageData
                        ]);
                    }
                }

                return view('dashboard.pages', [
                    'pages' => $pages,
                    'user' => $user
                ]);

            } catch (Exception $e) {
                Log::error('Failed to fetch Facebook pages', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return redirect()
                    ->route('dashboard.pages')
                    ->with('error', 'Failed to fetch your Facebook pages: ' . $e->getMessage());
            }

        } catch (Exception $e) {
            Log::error('Dashboard error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('login')
                ->with('error', 'An error occurred while loading your dashboard: ' . $e->getMessage());
        }
    }
} 