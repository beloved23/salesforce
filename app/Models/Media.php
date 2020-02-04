<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = ['user_id','media_category_id','source',
    'media_size','media_type','media_extension',
    'original_file_name'
    ];
    public function category(){
      return  $this->belongsTo('App\Models\MediaCategory', 'media_category_id', 'id');
    }
}
