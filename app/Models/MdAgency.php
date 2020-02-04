<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdAgency extends Model
{
    protected $table = 'md_agencies';
    protected $fillable = ['name','email'];
    public function locations()
    {
        return $this->hasMany('App\Models\MdAgencyLocation', 'agency_id', 'id');
    }
}
