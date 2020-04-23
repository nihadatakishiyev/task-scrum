<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($project_id)
 */
class Project extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'description', 'color_code', 'deadline', 'is_completed'
    ];

    public function tasks() {
        return $this->hasMany('App\Task');
    }

    public function owner() {
        return $this->belongsTo('App\User', 'owner_id');
    }
}
