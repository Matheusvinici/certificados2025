<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FormadorUserSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have a way to get the selected school ID (e.g., from a fixture)
        $selectedSchoolId = 1; // Replace with the actual logic to get the ID

        DB::table('users')->insert([
            'name' => 'Formador',
            'escola_id' => $selectedSchoolId,
            'email' => 'formador@gmail.com',
            'password' => bcrypt('senhaformador'),
            'role' => 'formador',
        ]);
    }
}