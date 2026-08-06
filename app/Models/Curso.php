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
        'vagas',
        'status',
    ];

    public function encontros()
    {
        return $this->hasMany(Encontro::class);
    }

    /**
     * Formadores do curso (um curso pode ter vários).
     */
    public function formadores()
    {
        return $this->belongsToMany(User::class, 'curso_formador', 'curso_id', 'formador_id');
    }

    /**
     * Responsáveis pela assinatura do curso (podem ser vários).
     */
    public function responsaveisAssinatura()
    {
        return $this->belongsToMany(User::class, 'curso_assinatura', 'curso_id', 'user_id');
    }
}
