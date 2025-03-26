<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FacebookPageController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pages', [FacebookPageController::class, 'index'])->name('pages.index');
Route::get('/pages/{username}', [FacebookPageController::class, 'show'])->name('pages.show');
Route::post('/pages/{username}/switch', [FacebookPageController::class, 'switchPage'])->name('pages.switch');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Facebook Authentication Routes
Route::prefix('auth/facebook')->group(function () {
    Route::get('/', [FacebookController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('callback', [FacebookController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/pages', [FacebookController::class, 'pagesDashboard'])->name('dashboard.pages');
    
    // Logout Route
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Successfully logged out!');
    })->name('logout');
});
