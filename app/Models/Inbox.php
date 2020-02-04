<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inbox';

    protected $fillable = ['subject','message','sender_id','','sender_auuid','recipient_id','recipient_auuid','label'];
    /**
    * Get the sender profile associated with the message
    */
    public function senderProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'sender_id');
    }

    /**
     * Get the sender profile associated with the message
     */
    public function sender()
    {
        return $this->hasOne('App\Models\User', 'id', 'sender_id');
    }
    /**
    * Get attachments associated with the message
    */
    public function attachments()
    {
        return $this->hasMany('App\Models\InboxAttachment', 'message_id', 'id');
    }
    /**
      * Get attachments associated with the message
      */
    public function replies()
    {
        return $this->hasMany('App\Models\InboxReply', 'message_id', 'id');
    }
    /**
    * Get the sender profile associated with the message
    */
    public function recipientProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'recipient_id');
    }
    /**
         * Get the sender profile associated with the message
         */
    public function recipient()
    {
        return $this->hasOne('App\Models\User', 'id', 'recipient_id');
    }
}
