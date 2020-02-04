<?php

namespace App\Http\Controllers;

use JavaScript;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Utilities\UtilityController;

class OrganogramController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function rod(Request $request)
    {
        //organogram
        $utility = new UtilityController;
        $utility->prepareOrganogram($request->user()->id);
     
        return view('organogram.index')->with([
            'title'=>'My Organogram | SalesForce',
            'showDownline'=>true,
            'showUpline'=>false
        ]);
    }
    public function zbm(Request $request)
    {
     
        //organogram
        $utility = new UtilityController;
        $utility->prepareOrganogram($request->user()->id);
        return view('organogram.index')->with([
            'title'=>'My Organogram | SalesForce',
            'showDownline'=>true,
            'showUpline'=>false
        ]);
    }
    public function asm(Request $request)
    {
        //organogram
        $utility = new UtilityController;
        $utility->prepareOrganogram($request->user()->id);

        JavaScript::put([
            'uplines' =>collect([]),
        ]);
        return view('organogram.index')->with([
            'title'=>'My Organogram | SalesForce',
            'showDownline'=>true,
            'showUpline'=>false,
        ]);
    }

    public function md(Request $request)
    {
        //organogram
        $utility = new UtilityController;
        $utility->prepareOrganogram($request->user()->id);
        return view('organogram.index')->with([
            'title'=>'My Organogram | SalesForce',
            'showUpline'=>false,
            'showDownline'=>true
        ]);
    }
    public function api(Request $request)
    {
        $utility = new UtilityController;
        $data = $utility->apiOrganogram($request->user()->id);
        return response()->json($data);
    }
}
