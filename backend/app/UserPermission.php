<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 */
class UserPermission extends Model
{
    protected $fillable = [
        'user_id', 'project_id', 'permission_type_id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function project() {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
