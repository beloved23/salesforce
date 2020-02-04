<?php

namespace App\Http\Controllers;

use App\Facades\MyFacades\LocationFacade;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Http\Request;
use JavaScript;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\LocationMovement;
use App\Models\LocationMovementProfile;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use App\Events\LocationMovementCreated;
use App\Events\LocationMovementApproved;
use App\Events\HierachyNotificationForLocationMovementEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Log;

class LocationMovementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function create(Request $request)
    {
        $title = 'Location Movement | '.config('global.app_name');
        $collection = LocationFacade::getLocationsForMovement($request->user()->id);
        JavaScript::put([
            'locationCollection'=>$collection,
            'initialLocationId'=> LocationFacade::getUserLocationId($request->user()->id),
        ]);
        return view('locationmovement.create')->with([
            'title'=>$title,
            'locationCollection'=>$collection,
        ]);
    }

    public function store(Request $request)
    {
        //validate comment
        $this->validate($request, [
            'comment'=>'required',
            'selectedLocationId'=>'required',
            'role'=>'required',
            'selectedUser'=>'required'
        ]);

        
        
        //handle ROD request
        // if ($request->user()->hasRole('ROD')) {
        //check unique transfer request
        if (!LocationFacade::checkUniqueLocationMovement($request->selectedUser, $request->role, $request->selectedLocationId)) {
            return redirect()->route('location.movement.create')->with([
                    'actionErrorMessage'=>"Please select a location that differs from resource current location"
                ]);
        } else {
            //check for pending transfer request
            $pending = LocationMovement::where('requester_id', $request->selectedUser)->where('is_cancelled', false)->where('is_approved', false)->get();
            if ($pending->count() >0) {
                return redirect()->route('location.movement.create')->with([
                        'actionErrorMessage'=>'Resource has a pending transfer request. '
                    ]);
            }
            $requester = User::find($request->selectedUser);
            $requestData["requester_id"] = $request->selectedUser;
            $requestData["requester_auuid"] = $requester->auuid;
            $requestData["location_model"] = config('global.location_models')[$request->role];
            $requestData["location_id"] = $request->selectedLocationId;
            $column = config('global.location_column')[$request->role];
            $requestData['initiated_by'] = $request->user()->id;
            $requestData["requester_location_id"] = config('global.models')[$request->role]::where('user_id', $request->selectedUser)->get()[0]->$column;
        }
        // } //elseif ($request->user()->hasRole('ZBM')) {
        //     //check if current zone differs from desired
        //     $zbm = ZbmProfile::where('user_id', $request->user()->id)->get()[0];
        //     if ($zbm->zone_id==$request->selectedLocationId) {
        //         return redirect()->route('location.movement.create')->with([
        //             'actionErrorMessage'=>'Please select a zone that differs from your current zone'
        //         ]);
        //     } else {
        //         //check for pending transfer request
        //         $pending = LocationMovement::where('requester_id', $request->user()->id)->where('is_cancelled', false)->where('is_approved', false)->get();
        //         if ($pending->count() >0) {
        //             return redirect()->route('location.movement.create')->with([
        //                 'actionErrorMessage'=>'You have a pending transfer request. Please cancel it and try again'
        //             ]);
        //         }
        //         $requestData["requester_id"] = $request->user()->id;
        //         $requestData["requester_auuid"] = $request->user()->auuid;
        //         $requestData["location_model"] = "App\Models\LocationZone";
        //         $requestData["location_id"] = $request->selectedLocationId;
        //         $requestData["requester_location_id"] = ZbmProfile::where('user_id', $request->user()->id)->get()[0]->zone_id;
        //     }
        // } elseif ($request->user()->hasRole('ASM')) {
        //     //check if current area differs from desired
        //     $asm = AsmProfile::where('user_id', $request->user()->id)->get()[0];
        //     if ($asm->area_id==$request->selectedLocationId) {
        //         return redirect()->route('location.movement.create')->with([
        //             'actionErrorMessage'=>'Please select a area that differs from your current area'
        //         ]);
        //     } else {
        //         //check for pending transfer request
        //         $pending = LocationMovement::where('requester_id', $request->user()->id)->where('is_cancelled', false)->where('is_approved', false)->get();
        //         if ($pending->count() >0) {
        //             return redirect()->route('location.movement.create')->with([
        //                 'actionErrorMessage'=>'You have a pending transfer request. Please cancel it and try again'
        //             ]);
        //         }
        //         $requestData["requester_id"] = $request->user()->id;
        //         $requestData["requester_auuid"] = $request->user()->auuid;
        //         $requestData["location_model"] = "App\Models\LocationArea";
        //         $requestData["location_id"] = $request->selectedLocationId;
        //         $requestData["requester_location_id"] = AsmProfile::where('user_id', $request->user()->id)->get()[0]->area_id;
        //     }
        // } elseif ($request->user()->hasRole('MD')) {
        //     //check if current territory differs from desired
        //     $md = MdProfile::where('user_id', $request->user()->id)->get()[0];
        //     if ($md->territory_id==$request->selectedLocationId) {
        //         return redirect()->route('location.movement.create')->with([
        //             'actionErrorMessage'=>'Please select a territory that differs from your current territory'
        //         ]);
        //     } else {
        //         //check for pending transfer request
        //         $pending = LocationMovement::where('requester_id', $request->user()->id)->where('is_cancelled', false)->where('is_approved', false)->get();
        //         if ($pending->count() >0) {
        //             return redirect()->route('location.movement.create')->with([
        //                 'actionErrorMessage'=>'You have a pending transfer request. Please cancel it and try again'
        //             ]);
        //         }
        //         $requestData["requester_id"] = $request->user()->id;
        //         $requestData["requester_auuid"] = $request->user()->auuid;
        //         $requestData["location_model"] = "App\Models\LocationTerritory";
        //         $requestData["location_id"] = $request->selectedLocationId;
        //         $requestData["requester_location_id"] = MdProfile::where('user_id', $request->user()->id)->get()[0]->territory_id;
        //     }
        // }
        $profile = new LocationMovementProfile;
        //attach attestation for asm and md
        if ($request->role=='ASM' || $request->role=='MD') {
            $profile->is_attestation_required = true;
            $zbm = QuickTaskFacade::getUserZbm($request->selectedUser);
            if (count($zbm) ==0) {
                return redirect()->route('location.movement.create')->with([
                    'actionErrorMessage'=>'Error: this request require that resource has a ZBM to attest this transfer request'
                ]);
            } else {
                $requestData["attester_auuid"] = $zbm[0]->auuid;
                $requestData["attester_id"] = $zbm[0]->user_id;
            }
        }
        //common actions to all roles
        $savedRequest = LocationMovement::create($requestData);
        
        
        $profile->location_movement_id = $savedRequest->id;
       
        $profile->requester_comment = $request->comment;
        $profile->save();
        event(new LocationMovementCreated($savedRequest));
        return redirect()->route('location.movement.create')->with([
            'actionSuccessMessage'=>'Location Movement Request sent successfully',
        ]);
    }

    //get country by Region
    public function getCountryByRegion($id)
    {
        return LocationFacade::getCountryByRegion($id);
    }
    public function profile(Request $request, $id)
    {
        $title = 'Location Movement Profile | '.config('global.app_name');
        $locationMovementProfile = LocationMovement::where('id', $id)->get();
        return view('locationmovement.profile')->with([
            'title'=>$title,
            'locationMovementProfile'=>$locationMovementProfile
        ]);
    }

    public function history(Request $request)
    {
        $title = 'Location Movement History | '.config('global.app_name');
        $id = $request->user()->id;
        if ($request->user()->hasRole('HR')) {
            $locationMovement = LocationMovement::orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $locationMovement = LocationMovement::where('requester_id', $id)->orWhere('initiated_by', $id)
        ->orWhere('hr_id', $id)->orWhere('attester_id', $id)->orderBy('updated_at', 'desc')->paginate(10);
        }
        return view('locationmovement.history')->with([
            'title'=>$title,
            'locationMovement'=>$locationMovement
        ]);
    }
    public function unclaim(Request $request, $id)
    {
        $locationMovement = LocationMovement::where('id', $id)->get()[0];
        if ($request->user()->id == $locationMovement->hr_auuid) {
            LocationMovement::where('id', $id)->update(['hr_auuid'=>null,'is_claimed'=>false]);
            return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'You have successfully undo the claim on this transfer request'
            ]);
        } else {
            return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionWarningMessage'=>'You do not have the permission to complete this request'
            ]);
        }
    }
    public function claim(Request $request, $id)
    {
        $locationMovement = LocationMovement::where('id', $id)->get()[0];
        if ($request->user()->hasRole('HR')) {
            LocationMovement::where('id', $id)->update(['hr_id'=>$request->user()->id,'hr_auuid'=>$request->user()->auuid,'is_claimed'=>true]);
            return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'You have successfully claimed to oversee this transfer request'
            ]);
        } else {
            return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionWarningMessage'=>'You do not have the permission to complete this request'
            ]);
        }
    }
    public function approve(Request $request, $id)
    {
        $request->validate([
            'approval_comment' => 'required|max:255',
        ]);
        $locationMovement = LocationMovement::find($id);
        if ($request->user()->hasRole('HR')) {
            if ($request->user()->id == $locationMovement->hr_id) {
                //check if attestation is required before approval
                //if attestation is not required
                if (!$locationMovement->is_attestation_required) {
                    if (LocationFacade::moveUserToLocation($locationMovement->requester_id, $locationMovement->location_id)) {
                        LocationMovement::where('id', $id)->update(['is_approved'=>true,'is_denied'=>false]);
                        LocationMovementProfile::where('location_movement_id', $id)->update(['approval_comment'=>$request->approval_comment,'denial_comment'=>null]);
                        //deliver emails below
                        event(new LocationMovementApproved($locationMovement));
                        //notification on site modification
                        event(new HierachyNotificationForLocationMovementEvent($locationMovement->id));
                        return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                          'actionSuccessMessage'=>'You have successfully approved this transfer request'
                         ]);
                    } else {
                        return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                            'actionWarningMessage'=>'The requested location is currently occupied'
                        ]);
                    }
                } else {
                    //if attestation is required
                    //check if movement has been attested by ZBM
                    if ($locationMovement->is_attested) {
                        LocationMovement::where('id', $id)->update(['is_approved'=>true]);
                        return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                        'actionSuccessMessage'=>'You have successfully approved this transfer request'
                    ]);
                    } else {
                        return redirect()->route('role.movement.profile', ['id'=>$id])->with([
                        'actionWarningMessage'=>'This transfer request requires attestation by related ZBM before it can be approved'
                    ]);
                    }
                }
            } else {
                return redirect()->route('location.movement.profile', ['id'=>$id])->with([
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
        $locationMovement = LocationMovement::where('id', $id)->get()[0];
        if ($request->user()->hasRole('HR')) {
            if ($request->user()->id == $roleMovement->hr_auuid) {
                LocationMovement::where('id', $id)->update(['is_denied'=>true]);
                LocationMovementProfile::where('location_movement_id', $id)->update(['denial_comment'=>$request->denial_comment]);
                return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'You have successfully denied this movement request'
            ]);
            } else {
                return redirect()->route('location.movement.profile', ['id'=>$id])->with([
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
        $locationMovement = LocationMovement::where('id', $id)->get()[0];
        if ($locationMovement->attester_id==$request->user()->id) {
            LocationMovementProfile::where('location_movement_id', $id)->update([
                'is_attested'=>true,
                'attester_comment'=>$request->attestation_comment,
                'no_of_kits'=>$request->kits
                ]);
            return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionSuccessMessage'=>'Attestation successful'
            ]);
        } else {
            return redirect()->route('location.movement.profile', ['id'=>$id])->with([
                'actionWarningMessage'=>'You do not have the permission to complete this request'
            ]);
        }
    }
    public function getUpline(Request $request, $id)
    {
        return LocationFacade::getUpline($id);
    }
    public function cancel($id)
    {
        LocationMovement::where('id', $id)->update(['is_cancelled'=>true]);
        return redirect()->route('location.movement.history')->with([
            'actionSuccessMessage'=>'Transfer request cancelled successfully',
        ]);
    }
    public function destroy($id)
    {
        LocationMovement::with(['profile'])->find($id)->delete();
        return redirect()->route('location.movement.history')->with([
            'actionSuccessMessage'=>'Location movement item deleted successfully',
        ]);
    }
}
