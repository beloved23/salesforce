<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsmProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asm_profile';
    /**
    * Get the user that owns the profile.
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
    * Get the userprofile.
    */
    public function userprofile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_id', 'user_id');
    }
    /**
    * Get the zbm that owns the profile.
    */
    public function zbm()
    {
        return $this->belongsTo('App\Models\ZbmProfile', 'zbm_auuid', 'auuid');
    }
    /**
    *Get mds under the a model
    */
    public function mds()
    {
        return $this->hasMany('App\Models\MdProfile', 'asm_auuid', 'auuid');
    }
    /**
    * Get the zone associated with profile.
    */
    public function area()
    {
        return $this->belongsTo('App\Models\LocationArea', 'area_id', 'id');
    }
    /**
    * Get the state associated with profile.
    */
//    public function state()
//    {
//        return $this->belongsTo('App\Models\LocationState', 'state_id', 'id');
//    }
}
