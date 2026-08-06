<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    // Definir a tabela associada ao modelo
    protected $table = 'inscricoes';

    // Definir os campos que podem ser preenchidos (mass assignment)
    protected $fillable = [
        'curso_id',
        'user_id',
        'status',
    ];

    // Relação com a tabela de Cursos
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Relação com a tabela de Usuários
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Posição na lista de espera do curso (1 = próximo a ser chamado).
     * Válido apenas quando status == 'lista_espera'.
     */
    public function posicaoListaEspera(): int
    {
        return self::where('curso_id', $this->curso_id)
            ->where('status', 'lista_espera')
            ->where('id', '<=', $this->id)
            ->count();
    }
}
