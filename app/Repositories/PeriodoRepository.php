<?php

namespace App\Repositories;

use App\Interfaces\PeriodoRepositoryInterface;
use App\Models\periodo_academico;

class PeriodoRepository implements PeriodoRepositoryInterface
{
    public function all()
    {
        return periodo_academico::all();
    }

    public function find($id)
    {
        return periodo_academico::findOrFail($id);
    }

    public function create(array $data)
    {
        return periodo_academico::create($data);
    }

    public function update($id, array $data)
    {
        $periodo = periodo_academico::findOrFail($id);
        $periodo->update($data);
        return $periodo;
    }

    public function delete($id)
    {
        $periodo = periodo_academico::findOrFail($id);
        return $periodo->delete();
    }
}
