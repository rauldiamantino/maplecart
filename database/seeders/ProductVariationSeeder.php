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
                $attributes = $product->store
                    ->attributes()
                    ->with('values')
                    ->get();

                if ($attributes->isEmpty()) {
                    $product->update([
                        'type' => 'simple',
                        'price' => fake()->randomFloat(2, 10, 300),
                        'quantity' => fake()->numberBetween(1, 100),
                    ]);

                    return;
                }


                // 🔒 Define o padrão de variações UMA VEZ por produto
                $schemaAttributes = $attributes
                    ->shuffle()
                    ->take(fake()->numberBetween(2, min(3, $attributes->count())))
                    ->values();

                $variationsCount = fake()->numberBetween(2, 6);

                for ($i = 1; $i <= $variationsCount; $i++) {
                    $variation = ProductVariation::factory()
                        ->forProduct($product, $i)
                        ->create();

                    // 🔒 Todos os SKUs usam o MESMO padrão
                    $this->attachAttributesFromSchema($variation, $schemaAttributes);
                }
            });
    }


    private function attachAttributesFromSchema(ProductVariation $variation, $schemaAttributes): void
    {
        foreach ($schemaAttributes as $attribute) {

            if ($attribute->values->isEmpty()) {
                continue;
            }

            $variation->attributeValues()->attach(
                $attribute->values->random()->id
            );
        }
    }
}
