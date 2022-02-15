<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
    return view('welcome');
});

Route::group(['middleware' => 'isAdmin','prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/media', [\App\Http\Controllers\Admin\ProductController::class, 'storeMedia'])->name('products.storeMedia');
});

Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [\App\Http\Controllers\HomeController::class, 'search'])->name('search.index');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/shop/{slug?}', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/tag/{slug}', [\App\Http\Controllers\ShopTagController::class, 'index'])->name('shop.tag');
Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
