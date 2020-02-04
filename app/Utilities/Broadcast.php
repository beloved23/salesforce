<?php

namespace App\Utilities;
use App\Utilities\Pusher;
use Log;

class Broadcast
{
    public $pusher;
    public function __construct(){
   $options = array(
            'cluster' => 'us2',
            'encrypted' => true
          );
          $this->pusher = new Pusher(
            'a6b246a297fca110d65d',
            'b92f49b14bfb500b041f',
            '426161',
            $options
          );
    }
    public function trigger($channel = null,$event = null,$data=null){
        //validates all required parameters are provided
        if(isset($channel) && isset($event) && $data){
      $this->pusher->trigger($channel, $event, $data);
        }
        else{
            Log::error('Broadcast Service requires a channel name, event name and data to broadcast');
        }
    }
}