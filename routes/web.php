<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\FeedbackAndSuggestionController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('showLoginForm'); // <- better target the GET login route
});

// ------------------------
// Guest (not logged in)
// ------------------------
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('showLoginForm');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('showRegisterForm');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Logout (must be POST for security)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ------------------------
// Authenticated routes
// ------------------------
Route::middleware('auth')->group(function () {

    // Dashboard (boxes overview) – everyone logged-in can see
    Route::get('/dashboard', [BoxController::class, 'index'])
        ->name('dashboard');

    // ------------------------
    // BOXES
    // ------------------------

    // All authenticated users can VIEW boxes
    Route::resource('boxes', BoxController::class)->only(['show']);

    // Only ADMIN (role = 1) can create / edit / delete boxes
    Route::middleware('admin')->group(function () {
        Route::resource('boxes', BoxController::class)->only([
            'create', 'store', 'edit', 'update', 'destroy',
        ]);
    });

    // ------------------------
    // FEEDBACK
    // ------------------------

    // All authenticated users can:
    // - list feedback
    // - create feedback
    // - edit/delete their own feedback
    // Admin can edit/delete any feedback (enforced in controller)
    Route::resource('feedback', FeedbackAndSuggestionController::class);

    // Comments on feedback – all authenticated users
    Route::resource('feedbacks.comments', CommentController::class)->shallow();
});
