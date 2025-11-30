<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
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
        // Brands Routes
        Route::resource('brand', BrandController::class);
    });
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
