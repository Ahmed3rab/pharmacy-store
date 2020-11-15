<?php

use App\Http\Controllers\CP\CategoriesController;
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

Route::get('cp/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('cp/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('cp/categories', [CategoriesController::class, 'index'])->name('categories.index');