<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Product One',
                'price' => 2.99,
                'stock_quantity' => 5,
                'description' => Str::random(20),
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Product One',
                'price' => 1.99,
                'stock_quantity' => 10,
                'description' => Str::random(20),
                'product_category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Product Three',
                'price' => 4.99,
                'stock_quantity' => 15,
                'description' => Str::random(20),
                'product_category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('products')->insertOrIgnore($data);
    }
}
