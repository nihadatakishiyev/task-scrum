<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class ActivityLog extends Model
{
    protected $fillable = [
      'action_name', 'owner_id'
    ];

    public function owner() {
        return $this->belongsTo('App\ActivityLog', 'owner_id');
    }
}
