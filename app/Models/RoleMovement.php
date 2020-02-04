<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMovement extends Model
{
    /**
    * Set model tabl
    */
    protected $table = "role_movement";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['requester_auuid','requester_id','resource_id','attester_id',
    'attester_auuid','resource_auuid','resource_role_id','requested_role_id','hr_auuid','is_claimed'];

    public function profile()
    {
        return $this->hasOne('App\Models\RoleMovementProfile', 'role_movement_id', 'id');
    }
    public function requesterUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'requester_id');
    }
    public function requesterProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'requester_id');
    }
    public function hrProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'hr_auuid');
    }
    public function attesterProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'attester_id');
    }
    
    public function resourceUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'resource_id');
    }
    public function resourceProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'resource_id');
    }
    public function resourceRole()
    {
        return $this->hasOne('Spatie\Permission\Models\Role', 'id', 'resource_role_id');
    }
    public function destinationRole()
    {
        return $this->hasOne('Spatie\Permission\Models\Role', 'id', 'requested_role_id');
    }
}
