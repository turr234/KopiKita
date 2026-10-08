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

Route::get('/', function () {
    return view('welcome');
});

route::resource('users', UserController::class);
route::resource('categories', CategoriesController::class);
route::resource('products', ProductController::class);
route::resource('product_images', ProductImageController::class);
route::resource('addresses', AddresseController::class);
route::resource('carts', CartController::class);
route::resource('cart_items', CartItemController::class);
route::resource('bank_accounts', BankAccountController::class);
route::resource('orders', OrderController::class);
route::resource('order_items', OrderItemController::class);
route::resource('payments', PaymentController::class);
route::resource('reviews', ReviewController::class);
route::resource('order_status_histories', OrderStatusHistorieController::class);
route::resource('store_settings', StoreSettingController::class);
