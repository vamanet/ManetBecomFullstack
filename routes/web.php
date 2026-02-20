<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/userdashboard');
    }

    return redirect('/register');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('app');
    })->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', function () {
        return view('app');
    })->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
});

Route::get('/userdashboard', [DashboardController::class, 'index'])
    ->name('userdashboard');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::get('/dashboard', [DashboardController::class, 'dashboardOne']);
