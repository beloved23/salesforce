<?php

namespace App\Listeners;

use App\Events\HierachyNotificationForLocationMovementEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\HierachyNotificationForLocationMovement;
use App\Models\LocationMovement;
use App\Http\Controllers\Utilities\UtilityController;
use Illuminate\Support\Facades\Mail;
use Log;

class HierachyNotificationForLocationMovementListener implements ShouldQueue
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
     * @param  HierachyNotificationForLocationMovementEvent  $event
     * @return void
     */
    public function handle(HierachyNotificationForLocationMovementEvent $event)
    {
        $locationMovementId = $event->locationMovement;
        $modelItem  = LocationMovement::find($locationMovementId);
        //Array for all recipients email
        $recipients = [];
        if ($modelItem->exists()) {
            $models_to_location = config('global.locationmodel_to_name');
            $locationType = $models_to_location[$modelItem->location_model];
            if ($locationType=='Zone') {
                $uplinesForFromLocation = UtilityController::getLocationZbmAndRod(
                    $modelItem->location_model,
                    $modelItem->requester_location_id
                );
                if (isset($uplinesForFromLocation)) {
                    $recipients[] = $uplinesForFromLocation['rod'];
                }
                $uplinesForToLocation = UtilityController::getLocationZbmAndRod(
                    $modelItem->location_model,
                    $modelItem->location_id
                );
                if (isset($uplinesForToLocation)) {
                    $recipients[] = $uplinesForToLocation['rod'];
                }
            } elseif ($locationType=='Area') {
                //Prepare Uplines
                //zbm and rod for From-Location
                $uplinesForFromLocation = UtilityController::getLocationZbmAndRod(
                    $modelItem->location_model,
                    $modelItem->requester_location_id
                );
                if (isset($uplinesForFromLocation)) {
                    $recipients[] = $uplinesForFromLocation['zbm'];
                    $recipients[] = $uplinesForFromLocation['rod'];
                }
                //Zbm and rod for To-Location
                $uplinesForToLocation = UtilityController::getLocationZbmAndRod(
                    $modelItem->location_model,
                    $modelItem->location_id
                );
                if (isset($uplinesForToLocation)) {
                    $recipients[] = $uplinesForToLocation['zbm'];
                    $recipients[] = $uplinesForToLocation['rod'];
                }
            } elseif ($locationType=='Territory') {
                //Uplines
                //Asm, zbm and rod for From-Location
                $uplinesForFromLocation = UtilityController::getLocationAsmZbmRod(
                    $modelItem->location_model,
                    $modelItem->requester_location_id
                );
                if (isset($uplinesForFromLocation)) {
                    $recipients[] = $uplinesForFromLocation['asm'];
                    $recipients[] = $uplinesForFromLocation['zbm'];
                    $recipients[] = $uplinesForFromLocation['rod'];
                }
                //Asm, Zbm and rod for To-Location
                $uplinesForToLocation = UtilityController::getLocationAsmZbmRod(
                    $modelItem->location_model,
                    $modelItem->location_id
                );
                if (isset($uplinesForToLocation)) {
                    $recipients[] = $uplinesForToLocation['asm'];
                    $recipients[] = $uplinesForToLocation['zbm'];
                    $recipients[] = $uplinesForToLocation['rod'];
                }
            }
        }
        foreach ($recipients as $user) {
            Mail::to($user->email)->queue(
                new HierachyNotificationForLocationMovement(
                    $user->id,
                    $locationMovementId
                )
            );
        }
    }
}
