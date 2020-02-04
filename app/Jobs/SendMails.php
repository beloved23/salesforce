<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Mail\TargetAssigned;
use Carbon\Carbon;
use Log;
use App\Http\Controllers\Pusher;
class SendMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $when = Carbon::now()->addMinutes(1);
        // Mail::to(Auth::user())->queue(new TargetAssigned);
           $options = array(
            'cluster' => 'us2',
            'encrypted' => true
          );
          $pusher = new Pusher(
            'a6b246a297fca110d65d',
            'b92f49b14bfb500b041f',
            '426161',
            $options
          );
        
          $data['message'] = 'hello world';
          $pusher->trigger('my-channel', 'my-event', $data);
        Log::info('I just delivered your email ');
    }
}
