<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\SiteContentController as AdminSiteContentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Cart & Checkout
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/{order}', [CheckoutController::class, 'success'])->name('order.success');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('products', AdminProductController::class)->except('show');
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::resource('coupons', AdminCouponController::class)->except('show');
        Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{phone}', [AdminCustomerController::class, 'show'])->name('customers.show');
        Route::get('settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        // Site Content (logo, hero banners, contact)
        Route::prefix('site-content')->name('site-content.')->group(function () {
            Route::get('branding', [AdminSiteContentController::class, 'branding'])->name('branding');
            Route::put('branding', [AdminSiteContentController::class, 'updateBranding'])->name('branding.update');
            Route::get('hero', [AdminSiteContentController::class, 'hero'])->name('hero');
            Route::put('hero', [AdminSiteContentController::class, 'updateHero'])->name('hero.update');
        });
    });
});

Route::get('/language/{locale}', LanguageController::class)->name('language.switch');

/*
|--------------------------------------------------------------------------
| One-time web installer (for shared hosting without SSH/Terminal)
|--------------------------------------------------------------------------
| Disabled by default. To use it: set ALLOW_WEB_SETUP=true in .env, open
| https://yourdomain.com/__setup once (runs migrations + seeders), then set
| ALLOW_WEB_SETUP=false again. Do NOT run `php artisan route:cache` while it
| is enabled.
*/
if (env('ALLOW_WEB_SETUP', false)) {
    Route::get('/__setup', function () {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $output .= "\n".\Illuminate\Support\Facades\Artisan::output();

        return response('<pre style="font:14px/1.5 monospace;padding:20px">'.e($output)."\nDONE. Now set ALLOW_WEB_SETUP=false in .env</pre>");
    });
}
