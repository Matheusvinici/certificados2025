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
        
    ];

    public function encontro()
    {
        return $this->belongsTo(Encontro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}