<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notificacion_leida extends Model
{
    protected $table = 'notificacion_leidas';

    protected $fillable = [
        'aviso_id',
        'usuario_id',
        'leido',
        'leido_at'
    ];

    public function aviso()
    {
        return $this->belongsTo(aviso::class, 'aviso_id');
    }

    public function usuario()
    {
        return $this->belongsTo(usuario::class, 'usuario_id');
    }
}
