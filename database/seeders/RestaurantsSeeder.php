<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Restaurant;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $faker    = Faker::create();

        $restaurants = [
            ["id" => 1, "title" => "Pot Au Feu"],
            ["id" => 2, "title" => "The Aviary"],
            ["id" => 3, "title" => "Brass Tacks"],
            ["id" => 4, "title" => "Cibo Matto"],
            ["id" => 5, "title" => "Catch 35"],
            ["id" => 6, "title" => "Parallel 37"],
            ["id" => 7, "title" => "Eleven Madison Park"],
        ];

        Restaurant::insert($restaurants);

        $restaurant_ids = Restaurant::pluck('id')->toArray();
    

        foreach(Dish::all() as $dish){
            
            for ($i=0; $i < $faker->numberBetween(0,3); $i++) {

                $dish->restaurants()->attach($faker->randomElement($restaurant_ids));

            }

        }

    }
}
