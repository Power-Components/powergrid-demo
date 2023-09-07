<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Kitchen;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    public function run()
    {
        $dishes = [
            ['name' => 'Pastel de Nata', 'category_id' => 6, 'chef_id' => 1, 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Peixada da chef Nábia', 'category_id' => 1, 'chef_id' => 1, 'price' => 100.11, 'in_stock' => true],
            ['name' => 'Carne Louca', 'category_id' => 1, 'chef_id' => 3, 'price' => 100.12],
            ['name' => 'Bife à Rolê', 'category_id' => 1, 'chef_id' => 1, 'price' => 100.13, 'in_stock' => false],
            ['name' => 'Salmão a Fiorentina', 'category_id' => 2, 'chef_id' => 2, 'price' => 100.14, 'in_stock' => true],
            ['name' => 'Francesinha', 'category_id' => 1, 'chef_id' => 1, 'price' => 100.15, 'in_stock' => true],
            ['name' => 'Barco-Sushi Simples', 'category_id' => 1, 'chef_id' => 2, 'price' => 100.17, 'in_stock' => true],
            ['name' => 'Polpetone Filé Mignon', 'category_id' => 1, 'chef_id' => 1, 'price' => 100.18, 'in_stock' => true],
            ['name' => 'борщ', 'category_id' => 7, 'chef_id' => 1, 'price' => 100.19],
            ['name' => 'Bife à Parmegiana', 'category_id' => 1, 'chef_id' => 4, 'price' => 110.20, 'in_stock' => true],
            ['name' => 'Berinjela à Parmegiana', 'category_id' => 4, 'chef_id' => 3, 'price' => 110.30, 'in_stock' => true],
            ['name' => 'Almôndegas ao Sugo', 'category_id' => 1, 'chef_id' => 1, 'price' => 110.40],
            ['name' => 'Filé Mignon à parmegiana', 'category_id' => 1, 'chef_id' => 4, 'price' => 110.50],
        ];

        $kitchens = Kitchen::all();
        $faker = Faker::create();

        foreach ($dishes as $dish) {

            $dish += [
                'kitchen_id' => $kitchens->random()->id,
                'calories' => $faker->biasedNumberBetween($min = 40, $max = 890, $function = 'sqrt'),
                'produced_at' => $faker->dateTimeBetween($startDate = '-1 months', $endDate = 'now')->format('Y-m-d'),
                'diet' => $faker->randomElement([0, 1, 2]), //Diet::cases()
                'serving_at' => $faker->randomElement(['restaurant', 'room service', 'pool bar']),
            ];

            Dish::create($dish);
        }
    }
}
