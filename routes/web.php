<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HistoryController;
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
    return view('auth.login');
});

Auth::routes([
    'verify' => false,
    'reset' => false
]);

Route::middleware('auth')->group(function () {
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-cart', [DashboardController::class, 'cart'])->name('mycart');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/{user:id}', [DashboardController::class, 'update'])->name('profile.update');
    Route::get('/history', [DashboardController::class, 'history'])->name('history');

    // Route User
    Route::resource('users', UserController::class);
    // Route Device
    Route::resource('devices', DeviceController::class);
    // Route History
    Route::resource('histories', HistoryController::class);

    // Route Product
    Route::post('/products/cart', [ProductController::class, 'cart'])->name('products.cart');
    Route::resource('products', ProductController::class);
    // Route Order
    Route::post('/orders/status-laundry', [OrderController::class, 'statuslaundry'])->name('orders.status');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::resource('/orders', OrderController::class);
});
