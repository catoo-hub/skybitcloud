<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ServerMachineController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{purchase}/manage', [ServerMachineController::class, 'show'])->name('orders.manage');
    Route::get('/products/{product}/buy', [PurchaseController::class, 'create'])->name('products.checkout');
    Route::post('/products/{product}/buy', [PurchaseController::class, 'store'])->name('products.buy');
    Route::patch('/purchases/{purchase}/power-on', [ServerMachineController::class, 'powerOn'])->name('purchases.power-on');
    Route::patch('/purchases/{purchase}/power-off', [ServerMachineController::class, 'powerOff'])->name('purchases.power-off');
    Route::patch('/purchases/{purchase}/password', [ServerMachineController::class, 'changePassword'])->name('purchases.password');
    Route::patch('/purchases/{purchase}/reinstall', [ServerMachineController::class, 'reinstall'])->name('purchases.reinstall');
    Route::delete('/purchases/{purchase}', [ServerMachineController::class, 'destroy'])->name('purchases.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});
