<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
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
    });
});

Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'bn'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('language.switch');
