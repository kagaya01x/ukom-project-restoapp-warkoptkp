<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthPassportController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

Route::redirect('/', 'login', 301);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthPassportController::class, 'index'])
        ->name('login');

    Route::post('/login', [AuthPassportController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth.session')->group(function () {

    // Logout
    Route::post('/logout', [AuthPassportController::class, 'logout'])
        ->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Manajemen Kategori
    Route::get('/categories', [MenuCategoryController::class, 'index'])
        ->name('categories.index');
    Route::get('/categories/create', [MenuCategoryController::class, 'create'])
        ->name('categories.create');
    Route::post('/categories', [MenuCategoryController::class, 'store'])
        ->name('categories.store');
    Route::get('/categories/{id}/edit', [MenuCategoryController::class, 'edit'])
        ->name('categories.edit');
    Route::put('/categories/{id}', [MenuCategoryController::class, 'update'])
        ->name('categories.update');
    Route::delete('/categories/{id}', [MenuCategoryController::class, 'destroy'])
        ->name('categories.destroy');

    // Manajemen Menu
    Route::get('/menu-items', [MenuItemController::class, 'index'])
        ->name('menu-items.index');
    Route::get('/menu-items/create', [MenuItemController::class, 'create'])
        ->name('menu-items.create');
    Route::post('/menu-items', [MenuItemController::class, 'store'])
        ->name('menu-items.store');
    Route::get('/menu-items/{id}/edit', [MenuItemController::class, 'edit'])
        ->name('menu-items.edit');
    Route::put('/menu-items/{id}', [MenuItemController::class, 'update'])
        ->name('menu-items.update');
    Route::delete('/menu-items/{id}', [MenuItemController::class, 'destroy'])
        ->name('menu-items.destroy');

    // Kasir & Pesanan
    Route::get('/orders/list', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])
        ->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->name('orders.show');
    Route::put('/orders/{invoice}', [OrderController::class, 'update'])
        ->name('orders.update');
});
