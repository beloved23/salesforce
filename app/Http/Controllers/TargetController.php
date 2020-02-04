<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use JavaScript;
use App\Models\Target;
use App\Models\TargetProfile;

use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','master','clearance']);
    }
    public function index(Request $request)
    {

        //date
        $date = Carbon::now()->format("jS \\of F");
        //retrieve targets owned by current user
        $targets = Target::where('user_id', $request->user()->id)->withCount(['profile'])->orderBy('created_at', 'desc')->limit(10)->get();

        //retrieve targets assigned to curent user
        $assignedTargets = TargetProfile::where('assigned_to_user_id', $request->user()->id)->with(['target'])->get();
        foreach ($assignedTargets as $t) {
            $getDateTime = new Carbon($t->created_at);
            $t->datetime = $getDateTime->format('F j, Y');   // formats datetime to December 31, 2015
            $profiles[] =  $t->target->ownerProfile;
        }
        //retrieve targets count for this month
        $dt = Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $targetsThisMonth = TargetProfile::where('assigned_to_user_id', $request->user()->id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->count();
        //retrieve uncompleted targets
        $uncompletedTargets = TargetProfile::where('assigned_to_user_id', $request->user()->id)->where('completed', false)->get()->count();
        JavaScript::put([
            'targets'=>$targets,
            'assignedTargets'=>$assignedTargets,
            'currentRoleFromMaster'=>$request->user()->roles[0]->name
        ]);

        return view('targets.index')->with([
        'title'=>'Targets | '.config('global.app_name'),
        'date'=>$date,
        'assignedTargets'=>$assignedTargets,
        'targetsPicture'=>(isset($profiles) ? $profiles : []),
        'targetsThisMonth'=>$targetsThisMonth,
        'uncompletedTargets'=>$uncompletedTargets,
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'tag' => 'bail|required',
            'gross_ads' => 'required|numeric',
            'decrement'=>'required|numeric',
            'kit'=>'required|numeric'
    ]);
        $target = new Target;
        $target->tag = $request->tag;
        $target->owner = $request->user()->auuid;
        $target->user_id = $request->user()->id;
        $target->gross_ads = $request->gross_ads;
        $target->kit = $request->kit;
        $target->decrement = $request->decrement;
        $target->save();
        return redirect()->route('targets.index')->with([
                'actionSuccessMessage'=>'Target created successfully'
            ]);
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        if ($request->has('tag') && $request->has('decrement') && $request->has('grossAds') && $request->has('kit')) {
            $target = Target::where('id', $request->id)->get();
            if ($target->count()==1) {
                $owner = $target[0]->user_id;
                if ($owner==$request->user()->id) {
                    Target::where('id', $request->id)->update([
                        'tag'=>$request->tag,
                        'decrement'=>$request->decrement,
                        'gross_ads'=>$request->grossAds,
                        'kit'=>$request->kit
                    ]);
                    $modifiedTarget = Target::where('id', $request->id)->get();
                    return response()->json(array("validations"=>true,"target"=>$modifiedTarget[0],"message"=>"Target modified successfully","action"=>true));
                } else {
                    return response()->json(array("validations"=>true,"message"=>"Only the owner of this target can modify it","action"=>false));
                }
            } else {
                return response()->json(array("validations"=>false,"message"=>"Specified target could not be found","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"Please provide tag, decrement, grossAds and kit","action"=>false));
        }
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $target = Target::find($id);
        if (isset($target->tag)) {
            if ($target->user_id==$request->user()->id) {
                TargetProfile::where('target_id', $id)->delete();
                $target->delete();
                return response()->json(array("validations"=>true,"message"=>"Target deleted successfully","action"=>true));
            } else {
                return response()->json(array("validations"=>true,"message"=>"Only the owner of this target can delete it","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>true,"message"=>"Specified target could not be found ","action"=>false));
        }
    }
}
