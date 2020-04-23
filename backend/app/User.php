<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static paginate(int $int)
 * @method static findOrFail(int $id)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function owner() {
        return $this->hasOne('App\Task', 'owner_id');
    }

    public function tasks() {
        return $this->hasMany('App\Task', 'assigned_to_id');
    }

    public function project() {
        return $this->hasMany('App\Project', 'owner_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'commenter_id');
    }
}
