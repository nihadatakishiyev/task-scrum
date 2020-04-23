<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'task_id', 'commenter_id', 'content', 'is_deleted'
    ];

    public function task() {
        return $this->hasOne('App\Task');
    }
}
