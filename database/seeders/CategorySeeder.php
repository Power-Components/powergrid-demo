<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::query()->insert([
            ['name' => 'Meat'],
            ['name' => 'Fish'],
            ['name' => 'Pie'],
            ['name' => 'Garnish'],
            ['name' => 'Pasta'],
            ['name' => 'Dessert'],
            ['name' => 'Soup'],
        ]);
    }
}
