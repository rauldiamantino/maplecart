<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    public function show(Store $store, Product $product, ProductVariation $variation): JsonResponse
    {
        abort_unless($variation->product_id === $product->id, 404);

        return response()->json($variation);
    }
}
