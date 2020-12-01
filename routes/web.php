<?php

use App\Http\Controllers\CP\AdvertisementController;
use App\Http\Controllers\CP\CategoriesController;
use App\Http\Controllers\CP\CompleteOrderController;
use App\Http\Controllers\CP\HomeController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\OrdersController;
use App\Http\Controllers\CP\ProductDiscountController;
use App\Http\Controllers\CP\ProductDiscountItemController;
use App\Http\Controllers\CP\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('auth/authenticate', [LoginController::class, 'authenticate'])->name('auth.authenticate');
Route::redirect('/', 'cp');
Route::group(['prefix' => 'cp', 'middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'show'])->name('cp');

    # Orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [CompleteOrderController::class, 'store'])->name('orders.complete.store');

    # Products
    Route::get('products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.delete');

    # Categories
    Route::get('categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::patch('categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');

    #advertisements
    Route::get('advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
    Route::get('advertisements/create', [AdvertisementController::class, 'create'])->name('advertisements.create');
    Route::post('advertisements', [AdvertisementController::class, 'store'])->name('advertisements.store');
    Route::get('advertisements/{advertisement}/edit', [AdvertisementController::class, 'edit'])->name('advertisements.edit');
    Route::patch('advertisements/{advertisement}', [AdvertisementController::class, 'update'])->name('advertisements.update');

    # Discounts
    Route::get('products-discounts', [ProductDiscountController::class, 'index'])->name('products.discounts.index');
    Route::get('products-discounts/create', [ProductDiscountController::class, 'create'])->name('products-discounts.create');
    Route::get('products-discounts/{discount}', [ProductDiscountController::class, 'show'])->name('products-discounts.show');
    Route::post('products-discounts', [ProductDiscountController::class, 'store'])->name('products-discounts.store');

    # Discount Items
    Route::delete('products-discounts/{discount}/items/{item}', [ProductDiscountItemController::class, 'destroy'])->name('products-discounts-items.destroy');
});
