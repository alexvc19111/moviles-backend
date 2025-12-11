<?php

namespace App\Repositories;

use App\Models\usuario;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function createUser(array $data, $rol)
    {
        $usuario = usuario::create([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'contraseña' => ($data['contraseña']),
            'rol' => $rol,
        ]);


        return $usuario;
    }

    public function findByCorreo($correo)
    {
        return usuario::where('correo', $correo)->first();
    }
}
