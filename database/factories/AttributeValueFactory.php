<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    public const VALUES_BY_ATTRIBUTE = [
        'color' => ['red', 'blue', 'green', 'black'],
        'size' => ['S', 'M', 'L', 'XL'],
        'material' => ['cotton1', 'cotton2', 'cotton3', 'cotton4'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::factory(),
            'value' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Model $model) {
            $model->value = $this->valueFor($model->attribute);
        });
    }

    private function valueFor(Attribute $attribute): string
    {
        return fake()->randomElement(
            self::VALUES_BY_ATTRIBUTE[ $attribute->name ] ?? ['default'],
        );
    }
}
