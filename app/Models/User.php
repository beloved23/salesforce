<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['id','email','auuid','password','remember_token'];

    //define relationships
   
    /**
     * Get the rod profile associated with the user.
     */
    public function rodprofile()
    {
        return $this->hasOne('App\Models\RodProfile', 'user_id', 'id');
    }

    /**
    * Get the rod profile associated with the user.
    */
    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'id');
    }
}
