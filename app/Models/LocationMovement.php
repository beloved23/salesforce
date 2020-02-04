<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationMovement extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'location_movement';

    protected $fillable = ['initiated_by','requester_id','requester_auuid','location_model','attester_auuid','attester_id','location_id','requester_location_id','requester_role_id'];

    //get the associated location movement profile
    public function profile()
    {
        return $this->hasOne('App\Models\LocationMovementProfile', 'location_movement_id', 'id');
    }
    public function requesterProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'requester_id');
    }
    public function requesterUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'requester_id');
    }
    public function hrProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'hr_id');
    }
    public function hrUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'hr_id');
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
