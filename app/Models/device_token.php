<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class device_token extends Model
{
    protected $table = 'device_tokens';

    protected $fillable = [
        'usuario_id',
        'token',
        'plataforma'
    ];

    public function usuario()
    {
        return $this->belongsTo(usuario::class, 'usuario_id');
    }
}
