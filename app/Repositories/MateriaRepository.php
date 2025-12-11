<?php

namespace App\Repositories;

use App\Interfaces\MateriaRepositoryInterface;
use App\Models\materia;

class MateriaRepository implements MateriaRepositoryInterface
{
    public function all()
    {
        return materia::with(['docente', 'periodo'])->get();
    }

    public function find($id)
    {
        return materia::with(['docente', 'periodo'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return materia::create($data);
    }

    public function update($id, array $data)
    {
        $materia = materia::findOrFail($id);
        $materia->update($data);
        return $materia;
    }

    public function delete($id)
    {
        $materia = materia::findOrFail($id);
        return $materia->delete();
    }
}
