<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
//            'id' => $this->id,
//            'task_id' => (int)($this->task_id),
//            'commenter_id' => (int)($this->commenter_id),
//            'content' => $this->content,
//            'is_deleted' => (int)($this->is_deleted),
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at
//        ];
    }
}
