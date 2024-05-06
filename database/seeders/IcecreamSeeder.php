<?php

namespace Database\Seeders;

use App\Models\Icecream;
use Illuminate\Database\Seeder;

class IcecreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Icecream::insert([
            ['flavor' => 'chocolate', 'in_stock' => fake()->boolean(), 'price' => fake()->randomFloat(2, 2.50, 5)],
            ['flavor' => 'vanilla', 'in_stock' => fake()->boolean(), 'price' => fake()->randomFloat(2, 2.50, 5)],
            ['flavor' => 'strawberry', 'in_stock' => fake()->boolean(), 'price' => fake()->randomFloat(2, 2.50, 5)],
        ]);
    }
}
