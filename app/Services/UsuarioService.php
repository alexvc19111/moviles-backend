<?php

namespace App\Services;

use App\Interfaces\UsuarioRepositoryInterface;

class UsuarioService
{
    protected $repo;

    public function __construct(UsuarioRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function obtenerTodos()
    {
        return $this->repo->all();
    }

    public function obtenerPorId($id)
    {
        return $this->repo->find($id);
    }

    public function crear(array $data)
    {
        $data['contraseña'] = bcrypt($data['contraseña']);
        return $this->repo->create($data);
    }

    public function actualizar($id, array $data)
    {
        if (isset($data['contraseña'])) {
            $data['contraseña'] = bcrypt($data['contraseña']);
        }
        return $this->repo->update($id, $data);
    }

    public function eliminar($id)
    {
        return $this->repo->delete($id);
    }
}
