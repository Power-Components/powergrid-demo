<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\KitchenSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            KitchenSeeder::class,
            CategorySeeder::class,
            DishSeeder::class,
        ]);
    }
}
