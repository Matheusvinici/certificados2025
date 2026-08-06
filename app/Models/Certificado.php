<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificado extends Model
{
    use HasFactory;

    protected $table = 'certificados';

    protected $fillable = [
        'curso_id',
        'user_id',
        'emitido',
        'hash_unico',
    ];

    protected static function booted(): void
    {
        static::creating(function (Certificado $certificado) {
            if (empty($certificado->hash_unico)) {
                $payload = $certificado->curso_id.'-'.$certificado->user_id.'-'.now()->timestamp.'-'.Str::random(16);
                $certificado->hash_unico = strtoupper(substr(hash('sha256', $payload), 0, 10));
            }
        });
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
