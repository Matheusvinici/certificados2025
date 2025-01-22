<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deletar o usuário caso já exista
        User::where('email', 'ntm.seduc@gmail.com')->delete();

        // Criar o novo usuário
        User::create([
            'name' => 'Administrador',
            'escola' => 'Crenildes',

            'email' => 'ntm.seduc@gmail.com',
            'password' => Hash::make('nucleomunicipal'),
            'role' => 'admin',
        ]);
    }
}
