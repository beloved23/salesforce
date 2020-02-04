<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InboxAttachment extends Model
{
      /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'inbox_attachments';

     /**
     * Get the inbox message that owns that attachment
     */
     public function inbox(){
        return $this->belongsTo('App\Models\Inbox');
    }
}
