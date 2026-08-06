<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    use HasFactory;

    protected $table = 'frequencias';

    protected $fillable = [
        'encontro_id',
        'user_id',
        'avaliacao_conteudo',
        'avaliacao_metodologia',
        'comentarios',
        'hora_inicio',
        'hora_saida',
    ];

    protected static function booted()
    {
        static::creating(function ($frequencia) {
            $frequencia->hora_inicio = $frequencia->hora_inicio ?? now()->format('H:i');

            if (! $frequencia->hora_saida && $frequencia->encontro) {
                $inicio = \Carbon\Carbon::parse($frequencia->hora_inicio);
                $frequencia->hora_saida = $inicio
                    ->addHours((int) $frequencia->encontro->carga_horaria_encontro)
                    ->format('H:i');
            }
        });
    }

    public function encontro()
    {
        return $this->belongsTo(Encontro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
