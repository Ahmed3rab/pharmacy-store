<?php

use App\Http\Controllers\API\ActivityLogController;
use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DiscountController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/token', [LoginController::class, 'login']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('advertisements', [AdvertisementController::class, 'index']);
Route::get('discounts', [DiscountController::class, 'index']);
Route::get('discounts/{discount}', [DiscountController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::post('auth/logout', [LoginController::class, 'logout']);
    Route::post('activities', ActivityLogController::class);
    Route::patch('user', [UserController::class, 'update']);
});
