<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $table = 'assinaturas';

    protected $fillable = [
        'user_id',
        'nome',
        'cargo',
        'secretaria',
        'facilitador',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
