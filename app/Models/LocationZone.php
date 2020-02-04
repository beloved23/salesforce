<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationZone extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'location_zones';

    public function region()
    {
        return    $this->belongsTo('App\Models\LocationRegion');
    }
    public function states()
    {
        return $this->hasMany('App\Models\LocationState', 'zone_id', 'id');
    }
    public function rodByLocation()
    {
        return $this->belongsTo('App\Models\RodProfile', 'region_id', 'region_id');
    }
    public function zbmByLocation()
    {
        return $this->belongsTo('App\Models\ZbmProfile', 'id', 'zone_id');
    }
    public function areas()
    {
        return $this->hasManyThrough('App\Models\LocationArea', 'App\Models\LocationState', 'zone_id', 'state_id', 'id', 'id');
    }
    /**
    *Get zbms under the zone
    */
    public function zbms()
    {
        return $this->hasMany('App\Models\ZbmProfile', 'zone_id', 'id');
    }
    /**
    *Get asms under the zone
    */
    public function asms()
    {
        return $this->hasManyThrough('App\Models\AsmProfile', 'App\Models\LocationState', 'zone_id', 'state_id', 'id', 'id');
    }
}
