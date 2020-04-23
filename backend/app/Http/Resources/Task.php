<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id' =>$this->id,
            'name' => $this->name,
            'description' =>$this->description,
            'label' => $this->label,
            'owner_id' =>(int)($this->owner_id),
            'assigned_to_id' => (int)($this->assigned_to_id),
            'project_id' => (int)($this->project_id),
            'priority_id' => (int)($this->priority_id),
            'group_id' => (int)($this->group_id),
            'deadline' => $this->deadline,
            'is_completed' =>(int)($this->completed),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
