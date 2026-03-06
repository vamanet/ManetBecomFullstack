<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FoodsController;
use App\Http\Controllers\API\FoodCategoryController;
use App\Http\Controllers\API\OrderController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Food & Category routes (public for now)
Route::apiResource('foods', FoodsController::class);
Route::apiResource('categories', FoodCategoryController::class);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Order routes
    Route::apiResource('orders', OrderController::class);
    Route::get('/orders-statistics', [OrderController::class, 'statistics']);
});
