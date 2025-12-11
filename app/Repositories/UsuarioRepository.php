<?php

namespace App\Repositories;

use App\Interfaces\UsuarioRepositoryInterface;
use App\Models\usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function all()
    {
        return usuario::all();
    }

    public function find($id)
    {
        return usuario::findOrFail($id);
    }

    public function create(array $data)
    {
        return usuario::create($data);
    }

    public function update($id, array $data)
    {
        $usuario = usuario::findOrFail($id);
        $usuario->update($data);
        return $usuario;
    }

    public function delete($id)
    {
        $usuario = usuario::findOrFail($id);
        return $usuario->delete();
    }
}
