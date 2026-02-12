<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminProducts;
use App\Livewire\Admin\AdminOrders;
use Illuminate\Support\Facades\Route;

// Front Office
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/products', AdminProducts::class)->name('admin.products');
        Route::get('/orders', AdminOrders::class)->name('admin.orders');
    });
});
