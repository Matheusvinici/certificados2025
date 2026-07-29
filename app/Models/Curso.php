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
        'data_inicio_inscricao',
        'data_fim_inscricao',
        'user_assinatura_id',
    ];

    public function encontros()
    {
        return $this->hasMany(Encontro::class);
    }

    public function responsavelAssinatura()
    {
        return $this->belongsTo(User::class, 'user_assinatura_id');
    }
}
