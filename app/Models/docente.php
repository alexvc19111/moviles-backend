<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class docente extends Model
{
    protected $fillable = [
        'usuario_id',
        'codigo',
        'especialidad'
    ];

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function materias()
    {
        return $this->hasMany(materia::class);
    }
}
