<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployerController;
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

Route::group(['middleware' => ['auth:web', 'admin'], 'prefix' => 'admin'], function () {
//    dd(\Illuminate\Support\Facades\Auth::guard());
    Route::get('/', [\App\Http\Controllers\AccountController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/notifications', [\App\Http\Controllers\AccountController::class, 'getNotification'])->name('admin.notifications');
    Route::resource('product', ProductController::class)->except(['index', 'show']);
    Route::get('/product/toggle/status/{product}', [ProductController::class, 'changeStatus'])->name('product.toggle.status');
    Route::get('/resource/toggle/status/{resource}', [ResourceController::class, 'changeStatus'])->name('resources.toggle.status');
    Route::get('/supplier/toggle/status/{supplier}', [SupplierController::class, 'changeStatus'])->name('supplier.toggle.status');
    Route::get('/employer/toggle/status/{employer}', [EmployerController::class, 'changeStatus'])->name('employer.toggle.status');
    Route::post('/product/increase', [ProductController::class, 'increaseQuantity'])->name('product.increase_quantity');
    Route::post('/product/decrease', [ProductController::class, 'decreaseQuantity'])->name( 'product.decrease_quantity');
    Route::get('/resources/all', [ResourceController::class, 'getResourcesJson'])->name('get.resources');
    Route::get('/suppliers/all', [SupplierController::class, 'getSupplierJson'])->name('get.suppliers');
    Route::get('/employers/all', [EmployerController::class, 'getEmployerJson'])->name('get.employers');
    Route::resource('resources', ResourceController::class);
    Route::resource('supplier', SupplierController::class);

    Route::resource('employer', EmployerController::class);
});

Route::group(['middleware' => ['auth:web,employer']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('product', ProductController::class)->only(['index', 'show']);
    Route::get('/products/all', [ProductController::class, 'getProductsJson'])->name('get.products');
//    Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/product/{product}/cart', [ProductController::class, 'toggleButtonToCart'])->name('product.toggle_cart');
    Route::get('/product/{requestProduct}/request/confirm', [ProductController::class, 'orderConfirm'])->name('product.order.confirm');
    Route::get('/product/{requestProduct}/request/reject', [ProductController::class, 'orderReject'])->name('product.order.reject');
    Route::post('/product/{product}/request/order', [ProductController::class, 'orderNewProduct'])->name('product.request.order');
    Route::post('/product/multi/checkout', [ProductController::class, 'buyMultipleProduct'])->name('product.multi.buy');
    Route::post('/product/{product}/checkout', [ProductController::class, 'buyProduct'])->name('product.buy');
    Route::post('/product/multi/buy', [ProductController::class, 'checkoutMultipleStripe'])->name('product.multi.checkout');
    Route::post('/product/{product}/buy', [ProductController::class, 'checkoutStripe'])->name('product.checkout');
    Route::resource('cart', CartController::class);

});

Route::get('/employer/dashboard', [EmployerController::class, 'myProfile'])->name('employer.dashboard')->middleware('auth:employer');
