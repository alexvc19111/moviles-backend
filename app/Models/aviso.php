<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class aviso extends Model
{
    protected $table = 'avisos';

    protected $fillable = [
        'titulo',
        'mensaje',
        'destinatario_tipo',
        'destinatario_id',
        'creado_por',
        'sent_at'
    ];

    public function creador()
    {
        return $this->belongsTo(usuario::class, 'creado_por');
    }

    public function lecturas()
    {
        return $this->hasMany(notificacion_leida::class, 'aviso_id');
    }
}
