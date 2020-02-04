<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'md_profile';
    protected $fillable = ['user_id'];
    /**
    * Get the user that owns the profile.
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    /**
    * Get the zbm that owns the profile.
    */
    public function asm()
    {
        return $this->belongsTo('App\Models\AsmProfile', 'asm_auuid', 'auuid');
    }
    /**
    * Get the userprofile.
    */
    public function userprofile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_id', 'user_id');
    }
    /**
    * Get the territory associated with profile.
    */
    public function territory()
    {
        return $this->belongsTo('App\Models\LocationTerritory', 'territory_id', 'id');
    }
}
