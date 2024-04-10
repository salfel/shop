<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])
    ->name('home');

Route::resource('products', ProductController::class)
    ->except('index');

require __DIR__.'/auth.php';
