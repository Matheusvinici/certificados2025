<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Escola; // Use the Escola model

class EscolaSeeder extends Seeder
{
    public function run()
    {
        // Check if the escola already exists
        $escola = Escola::where('nome', 'Crenildes')->first();

        if (!$escola) {
            // Create the escola using the model
            Escola::create([
                'nome' => 'Crenildes',
            ]);
        }
    }
}