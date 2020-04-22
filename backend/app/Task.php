<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class Task extends Model
{
    protected $fillable = [
        'owner_id', 'assigned_to_id', 'name', 'description', 'group_id', 'deadline', 'is_completed', 'priority_id', 'project_id', 'label'
    ];

    public function project() {
        return $this->hasOne('App\Project');
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
