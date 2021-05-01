<?php

namespace Database\Seeders;

use App\Models\Kitchen;
use Illuminate\Database\Seeder;

class KitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kitchen::insert([
            ['name' => 'SP'],
            ['name' => 'RJ'],
            ['name' => 'MG'],
            ['name' => 'BA'],
        ]);
    }
}
