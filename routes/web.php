<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Models\Order;
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

        Route::resource('province', ProvinceController::class);

        Route::resource('city', CityController::class);
        Route::get('city/status/{id}', [CityController::class, 'CityStatus'])->name('city.status');

        Route::resource('coupon', CouponController::class);
        Route::resource('stock', StockController::class);

        // Manage Order Routes
        Route::prefix('order')->group(function () {
            Route::controller(OrderController::class)->group(function () {
                Route::get('pending', 'pendingOrders')->name('pending.order');
                Route::get('processing', 'processingOrders')->name('processing.order');
                Route::get('shipped', 'shippedOrders')->name('shipped.order');
                Route::get('delivered', 'delivered')->name('delivered');
                Route::get('cancel', 'cancelOrder')->name('cancel.order');
                Route::get('refunded', 'refunded')->name('refunded');
                Route::get('detail/{id}', 'orderDetail')->name('orders.detail');
                Route::get('invoice/{id}', 'invoicePdf')->name('invoice.pdf');
                Route::delete('delete/{id}', [OrderController::class, 'destroy'])
                    ->name('orders.delete');

                Route::put('status/{id}', 'updateStatus')
                    ->name('admin.orders.updateStatus');
            });
        });
        Route::post('notifications/mark-all-read', function () {
            auth('admin')->user()
                ->notifications()
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return response()->json(['success' => true]);
        })->name('admin.notifications.markAllRead');

        Route::post('notifications/{id}/read', function ($id) {
            $notification = auth('admin')->user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            return response()->json(['success' => true]);
        })->name('admin.notifications.markRead');
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

    // Product Cart All Routes
    Route::controller(CartController::class)->group(function () {
        Route::get('add/to/cart/{id}', 'AddToCart');
        Route::get('all/cart', 'AllCartData');
        Route::delete('cart/remove/{id}', 'CartRemove');
        Route::get('all/carts', 'ViewAllCart');
        Route::get('cart', 'Cart')->name('cart');
        Route::get('cart/all/cities/{id}', 'AllCities');

        Route::put('cart/quantity/{id}', 'CartQuantity');
        Route::post('cart/clear', 'CartClear');
        Route::post('cart/apply-coupon', 'ApplyCoupon');
        Route::post('cart/remove-coupon', 'RemoveCoupon');
    });

    // Checkout All Routes
    Route::middleware('auth')->group(function () {
        Route::controller(CheckoutController::class)->group(function () {
            Route::get('checkout/page', 'CheckoutPage')->name('checkout.page');
            Route::get('thank/you', 'ThanksPage')->name('thank.you.page');

            Route::post('checkout/info', 'CheckOutInfo')->name('checkout.info');
            Route::post('place/order', 'PlaceOrder')->name('place.order');

        });
    });
});

Route::controller(ContactUsController::class)->group(function () {
    Route::get('contact/us', 'contactPage')->name('contact.us');
    Route::post('send/email', 'sendMail')->name('send.email');
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
