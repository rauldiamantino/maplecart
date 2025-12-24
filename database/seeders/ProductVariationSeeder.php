<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::where('type', 'variable')
            ->with(['store.attributesWithValues'])
            ->each(function (Product $product) {
                $variationsCount = fake()->numberBetween(2, 6);

                for ($i = 1; $i <= $variationsCount; $i++) {
                    $variation = ProductVariation::factory()
                        ->forProduct($product, $i)
                        ->create();

                    $this->attachAttributes($variation, $product->store);
                }
            });
    }

    private function attachAttributes(ProductVariation $variation, Store $store): void
    {
        $attributes = $store->attributesWithValues;

        if ($attributes->isEmpty()) {
            return;
        }

        $selectedAttributes = $attributes
            ->shuffle()
            ->take(fake()->numberBetween(1, min(2, $attributes->count())));

        foreach ($selectedAttributes as $attribute) {

            if ($attribute->values->isEmpty()) {
                continue;
            }

            $variation->attributeValues()->attach(
                $attribute->values->random()->id
            );
        }
    }
}
