<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "user_id"=>$this['user_id'],
            // "user"=>[
            //     "id"=> $this->user ? $this->user->id : "Not Found",
            //     "name"=> $this->user ? $this->user->name : "Not Found",
            //     "email"=> $this->user ? $this->user->email : "Not Found",
            // ],
            "user"=>new UserResource($this->user),
            'slug'=>$this->slug
     ];
    }
}
