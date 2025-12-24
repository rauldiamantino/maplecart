<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectInsertSeeder extends Seeder
{
    public function run(): void
    {
        echo "=== INSERÇÃO DIRETA NO BANCO ===\n";

        // 1. Insere uma variação
        $variationId = DB::table('product_variations')->insertGetId([
            'product_id' => 1, // Substitua pelo ID real do seu produto
            'sku' => 'DIRECT-TEST',
            'price' => 88.90,
            'quantity' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Variação inserida: ID {$variationId}\n";

        // 2. Insere na tabela pivot
        DB::table('variation_attributes')->insert([
            [
                'product_variation_id' => $variationId,
                'attribute_value_id' => 1, // red
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_variation_id' => $variationId,
                'attribute_value_id' => 3, // M
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        echo "✅ 2 registros inseridos na pivot\n";

        // 3. Verifique
        $result = DB::table('variation_attributes')
            ->where('product_variation_id', $variationId)
            ->count();

        echo "✅ Registros na pivot: {$result}\n";

        // 4. Teste o relacionamento
        $test = DB::table('variation_attributes as va')
            ->join('attribute_values as av', 'va.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
            ->where('va.product_variation_id', $variationId)
            ->select('a.name', 'av.value')
            ->get();

        echo "✅ Atributos conectados: " . $test->count() . "\n";
        foreach ($test as $row) {
            echo "  - {$row->name} = {$row->value}\n";
        }
    }
}
