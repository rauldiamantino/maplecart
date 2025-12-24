<?php

namespace Database\Seeders;

use App\Models\Store;
use Database\Factories\AttributeValueFactory;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::query()->each(function (Store $store) {
            foreach (AttributeValueFactory::VALUES_BY_ATTRIBUTE as $name => $values) {
                $attribute = $store->attributes()->create([
                    'name' => $name,
                ]);

                foreach ($values as $value) {
                    $attribute->values()->create([
                        'value' => $value,
                    ]);
                }
            }
        });
    }
}
