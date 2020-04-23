<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return parent::toArray($request);
//        return [
//            'id' =>$this->id,
//            'owner_id' =>(int)($this->owner_id),
//            'name' => $this->name,
//            'description' =>$this->description,
//            'color_code' => $this->color_code,
//            'is_completed' =>(int)($this->completed),
//            'deadline' => $this->deadline,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at
//        ];
    }
}
