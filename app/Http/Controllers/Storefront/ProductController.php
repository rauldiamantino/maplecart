<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(string $slug): View
    {
        $store = Store::where('slug', $slug)
            ->firstOrFail();

        $products = $store->products()
            ->where('status', 'active')
            ->with('variations')
            ->paginate(12);

        foreach ($products as $product) {
            $product->display_price = $this->calculateDisplayPrice($product);
        }

        return view('storefront.products.index', compact('store', 'products'));
    }


    public function show(string $id)
    {
        //
    }

    private function calculateDisplayPrice(Product $product): string
    {
        if ($product->type == 'simple') {

            if (empty($product->price)) {
                return 'Contact for price';
            }

            return 'CAD $' . number_format($product->price, 2) ;
        }

        $prices = $product->variations->pluck('price');
        $prices = $prices->filter()->toArray();

        if (empty($prices)) {
            return 'Contact for price';
        }

        $price_min = min($prices);
        $price_max = max($prices);

        if ($price_min === $price_max) {
            return 'CAD $' . number_format($price_min, 2) ;
        }

        return 'CAD $' . number_format($price_min, 2) . ' - $' . number_format($price_max, 2) ;
    }
}
