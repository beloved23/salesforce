<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationCountry extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'location_country';
      /**
     * Get the regions for the country
     */
    public function regions()
    {
        return $this->hasMany('App\Models\LocationRegion','country_id','id');
    }

 /**
     * Get the all zones for the country
     */
     public function zones()
     {
         return $this->hasManyThrough('App\Models\LocationZone','App\Models\LocationRegion','country_id','region_id','id','id');
     }       
}
