<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\AccountController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/notifications', [\App\Http\Controllers\AccountController::class, 'getNotification'])->name('admin.notifications');
    Route::resource('product', ProductController::class)->only(
    ['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/product/toggle/status/{product}', [App\Http\Controllers\ProductController::class, 'changeStatus'])->name('product.toggle.status');
    Route::post('/product/increase', [App\Http\Controllers\ProductController::class, 'increaseQuantity'])->name('product.increase_quantity');
    Route::post('/product/decrease', [App\Http\Controllers\ProductController::class, 'decreaseQuantity'])->name( 'product.decrease_quantity');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('product', ProductController::class)->only(['index', 'show']);
    Route::get('/products/all', [App\Http\Controllers\ProductController::class, 'getProductsJson'])->name('get.products');

//    Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/product/{product}/cart', [ProductController::class, 'toggleButtonToCart'])->name('product.toggle_cart');
    Route::get('/product/{requestProduct}/request/confirm', [ProductController::class, 'orderConfirm'])->name('product.order.confirm');
    Route::get('/product/{requestProduct}/request/reject', [ProductController::class, 'orderReject'])->name('product.order.reject');
    Route::post('/product/{product}/request/order', [ProductController::class, 'orderNewProduct'])->name('product.request.order');
    Route::post('/product/multi/checkout', [ProductController::class, 'buyMultipleProduct'])->name('product.multi.buy');
    Route::post('/product/{product}/checkout', [ProductController::class, 'buyProduct'])->name('product.buy');
    Route::post('/product/multi/buy', [ProductController::class, 'checkoutMultipleStripe'])->name('product.multi.checkout');
    Route::post('/product/{product}/buy', [ProductController::class, 'checkoutStripe'])->name('product.checkout');
    Route::resource('cart', \App\Http\Controllers\CartController::class);

});
