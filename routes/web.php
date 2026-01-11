<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes - Public Routes
|--------------------------------------------------------------------------
|
| Routes publiques pour le site 7 Ensemble.
| Ces routes sont accessibles sans authentification.
|
*/

// ================================================
// PUBLIC PAGES
// ================================================

// Homepage - Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tours Page - Les 7 Tours (Triangulum vs Pléiades)
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{type}', [TourController::class, 'show'])->name('tours.show');

// Mission Page - Notre Mission
Route::get('/mission', [MissionController::class, 'index'])->name('mission');

// FAQ & Support
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Legal Pages
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/legal', [HomeController::class, 'legal'])->name('legal');

// ================================================
// AUTHENTICATION ROUTES
// ================================================

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function () {
    // Email verification logic
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function () {
    // Resend verification email
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Password Reset
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

// ================================================
// PAYMENT ROUTES (Public - for guest payments)
// ================================================

// Payment Processing
Route::prefix('payment')->group(function () {
    Route::get('/process/{transaction}', [PaymentController::class, 'process'])->name('payment.process');
    Route::post('/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/cancelled', [PaymentController::class, 'cancelled'])->name('payment.cancelled');
    Route::get('/failed', [PaymentController::class, 'failed'])->name('payment.failed');
});

// ================================================
// WEBHOOK ROUTES (No CSRF protection)
// ================================================

Route::prefix('webhooks')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::post('/stripe', [PaymentController::class, 'stripeWebhook'])->name('webhooks.stripe');
    Route::post('/paypal', [PaymentController::class, 'paypalWebhook'])->name('webhooks.paypal');
});

// ================================================
// REFERRAL ROUTES
// ================================================

// Referral Link Handler
Route::get('/ref/{code}', [HomeController::class, 'referral'])->name('referral');

// ================================================
// API ROUTES (for AJAX calls)
// ================================================

Route::prefix('api')->group(function () {
    // Get constellation availability
    Route::get('/constellation/availability/{type}', [HomeController::class, 'checkAvailability']);

    // Get tour details
    Route::get('/tour/details/{type}/{tour}', [TourController::class, 'details']);

    // Validate referral code
    Route::get('/referral/validate/{code}', [HomeController::class, 'validateReferral']);
});

// ================================================
// DOWNLOADS
// ================================================

Route::prefix('download')->group(function () {
    Route::get('/whitepaper', [HomeController::class, 'downloadWhitepaper'])->name('download.whitepaper');
    Route::get('/guide', [HomeController::class, 'downloadGuide'])->name('download.guide');
});

// ================================================
// LOCALIZATION
// ================================================

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'de', 'it'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

// ================================================
// FALLBACK ROUTE (404)
// ================================================

Route::fallback(function () {
    return view('errors.404');
});
