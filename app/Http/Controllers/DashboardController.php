<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utilities\UtilityController;
use App\Models\TargetProfile;
use Carbon\Carbon;
use App\Http\Requests;
use App\Facades\MyFacades\QuickTaskFacade;
use App\Facades\MyFacades\LocationFacade;
use Illuminate\Support\Facades\Validator;
use App\Models\LocationArea;
use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationTerritory;
use JavaScript;

class DashboardController extends Controller
{
    /**
       * Create a new controller instance.
       *
       * @return void
       */
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index(Request $request)
    {
        $title = config('global.app_name')." | Dashboard";
        $page = "Dashboard";
        $userRole = Auth::user()->roles[0]->name;
        $userId = $request->user()->id;
        //dummy hierachy variables
        $myRod;
        $myZbm=1;
        $myAsm=1;
        $myMd=1;
        $locations = collect([]);
      
        //for percentage calculation
        $totalRod = RodProfile::count();
        $totalZbm = ZbmProfile::count();
        $totalAsm = AsmProfile::count();
        $totalMd = MdProfile::count();
        JavaScript::put([
            'totalZbm' => $totalZbm,
            'totalAsm' =>$totalAsm,
            'totalMd' =>$totalMd,
            'totalRod'=>$totalRod,
            'profile'=>$userRole
        ]);
        // If User is an ROD
        if (Auth::user()->hasRole('ROD')) {
            //declare and assign variables to hold hierachy downlines count
            $myZbm = QuickTaskFacade::getUserZbm($userId)->count();
            $myAsm = QuickTaskFacade::getUserAsm($userId)->count();
            $myMd = QuickTaskFacade::getUserMd($userId)->count();
            //Get all Hierachy Relationships
            $totalZbmPercentage  = round(
            ($myZbm/(($totalZbm>0) ? $totalZbm : 1))*100
            );
            $totalAsmPercentage = round(
                ($myAsm/(($totalAsm>0) ? $totalAsm : 1))*100
            );
            $totalMdPercentage = round(
                ($myMd/(($totalMd>0) ? $totalMd : 1))*100
            );
            $locations = LocationFacade::getUserZone($userId);
        }
        // //End ROD
        // If User is a ZBM
        if (Auth::user()->hasRole('ZBM')) {
            //declare and assign variables to hold hierachy downlines count
            $myAsm = QuickTaskFacade::getUserAsm($userId)->count();
            $myMd = QuickTaskFacade::getUserMd($userId)->count();
            $totalAsmPercentage = round(
                ($myAsm/(($totalAsm>0) ? $totalAsm : 1))*100
            );
            $totalMdPercentage = round(
                ($myMd/(($totalMd>0) ? $totalMd : 1))*100
            );
            $locations[] = LocationFacade::getUserZone($userId);
        }
        //End ZBM
        // If User is a ASM
        if (Auth::user()->hasRole('ASM')) {
            //declare and assign variables to hold hierachy downlines count
            $myMd = QuickTaskFacade::getUserMd($userId)->count();
            $totalMdPercentage = round(
                ($myMd/(($totalMd>0) ? $totalMd :1))*100
            );
        }
        //End ASM
        //If User is HR
        if (Auth::user()->hasRole('HR')) {
        }
        //End HR
        //If User is HQ
        if (Auth::user()->hasRole('HQ')) {
        }
        //End HQ
        //If User is GeoMarketing
        if (Auth::user()->hasRole('GeoMarketing')) {
            //for percentage calculation
            $regionCount = LocationRegion::get()->count();
            $zoneCount = LocationZone::get()->count();
            $areaCount = LocationArea::get()->count();
            $territoryCount = LocationTerritory::get()->count();
            JavaScript::put([
            'regionCount' => $regionCount,
            'zoneCount' =>$zoneCount,
            'areaCount' =>$areaCount,
            'territoryCount'=>$territoryCount,
        ]);
        }

      
        if (isset($request->welcome) && $request->welcome) {
            JavaScript::put([
                'welcome'=>'show']);
        }

        JavaScript::put([
            'app_name'=>'SalesForce',
            'page'=>'Dashboard',
            'myZbm'=>$myZbm,
            'myAsm'=>$myAsm,
            'myMd'=>$myMd
            ]);
        // if ($request->user()->hasRole('HR') || $request->user()->hasRole('HQ') || $request->user()->hasRole('GeoMarketing')) {
        //     //retrieve targets assigned
        //     $assignedTargets = TargetProfile::all();
        //     //retrieve targets count for this month
        //     $dt = Carbon::now();
        //     $year = $dt->year;
        //     $month = $dt->month;
        //     $targetsThisMonth = TargetProfile::whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->count();
        //     //retrieve uncompleted targets
        //     $uncompletedTargets = TargetProfile::where('completed', false)->get()->count();
        //     //retrieve total completed targets
        //     $totalCompletedTargets = TargetProfile::where('completed', true)->get()->count();
        // } else {
        //     //retrieve targets assigned to curent user
        //     $assignedTargets = TargetProfile::where('assigned_to_user_id', $request->user()->id)->with(['target'])->get();
        //     foreach ($assignedTargets as $t) {
        //         $getDateTime = new Carbon($t->created_at);
        //         $t->datetime = $getDateTime->format('F j, Y');   // formats datetime to December 31, 2015
        //         $profiles[] =  $t->target->ownerProfile;
        //     }
        //     //retrieve targets count for this month
        //     $dt = Carbon::now();
        //     $year = $dt->year;
        //     $month = $dt->month;
        //     $targetsThisMonth = TargetProfile::where('assigned_to_user_id', $request->user()->id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->count();
        //     //retrieve uncompleted targets
        //     $uncompletedTargets = TargetProfile::where('assigned_to_user_id', $request->user()->id)->where('completed', false)->get()->count();
        //     //retrieve total completed targets
        //     $totalCompletedTargets = TargetProfile::where('assigned_to_user_id', $request->user()->id)->where('completed', true)->get()->count();
        // }

        //organogram
        // $utility = new UtilityController;
        // $utility->prepareOrganogram($request->user()->id);

        return view('dashboard.dashboard')->with([
            'title'=>$title,
            'page'=>$page,
            'userRole'=>$userRole,
            'locations'=>$locations,
            'totalZbmPercentage'=> (isset($totalZbmPercentage) ? $totalZbmPercentage : 10),
            'totalAsmPercentage'=> (isset($totalAsmPercentage) ? $totalAsmPercentage : 10),
            'totalMdPercentage' => (isset($totalMdPercentage) ? $totalMdPercentage : 10),
            'targetsPicture'=>(isset($profiles) ? $profiles : []),
            // 'targetsThisMonth'=>$targetsThisMonth,
            'targetsThisMonth'=>[],
            // 'uncompletedTargets'=>$uncompletedTargets,
            'uncompletedTargets'=>[],
            // 'totalAssignedTargets'=>$assignedTargets->count(),
            'totalAssignedTargets'=>0,
            // 'totalCompletedTargets'=> $totalCompletedTargets,
            'totalCompletedTargets'=> []
        ]);
    }
    public function store(Request $request)
    {
        //If request is made for profile update
        if ($request->action =="profile") {
            //validates data
            $validator = Validator::make($request->all(), [
        'msisdn' => 'bail|required|numeric',
        'first_name' => 'required',
        'last_name'=> 'required',
        'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        
    ]);
            if ($validator->fails()) {
                return redirect('home')
        ->withErrors($validator)
        ->withInput();
            }
            if ($request->hasFile('picture')) {
                $this->validate($request, [
                            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                ]);
                if ($request->file('picture')->isValid()) {
                    $path = $request->file('picture')->store('public');
                    //get the filename
                    $filename = substr($path, 7);
                    $profile = UserProfile::where('user_id', $request->user()->id)->get();
                    if ($profile->count() ==0) {
                        $profile = new UserProfile;
                        $profile->user_id = $request->user()->id;
                        $profile->auuid = $request->user()->auuid;
                        $profile->profile_picture = $filename;
                        $profile->last_name = $request->last_name;
                        $profile->phone_number = $request->msisdn;
                        $profile->first_name = $request->first_name;
                        $profile->save();
                    } elseif ($profile->count() ==1) {
                        UserProfile::where('user_id', $request->user()->id)->update([
                        'profile_picture'=>$filename,
                        'last_name'=>$request->last_name,
                        'phone_number'=>$request->msisdn,
                        'first_name'=>$request->first_name
                        ]);
                    }
                   
                    return redirect()->route('home')->with([
                        'actionSuccessMessage'=>'Profile updated successfully'
                     ]);
                } else {
                    return redirect()->route('home')->with([
                        'actionErrorMessage'=> "Invalid file selected"
                    ]);
                }
            } else {
                return redirect()->route('home')->with([
                    'actionErrorMessage'=> "No file selected for upload"
                ]);
            }
        }

        //handles other requests below
    }
}
