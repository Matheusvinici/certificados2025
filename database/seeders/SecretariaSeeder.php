<?php

namespace Database\Seeders;

use App\Models\Secretaria;
use Illuminate\Database\Seeder;

class SecretariaSeeder extends Seeder
{
    public function run(): void
    {
        $secretarias = [
            ['nome' => 'Administração', 'descricao' => 'Secretaria de Administração'],
            ['nome' => 'Agricultura', 'descricao' => 'Secretaria de Agricultura'],
            ['nome' => 'Assistência Social', 'descricao' => 'Secretaria de Assistência Social'],
            ['nome' => 'Cultura', 'descricao' => 'Secretaria de Cultura'],
            ['nome' => 'Desenvolvimento Econômico', 'descricao' => 'Secretaria de Desenvolvimento Econômico'],
            ['nome' => 'Educação', 'descricao' => 'Secretaria de Educação'],
            ['nome' => 'Esportes', 'descricao' => 'Secretaria de Esportes'],
            ['nome' => 'Fazenda', 'descricao' => 'Secretaria de Fazenda'],
            ['nome' => 'Gestão de Pessoas', 'descricao' => 'Secretaria de Gestão de Pessoas'],
            ['nome' => 'Governo', 'descricao' => 'Secretaria de Governo'],
            ['nome' => 'Infraestrutura', 'descricao' => 'Secretaria de Infraestrutura'],
            ['nome' => 'Meio Ambiente', 'descricao' => 'Secretaria de Meio Ambiente'],
            ['nome' => 'Planejamento', 'descricao' => 'Secretaria de Planejamento'],
            ['nome' => 'Procuradoria', 'descricao' => 'Procuradoria Geral do Município'],
            ['nome' => 'Saúde', 'descricao' => 'Secretaria de Saúde'],
            ['nome' => 'Segurança Pública', 'descricao' => 'Secretaria de Segurança Pública'],
            ['nome' => 'Transportes', 'descricao' => 'Secretaria de Transportes'],
            ['nome' => 'Turismo', 'descricao' => 'Secretaria de Turismo'],
        ];

        foreach ($secretarias as $secretaria) {
            Secretaria::firstOrCreate(['nome' => $secretaria['nome']], $secretaria);
        }
    }
}
