<?php

use App\Http\Controllers\AddresseController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderStatusHistorieController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\landing_pages\LandingPagesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\JenisProductsController;
use App\Http\Controllers\LandingPagesController as ControllersLandingPagesController;

// Landing Page Route
Route::get('/', [ControllersLandingPagesController::class, 'index'])->name('landing_pages.index');

// Resource Routes Utama
Route::resource('users', UserController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('products', ProductController::class);
Route::resource('product_images', ProductImageController::class);
Route::resource('addresses', AddresseController::class);
Route::resource('carts', CartController::class);
Route::resource('cart_items', CartItemController::class);
Route::resource('bank_accounts', BankAccountController::class);
Route::resource('orders', OrderController::class);
Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update_status');
Route::resource('order_items', OrderItemController::class);
Route::resource('payments', PaymentController::class);
Route::resource('reviews', ReviewController::class);
Route::resource('order_status_histories', OrderStatusHistorieController::class);
Route::resource('store_settings', StoreSettingController::class);
Route::resource('roles', RoleController::class);
Route::resource('landing_pages', ControllersLandingPagesController::class);
Route::resource('jenis_products', JenisProductsController::class);
Route::get('/cart-data', [CartController::class, 'getCartData'])->name('cart.data');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart-add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart-item/{id}', [CartController::class, 'updateCartItem'])->name('cart.item.update');
    Route::delete('/cart-item/{id}', [CartController::class, 'removeCartItem'])->name('cart.item.delete');

    // Fitur Pemesanan & Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/buy-now', [CheckoutController::class, 'buyNow'])->name('buy.now');
    Route::get('/pesanan-berhasil/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/pesanan-saya', [CheckoutController::class, 'myOrders'])->name('orders.my_orders');
    Route::get('/pesanan-saya/{order_number}', [CheckoutController::class, 'myOrderDetail'])->name('orders.my_order_detail');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
