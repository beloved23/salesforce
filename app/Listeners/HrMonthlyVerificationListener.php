<?php

namespace App\Listeners;

use App\Events\HrMonthlyVerification;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Support\Facades\Mail;
use App\Mail\HRMonthlyVerification as VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class HrMonthlyVerificationListener implements ShouldQueue
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
     * @param  HrMonthlyVerification  $event
     * @return void
     */
    public function handle(HrMonthlyVerification $event)
    {
        $mdsToVerify = $event->mdsToVerify;
        $zbm = $event->zbm;
        $users = User::role('HR')->get();
        $a = QuickTaskFacade::formatUsersForEmail($users);
        Mail::to($a)->queue(new VerificationMail($mdsToVerify, $zbm));
    }
}
