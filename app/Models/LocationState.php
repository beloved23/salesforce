<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationState extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'location_states';
     public function zone(){
         return $this->belongsTo('App\Models\LocationZone');
     }
     public function areas(){
         return $this->hasMany('App\Models\LocationArea','state_id','id');
     }
     public function asm(){
        return $this->belongsTo('App\Models\AsmProfile','id','state_id');
    }
        /**
    *Get lgas under the  model
    */
    public function lgas()
    {
        return $this->hasManyThrough('App\Models\LocationLga','App\Models\LocationArea','state_id','area_id','id','id');
    }
}
