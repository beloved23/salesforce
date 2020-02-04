<?php

namespace App\Listeners;

use App\Events\LocationMovementApproved;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\LocationMovementApprovalInform;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Support\Facades\Mail;

class LocationMovementApprovedListener implements ShouldQueue
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
     * @param  LocationMovementApproved  $event
     * @return void
     */
    public function handle(LocationMovementApproved $event)
    {
        $locationMovement = $event->locationMovement;
        $users = User::where('id', $locationMovement->requester_id)->get();
        $a = QuickTaskFacade::formatUsersForEmail($users);
        Mail::to($a)->queue(new LocationMovementApprovalInform($locationMovement));
    }
}
