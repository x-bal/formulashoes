<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/products/cart', [ProductController::class, 'cart'])->name('products.cart');
Route::get('/products/mycart/{user:id}', [ProductController::class, 'mycart'])->name('products.mycart');

Route::get('/order/status/{order:no_order}', [OrderController::class, 'status']);
Route::get('/order/nourut', [OrderController::class, 'nourut']);

// Route For Device
Route::get('/tapping', [ApiController::class, 'tapping']);
Route::post('/upload', [ApiController::class, 'upload']);
