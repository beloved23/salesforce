<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleMovementProfile;
use Carbon\Carbon;
class RoleMovementApproval extends Mailable
{
    use Queueable, SerializesModels;

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
        $requester = User::where('id',$this->roleMovementItem->requester_id)->with('profile')->get()[0];
        $resource = User::where('id',$this->roleMovementItem->resource_id)->with('profile')->get()[0]; 
        $hr = User::where('id',$this->roleMovementItem->hr_auuid)->with('profile')->get()[0];         
        $destinationRole = Role::find($this->roleMovementItem->requested_role_id);
        $resourceRole = Role::find($this->roleMovementItem->resource_role_id);
        $roleMovementProfile = RoleMovementProfile::where('role_movement_id',$this->roleMovementItem->id)->get()[0];
            $getRequestTime = new Carbon($this->roleMovementItem->created_at);
             $formattedTime = $getRequestTime->format('l\\, jS \\of F Y');         // Saturday 19th of December 2015 10:10:16 AM
             $getApprovalTime = new Carbon($roleMovementProfile->updated_at);
             $getApprovalDate = $getApprovalTime->format('l\\, jS \\of F Y');
            return $this->from('support@salesforce.com.ng')->view('mails.rolemovementapproval')->with([
                'greetingsName'=>'Human Resource',
                'siteLogo'=>asset('images/airtel.png'),
                'requesterName' =>$requester->profile->first_name.' '.$requester->profile->last_name,
                'resourceName' =>$resource->profile->first_name.' '.$resource->profile->last_name,
                'resourceRole' => $resourceRole->name,
                'destinationRole'=>$destinationRole->name,
                'approvalComment'=>$roleMovementProfile->approval_comment,
                'approvalDate'=> $getApprovalDate,
                'time'=>$formattedTime,
                'approveeName'=> (isset($hr->profile) ? $hr->profile->first_name.' '.$hr->profile->last_name : $hr->email),
                'company'=>'SalesForce'
            ]);
    }
}
