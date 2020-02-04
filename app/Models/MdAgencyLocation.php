<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdAgencyLocation extends Model
{
    protected $table = 'agency_has_locations';
    public function agency()
    {
        return $this->belongsTo('App\Models\MdAgency', 'agency_id', 'id');
    }
}
