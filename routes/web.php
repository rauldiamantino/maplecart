<?php

use App\Http\Controllers\Storefront\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('store/{store:slug}')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('storefront.products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('storefront.products.show');
});
