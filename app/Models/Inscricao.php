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
    public function frequencias()
        {
            return $this->hasMany(Frequencia::class);
        }

}

