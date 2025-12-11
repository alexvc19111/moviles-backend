<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'clase_id',
        'alumno_id',
        'estado',
        'observacion',
        'marcado_por'
    ];

    public function clase()
    {
        return $this->belongsTo(clase::class, 'clase_id');
    }

    public function alumno()
    {
        return $this->belongsTo(usuario::class, 'alumno_id');
    }

    public function marcador()
    {
        return $this->belongsTo(usuario::class, 'marcado_por');
    }
}
