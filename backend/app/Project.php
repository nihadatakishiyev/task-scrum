<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'group_id', 'deadline', 'is_completed', 'priority_id'
    ];

    public function tasks() {
        return $this->hasMany('App\Task');
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
