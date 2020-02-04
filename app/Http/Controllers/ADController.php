<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Log;

class ADController extends Controller
{
    public function simulate(Request $request)
    {
        $obj =   '{"IsSuccess":true,"MessageList":[],"ObjectList":[{"FullName":"SalesForce","Email":"support@salesforce.com.ng","PhoneNumber":"080300000000","Department":"IT"}]}';
        return response()->json(json_decode($obj));
    }
    public function authenticate(Request $request, $auuid)
    {
        Log::info($auuid);
        $user = User::where('auuid', "".$auuid)->get();
        if ($user->count()> 0) {
            return response()->json(array("validation"=>true,"message"=>"User is valid","userId"=>$user[0]->id));
        } else {
            return response()->json(array("validation"=>false,"auuid"=>$auuid,"data"=>json_encode($user),"message"=>"No account is associated with this auuid. Please contact Human Resources"));
        }
    }
}
