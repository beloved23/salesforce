<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    protected $table = 'outlet_mediacategory';
    protected $fillable = ['name'];
    public function media()
    {
        return $this->hasMany('App\Models\Media', 'id', 'media_category_id');
    }
}
