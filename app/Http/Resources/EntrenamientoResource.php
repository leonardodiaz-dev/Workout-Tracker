<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntrenamientoResource extends JsonResource
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
            'titulo' => $this->titulo,
            'comentario' => $this->comentario,
            'status' => $this->status,
            'fecha_programacion' => $this->fecha_programacion,
            'ejercicios' => EjercicioResource::collection($this->whenLoaded('ejercicios')),
        ];
    }
}
