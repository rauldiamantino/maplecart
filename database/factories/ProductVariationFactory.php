<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => strtoupper(fake()->bothify('VAR-#####')),
            'price' => fake()->randomFloat(2, 10, 300),
            'quantity' => fake()->numberBetween(0, 50),
            'weight' => fake()->randomFloat(2, 0.01, 5),
        ];
    }

    public function forProduct(Product $product, int $index): static
    {
        return $this->state([
            'product_id' => $product->id,
            'sku' => "{$product->sku}-VAR" . str_pad($index, 3, '0', STR_PAD_LEFT),
        ]);
    }
}
