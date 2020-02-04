<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZbmProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'zbm_profile';
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
    public function userprofile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_id', 'user_id');
    }

    /**
     * Get the rod that owns the profile.
     */
    public function rod()
    {
        return $this->belongsTo('App\Models\RodProfile', 'rod_auuid', 'auuid');
    }
    /**
    *Get asms under the a model
    */
    public function asms()
    {
        return $this->hasMany('App\Models\AsmProfile', 'zbm_auuid', 'auuid');
    }
    /**
    *Get mds under the a model
    */
    public function mds()
    {
        return $this->hasManyThrough('App\Models\MdProfile', 'App\Models\AsmProfile', 'zbm_auuid', 'asm_auuid', 'auuid', 'auuid', 'auuid', 'auuid');
    }
    /**
    * Get the zone associated with profile.
    */
    public function zone()
    {
        return $this->belongsTo('App\Models\LocationZone', 'zone_id', 'id');
    }
}
