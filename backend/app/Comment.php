<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 */
class Comment extends Model
{
    protected $fillable = [
        'task_id', 'commenter_id', 'content', 'is_deleted'
    ];

    public function task() {
        return $this->belongsTo('App\Task');
    }

    public function commenter() {
        return $this->belongsTo('App\User');
    }
}
