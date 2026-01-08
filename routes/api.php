<?php

use App\Http\Controllers\Storefront\ProductVariationController;
use Illuminate\Support\Facades\Route;

Route::prefix('store/{store:slug}')->group(function () {
    Route::get('/products/{product:slug}/variations/{variation}', [ProductVariationController::class, 'show'])->name('storefront.products.variations.show');
});
