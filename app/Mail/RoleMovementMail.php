<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use App\Models\RoleMovementProfile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoleMovementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    
    /**
     * The order instance.
     *
     * @var Order
     */
    protected $roleMovementItem;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($roleMovementItem)
    {
        $this->roleMovementItem = $roleMovementItem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $requester = User::with('profile')->find($this->roleMovementItem->requester_id);
        $resource = User::with('profile')->find($this->roleMovementItem->resource_id);
        $destinationRole = Role::find($this->roleMovementItem->requested_role_id);
        $resourceRole = Role::find($this->roleMovementItem->resource_role_id);
        $roleMovementProfile = RoleMovementProfile::where('role_movement_id', $this->roleMovementItem->id)->get()[0];
        $getRequestTime = new Carbon($this->roleMovementItem->created_at);
        $formattedTime = $getRequestTime->format('l jS \\of F Y h:i:s A');         // Saturday 19th of December 2015 10:10:16 AM
        //setup claim route
        $claimRouteToken = Crypt::encryptString(env('ROLE_MOVEMENT_CLAIM_SECRET'));
        $claimRoute =  config('app.url').'/'.'role/movement/claim/'.$this->roleMovementItem->id.'?token='.$claimRouteToken;
        return $this->from('support@salesforce.com.ng')->view('mails.rolemovement')->with([
            'greetingsName'=>'Human Resource',
            'siteLogo'=>asset('images/airtel.png'),
            'requesterName' =>$requester->profile->first_name.' '.$requester->profile->last_name,
            'resourceName' =>$resource->profile->first_name.' '.$resource->profile->last_name,
            'requesterProfilePicture'=>asset('storage/'.$requester->profile->profile_picture),
            'resourceProfilePicture'=>asset('storage/'.$resource->profile->profile_picture),
            'resourceRole' => $resourceRole->name,
            'destinationRole'=>$destinationRole->name,
            'requestComment'=>$roleMovementProfile->requester_comment,
            'claimRoute'=>$claimRoute,
            'time'=>$formattedTime,
            'company'=>'SalesForce'
        ]);
    }
}
