<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/products/cart', [ProductController::class, 'cart'])->name('products.cart');
Route::get('/products/mycart/{user:id}', [ProductController::class, 'mycart'])->name('products.mycart');

Route::get('/order/status/{order:no_order}', [OrderController::class, 'status']);
