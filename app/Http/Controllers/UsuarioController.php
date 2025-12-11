<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UsuarioService;
use App\Http\Requests\Usuario\UsuarioStoreRequest;
use App\Http\Requests\Usuario\UsuarioUpdateRequest;

class UsuarioController extends Controller
{
    protected $service;

    public function __construct(UsuarioService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->obtenerTodos());
    }

    public function store(UsuarioStoreRequest $request)
    {
        $usuario = $this->service->crear($request->validated());
        return response()->json($usuario, 201);
    }

    public function show($id)
    {
        return response()->json($this->service->obtenerPorId($id));
    }

    public function update(UsuarioUpdateRequest $request, $id)
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
