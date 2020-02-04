<?php

namespace App\Listeners;

use App\Events\MessageReceived;
use Illuminate\Queue\InteractsWithQueue;
use Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Utilities\Broadcast;

class SendMessageNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageReceived  $event
     * @return void
     */
    public function handle(MessageReceived $event)
    {
       $data["message"] = "Adekunle";
        $broadcast = new BroadCast();
        $broadcast->trigger('App.User.123123','MessageReceived',$data);
    }
}
