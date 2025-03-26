<?php

namespace App\Http\Controllers;

use App\Models\FacebookPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FacebookPageController extends Controller
{
    /**
     * Display a listing of Facebook pages.
     */
    public function index()
    {
        $pages = FacebookPage::where('is_active', true)->get();
        $currentPage = Session::get('current_page_id');
        return view('pages.index', compact('pages', 'currentPage'));
    }

    /**
     * Display the specified Facebook page.
     */
    public function show($identifier)
    {
        \Log::info('Attempting to find page with identifier: ' . $identifier);

        // Try to find the page by page_id first
        $page = FacebookPage::where('page_id', $identifier)->first();

        if (!$page && is_string($identifier)) {
            // If not found by page_id, try username
            $page = FacebookPage::where('username', $identifier)->first();
        }

        \Log::info('Page query result:', [
            'found' => $page ? 'yes' : 'no',
            'page_data' => $page ? $page->toArray() : null
        ]);

        if (!$page) {
            // Check if any pages exist at all
            $allPages = FacebookPage::all();
            \Log::info('All available pages:', [
                'count' => $allPages->count(),
                'pages' => $allPages->map(function($p) {
                    return [
                        'id' => $p->id,
                        'page_id' => $p->page_id,
                        'username' => $p->username,
                        'name' => $p->name,
                        'is_active' => $p->is_active
                    ];
                })
            ]);
            
            abort(404, 'Facebook page not found');
        }
            
        // Get all active pages for the switcher
        $allPages = FacebookPage::where('is_active', true)
            ->where('id', '!=', $page->id)
            ->get();
            
        Session::put('current_page_id', $page->id);
        
        return view('pages.show', compact('page', 'allPages'));
    }

    /**
     * Switch to a different page.
     */
    public function switchPage($identifier)
    {
        // Try to find the page by username first, then by page_id if not found
        $page = FacebookPage::where(function($query) use ($identifier) {
                $query->where('username', $identifier)
                      ->orWhere('page_id', $identifier);
            })
            ->where('is_active', true)
            ->firstOrFail();
            
        Session::put('current_page_id', $page->id);
        
        return redirect()->route('pages.show', $identifier)
            ->with('success', "Switched to {$page->name}");
    }
}
