<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LocationMovement;
use JavaScript;

class ClaimLocationMovement extends Controller
{
    public function claim(Request $request, $id)
    {
        try {
            //verify token
            $token = $request->input('token');
            //decrypt token
            $decryptedToken = Crypt::decryptString($token);
            if ($decryptedToken==config('global.location_movement_secret')) {
                $allHR = Role::where('name', 'HR')->with(['users:id,email,auuid'])->paginate(10);
                foreach ($allHR[0]->users as $hr) {
                    $hr->profile;
                }
                JavaScript::put([
                'allHR' =>$allHR[0]->users,
                'locationMovementId'=>$id,
                'verificationToken'=>$token
            ]);
                return view('locationmovement.claim')->with([
              'allHR'=> $allHR
          ]);
            } else {
                return redirect()->route('login');
            }
        } catch (DecryptException $e) {
            return redirect()->route('login');
        }
    }
    public function verifyWithToken(Request $request)
    {
        //perform validation for all required inputs
        if ($request->has('hrId') && $request->has('locationMovementId') && $request->has('token') && $request->has('password')) {
            $token = $request->token;
            try {
                $decryptedToken = Crypt::decryptString($token);
                if ($decryptedToken==config('global.location_movement_secret')) {
                    $hrUser = User::select('password', 'email', 'auuid')->where('id', $request->hrId)->get()[0];
                    //  if (Hash::check($request->password, $hrUser->password)) {
                    // $ad_api = sprintf(config('global.ad_api'), $request->auuid, $request->password);
                    // //send request to AD api
                    // $adResponse = QuickTaskFacade::curlGetRequest($ad_api);
                    // $adResponse= json_decode($adResponse);
   
                    if ($request->password=="airtel") {
                        //claim role movement
                        $roleMovementItem = LocationMovement::where('id', $request->locationMovementId)->get()[0];
                        //if movement has been claimed already
                        if ($roleMovementItem->is_claimed) {
                            return response()->json(array("validations"=>true,"message"=>"This transfer request has been claimed already. Please check your history for more details","action"=>false));
                        } else {
                            $claimRoleMovementItem = LocationMovement::where('id', $request->locationMovementId)->update(['is_claimed'=>true,'hr_id'=>$request->hrId,'hr_auuid'=>$hrUser->auuid]);
                            $routeToken = Crypt::encryptString('location.movement.profile');
                            $userToken = Crypt::encryptString($request->hrId);
                            return response()->json(array("validations"=>true,"routeToken"=>$routeToken,"userToken"=>$userToken,"message"=>"You have successfully claimed this location transfer request","action"=>true));
                        }
                    } else {
                        return response()->json(array("validations"=>true,"message"=>"Incorrect username or password","action"=>false));
                    }
                } else {
                    return response()->json(array("validations"=>true,"message"=>"A payload error occured. Please try again later","action"=>false));
                }
            } catch (DecryptException $e) {
                return response()->json(array("validations"=>true,"message"=>"A payload error occured. Please try again later","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"Please provide token, HR auuid, role movement id and password","action"=>false));
        }
    }
}
