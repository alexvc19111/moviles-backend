<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearAlumnoPerfil
{
    public function handle(UsuarioRegistrado $event)
    {
        $usuario = $event->usuario;

        if ($usuario->rol === 'alumno') {
            alumno::create([
                'usuario_id' => $usuario->id,
                'codigo' => 'ALU-' . str_pad($usuario->id, 5, '0', STR_PAD_LEFT),
                'carrera' => 'Sin asignar',
                'semestre' => 1
            ]);
        }
    }
}