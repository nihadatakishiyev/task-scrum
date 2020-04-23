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
}
