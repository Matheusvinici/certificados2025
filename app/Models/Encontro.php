<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encontro extends Model
{
    use HasFactory;

    protected $table = 'encontros';

    protected $fillable = [
        'curso_id',
        'conteudo',
        'data',
        'carga_horaria_encontro',
        'hash',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }
}
