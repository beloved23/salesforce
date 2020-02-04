<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationTerritory extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'location_territories';
    public function lga()
    {
        return $this->belongsTo('App\Models\LocationLga','lga_id','id');
    }
    public function mds()
    {
        return $this->hasMany('App\Models\MdProfile', 'territory_id', 'id');
    }
    public function sites()
    {
        return $this->hasMany('App\Models\LocationSite', 'territory_id', 'id');
    }
    public function mdByLocation()
    {
        return $this->belongsTo('App\Models\MdProfile', 'id', 'territory_id');
    }
}
