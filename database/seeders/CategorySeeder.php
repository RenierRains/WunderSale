<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Textbooks']);
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'School Supplies']);
        Category::create(['name' => 'Furniture & Dorm Essentials']);
        Category::create(['name' => 'Clothing & Accessories']);
        Category::create(['name' => 'Sports & Fitness']);
        Category::create(['name' => 'Games & Hobbies']);
        Category::create(['name' => 'Services']);
        Category::create(['name' => 'Transportation']);
        Category::create(['name' => 'Miscellaneous']);
        
    }
}