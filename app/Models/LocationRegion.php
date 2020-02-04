<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationRegion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'location_regions';
      /**
     * Get the country that owns the region.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\LocationCountry','country_id','id');
    }

    /**
    *Get zones under the a model
    */
    public function zones()
    {
        return $this->hasMany('App\Models\LocationZone','region_id','id');
    }
      /**
    *Get states under the a model
    */
    public function states()
    {
        return $this->hasManyThrough('App\Models\LocationState','App\Models\LocationZone','region_id','zone_id','id','id');
    }
      /**
    *Get zbms under the region
    */
    public function zbms()
    {
        return $this->hasManyThrough('App\Models\ZbmProfile','App\Models\LocationZone','region_id','zone_id','id','id');
    }
    public function rodByLocation(){
        return $this->belongsTo('App\Models\RodProfile','id','region_id');
    }
}
