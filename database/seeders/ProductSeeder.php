<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::query()->each(function (Store $store) {
            Product::factory()
                ->count(5)
                ->for($store)
                ->simple()
                ->create(['status' => 'active']);

            Product::factory()
                ->count(5)
                ->for($store)
                ->variable()
                ->create(['status' => 'active']);
        });
    }
}
