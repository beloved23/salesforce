<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;
use App\Models\TargetProfile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Facades\MyFacades\QuickTaskFacade;
use JavaScript;
use Log;
use App\Models\User;

class TargetProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Targets | '.config('global.app_name');
        //retrieve targets assigned
        $assignedTargets = TargetProfile::orderBy('created_at', 'desc')->paginate(10);
        return view('targets.history')->with([
            'title'=>$title,
            'assignedTargets'=>$assignedTargets
        ]);
    }
    public function completed(Request $request)
    {
        $title = 'Targets | '.config('global.app_name');
        //Carbon for DateTime
        //retrieve targets count for this month
        $dt = Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $assignedTargets = TargetProfile::where('completed', true)->orderBy('created_at', 'desc')->paginate(10);
        return view('targets.history')->with([
            'title'=>$title,
            'assignedTargets'=>$assignedTargets
        ]);
    }
    public function uncompleted(Request $request)
    {
        $title = 'Targets | '.config('global.app_name');
        //Carbon for DateTime
        //retrieve targets count for this month
        $dt = Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $assignedTargets = TargetProfile::where('completed', false)->orderBy('created_at', 'desc')->paginate(10);
        return view('targets.history')->with([
            'title'=>$title,
            'assignedTargets'=>$assignedTargets
        ]);
    }
    public function thisMonth(Request $request)
    {
        $title = 'Targets | '.config('global.app_name');
        //Carbon for DateTime
        //retrieve targets count for this month
        $dt = Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $assignedTargets = TargetProfile::whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('created_at', 'desc')->paginate(10);
        return view('targets.history')->with([
            'title'=>$title,
            'assignedTargets'=>$assignedTargets
        ]);
    }
    public function lastMonth(Request $request)
    {
        $title = 'Targets | '.config('global.app_name');
        //Carbon for DateTime
        //retrieve targets count for this month
        $dt = Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $assignedTargets = TargetProfile::whereMonth('created_at', $month-1)->whereYear('created_at', $year)->orderBy('created_at', 'desc')->paginate(10);
        return view('targets.history')->with([
            'title'=>$title,
            'assignedTargets'=>$assignedTargets
        ]);
    }
    public function thisYear(Request $request)
    {
        $title = 'Targets | '.config('global.app_name');
        //Carbon for DateTime
        //retrieve targets count for this month
        $dt = Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $assignedTargets = TargetProfile::whereYear('created_at', $year)->orderBy('created_at', 'desc')->paginate(10);
        return view('targets.history')->with([
            'title'=>$title,
            'assignedTargets'=>$assignedTargets
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "store";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Target Profile '.config('global.app_name');
        //date
        $date = Carbon::now()->format("jS \\of F");
        $target = Target::find($id);
        if (isset($target->id)) {
            $profiles = TargetProfile::where('target_id', $id)->paginate(20);
            return view('targets.profile')->with([
            'title'=>$title,
            'date'=>$date,
            'targetProfiles'=>$profiles,
            'target'=>$target,
        ]);
        } else {
            return redirect()->route('targets.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $targetProfile = TargetProfile::find($id);
        if (isset($targetProfile)) {
            $target = $targetProfile->target;
            if ($target->user_id==$request->user()->id) {
                TargetProfile::where('id', $id)->update(['completed'=>true]);
                return response()->json(array("validations"=>true,"message"=>"Target marked as completed successfully","action"=>true));
            } else {
                return response()->json(array("validations"=>false,"message"=>"Only the owner of this target can perform this action","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"Specified target could not be found. Please check if it exist and try again ","action"=>false));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('id') && $request->has('assignToAllDownlines') && $request->has('assignToMe')) {
            $selectedTarget = Target::find($request->id);
            if (isset($selectedTarget->id)) {
                //prepare target for assignToMe
                if (json_decode($request->assignToMe)) {
                    //clean existing row
                    $targetToMe = TargetProfile::where('assigned_to_user_id', $request->user()->id)->where('target_id', $request->id)->delete();
                    $newTargetToMe = new TargetProfile;
                    $newTargetToMe->target_id = $request->id;
                    $newTargetToMe->assigned_to_user_id = $request->user()->id;
                    $newTargetToMe->assigned_to_auuid = $request->user()->auuid;
                    $newTargetToMe->decrement = $selectedTarget->decrement;
                    $newTargetToMe->kit = $selectedTarget->kit;
                    $newTargetToMe->gross_ads = $selectedTarget->gross_ads;
                    $newTargetToMe->save();
                }
                //assign to all downlines
                if (json_decode($request->assignToAllDownlines)) {
                    if (Auth::user()->hasRole("ROD")) {
                        $downlines = QuickTaskFacade::getUserZbm($request->user()->id);
                    } elseif (Auth::user()->hasRole("ZBM")) {
                        $downlines = QuickTaskFacade::getUserAsm($request->user()->id);
                    } elseif (Auth::user()->hasRole('ASM')) {
                        $downlines = QuickTaskFacade::getUserMd($request->user()->id);
                    }
                    if (count($downlines)>0) {
                        //calculate each cascade unit
                        $cascadeUnitGrossAds = round($selectedTarget->gross_ads/count($downlines));
                        $cascadeUnitKit = round($selectedTarget->kit/count($downlines));
                        $cascadeUnitDecrement = round($selectedTarget->decrement/count($downlines));
                    }
                        
                    foreach ($downlines as $a) {
                        $targetToMe = TargetProfile::where('assigned_to_user_id', $a->user_id)->where('target_id', $request->id)->delete();
                        $newTargetToMe = new TargetProfile;
                        $newTargetToMe->target_id = $request->id;
                        $newTargetToMe->assigned_to_user_id = $a->user_id;
                        $newTargetToMe->assigned_to_auuid = $a->auuid;
                        $newTargetToMe->decrement = $cascadeUnitDecrement;
                        $newTargetToMe->kit = $cascadeUnitKit;
                        $newTargetToMe->gross_ads = $cascadeUnitGrossAds;
                        $newTargetToMe->save();
                    }
                }
                //save only selected users
                if ($request->has('selectedDownlines')) {
                    if (count(json_decode($request->selectedDownlines)) > 0) {
                        foreach (json_decode($request->selectedDownlines) as $id) {
                            $user = User::find($id);
                            $targetToMe = TargetProfile::where('assigned_to_user_id', $id)->where('target_id', $request->id)->delete();
                            $newTargetToMe = new TargetProfile;
                            $newTargetToMe->target_id = $request->id;
                            $newTargetToMe->assigned_to_auuid = $user->auuid;
                            $newTargetToMe->assigned_to_user_id = $user->id;
                            $newTargetToMe->decrement = $selectedTarget->decrement;
                            $newTargetToMe->kit = $selectedTarget->kit;
                            $newTargetToMe->gross_ads = $selectedTarget->gross_ads;
                            $newTargetToMe->save();
                        }
                    }
                }
                $assignedToCount = TargetProfile::where('target_id', $request->id)->get()->count();
                return response()->json(array("validations"=>true,"assigned_to_count"=>$assignedToCount,"message"=>"Target was successfully assigned","action"=>true));
            } else {
                return response()->json(array("validations"=>false,"message"=>"Specified target could not be found. Please check if it exist and try again ","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"Please provide target id, assignToAllDownlines  and assignToMe properties","action"=>false));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
