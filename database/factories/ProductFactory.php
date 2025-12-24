<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'name' => fake()->words(3, true),
            'slug' => fake()->slug(3),
            'description' => fake()->paragraph(),
            'sku' => strtoupper(fake()->bothify('PROD-#####')),
            'type' => 'simple',
            'status' => fake()->randomElement(['draft', 'active', 'archived']),
            'price' => fake()->randomFloat(2, 10, 500),
            'quantity' => fake()->numberBetween(0, 100),
        ];
    }

    public function simple(): static
    {
        return $this->state([
            'type' => 'simple',
        ]);
    }

    public function variable(): static
    {
        return $this->state([
            'type' => 'variable',
            'price' => null,
            'quantity' => null,
        ]);
    }
}
