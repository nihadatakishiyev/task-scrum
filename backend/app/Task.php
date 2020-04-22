<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'group_id', 'deadline', 'is_completed', 'priority_id'
    ];

    public function project() {
        return $this->hasOne('app\Project');
    }

    public function user() {
        return $this->hasOne('app\User');
    }
}
