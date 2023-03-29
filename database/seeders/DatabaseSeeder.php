<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
        User::factory(30)->create();
    }
}
