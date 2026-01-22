<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'AdminLogin')->name('admin.login.page')->middleware('is-LoggedIn');
        Route::get('logout', 'AdminLogout')->name('admin.logout');
        Route::get('dashboard', 'AdminDashboard')->name('admin.dashboard')->middleware('admin-check');

        Route::post('login', 'Login')->name('admin.login');
    });

    Route::middleware('admin-check')->group(function () {
        // Brand Routes
        Route::resource('brand', BrandController::class);

        // Category Routes
        Route::resource('category', CategoryController::class);

        // Product Routes
        Route::resource('product', ProductController::class);
        Route::get('product/status/{id}', [ProductController::class, 'ProductStatus'])->name('product.status');

        // Slider Routes
        Route::resource('slider', SliderController::class);
        Route::get('slider/status/{id}', [SliderController::class, 'SliderStatus'])->name('slider.status');
    });
});

// Frontend All Routes
Route::controller(ProductDetailController::class)->group(function () {
    Route::get('product', 'ProductFilter');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
