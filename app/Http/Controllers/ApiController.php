<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationCountry;
use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationState;
use App\Models\LocationArea;
use App\Models\LocationLga;
use App\Models\LocationSite;
use App\Models\LocationTerritory;
use App\Models\WorkHistory;
use App\Models\User;
use App\Facades\MyFacades\LocationFacade;
use App\Facades\MyFacades\QuickTaskFacade;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use Carbon\Carbon;

class ApiController extends Controller
{
    //
    public function getCountries(Request $request)
    {
        $countries = LocationCountry::select('id', 'name', 'country_code')->get();
        return response()->json(['data'=>$countries,'action'=>true,'count'=>$countries->count()]);
    }
    public function getRegions(Request $request)
    {
        $regions = LocationRegion::select('id', 'name', 'region_code', 'country_id')->get();
        foreach ($regions as $region) {
            $region->country;
        }
        return response()->json(['data'=>$regions,'action'=>true,'count'=>$regions->count()]);
    }
    public function getZones(Request $request)
    {
        $zones = LocationZone::select('id', 'name', 'zone_code', 'region_id')->get();
        foreach ($zones as $zone) {
            $zone->region;
            $zone->states;
        }
        return response()->json(['data'=>$zones,'action'=>true,'count'=>$zones->count()]);
    }
    public function getStates(Request $request)
    {
        $states = LocationState::select('id', 'name', 'state_code', 'zone_id')->get();
        foreach ($states as $state) {
            $state->zone;
        }
        return response()->json(['data'=>$states,'action'=>true,'count'=>$states->count()]);
    }
    public function getAreas(Request $request)
    {
        $areas = LocationArea::select('id', 'name', 'area_code', 'state_id')->get();
        foreach ($areas as $area) {
            $area->state;
        }
        return response()->json(['data'=>$areas,'action'=>true,'count'=>$areas->count()]);
    }
    public function getLgas(Request $request)
    {
        $lgas = LocationLga::select('id', 'name', 'lga_code', 'area_id')->get();
        foreach ($lgas as $lga) {
            $lga->area;
        }
        return response()->json(['data'=>$lgas,'action'=>true,'count'=>$lgas->count()]);
    }
    public function getTerritories(Request $request)
    {
        $territories = LocationTerritory::select('id', 'name', 'territory_code', 'lga_id')->get();
        foreach ($territories as $territory) {
            $territory->lga;
        }
        return response()->json(['data'=>$territories,'action'=>true,'count'=>$territories->count()]);
    }
    public function getSites(Request $request)
    {
        $sites = LocationSite::get();
        foreach ($sites as $site) {
            $territory =  $site->territory;
            $lga = $territory->lga;
            $area = $lga->area;
        }
        return response()->json(['data'=>$sites,'action'=>true,'count'=>$sites->count()]);
    }
    public function custom()
    {
        // $rods = User::role('ROD')->get();
        $abc = bcrypt('kimberly');
        return response()->json($abc);
    }
}
