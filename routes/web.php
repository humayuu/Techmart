<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Admin All Routes
Route::prefix('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'AdminLogin')->name('admin.login.page')->middleware('is-LoggedIn');
        Route::get('logout', 'AdminLogout')->name('admin.logout');
        Route::get('dashboard', 'AdminDashboard')->name('admin.dashboard')->middleware('admin-check');
        Route::get('profile/detail', 'AdminProfileDetail')->name('admin.profile.detail');
        Route::get('profile/change/password', 'AdminChangePassword')->name('admin.change.password');

        Route::post('login', 'Login')->name('admin.login');
        Route::put('profile/detail/update', 'AdminProfileUpdate')->name('admin.profile.update');
        Route::put('profile/password/update', 'AdminPasswordUpdate')->name('admin.password.update');
    });

    Route::middleware('admin-check')->group(function () {
        Route::resource('brand', BrandController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('settings', SettingController::class);

        Route::resource('product', ProductController::class);
        Route::get('product/status/{id}', [ProductController::class, 'ProductStatus'])->name('product.status');

        Route::resource('slider', SliderController::class);
        Route::get('slider/status/{id}', [SliderController::class, 'SliderStatus'])->name('slider.status');

    });
});

// Frontend All Routes
Route::prefix('product')->group(function () {
    // Product Details
    Route::controller(ProductDetailController::class)->group(function () {
        Route::get('/', 'ProductFilter');
        Route::get('detail/{id}', 'ProductDetails')->name('product.detail');

        Route::get('category/{id}', 'CategoryWiseProduct')->name('category.wise.product');
        Route::get('category/{id}/sorting', 'CategoryWiseSorting');

        Route::get('brand/{id}', 'BrandWiseProduct')->name('brand.wise.product');
        Route::get('brand/{id}/sorting', 'BrandWiseSorting');
        Route::get('/quick/{id}', 'QuickShow');
    });

    // Add to Cart
    Route::controller(CartController::class)->group(function () {
        Route::get('add/to/cart/{id}', 'AddToCart');
        Route::get('cart/remove/{id}', 'CartRemove');
        Route::put('cart/quantity/{id}', 'CartQuantity');

        Route::get('all/carts', 'ViewAllCart');
        Route::get('cart', 'Cart')->name('cart');

    });
});

// Google Login
Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google', 'GoogleLogin')->name('auth.google');
    Route::get('auth/google-callback', 'GoogleAuthentication')->name('auth.google.callback');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 404 Page
Route::fallback(function () {
    return view('errors.404');
});

require __DIR__.'/auth.php';
