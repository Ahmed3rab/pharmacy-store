<?php

use App\Http\Controllers\CP\ActivityLogController;
use App\Http\Controllers\CP\AdvertisementController;
use App\Http\Controllers\CP\CategoriesController;
use App\Http\Controllers\CP\CompleteOrderController;
use App\Http\Controllers\CP\DiscountController;
use App\Http\Controllers\CP\DiscountItemController;
use App\Http\Controllers\CP\HomeController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\NotificationController;
use App\Http\Controllers\CP\OrdersController;
use App\Http\Controllers\CP\PendingOrderController;
use App\Http\Controllers\CP\ProductsController;
use App\Http\Controllers\CP\UserActivityController;
use App\Http\Controllers\CP\UserController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('auth/authenticate', [LoginController::class, 'authenticate'])->name('auth.authenticate');
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::redirect('/', 'cp');

Route::group(['prefix' => 'cp', 'middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'show'])->name('cp');

    # Orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
    Route::post('completed-orders/{order}', [CompleteOrderController::class, 'store'])->name('orders.complete.store');
    Route::post('pending-orders/{order}', [PendingOrderController::class, 'store'])->name('orders.pending.store');

    # Products
    Route::resource('products', ProductsController::class)->except('show');
    Route::post('products/{product}/restore', [ProductsController::class, 'restore'])->name('products.restore');

    # Categories
    Route::resource('categories', CategoriesController::class)->except('show');
    Route::post('categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');

    #advertisements
    Route::resource('advertisements', AdvertisementController::class)->except('show');

    # Discounts
    Route::resource('discounts', DiscountController::class);

    # Discount Items
    Route::delete('discounts/{discount}/items/{item}', [DiscountItemController::class, 'destroy'])->name('discounts-items.destroy');

    # Users
    Route::resource('users', UserController::class);


    #activities
    Route::get('activities', [ActivityLogController::class, 'index'])->name('activities.index');
    Route::get('activities/{activity}', [ActivityLogController::class, 'show'])->name('activities.show');

    #user-activities
    Route::get('users/{user}/activities', UserActivityController::class)->name('users.activities.show');

    # Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
});
