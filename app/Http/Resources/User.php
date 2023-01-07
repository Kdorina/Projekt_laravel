<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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

        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "date_of_birth"=> $this->date_of_birth,
            "gender"=> $this->gender,
            
         
        ];
    }
}
