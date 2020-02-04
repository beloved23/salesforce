<?php

namespace App\Http\Controllers;

use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use App\Models\LocationRegion;
use App\Models\LocationState;
use App\Models\LocationTerritory;
use App\Models\LocationArea;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Target;
use App\Models\TargetProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleMovement;
use Carbon\Carbon;
use App\Models\Inbox;
use App\Models\LocationZone;
use App\Models\Vacancy;
use Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Facades\MyFacades\QuickTaskFacade;
use App\Facades\MyFacades\LocationFacade;
use App\Facades\MyFacades\VacancyFacade;
use Illuminate\Http\Request;
use App\Http\Controllers\Utilities\UtilityController;

class ProtectedApiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance']);
    }
    //
    public function getRods(Request $request)
    {
        $rods = RodProfile::with(['user:id,email,auuid'])->get();
        return response()->json(['data'=>$rods,
        'action'=>true,'count'=>$rods->count()]);
    }
    public function getZbms(Request $request)
    {
        $rods = ZbmProfile::with(['user:id,email'])->get();
        return response()->json(['data'=>$rods,'action'=>true,'count'=>$rods->count()]);
    }
    public function getMyZbms(Request $request)
    {
        if (Auth::user()->hasRole('ZBM')) {
            $data = ZbmProfile::where('user_id', $request->user()->id)->with(['user','userprofile'])->get();
        } else {
            $data = QuickTaskFacade::getUserZbm($request->user()->id);
            foreach ($data as $zbm) {
                $zbm->user;
                $zbm->userprofile;
            }
        }
        return response()->json(['data'=>$data,'action'=>true,'count'=>count($data)]);
    }
    public function getMyAsms(Request $request)
    {
        if (Auth::user()->hasRole('ASM')) {
            $data = AsmProfile::where('user_id', $request->user()->id)->with(['user','userprofile'])->get();
        } else {
            $data = QuickTaskFacade::getUserAsm($request->user()->id);
            foreach ($data as $asm) {
                $asm->user;
                $asm->userprofile;
            }
        }
        return response()->json(['data'=>$data,'action'=>true,'count'=>count($data)]);
    }
    public function getMyMds(Request $request)
    {
        if (Auth::user()->hasRole('MD')) {
            $data = MdProfile::where('user_id', $request->user()->id)->with(['user','userprofile'])->get();
        } else {
            $data = QuickTaskFacade::getUserMd($request->user()->id);
            foreach ($data as $asm) {
                $asm->user;
                $asm->userprofile;
            }
        }
        return response()->json(['data'=>$data,'action'=>true,'count'=>count($data)]);
    }
    public function getAsms(Request $request)
    {
        $asms = AsmProfile::with(['user:id,email'])->get();
        return response()->json(['data'=>$asms,'action'=>true,'count'=>$asms->count()]);
    }
    public function getMds(Request $request)
    {
        $mds = MdProfile::with(['user:id,email'])->get();
        return response()->json(['data'=>$mds,'action'=>true,'count'=>$mds->count()]);
    }
    public function getDownlines(Request $request)
    {
        if (Auth::user()->hasRole("ROD")) {
            $role = "ROD";
            $downlines = QuickTaskFacade::getUserZbm($request->user()->id);
            foreach ($downlines as $a) {
                $a->user;
            }
        } elseif (Auth::user()->hasRole("ZBM")) {
            $role = "ZBM";
            $downlines = QuickTaskFacade::getUserAsm($request->user()->id);
            foreach ($downlines as $a) {
                $a->user;
            }
        } elseif (Auth::user()->hasRole("ASM")) {
            $role = "ASM";
            $downlines = QuickTaskFacade::getUserMd($request->user()->id);
            foreach ($downlines as $a) {
                $a->user;
            }
        }
        if (!isset($downlines)) {
            $downlines = array();
            $role = "HQ";
        }
        return response()->json(array("downlines"=>$downlines,"role"=>$role));
    }
    public function user(Request $request, $id)
    {
        $user = User::select('id', 'email', 'is_deactivated')->find($id);
        $user->profile;
        if ($user->roles()->exists()) {
            $user["role"] = $user->roles()->select('id', 'name')->get()[0];
        }
        else{
            $user["role"] = json_decode(json_encode(['name'=>'N/A']));
        }
        $user["zbmCount"] = count(QuickTaskFacade::getUserZbm($user->id));
        $user["asmCount"] = count(QuickTaskFacade::getUserAsm($user->id));
        $user["mdCount"] = count(QuickTaskFacade::getUserMd($user->id));
        return response()->json($user);
    }
    public function dummy()
    {
        $users = User::all();
        foreach ($users as $user) {
            $profile = UserProfile::where('user_id', $user->id)->get();
            if ($profile->count()==0) {
                $newProfile = new UserProfile;
                $newProfile->user_id = $user->id;
                $newProfile->first_name = '';
                $newProfile->last_name  = '';
                $newProfile->phone_number = '';
                $newProfile->profile_picture = 'avatar.jpg';
                $newProfile->auuid = $user->auuid;
                $newProfile->save();
            }
        }
        return 'done';
    }
    public function moreTargets(Request $request, $id)
    {
        $targets = Target::where('user_id', $request->user()->id)->where('id', '<', $id)->withCount(['profile'])->orderBy('created_at', 'desc')->limit(5)->get();
        return response()->json($targets);
    }
    public function custom(Request $request)
    {
        $utility = new UtilityController;
        $data = $utility->apiOrganogram(1);
        // // $vacancies = bcrypt('kimberly');
        return response()->json($data);
    }
    public function pusherAuth(Request $request)
    {
        Log::info('Service_id '.$request->socket_id);
        Log::info('Channel_name '.$request->channel_name);
    }
}
