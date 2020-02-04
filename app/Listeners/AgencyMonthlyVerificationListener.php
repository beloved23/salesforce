<?php

namespace App\Listeners;

use App\Events\AgencyMonthlyVerification;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Support\Facades\Mail;
use App\Models\MdAgencyLocation;
use App\Models\ZbmProfile;
use App\Mail\AgencyMonthlyVerification as VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class AgencyMonthlyVerificationListener
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
     * @param  AgencyMonthlyVerification  $event
     * @return void
     */
    public function handle(AgencyMonthlyVerification $event)
    {
        $mdsToVerify = $event->mdsToVerify;
        $zbmId = $event->zbm;
        $zbm = ZbmProfile::where('user_id', $zbmId)->get();
        if ($zbm->count()>0) {
            $region = $zbm[0]->zone->region;
            if (!is_null($region)) {
                $location = MdAgencyLocation::where('location_id', $region->id)->get();
                if ($location->count()>0) {
                    Mail::to($location[0]->agency->email)->queue(new VerificationMail($mdsToVerify, $event->zbm));
                }
            }
        }
    }
}
