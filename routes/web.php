<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

// Pages that DO NOT require authentication.
// Anything added inside this group is publicly reachable.
Route::middleware([])->group(function () {
    // Login page
    Route::get('/', [PagesController::class, 'login'])->name('login');

    // Login form submission (POST / + POST /home both work)
    Route::post('/', [PagesController::class, 'handlePost']);

    // Admin entry (kept public for now, matches original behavior)
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');

    // Logout endpoint
    Route::post('/logout', [PagesController::class, 'logout'])->name('logout');
});

// Pages that REQUIRE an authenticated session.
// Visiting any of these while not logged in will redirect to route('login').
Route::middleware(['session.auth'])->group(function () {
    // Home
    Route::prefix('/home')->group(function () {
        Route::get('/', [PagesController::class, 'home'])->name('home');
        Route::post('/', [PagesController::class, 'handlePost'])->name('home.post');
    });

    // Dashboard
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    // Chatbot
    Route::prefix('/chatbot')->group(function () {
        Route::get('/', [PagesController::class, 'chatbot'])->name('chatbot');
        Route::post('/message', [PagesController::class, 'chatbotMessage'])->name('chatbot.message');
    });
});
