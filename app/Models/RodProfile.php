<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RodProfile extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'rod_profile';
     
    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
    * Get the user that owns the profile.
    */
    public function region()
    {
        return $this->hasOne('App\Models\LocationRegion', 'id', 'region_id');
    }
    /**
    *Get zbms under the a model
    */
    public function zbms()
    {
        return $this->hasMany('App\Models\ZbmProfile', 'rod_auuid', 'auuid');
    }
    /**
    *Get asms under the a model
    */
    public function asms()
    {
        return $this->hasManyThrough('App\Models\AsmProfile', 'App\Models\ZbmProfile', 'rod_auuid', 'zbm_auuid', 'auuid', 'auuid');
    }
    /**
    *Get zones under the a model
    */
    public function zones()
    {
        return $this->hasManyThrough('App\Models\LocationZone', 'App\Models\LocationRegion', 'id', 'region_id', 'region_id', 'id');
    }
    /**
    * Get the userprofile.
    */
    public function userprofile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_id', 'user_id');
    }
}
