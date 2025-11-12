<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TareaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'finalizada' => (bool)$this->finalizada,
            'fecha_limite' => $this->fecha_limite->toISOString(),
            'fecha_limite_formatted' => $this->fecha_limite->format('d/m/Y H:i'),
            'urgencia' => $this->urgencia,
            'urgencia_texto' => $this->urgencia_texto,
            'urgencia_clase' => $this->urgencia_clase,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
