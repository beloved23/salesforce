<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InboxReply extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inbox_replies';
    /**
    * Get the sender profile associated with the message
    */
    public function senderProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'sender_id');
    }
}
