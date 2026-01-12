<?php

namespace App\Repositories;

use App\Models\usuario;

class AuthRepository
{
    public function createUser(array $data)
    {
        return usuario::create($data);
    }

    public function findByCorreo($correo)
    {
        return usuario::where('correo', $correo)->first();
    }
}
