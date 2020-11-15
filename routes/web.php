<?php

use App\Http\Controllers\CP\CategoriesController;
use App\Http\Controllers\CP\CompleteOrderController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\OrdersController;
use App\Http\Controllers\CP\ProductsController;
use Illuminate\Support\Facades\Route;


Route::get('cp', function () {
    return view('cp');
})->name('cp');

Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');

Route::post('auth/authenticate', [LoginController::class, 'authenticate'])->name('auth.authenticate');

# Orders
Route::get('cp/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('cp/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
Route::patch('cp/orders/{order}', [CompleteOrderController::class, 'store'])->name('orders.complete.store');

# Products
Route::get('cp/products', [ProductsController::class, 'index'])->name('products.index');

# Categories
Route::get('cp/categories', [CategoriesController::class, 'index'])->name('categories.index');