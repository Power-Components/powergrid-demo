<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::insert(
            [
                ["title" => "Παρά θιν' αλός"],
                ["title" => "The Aviary"],
                ["title" => "Brass Tacks"],
                ["title" => "Cibo Matto"],
                ["title" => "Catch 35"],
                ["title" => "Parallel 37"],
                ["title" => "Eleven Madison Park"]
            ]
        );

        $restaurants = Restaurant::all();
        
        Dish::all()->each(fn($dish) => $dish->restaurants()->sync($restaurants->random(rand(1,3))));
    }
}
