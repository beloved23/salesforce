<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleMovement;
use App\Models\RoleMovementProfile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RodProfile;
use App\Models\LocationRegion;
use App\Models\ZbmProfile;
use App\Models\LocationZone;
use App\Models\AsmProfile;
use App\Models\LocationArea;
use App\Models\MdProfile;
use Log;
use App\Models\LocationTerritory;
use App\Facades\MyFacades\QuickTaskFacade;
use App\Events\HierachyNotificationForRoleMovementEvent;
use App\Http\Controllers\Utilities\UtilityController;

class RoleMovementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index(Request $request)
    {
        $title = 'Role Movement | '.config('global.app_name');
        if (!$request->user()->hasRole('HR')) {
            return redirect()->route('home')->with([
                'actionError'=>'Permission denied'
            ]);
        }
        return view('rolemovement.index')->with([
            'title'=>$title
        ]);
    }
    public function store(Request $request)
    {
        if ($request->has('resourceAuuid') && $request->has('resourceRoleName') &&
        $request->has('requestedRoleName') && $request->has('destinationLocation')) {
            $check = RoleMovement::where('requester_id', $request->user()->id)
            ->where('is_approved', false)->where('is_denied', false)
            ->orWhere('resource_id', $request->resourceAuuid)->where('is_approved', false)
            ->where('is_denied', false)->get();
            if ($check->count()==0) {
                $roleMovementProfile = new RoleMovementProfile;
                $roleMovementItem["requester_id"] = $request->user()->id;
                $roleMovementItem["requester_auuid"] = $request->user()->auuid;
                $roleMovementItem["resource_id"] = $request->resourceAuuid;
                //NOTE: store destinationLocation in resource_auuid
                $roleMovementItem["resource_auuid"] = $request->destinationLocation;
                //get requested role id
                $requestedRoleId = Role::where('name', $request->requestedRoleName)->get()[0]->id;
                //get resource role id
                $resourceRoleId = Role::where('name', $request->resourceRoleName)->get()[0]->id;
                //if role is ASM or MD, attestation is required
                // if ($request->resourceRoleName == "ASM" || $request->resourceRoleName == "MD") {
                //     $resourceZbm = QuickTaskFacade::getUserZbm($request->resourceAuuid);
                //     if (count($resourceZbm)>0) {
                //         $roleMovementProfile->is_attestation_required= true;
                //         //retrieve resource ZBM
                      
                //         $roleMovementItem["attester_id"] = $resourceZbm[0]->user_id;
                //         $roleMovementItem["attester_auuid"] = $resourceZbm[0]->auuid;
                //     }
                // } else {
                // }
                $roleMovementItem["resource_role_id"] = $resourceRoleId;
                $roleMovementItem["requested_role_id"] = $requestedRoleId;
                $roleMovementItem["hr_auuid"] = $request->user()->id;
                $roleMovementItem['is_claimed'] = true;
                $savedRole = RoleMovement::create($roleMovementItem);
                //save Role Movement Profile
                $roleMovementProfile->role_movement_id = $savedRole->id;
                $roleMovementProfile->requester_comment = $request->requesterComment;
                $roleMovementProfile->save();

                //deliver emails below
                $utility = new UtilityController();
                $utility->deliverEmailsForRoleMovementToHr($savedRole);

                //approve role movement request below
                $response = $this->approveUtility(
                    $savedRole->id,
                 $request
                );
                event(new HierachyNotificationForRoleMovementEvent($savedRole->id));
                return response()->json($response);
            } else {
                return response()->json(array("validations"=>false,"message"=>"a pending role movement request exist for this resource","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"please provide resource, resource role, and destination role","action"=>false));
        }
    }
    public function approveUtility($id, $request)
    {
        $utility = new UtilityController;
        $roleMovement = RoleMovement::find($id);
        $roleMovementProfile = $roleMovement->profile;
        if ($request->user()->hasRole('HR')) {
            if ($request->user()->id == $roleMovement->hr_auuid) {
                //check availability of destination location
                if ($utility->checkLocationAvailability($roleMovement)) {
                    //check if attestation is required before approval
                    //if attestation is not required
                    // if (!$roleMovementProfile->is_attestation_required) {
                    RoleMovement::where('id', $id)->update(['is_approved'=>true,'is_denied'=>false]);
                    RoleMovementProfile::where('role_movement_id', $id)
                        ->update(['approval_comment'=>'Role movement approved', 'denial_comment'=>null]);
                    
                    $utility->prepareResourceForRoleMovement($roleMovement);
                  
                    //deliver emails below
                    //retrieve all recipients
                    $allRecipients = User::where('id', $roleMovement->requester_id)
                        ->orWhere('id', $roleMovement->resource_id)->orWhere('auuid', $roleMovement->hr_auuid)->get();
                    $utility = new UtilityController();
                    $utility->deliverEmailsForRoleMovementApproval($allRecipients, $roleMovement);
          
                    return array("validations"=>true,"message"=>"Role Movement request submitted successfully","action"=>true);
                    // } else {
                    //     //if attestation is required
                    //     //check if movement has been attested by ZBM
                    //     if ($roleMovement->profile->is_attested) {
                    //         RoleMovement::where('id', $id)->update(['is_approved'=>true]);
                    //         RoleMovementProfile::where('role_movement_id', $id)
                    //         ->update(['approval_comment'=>$request->approval_comment,'denial_comment'=>null]);
                        
                    //         $utility->prepareResourceForRoleMovement($roleMovement);

                    //         //deliver emails below
                    //         //retrieve all recipients
                    //         $allRecipients = User::where('id', $roleMovement->requester_id)
                    //         ->orWhere('id', $roleMovement->resource_id)->orWhere('auuid', $roleMovement->hr_auuid)->get();
                    //         $utility = new UtilityController();
                    //         $utility->deliverEmailsForRoleMovementApproval($allRecipients, $roleMovement);
                        
                    //         return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                    //     'actionSuccessMessage'=>'You have successfully approved this movement request. '
                    // ]);
                    //     } else {
                    //         return array("validations"=>false,
                    //         "message"=>"This role movement requires attestation by related ZBM before it can be approved",
                    //         "action"=>false);
                    //     }
                    // }
                } else {
                    return array("validations"=>false,
                    "message"=>"Destination Location for this request is currently occupied. Please deny request or approve when location is available",
                    "action"=>false);
                }
            } else {
                return array("validations"=>false,"message"=>"You do not have the permission to complete this request","action"=>false);
            }
        } else {
            return array("validations"=>false,"message"=>"Only HR can create a role movement request","action"=>false);
        }
    }
    public function history(Request $request)
    {
        $title = 'Role Movement History | '.config('global.app_name');
        $id = $request->user()->id;
        $roleMovement = RoleMovement::where('requester_id', $id)
        ->orWhere('resource_id', $id)->orWhere('requester_id', $id)
        ->orWhere('resource_id', $id)
        ->orWhere('hr_auuid', $request->user()->id)
        ->with(['profile','requesterProfile','destinationRole','requesterUser','resourceProfile','resourceUser','resourceRole'])->paginate(10);
        if ($request->user()->hasRole('HR')) {
            $roleMovement = RoleMovement::orderBy('updated_at', 'desc')->paginate(10);
        }
        return view('rolemovement.history')->with([
            'title'=>$title,
            'roleMovement'=>$roleMovement
        ]);
    }
    public function profile(Request $request, $id)
    {
        $title = 'Role Movement Profile | '.config('global.app_name');
        $roleMovementProfile = RoleMovement::find($id);
        $role = Role::find($roleMovementProfile->requested_role_id);
        $destinationLocationName = "N/A";
        if ($role->name=="ROD") {
            $region = LocationRegion::find($roleMovementProfile->resource_auuid);
            $destinationLocationName = "Region ".$region->name;
        } elseif ($role->name=="ZBM") {
            $zone = LocationZone::find($roleMovementProfile->resource_auuid);
            $destinationLocationName = "Zone ".$zone->name;
        } elseif ($role->name=="ASM") {
            $area = LocationArea::find($roleMovementProfile->resource_auuid);
            $destinationLocationName = "Area ".$area->name;
        } elseif ($role->name=="MD") {
            $territory = LocationTerritory::find($roleMovementProfile->resource_auuid);
            $destinationLocationName = "Territory ".$territory->name;
        }
        return view('rolemovement.profile')->with([
            'title'=>$title,
            'roleMovementProfile'=>$roleMovementProfile,
            'destionationLocation'=>$destinationLocationName
        ]);
    }
    public function unclaim(Request $request, $id)
    {
        $roleMovement = RoleMovement::where('id', $id)->get()[0];
        if ($request->user()->id == $roleMovement->hr_auuid) {
            RoleMovement::where('id', $id)->update(['hr_auuid'=>null,'is_claimed'=>false]);
            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'You have successfully undo the claim on this movement request'
            ]);
        } else {
            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                'actionWarningMessage'=>'You do not have the permission to complete this request'
            ]);
        }
    }
    public function claim(Request $request, $id)
    {
        $roleMovement = RoleMovement::where('id', $id)->get()[0];
        if ($request->user()->hasRole('HR')) {
            RoleMovement::where('id', $id)->update(['hr_auuid'=>$request->user()->id,'is_claimed'=>true]);
            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'You have successfully claimed to oversee this movement request'
            ]);
        }
    }
    public function approve(Request $request, $id)
    {
        $utility = new UtilityController;
        $request->validate([
            'approval_comment' => 'required|max:255',
        ]);
        $roleMovement = RoleMovement::find($id);
        $roleMovementProfile = RoleMovementProfile::where('role_movement_id', $id)->get()[0];
        if ($request->user()->hasRole('HR')) {
            if ($request->user()->id == $roleMovement->hr_auuid) {
                //check availability of destination location
                if ($utility->checkLocationAvailability($roleMovement)) {
                    //check if attestation is required before approval
                    //if attestation is not required
                    if (!$roleMovementProfile->is_attestation_required) {
                        RoleMovement::where('id', $id)->update(['is_approved'=>true,'is_denied'=>false]);
                        RoleMovementProfile::where('role_movement_id', $id)->update(['approval_comment'=>$request->approval_comment,'denial_comment'=>null]);
                    
                        $utility->prepareResourceForRoleMovement($roleMovement);
                  
                        //deliver emails below
                        //retrieve all recipients
                        $allRecipients = User::where('id', $roleMovement->requester_id)->orWhere('id', $roleMovement->resource_id)->orWhere('auuid', $roleMovement->hr_auuid)->get();
                        $utility = new UtilityController();
                        $utility->deliverEmailsForRoleMovementApproval($allRecipients, $roleMovement);
          
                        return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                    'actionSuccessMessage'=>'You have successfully approved this movement request. '
                ]);
                    } else {
                        //if attestation is required
                        //check if movement has been attested by ZBM
                        if ($roleMovement->profile->is_attested) {
                            RoleMovement::where('id', $id)->update(['is_approved'=>true]);
                            RoleMovementProfile::where('role_movement_id', $id)->update(['approval_comment'=>$request->approval_comment,'denial_comment'=>null]);
                        
                            $utility->prepareResourceForRoleMovement($roleMovement);

                            //deliver emails below
                            //retrieve all recipients
                            $allRecipients = User::where('id', $roleMovement->requester_id)->orWhere('id', $roleMovement->resource_id)->orWhere('auuid', $roleMovement->hr_auuid)->get();
                            $utility = new UtilityController();
                            $utility->deliverEmailsForRoleMovementApproval($allRecipients, $roleMovement);
                        
                            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                        'actionSuccessMessage'=>'You have successfully approved this movement request. '
                    ]);
                        } else {
                            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                        'actionWarningMessage'=>'This role movement requires attestation by related ZBM before it can be approved'
                    ]);
                        }
                    }
                } else {
                    return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                    'actionWarningMessage'=>'Destination Location for this request is currently occupied. Please deny request or approve when location is available'
                ]);
                }
            } else {
                return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                    'actionWarningMessage'=>'You do not have the permission to complete this request'
                ]);
            }
        }
    }
    public function deny(Request $request, $id)
    {
        $request->validate([
            'denial_comment' => 'required|max:255',
        ]);
        $roleMovement = RoleMovement::where('id', $id)->get()[0];
        if ($request->user()->hasRole('HR')) {
            if ($request->user()->id == $roleMovement->hr_auuid) {
                RoleMovement::where('id', $id)->update(['is_denied'=>true]);
                RoleMovementProfile::where('role_movement_id', $id)->update(['denial_comment'=>$request->denial_comment]);
                return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'You have successfully denied this movement request'
            ]);
            } else {
                return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                    'actionWarningMessage'=>'You do not have the permission to complete this request'
                ]);
            }
        }
    }
    public function attest(Request $request, $id)
    {
        $request->validate([
            'attestation_comment' => 'required|max:255',
            'kits'=>'required'
        ]);
        $roleMovement = RoleMovement::where('id', $id)->get()[0];
        if ($roleMovement->attester_id==$request->user()->id) {
            RoleMovementProfile::where('role_movement_id', $id)->update([
                'is_attested'=>true,
                'attester_comment'=>$request->attestation_comment,
                'no_of_kits'=>$request->kits
                ]);
            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'Attestation successful'
            ]);
        } else {
            return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                'actionWarningMessage'=>'You do not have the permission to complete this request'
            ]);
        }
    }
    public function getAttester($id)
    {
        $resourceZbm = QuickTaskFacade::getUserZbm($id);
        if (isset($resourceZbm[0]->userprofile)) {
            $resourceZbm[0]->userprofile;
        } else {
            $resourceZbm = collect([]);
        }
       
        return response()->json($resourceZbm);
    }
    public function destroy(Request $request, $id)
    {
        if ($request->user()->hasRole('HR')) {
            RoleMovementProfile::where('role_movement_id', $id)->delete();
            RoleMovement::find($id)->delete();
            $message = [
                'actionSuccess'=>'Role movement item deleted successfully'
            ];
        } else {
            $message =  [
                'actionError'=>'Permission denied'
            ];
        }
        return redirect()->route('role.movement.history')->with($message);
    }
}
