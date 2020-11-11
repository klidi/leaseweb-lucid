<?php

namespace Framework\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Server extends JsonResource
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
            'asset_id' => $this->asset_id,
            'user_id' => $this->user_id,
            'name'  => $this->name,
            'brand' => $this->brand,
            'price' => $this->price->toArray(),
            'ram_modules' => $this->ram_modules,
            'updated_at'  => $this->updated_at,
            'created_at'  => $this->created_at,
        ];
    }
}
