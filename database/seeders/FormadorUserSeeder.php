<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class FormadorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deletar o formador caso já exista
        User::where('email', 'formador@gmail.com')->delete();

        // Criar o novo formador
        User::create([
            'name' => 'Formador',
            'escola' => 'Crenildes',

            'email' => 'formador@gmail.com',
            'password' => bcrypt('senhaformador'),
            'role' => 'formador',
        ]);
    }
}
