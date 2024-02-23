<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $items = [
            ['name' => 'Item 1', 'description' => 'Description for Item 1', 'price' => 100.00, 'category_id' => 1, 'image' => null],
            ['name' => 'Item 2', 'description' => 'Description for Item 2', 'price' => 150.00, 'category_id' => 2, 'image' => null],
            ['name' => 'Item 3', 'description' => 'Description for Item 3', 'price' => 200.00, 'category_id' => 3, 'image' => null],
            ['name' => 'Item 10', 'description' => 'Description for Item 10', 'price' => 500.00, 'category_id' => 10, 'image' => null],
        ];

        // Insert items into the database
        foreach ($items as $item) {
            DB::table('items')->insert($item);
        }
    }
}
