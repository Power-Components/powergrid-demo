<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::query()->insert([
            [
                'name' => 'Luan',
                'email' => 'luanfreitasdev@fakemail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Daniel',
                'email' => 'dansysanalyst@fakemail.com',
                'password' => 'password',
            ],
            [
                'nome' => 'Claudio',
                'email' => 'claudio@fakemail.com',
                'password' => 'password',
            ],
            [
                'nome' => 'Vitor',
                'email' => 'vitao@fakemail.com',
                'password' => 'password',
            ],
            [
                'nome' => 'Tio Jobs',
                'email' => 'tiojobs@fakemail.com',
                'password' => 'password',
            ],
        ]);
    }
}
