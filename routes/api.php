<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\BundleController;

/* ---- System API Contracts (Section 13) ---- */

// Authentication Routing (rate-limited to curb OTP spam)
Route::middleware('throttle:6,1')->group(function () {
    Route::post('/auth/send-otp',   [AuthController::class, 'sendOtp']);
    Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
});

// Product Routing
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// Bundle Routing (storefront)
Route::get('/bundles', [BundleController::class, 'index']);

// Order Routing (public initialize) — checkout session
Route::post('/orders', [OrderController::class, 'store']);

// Admin-protected API surface
Route::middleware(['auth:sanctum', 'role:admin,super_admin'])->group(function () {
    Route::post('/admin/products',          [\App\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::put('/admin/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::delete('/admin/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy']);

    Route::get('/admin/orders',              [\App\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::put('/admin/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus']);

    Route::post('/admin/bundles', [\App\Http\Controllers\Admin\BundleController::class, 'store']);
});
