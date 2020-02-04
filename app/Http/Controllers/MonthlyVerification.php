<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\HrMonthlyVerification;
use App\Models\MonthlyVerification as VerificationModel;
use App\Events\AgencyMonthlyVerification;
use Log;
use Carbon\Carbon;

class MonthlyVerification extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index(Request $request)
    {
        $title = 'MD Monthly Verification | '.config('global.app_name');
        $dt = Carbon::now();
        $verified = VerificationModel::select('user_id')->whereMonth('month', $dt->month)->get();
        $verifiedIds  = [];
        foreach ($verified as $item) {
            $verifiedIds[] = $item->user_id;
        }
        $allMds =  \App\Facades\MyFacades\QuickTaskFacade::getUserMd($request->user()->id);
        $filteredMds = $allMds->whereNotIn('user_id', $verifiedIds);
        return view('verification.index')->with([
            'title'=>$title,
            'data'=>$filteredMds,
        ]);
    }
    public function store(Request $request)
    {
        if ($request->has('mds')) {
            $mdsToVerify = json_decode($request->mds);

            //deliver emails to HR
            event(new HrMonthlyVerification($mdsToVerify, $request->user()->id));
            //deliver email to Agency
            event(new AgencyMonthlyVerification($mdsToVerify, $request->user()->id));
            
            $dt = Carbon::now();
            foreach ($mdsToVerify as $id) {
                $verified = new VerificationModel;
                $verified->user_id = $id;
                $verified->month = $dt->toDateString();
                $verified->is_verified = true;
                $verified->save();
            }
            return response()->json(array('message'=>'MDs verified successfully','action'=>true));
        } else {
            return response()->json(array('action'=>false,'message'=>'Please select atleast a MD to verify'));
        }
    }
}
