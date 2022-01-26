<?php

namespace App\Http\Resources\Reuniones;

use Illuminate\Http\Resources\Json\JsonResource;

class ReunionesResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "created_at" => $this->resource->created_at->format('Y-m-d H:i:s')
        ];
    }
}
