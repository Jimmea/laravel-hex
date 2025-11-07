<?php

use App\Domains\Product\Infrastructure\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/products', [ProductController::class, 'create']);
Route::get('/products/{id}', [ProductController::class, 'detail']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/statistics', [ProductController::class, 'statistics']);
Route::get('/products/{id}/purchase-quantity', [ProductController::class, 'purchaseQuantity']);
Route::get('/products/user-views/{user_id}', [ProductController::class, 'userViews']);

Route::post('/products/{id}/reviews', [ProductController::class, 'addReview']);
Route::get('/products/{id}/reviews', [ProductController::class, 'getReviews']);

Route::get('/products/recommendations/{user_id}', [ProductController::class, 'getRecommendations']);

Route::post('/orders', [OrderController::class, 'create']); // Thêm route cho đặt hàng