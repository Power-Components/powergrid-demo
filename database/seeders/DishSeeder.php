<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Kitchen;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dishes = [
            ['name' => 'Pastel de Nata', 'category_id' => 6, 'chef_name' => null, 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Peixada da chef Nábia', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.11, 'in_stock' => true],
            ['name' => 'Carne Louca', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 100.12],
            ['name' => 'Bife à Rolê', 'category_id' => 1, 'chef_name' => 'Vitor', 'price' => 100.13, 'in_stock' => false],
            ['name' => 'Salmão a Fiorentina', 'category_id' => 2, 'chef_name' => 'Cláudio', 'price' => 100.14, 'in_stock' => true],
            ['name' => 'Francesinha', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.15, 'in_stock' => true],
            ['name' => 'Barco-Sushi da Sueli', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.16, 'in_stock' => true],
            ['name' => 'Barco-Sushi Simples', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.17, 'in_stock' => true],
            ['name' => 'Polpetone Filé Mignon', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 100.18, 'in_stock' => true],
            ['name' => 'борщ', 'category_id' => 7, 'chef_name' => 'Luan', 'price' => 100.19],
            ['name' => 'Bife à Parmegiana', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 110.20, 'in_stock' => true],
            ['name' => 'Berinjela à Parmegiana', 'category_id' => 4, 'chef_name' => 'Dan', 'price' => 110.30, 'in_stock' => true],
            ['name' => 'Almôndegas ao Sugo', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 110.40],
            ['name' => 'Filé Mignon à parmegiana', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 110.50],
            ['name' => 'Strogonoff de Filé Mignon', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 110.60, 'in_stock' => true],
            ['name' => 'Carne Assada ao Molho Ferrugem', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 110.70, 'in_stock' => true],
            ['name' => 'Kibe Assado Recheado 500g', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 110.80],
            ['name' => 'Carne Assada ao Molho', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 110.90, 'in_stock' => true],
            ['name' => 'Empadão de Palmito', 'category_id' => 3, 'chef_name' => 'Luan', 'price' => 130.30, 'in_stock' => true],
            ['name' => 'Empadão de Alcachofra', 'category_id' => 3, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Ratatouille', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Legumes Primavera ', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Purê de Banana Terra Tartufo', 'category_id' => 4, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Farofa de Banana da Terra Tartufo 60g', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Cenoura com Chia Tartufo', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Camarão ao Thermidor', 'category_id' => 2, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Carne de Panela ao Molho Ferrugem', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Escondidinho de Carne Seca', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Lagarto recheado com Calabresa', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Filé Mignon Ao Vinho', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Filé Mignon comGorgonzola', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Maminha Assada', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Lagarto', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Strogonoff', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Filé Mignon Suíno', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Carne Moída com Legumes', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Carne Moída com Lentilha', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Carne de Panela ao Molho Funghi', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Escondidinho de Cenoura e Carne Seca', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Hamburguer Assado', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Carne na Cerveja Preta', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Picadinho de Carne', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Filé Mignon', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Feijoada da Chef', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Bife à Milanesa', 'category_id' => 1, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => false],
            ['name' => 'Filé Mignon à Parmegiana', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Feijoada', 'category_id' => 1, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Filé de Peixe', 'category_id' => 2, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Saint Peter à Fiorentina', 'category_id' => 2, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Salmão ao Molho de Mostarda e Mel', 'category_id' => 2, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Salmão ao Molho de Cogumelos', 'category_id' => 2, 'chef_name' => 'Cláudio', 'price' => 100.10],
            ['name' => 'Filé de Pescada à Milanesa', 'category_id' => 2, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Bacalhau Gratinado - 600g', 'category_id' => 2, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Filé de Peixe à Dorê', 'category_id' => 2, 'chef_name' => 'Vitor', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Filé de Pescada à Dorê', 'category_id' => 2, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Quiche Brie com Damasco', 'category_id' => 3, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Quiche Alho Poró', 'category_id' => 3, 'chef_name' => 'Cláudio', 'price' => 100.10],
            ['name' => 'Quiche Festa Três Queijos', 'category_id' => 3, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Torta Campestre de Frango', 'category_id' => 3, 'chef_name' => 'Vitor', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Torta Média de Frango com Requeijão', 'category_id' => 3, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Risoto de Filé Mignon', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Escondidinho de Carne Moída', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Berinjela ao Pomodoro e 4 Queijos', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Creme de Milho', 'category_id' => 4, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Batata Assada Três Queijos -', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Batata Assada Bacon com Requeijão', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Purê de Batatas', 'category_id' => 4, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Purê de Mandioquinha', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Creme de Espinafre', 'category_id' => 4, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Rondellini de Mussarela ao Sugo', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha de Berinjela Assada ', 'category_id' => 5, 'chef_name' => 'Cláudio', 'price' => 100.10],
            ['name' => 'Lasanha de Abobrinha Assada', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha ao Creme Funghi', 'category_id' => 5, 'chef_name' => 'Cláudio', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Lasanha Verde com Frango ', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Tortelli de Mussarela', 'category_id' => 5, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Capeteli Frango in Brodo Tartufo', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Talharim aos 2 Queijos', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha de Batata Doce', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Rondellini de Mussarela ao Sugo', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha Margherita', 'category_id' => 5, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Lasanha de Espinafre e Queijos', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha à Bolognesa', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha Marguerita Média', 'category_id' => 5, 'chef_name' => 'Vitor', 'price' => 100.10],
            ['name' => 'Talharim ao Ragú de Costelinha', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Panqueca de Carne com Molho', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Talharim a Bolognesa', 'category_id' => 5, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Lasanha de Mussarela', 'category_id' => 5, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Bolo de Beijinho', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Fios de Ovos 500g', 'category_id' => 6, 'chef_name' => 'Cláudio', 'price' => 100.10],
            ['name' => 'Brownie Low Carb', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Creme de Morangos', 'category_id' => 6, 'chef_name' => 'Dan', 'price' => 100.10],
            ['name' => 'Doce de mamão', 'category_id' => 6, 'chef_name' => 'Vitor', 'price' => 100.10],
            ['name' => 'Torta de Pêra', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Torta de Limão Siciliano', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Fios de Ovos 250g', 'category_id' => 6, 'chef_name' => 'Dan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Torta de Baunilha com Berries 450g', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Torta de Chocolate Belga', 'category_id' => 6, 'chef_name' => 'Vitor', 'price' => 100.10, 'in_stock' => true],
            ['name' => 'Bolo de Brigadeiro Belga BB', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Torta de Brigadeiro Crocante', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Strudel de Maçã', 'category_id' => 6, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Sopa de Tomates Assados', 'category_id' => 7, 'chef_name' => 'Luan', 'price' => 100.10],
            ['name' => 'Sopa Creme de Ervilha', 'category_id' => 7, 'chef_name' => 'Vitor', 'price' => 100.10, 'in_stock' => true],
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
