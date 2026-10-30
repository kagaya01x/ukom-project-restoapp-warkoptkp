<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthPassportController;

Route::redirect('/', 'login', 301);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthPassportController::class, 'index'])
    ->name('login');

    Route::post('/login', [AuthPassportController::class, 'login'])
    ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthPassportController::class, 'logout'])
    ->name('logout');
});
