<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Chef;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            KitchenSeeder::class,
            CategorySeeder::class,
            RestaurantSeeder::class,
            ChefSeeder::class,
            DishSeeder::class,
            UserSeeder::class,
            IcecreamSeeder::class,
        ]);

        $chefCategories = Category::all();

        Chef::query()->get()->each(function (Chef $chef) use ($chefCategories) {
            $chef->categories()->attach($chefCategories->shuffle()->take(rand(1, 4)));
        });
    }
}
