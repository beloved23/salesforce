<?php

namespace App\Listeners;

use App\Events\LocationMovementCreated;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\LocationMovementRequest;
use App\Mail\LocationMovementInform;
use App\Mail\LocationMovementAttestation;
use Illuminate\Support\Facades\Mail;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\LocationMovementProfile;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class LocationMovementCreatedListener implements ShouldQueue
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
     * @param  LocationMovementCreated  $event
     * @return void
     */
    public function handle(LocationMovementCreated $event)
    {
        $locationMovement = $event->locationMovement;
        Mail::to(QuickTaskFacade::getAllHrForEmail())->queue(new LocationMovementRequest($locationMovement));
        $users = User::where('id', $locationMovement->requester_id)->get();
        $a = QuickTaskFacade::formatUsersForEmail($users);
        Mail::to($a)->queue(new LocationMovementInform($locationMovement));
        $locationMovementProfile = LocationMovementProfile::where('location_movement_id', $locationMovement->id)->get()[0];
        if ($locationMovementProfile->is_attestation_required) {
            $zbmUser =  User::where('id', $locationMovement->attester_id)->get();
            $b = QuickTaskFacade::formatUsersForEmail($zbmUser);
            Mail::to($b)->queue(new LocationMovementAttestation($locationMovement));
        }
    }
}
