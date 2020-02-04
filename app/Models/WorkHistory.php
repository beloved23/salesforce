<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    //
    public function UserProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'user_id');
    }
    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
