<?php

namespace App\Http\Resources\Reuniones;

use Illuminate\Http\Resources\Json\JsonResource;

class ReunionesJoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "reunion_id" => $this->resource->reunion_id,
            "joining_at" => $this->resource->joining_at,
            "disconnected_at" => $this->resource->disconnected_at
        ];
    }
}
