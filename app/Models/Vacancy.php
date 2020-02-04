<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'vacancies';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['location_model','location_id','pending_recruit','location_name','location_code','required_profile'];
}
