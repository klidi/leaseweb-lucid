<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 10.11.20
 * Time: 10:43 PM
 */

namespace Framework\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email'  => $this->email,
        ];
    }
}

