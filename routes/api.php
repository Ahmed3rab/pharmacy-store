<?php

use App\Http\Controllers\API\ActivityLogController;
use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('auth/token', [LoginController::class, 'login']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('advertisements', [AdvertisementController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('orders', [\App\Http\Controllers\API\OrderController::class, 'store']);
    Route::get('orders', [\App\Http\Controllers\API\OrderController::class, 'index']);
    Route::post('auth/logout', [LoginController::class, 'logout']);
    Route::post('activities', ActivityLogController::class);
});
