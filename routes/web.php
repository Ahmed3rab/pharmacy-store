<?php

use App\Http\Controllers\CP\CategoriesController;
use App\Http\Controllers\CP\CompleteOrderController;
use App\Http\Controllers\CP\HomeController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\OrdersController;
use App\Http\Controllers\CP\ProductsController;
use Illuminate\Support\Facades\Route;


Route::get('cp', [HomeController::class, 'show'])->name('cp');

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
Route::get('cp/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('cp/products', [ProductsController::class, 'store'])->name('products.store');
Route::get('cp/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('cp/products/{product}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('cp/products/{product}', [ProductsController::class, 'destroy'])->name('products.delete');

# Categories
Route::get('cp/categories', [CategoriesController::class, 'index'])->name('categories.index');
