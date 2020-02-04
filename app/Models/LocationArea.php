<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationArea extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'location_areas';
    public function state()
    {
        return $this->belongsTo('App\Models\LocationState');
    }


    public function lgas()
    {
        return $this->hasMany('App\Models\LocationLga', 'area_id', 'id');
    }

    public function territories()
    {
        return $this->hasManyThrough('App\Models\LocationTerritory', 'App\Models\LocationLga', 'area_id', 'lga_id', 'id', 'id');
    }
    public function asmByLocation()
    {
        return $this->belongsTo('App\Models\AsmProfile', 'id', 'area_id');
    }
}
