<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\RoleMovement;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class HierachyNotificationForRoleMovement extends Mailable
{
    use Queueable, SerializesModels;
    protected $userId;
    protected $roleMovementId;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userId, $roleMovementId)
    {
        $this->userId = $userId;
        $this->roleMovementId = $roleMovementId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $modelItem = RoleMovement::find($this->roleMovementId);
        $dt = Carbon::now();
        //retrieve recipient FullName
        $fullName = 'User';
        $user = User::find($this->userId);
        if($user->profile()->exists()){
            $fullName = $user->profile->last_name.' '.$user->profile->first_name;
        }
        //retrieve from-role
        $fromRoleModel  = Role::find($modelItem->resource_role_id);
        $fromRole  = $fromRoleModel->name;
        $toRoleModel = Role::find($modelItem->requested_role_id);
        $toRole = $toRoleModel->name;
        //retrieve resource
        $resourceUser = User::find($modelItem->resource_id);
        $resourceFullName = '';
        if($resourceUser->profile()->exists())
        {
            $resourceProfile = $resourceUser->profile;
            $resourceFullName = $resourceProfile->last_name.' '.$resourceProfile->first_name;
        }
        //retrieve destination location 
        $location_to_role = config('global.location_models');
        $locationModel = $location_to_role[$toRole];
        $location = $locationModel::find($modelItem->resource_auuid);
        //retrieve location type
        $role_to_location_column = config('global.location_column');
        $locationType = $role_to_location_column[$toRole];
        $locationType = str_replace('_id', '', $locationType);
        $locationType = strtoupper(substr($locationType, 0, 1)).substr($locationType, 1, strlen($locationType));
       //timestamp
        $dt = new Carbon($modelItem->updated_at);
        $timestamp = $dt->toDayDateTimeString();
        return $this->view('mails.notifications.hierachyforrolemovement')->with(
            [
            'siteLogo'=>asset('images/airtel.png'),
            'greetingsName'=>$fullName,
            'fromRole'=>$fromRole,
            'resourceFullName'=>$resourceFullName,
            'resourceAuuid'=>$resourceUser->auuid,
            'location'=>$location,
            'modelItem'=>$modelItem,
            'toRole'=>$toRole,
            'locationType'=>$locationType,
            'timestamp'=>$timestamp,
            'appUrl'=>env('APP_URL'),
             'company'=>'SalesForce',
             'year'=>$dt->year,
            ]
        );
    }
}
