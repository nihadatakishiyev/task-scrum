<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'group_id', 'deadline', 'is_completed', 'priority_id'
    ];

    public function project() {
        return $this->hasOne('App\Project');
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
