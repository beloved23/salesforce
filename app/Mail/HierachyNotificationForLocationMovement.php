<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\LocationMovement;

class HierachyNotificationForLocationMovement extends Mailable
{
    use Queueable, SerializesModels;

    protected $userId;
    protected $locationMovementId;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userId,$locationMovementId)
    {
        $this->userId = $userId;
        $this->locationMovementId = $locationMovementId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $modelItem = LocationMovement::find($this->locationMovementId);
        $dt = Carbon::now();
        //retrieve recipient FullName
        $fullName = 'User';
        $user = User::find($this->userId);
        if($user->profile()->exists()){
            $fullName = $user->profile->last_name.' '.$user->profile->first_name;
        }
        //retrieve role
        $models = config('global.location_models');
        $role = '';
        $models = collect($models);
        $flipped = $models->flip();
        $role = $flipped->get($modelItem->location_model);
        //retrieve resource
        $resourceUser = User::find($modelItem->requester_id);
        $resourceFullName = '';
        if($resourceUser->profile()->exists())
        {
            $resourceProfile = $resourceUser->profile;
            $resourceFullName = $resourceProfile->last_name.' '.$resourceProfile->first_name;
        }
        //retrieve geo-location type
        $location_to_name = config('global.locationmodel_to_name');
        $location = $location_to_name[$modelItem->location_model];
        //from 
        $fromLocation = $modelItem->location_model::find($modelItem->requester_location_id);
        //to
        $toLocation = $modelItem->location_model::find($modelItem->location_id);
        //timestamp
        $dt = new Carbon($modelItem->updated_at);
        $timestamp = $dt->toDayDateTimeString();
        return $this->view('mails.notifications.hierachyforlocationmovement')->with(
            [
            'siteLogo'=>asset('images/airtel.png'),
            'greetingsName'=>$fullName,
            'items'=>[],
            'role'=>$role,
            'resourceFullName'=>$resourceFullName,
            'location'=>$location,
            'modelItem'=>$modelItem,
            'from'=>$fromLocation,
            'to'=>$toLocation,
            'timestamp'=>$timestamp,
            'appUrl'=>env('APP_URL'),
             'company'=>'SalesForce',
             'year'=>$dt->year,
            ]
        );
    }
}
