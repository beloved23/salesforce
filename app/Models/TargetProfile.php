<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetProfile extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'targets_profile';

     
    /**
    * Get the target that owns the profile
    */
    public function target()
    {
        return $this->belongsTo('App\Models\Target', 'target_id', 'id');
    }
    /**
    * Get the user profile of the assignee
    */
    public function assigneeProfile()
    {
        return $this->hasOne("App\Models\UserProfile", 'user_id', 'assigned_to_user_id');
    }
}
