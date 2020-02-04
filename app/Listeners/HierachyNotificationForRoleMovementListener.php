<?php

namespace App\Listeners;

use App\Events\HierachyNotificationForRoleMovementEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Models\RoleMovement;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Utilities\UtilityController;
use Illuminate\Support\Facades\Mail;
use App\Mail\HierachyNotificationForRoleMovement;

class HierachyNotificationForRoleMovementListener implements ShouldQueue
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
     * @param  HierachyNotificationForRoleMovementEvent  $event
     * @return void
     */
    public function handle(HierachyNotificationForRoleMovementEvent $event)
    {
        $recipients = [];
        $roleMovement = $event->roleMovement;
        $modelItem = RoleMovement::find($roleMovement);
        $toRole = Role::find($modelItem->requested_role_id);
        if ($toRole->name=='ZBM') {
            $location_models = config('global.location_models');
            $zone = $location_models[$toRole->name]::find(
                $modelItem->resource_auuid
            );
            if ($zone->rodByLocation->exists()) {
                $recipients[] = $zone->rodByLocation->user;
            }
        } elseif ($toRole->name=='ASM') {
            $location_models = config('global.location_models');
            //Zbm and rod for To-Location
            $uplinesForToLocation = UtilityController::getLocationZbmAndRod(
                $location_models[$toRole->name],
                $modelItem->resource_auuid
            );
            if (isset($uplinesForToLocation)) {
                $recipients[] = $uplinesForToLocation['zbm'];
                $recipients[] = $uplinesForToLocation['rod'];
            }
        }
        foreach ($recipients as $user) {
            Mail::to($user->email)->queue(
                new HierachyNotificationForRoleMovement(
                    $user->id,
                    $roleMovement
                )
            );
        }
    }
}
