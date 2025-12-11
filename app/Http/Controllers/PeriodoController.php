<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PeriodoService;
use App\Http\Requests\Periodo\PeriodoStoreRequest;
use App\Http\Requests\Periodo\PeriodoUpdateRequest;

class PeriodoController extends Controller
{
    protected $service;

    public function __construct(PeriodoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->obtenerTodos());
    }

    public function store(PeriodoStoreRequest $request)
    {
        $periodo = $this->service->crear($request->validated());
        return response()->json($periodo, 201);
    }

    public function show($id)
    {
        return response()->json($this->service->obtenerPorId($id));
    }

    public function update(PeriodoUpdateRequest $request, $id)
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
