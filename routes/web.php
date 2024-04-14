<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])
    ->name('home');

Route::get('cart', [CartController::class, 'show'])
    ->middleware('auth')
    ->name('cart');

Route::delete('cart', [CartController::class, 'delete'])
    ->middleware('auth')
    ->name('cart.delete');

Route::resource('products', ProductController::class)
    ->except('index');

Route::get('/checkout', CheckoutController::class)
    ->middleware('auth')
    ->name('checkout');

require __DIR__.'/auth.php';
