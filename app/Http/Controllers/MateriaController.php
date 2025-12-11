<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MateriaService;
use App\Http\Requests\Materia\MateriaStoreRequest;
use App\Http\Requests\Materia\MateriaUpdateRequest;
use App\Http\Resources\MateriaResource;

class MateriaController extends Controller
{
    protected $service;

    public function __construct(MateriaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $materias = $this->service->obtenerTodos();
        return MateriaResource::collection($materias);
    }

    public function store(MateriaStoreRequest $request)
    {
        $materia = $this->service->crear($request->validated());
        return response()->json($materia, 201);
    }

    public function show($id)
    {
         $materia = $this->service->obtenerPorId($id);
         return new MateriaResource($materia);
    }

    public function update(MateriaUpdateRequest $request, $id)
    {
        return response()->json(
            $this->service->actualizar($id, $request->validated())
        );
    }

    public function destroy($id)
    {
        return response()->json([
            'deleted' => $this->service->eliminar($id)
        ]);
    }
}
