<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class Task extends Model
{
    protected $fillable = [
        'name', 'description', 'owner_id', 'assigned_to_id', 'project_id', 'priority_id', 'group_id', 'deadline', 'is_completed', 'label'
    ];

    public function project() {
        return $this->hasOne('App\Project');
    }

    public function user() {
        return $this->hasOne('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'task_id');
    }

    public function priority() {
        return $this->hasOne('App\Priority');
    }
}
