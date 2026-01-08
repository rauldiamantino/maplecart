<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Store;
use App\Models\VariationAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use stdClass;

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


    public function show(string $storeSlug, string $productSlug): View
    {
        $store = Store::where('slug', $storeSlug)
            ->firstOrFail();

        $product = $store->products()
            ->where('status', 'active')
            ->where('slug', $productSlug)
            ->firstOrFail();

        $schema = [];
        $productVariations = [];
        $variationsById = [];

        if ($product->type == 'variable') {
            $productVariations = $this->productVariations($product);
            $product->product_variations = $productVariations;

            foreach ($productVariations as $variation) {

                foreach ($variation['variations'] as $key => $value) {
                    $schema[ $key ][ $value ][] = $variation->id;
                    $variationsById[ $variation->id ][ $key ] = $value;
                }
            }
        }

        $product->display_price = $this->calculateDisplayPrice($product);

        return view('storefront.products.show', compact('store', 'product', 'schema', 'variationsById'));
    }

    private function productVariations(Product $product)
    {
        $productVariations = ProductVariation::where('product_id', $product->id)
            ->get();

        if ($productVariations->IsEmpty()) {
            return [];
        }

        $productVariationsIds = $productVariations->pluck('id');

        $variationAttributes = VariationAttribute::whereIn('product_variation_id', $productVariationsIds)
            ->get();

        if ($variationAttributes->IsEmpty()) {
            return [];
        }

        $variationAttributesIds = $variationAttributes->pluck('attribute_value_id');

        $attributeValues = AttributeValue::whereIn('attribute_id', $variationAttributesIds)
            ->get();

        if ($attributeValues->IsEmpty()) {
            return [];
        }

        $attributeIds = $attributeValues->pluck('attribute_id');

        $attributes = Attribute::whereIn('id', $attributeIds)
            ->get();

        if ($attributes->IsEmpty()) {
            return [];
        }

        foreach ($productVariations as $productVariation) {
            $variations = [];

            foreach ($variationAttributes as $variationAttribute) {

                if ($productVariation->id != $variationAttribute->product_variation_id) {
                    continue;
                }

                foreach ($attributeValues as $attributeValue) {

                    if ($variationAttribute->attribute_value_id != $attributeValue->id) {
                        continue;
                    }

                    foreach ($attributes as $attribute) {

                        if ($attributeValue->attribute_id != $attribute->id) {
                            continue;
                        }

                        $variations[ $attribute->name ] = $attributeValue->value;
                    }
                }
            }

            $productVariation->variations = $variations;
        }

        return $productVariations;
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
