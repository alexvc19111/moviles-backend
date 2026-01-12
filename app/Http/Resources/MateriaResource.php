<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MateriaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'docente' => [$this->docente ? $this->docente->nombre : null,],
            'periodo' => [ $this->periodo ? $this->periodo->nombre : null,],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
