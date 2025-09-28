<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialAccountController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Legal pages
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

Route::get('/cookie-policy', function () {
    return view('cookie-policy');
})->name('cookie-policy');

Route::get('/gdpr', function () {
    return view('gdpr');
})->name('gdpr');

// Pricing page
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');
    
    // Social Account routes
    Route::get('/social-accounts', [SocialAccountController::class, 'index'])->name('social-accounts.index');
    Route::get('/social-accounts/connect/{platform}', [SocialAccountController::class, 'connect'])->name('social-accounts.connect');
    Route::get('/social-accounts/callback/{platform}', [SocialAccountController::class, 'callback'])->name('social-accounts.callback');
    Route::post('/social-accounts/{socialAccount}/refresh', [SocialAccountController::class, 'refresh'])->name('social-accounts.refresh');
    Route::delete('/social-accounts/{socialAccount}', [SocialAccountController::class, 'disconnect'])->name('social-accounts.disconnect');
    
    // Posts routes
    Route::resource('posts', PostController::class);
    Route::get('/posts/create/{platform}', [PostController::class, 'createForPlatform'])->name('posts.create.platform');
    Route::post('/posts/{post}/schedule', [PostController::class, 'schedule'])->name('posts.schedule');
    Route::post('/posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{post}/retry', [PostController::class, 'retry'])->name('posts.retry');
    Route::get('/posts/{post}/duplicate', [PostController::class, 'duplicate'])->name('posts.duplicate');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
