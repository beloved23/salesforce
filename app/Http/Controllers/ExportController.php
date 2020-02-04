<?php

namespace App\Http\Controllers;

use App\Models\RodProfile;
use App\Models\MdProfile;
use App\Models\LocationSite;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function salesforce()
    {
        // $collection = MdProfile::all();
        $collection = collect([]);
        $rods = RodProfile::paginate(1);
        foreach ($rods as $rod) {
            $collection = $collection->concat(
                QuickTaskFacade::getUserMd($rod->user_id)
            );
        }
        return view('export.salesforce')->with([
            'title'=>'Export | Salesforce',
            'collection'=>$collection,
            'rods'=>$rods
        ]);
    }
    public function geography()
    {
        $collection = collect([]);
        $collection = LocationSite::all();
        return view('export.geography')->with([
            'title'=>'Export Geography Master | Salesforce',
            'collection'=>$collection
        ]);
    }
}
