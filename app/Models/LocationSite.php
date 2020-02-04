<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationSite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'location_sites';
     function territory(){
         return $this->belongsTo('App\Models\LocationTerritory','territory_id','id');
     }
}
