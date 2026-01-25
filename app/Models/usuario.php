<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'usuarios'; 
    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
        'rol',
    ];

    protected $hidden = ['contraseña'];
    
    public function getAuthPassword()
{
    return $this->contraseña;
}

    public function materiasComoDocente()
    {
        return $this->hasMany(materia::class, 'docente_id');
    }

    public function inscripciones()
    {
        return $this->hasMany(inscripcion::class, 'alumno_id');
    }

    public function materiasInscritas()
    {
        return $this->belongsToMany(materia::class, 'inscripciones', 'alumno_id', 'materia_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(calificacion::class, 'alumno_id');
    }

    public function asistencias()
    {
        return $this->hasMany(asistencia::class, 'alumno_id');
    }

    public function avisosCreados()
    {
        return $this->hasMany(aviso::class, 'creado_por');
    }

    public function deviceTokens()
    {
        return $this->hasMany(device_token::class, 'usuario_id');
    }
    public function alumno()
{
    return $this->hasOne(alumno::class, 'usuario_id');
}
public function docente()
{
    return $this->hasOne(docente::class);
}

}
