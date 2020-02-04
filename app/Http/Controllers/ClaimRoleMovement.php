<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleMovement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class ClaimRoleMovement extends Controller
{
    public function claim(Request $request,$id){
        try{
        //verify token
        $token = $request->input('token');
        //decrypt token
        $decryptedToken = Crypt::decryptString($token);
        if($decryptedToken==env('ROLE_MOVEMENT_CLAIM_SECRET')){
            $allHR = Role::where('name','HR')->with(['users:id,email'])->paginate(10);
            foreach($allHR[0]->users as $hr){
                $hr->profile;
            }
            JavaScript::put([
                'allHR' =>$allHR[0]->users,
                'roleMovementId'=>$id,
                'verificationToken'=>$token
            ]);
          return view('rolemovement.claim')->with([
              'allHR'=> $allHR
          ]);
        }
        else{
                return redirect()->route('login');
        }
    }
    catch(DecryptException $e){
        return redirect()->route('login');
    }
    }
    public function verifyWithToken(Request $request){
        //perform validation for all required inputs
        if($request->has('hrAuuid') && $request->has('roleMovementId') && $request->has('token') && $request->has('password')){
            $token = $request->token;
            try{
                $decryptedToken = Crypt::decryptString($token);
                if($decryptedToken==env('ROLE_MOVEMENT_CLAIM_SECRET')){
                    $hrUser = User::select('password','email')->where('id',$request->hrAuuid)->get()[0];
                    if (Hash::check($request->password, $hrUser->password)) {
                        //claim role movement
                        $roleMovementItem = RoleMovement::where('id',$request->roleMovementId)->get()[0];
                        //if movement has been claimed already
                        if($roleMovementItem->is_claimed){
                            return response()->json(array("validations"=>true,"message"=>"This role movement request has been claimed already. Please check your history for more details","action"=>false));                                                                  
                        }
                        else{
                        $claimRoleMovementItem = RoleMovement::where('id',$request->roleMovementId)->update(['is_claimed'=>true,'hr_auuid'=>$request->hrAuuid]);
                        $routeToken = Crypt::encryptString('role.movement.profile');
                        $userToken = Crypt::encryptString($request->hrAuuid);
                         return response()->json(array("validations"=>true,"routeToken"=>$routeToken,"userToken"=>$userToken,"message"=>"You have successfully claimed this role movement request","action"=>true));                         
                        }
                    }
                    else{
                        return response()->json(array("validations"=>true,"message"=>"Incorrect username or password","action"=>false));                                      
                    }
                  
                }
                else{
                    return response()->json(array("validations"=>true,"message"=>"A payload error occured. Please try again later","action"=>false));                                      
                }
            }
            catch(DecryptException $e){
                return response()->json(array("validations"=>true,"message"=>"A payload error occured. Please try again later","action"=>false));                                                      
            }   
        }
        else{
            return response()->json(array("validations"=>false,"message"=>"Please provide token, HR auuid, role movement id and password","action"=>false));              
        }
       
    }
    public function authenticateAndRedirectWithToken(Request $request){

    }
}
