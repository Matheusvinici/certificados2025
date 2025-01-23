<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Find the "Crenildes" school (or create it if it doesn't exist)
        $escola = DB::table('escolas')->where('nome', 'Crenildes')->first();
        if (!$escola) {
            $escola = DB::table('escolas')->insertGetId([
                'nome' => 'Crenildes',
            ]);
        }

        // Ensure $escola is an object before accessing its properties
        if (is_object($escola)) {
            $escolaId = $escola->id;
        } else {
            // Handle the case where the school is not found (optional)
            // You can throw an exception or log an error message
            throw new \Exception("Escola 'Crenildes' not found.");
        }

        // Create the admin user associated with the "Crenildes" school
        DB::table('users')->insert([
            'name' => 'Administrador',
            'escola_id' => $escolaId,
            'email' => 'ntm.seduc@gmail.com',
            'password' => Hash::make('secret'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}