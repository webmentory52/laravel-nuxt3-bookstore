<?php

use App\Http\Controllers\Api\Admin\AdminBookController;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminOrderController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;


Route::controller(BookController::class)->group(function () {
    Route::get('/books', 'index');
    Route::get('/books/{slug}', 'show');
});

Route::controller(CategoryController::class)->group(function () {
   Route::get('/categories', 'index');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('/orders', 'store');
});

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    Route::post('/logout', [AdminAuthController::class, 'logout']);

    Route::apiResource('books', AdminBookController::class);

    Route::apiResource('categories', AdminCategoryController::class)
        ->only(['index', 'store', 'destroy']);

    Route::get('/orders', [AdminOrderController::class, 'index']);

    Route::patch('/orders/{order}/status', [
        AdminOrderController::class,
        'updateStatus',
    ]);
});
