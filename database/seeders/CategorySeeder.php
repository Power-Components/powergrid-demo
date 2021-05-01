<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => 'Carnes'],
            ['name' => 'Peixe'],
            ['name' => 'Tortas'],
            ['name' => 'Acompanhamentos'],
            ['name' => 'Massas'],
            ['name' => 'Sobremesas'],
            ['name' => 'Sopas'],
        ]);
    }
}
