<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login-half');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-cart', [DashboardController::class, 'cart'])->name('mycart');
    // Route User
    Route::resource('users', UserController::class);
    // Route Product
    Route::post('/products/cart', [ProductController::class, 'cart'])->name('products.cart');
    Route::resource('products', ProductController::class);
    // Route Order
    Route::resource('/orders', OrderController::class);
});
