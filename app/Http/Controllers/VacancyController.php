<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\MyFacades\VacancyFacade;
use App\Models\Vacancy;
use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationArea;
use App\Models\LocationTerritory;
use App\Events\RecruitByAgency;
use Log;

class VacancyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index(Request $request)
    {
        $title = 'Vancancies | '.config('global.app_name');
        $collection = Vacancy::where('pending_recruit',false)->paginate(100);
        if($request->has('location')){
            $models = config('global.location_models');
            if (array_key_exists($request->location, $models)) {
                $collection = Vacancy::where('pending_recruit', false)
            ->where('location_model', $models[$request->location])->paginate(100);
            }
        }
        return view('vacancies.index')->with([
            'title'=>$title,
            'vacancies'=>$collection
        ]);
    }
    public function sync()
    {
        VacancyFacade::sync();
        return redirect()->route('vacancies.index');
    }
    public function location(Request $request)
    {
        $vacancy = collect([]);
        $role = $request->role;
        if ($role=='ROD') {
            //check all regions
            $regions = LocationRegion::all();
            foreach ($regions as $region) {
                if (is_null($region->rodByLocation)) {
                    $vacancy[] = $region;
                }
            }
        } elseif ($role=="ZBM") {
            //check all zones
            $zones = LocationZone::all();
            foreach ($zones as $zone) {
                if (is_null($zone->zbmByLocation)) {
                    $vacancy[] = $zone;
                }
            }
        } elseif ($role=="ASM") {
            //check all areas
            $areas = LocationArea::all();
            foreach ($areas as $area) {
                if (is_null($area->asmByLocation)) {
                    $vacancy[] = $area;
                }
            }
        } elseif ($role=="MD") {
            // check all territories
            $territories = LocationTerritory::all();
            $territoriesCount  =0;
            foreach ($territories as $territory) {
                if (is_null($territory->mdByLocation)) {
                    $vacancy[] = $territory;
                }
            }
        }
        return response()->json($vacancy);
    }
    public function report(Request $request, $userId)
    {
        return view('vacancies.report')->with([
            'title' => 'Vancancy Report | '.config('global.app_name'),
            'vacancies'=> VacancyFacade::report($userId)
        ]);
    }
    public function recruit(Request $request)
    {
        if ($request->has('vacancies')) {
            $vacancies = json_decode($request->vacancies);
            // //deliver email to Agency
            event(new RecruitByAgency($vacancies));
            
            Vacancy::whereIn('id', $vacancies)->update([
                'pending_recruit'=>true
            ]);
            return response()->json(array('message'=>'Recruitment agency notified successfully','action'=>true));
        } else {
            return response()->json(array('action'=>false,'message'=>'Please select atleast a vacant position'));
        }
    }
}
