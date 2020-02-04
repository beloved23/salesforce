<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    
     /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'targets';

       /**
      * Get the user profile of the owner
      */
      public function ownerProfile(){
        return $this->hasOne("App\Models\UserProfile",'user_id','user_id');
    }
    public function profile(){
             return $this->hasMany("App\Models\TargetProfile",'target_id','id');
    }
}
