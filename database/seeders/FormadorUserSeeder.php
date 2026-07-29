<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FormadorUserSeeder extends Seeder
{
    public function run()
    {
        User::where('email', 'formador@gmail.com')->delete();

        User::create([
            'name' => 'Formador',
            'cpf' => '11111111111',
            'matricula' => 'FRM001',
            'email' => 'formador@gmail.com',
            'password' => bcrypt('senhaformador'),
            'role' => 'formador',
        ]);
    }
}
