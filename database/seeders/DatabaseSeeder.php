<?php

namespace Database\Seeders;

use App\Models\Chef;
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
            RestaurantSeeder::class,
            ChefSeeder::class,
            DishSeeder::class,
        ]);

        User::factory(30)->create();

        $chefCategories = [
            'Luan' => [1, 3, 4],
            'Dan' => [2, 5],
            'Vitor' => [5, 6],
            'Claudio' => [1, 6, 7],
        ];

        Chef::query()->get()->each(function (Chef $chef) use ($chefCategories) {
            $chef->categories()->attach($chefCategories[$chef->name]);
        });
    }
}
