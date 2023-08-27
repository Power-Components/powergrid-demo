<?php

namespace Database\Seeders;

use App\Models\Chef;
use Illuminate\Database\Seeder;

class ChefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chef::query()->insert([
            ['name' => 'Luan', 'restaurant_id' => 1],
            ['name' => 'Dan', 'restaurant_id' => 1],
            ['name' => 'Vitor', 'restaurant_id' => 1],
            ['name' => 'Claudio', 'restaurant_id' => 1],
        ]);
    }
}
