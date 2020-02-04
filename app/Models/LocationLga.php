<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationLga extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'location_lgas';
     public function area(){
         return $this->belongsTo('App\Models\LocationArea');
     }
     public function territories(){
         return $this->hasMany('App\Models\LocationTerritory', 'lga_id', 'id');
     }
}
