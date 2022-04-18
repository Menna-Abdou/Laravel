<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id"=> $this->id ? $this->id : "Not Found",
            "name"=> $this->name ? $this->name : "Not Found",
            "email"=> $this->email ? $this->email : "Not Found",
        ];
    }
}
