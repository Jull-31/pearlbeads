<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Customer Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/contact', function() {
    return view('contact');
})->name('contact');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function() {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Banners Management
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    
    // Products Management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    
    // Categories Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});
// Route untuk Checkout dari JS (Public)
Route::post('/checkout', [App\Http\Controllers\OrderController::class, 'store'])->name('checkout.store');

// Group Admin (Tambahkan di dalam middleware admin yang sudah ada)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // ... route dashboard, banner, product yang lama ...
    
    // Route Baru Order
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/history', [App\Http\Controllers\OrderController::class, 'history'])->name('orders.history');
    Route::post('/orders/{id}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.status');
});