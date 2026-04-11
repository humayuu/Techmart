<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ReturnOrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeoSettingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::prefix('admin')->group(function () {

    // PUBLIC — No Auth
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'AdminLogin')->name('admin.login.page')->middleware('is-LoggedIn');
        Route::post('login', 'Login')->name('admin.login');
        Route::get('logout', 'AdminLogout')->name('admin.logout');
    });

    // PROTECTED — Login Required
    Route::middleware(['admin-check'])->group(function () {

        // Dashboard, Profile, Notifications — sab ke liye
        Route::controller(AdminController::class)->group(function () {
            Route::get('dashboard', 'AdminDashboard')->name('admin.dashboard');
            Route::get('profile/detail', 'AdminProfileDetail')->name('admin.profile.detail');
            Route::get('profile/change/password', 'AdminChangePassword')->name('admin.change.password');
            Route::put('profile/detail/update', 'AdminProfileUpdate')->name('admin.profile.update');
            Route::put('profile/password/update', 'AdminPasswordUpdate')->name('admin.password.update');
            Route::post('notifications/{id}/read', 'markNotificationRead')->name('admin.notifications.markRead');
            Route::post('notifications/mark-all-read', 'markAllNotificationsRead')->name('admin.notifications.markAllRead');
        });

        // Admin Users
        Route::middleware('admin.access:admin_users')
            ->controller(AdminController::class)
            ->group(function () {
                Route::get('user', 'adminUser')->name('admin.user');
                Route::get('user/create', 'adminUserCreate')->name('admin.user.create');
                Route::post('user/store', 'adminUserStore')->name('admin.user.store');
                Route::get('user/show/{id}', 'adminUserShow')->name('admin.user.show');
                Route::get('user/edit/{id}', 'adminUserEdit')->name('admin.user.edit');
                Route::put('user/update/{id}', 'adminUserUpdate')->name('admin.user.update');
                Route::get('user/status/{id}', 'adminUserStatus')->name('admin.user.status');
                Route::delete('user/delete/{id}', 'adminUserDelete')->name('admin.user.destroy');
            });

        // Brands
        Route::middleware('admin.access:brands')->group(function () {
            Route::resource('brand', BrandController::class);
        });

        // Categories
        Route::middleware('admin.access:categories')->group(function () {
            Route::resource('category', CategoryController::class);
        });

        // Products —
        Route::middleware('admin.access:products')->group(function () {
            Route::get('product/status/{id}', [ProductController::class, 'ProductStatus'])->name('product.status');
            Route::resource('product', ProductController::class);
        });

        // Sliders
        Route::middleware('admin.access:sliders')->group(function () {
            Route::get('slider/status/{id}', [SliderController::class, 'SliderStatus'])->name('slider.status');
            Route::resource('slider', SliderController::class);
        });

        // Customers
        Route::middleware('admin.access:customers')->group(function () {
            Route::resource('customer', CustomerController::class);
        });

        // Coupons
        Route::middleware('admin.access:coupons')->group(function () {
            Route::resource('coupon', CouponController::class);
        });

        // Shipping
        Route::middleware('admin.access:shipping')->group(function () {
            Route::resource('province', ProvinceController::class);
            Route::get('city/status/{id}', [CityController::class, 'CityStatus'])->name('city.status');
            Route::resource('city', CityController::class);
        });

        // Stock
        Route::middleware('admin.access:stock')->group(function () {
            Route::resource('stock', StockController::class);
        });

        // Settings
        Route::middleware('admin.access:settings')->group(function () {
            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');
        });

        Route::middleware('admin.access:seo_settings')->group(function () {
            Route::get('seo', [SeoSettingController::class, 'index'])->name('seo.index');
            Route::put('seo/update/{id}', [SeoSettingController::class, 'update'])->name('seo.update');
        });

        // Return Order
        Route::middleware('admin.access:return_orders')->group(function () {
            Route::resource('return', ReturnOrderController::class);
        });

        // Orders
        Route::middleware('admin.access:orders')
            ->prefix('order')
            ->controller(OrderController::class)
            ->group(function () {
                Route::get('pending', 'pendingOrders')->name('pending.order');
                Route::get('processing', 'processingOrders')->name('processing.order');
                Route::get('shipped', 'shippedOrders')->name('shipped.order');
                Route::get('delivered', 'delivered')->name('delivered');
                Route::get('cancel', 'cancelOrder')->name('cancel.order');
                Route::get('refunded', 'refunded')->name('refunded');
                Route::get('detail/{id}', 'orderDetail')->name('orders.detail');
                Route::get('invoice/{id}', 'invoicePdf')->name('invoice.pdf');
                Route::put('status/{id}', 'updateStatus')->name('admin.orders.updateStatus');
                Route::delete('delete/{id}', 'destroy')->name('orders.delete');
            });

    }); // end admin-check

}); // end admin prefix

// ========================== Frontend All Routes ============================

Route::prefix('product')->group(function () {
    // Product Details
    Route::controller(ProductDetailController::class)->group(function () {
        Route::get('/', 'ProductFilter');
        Route::get('detail/{id}', 'ProductDetails')->name('product.detail');

        Route::get('category/{id}', 'CategoryWiseProduct')->name('category.wise.product');
        Route::get('category/{id}/sorting', 'CategoryWiseSorting');

        Route::get('brand/{id}', 'BrandWiseProduct')->name('brand.wise.product');
        Route::get('brand/{id}/sorting', 'BrandWiseSorting');
    });

    // Product Cart All Routes
    Route::controller(CartController::class)->group(function () {
        Route::post('add/to/cart/{id}', 'AddToCart');
        Route::get('all/cart', 'AllCartData');
        Route::get('all/carts', 'ViewAllCart');
        Route::get('cart', 'Cart')->name('cart');
        Route::get('cart/all/cities/{id}', 'AllCities');

        Route::put('cart/quantity/{id}', 'CartQuantity');
        Route::post('cart/clear', 'CartClear');
        Route::post('cart/apply-coupon', 'ApplyCoupon');
        Route::post('cart/remove-coupon', 'RemoveCoupon');
        Route::delete('cart/remove/{id}', 'CartRemove');
    });

    // Product Wishlist All Routes
    Route::controller(WishlistController::class)->group(function () {
        Route::get('add/to/wishlist/{id}', 'addToWishlist');
        Route::get('all/wishlist', 'allWishlistData');
        Route::get('wishlist', 'wishlist')->name('wishlist');
        Route::delete('wishlist/remove/{id}', 'wishlistRemove');
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

// routes/web.php
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'userOrderInfo']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/order/detail/{id}', [ProfileController::class, 'userOrderDetail'])->name('order.show');
    Route::get('/profile/order/tracking/{id}', [ProfileController::class, 'trackOrder'])->name('track.order');
    Route::get('/profile/order/return/{id}', [ProfileController::class, 'returnOrder'])->name('order.return');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 404 Page
Route::fallback(function () {
    return view('errors.404');
});

require __DIR__.'/auth.php';
