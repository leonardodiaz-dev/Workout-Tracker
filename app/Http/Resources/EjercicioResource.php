<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EjercicioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'categoria_id' => $this->categoria_id,
            'grupo_muscular_id' => $this->grupo_muscular_id,
            'detalle' => [
                'id' => $this->detalle->id ?? null,
                'series' => $this->detalle->series ?? null,
                'repeticiones' => $this->detalle->repeticiones ?? null,
                'peso' => $this->detalle->peso ?? null,
            ],
        ];
    }
}
