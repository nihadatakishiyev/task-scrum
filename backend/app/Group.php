<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'place'
    ];

    public function tasks() {
        return $this->hasMany('App\Task', 'group_id');
    }
}
