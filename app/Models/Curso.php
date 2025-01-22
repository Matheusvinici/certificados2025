<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    // Definir a tabela associada ao modelo
    protected $table = 'cursos';

    // Definir os campos que podem ser preenchidos (mass assignment)
    protected $fillable = [
        'nome',
        'data_inicio',
        'carga_horaria',
        'data_fim',
        'percentual',
        'ativo',
    ];

    // Definir a relação com a tabela de Encontros
    public function encontros()
    {
        return $this->hasMany(Encontro::class);
    }
}
