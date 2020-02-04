<?php

namespace App\Http\Controllers;

use App\Models\LocationCountry;
use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationState;
use App\Models\LocationArea;
use App\Models\LocationLga;
use App\Models\LocationTerritory;
use App\Models\LocationSite;
use Carbon\Carbon;
use JavaScript;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utilities\UtilityController;


use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth','clearance','master']);
    } 
    public function index(){
        $title = "Locations | ".config('global.app_name');
        $countryCount = LocationCountry::get()->count();
        $country = LocationCountry::latest('updated_at')->first();
        if($country){
            $dt = new Carbon($country->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $countryTimestamp = $result;
        }
        else{
            $countryTimestamp = "None";
        }

        $regionCount = LocationRegion::get()->count();
        $region = LocationRegion::latest('updated_at')->first();
        if($region){
            $dt = new Carbon($region->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $regionTimestamp = $result;
        }
        else{
            $regionTimestamp = "None";
        }

        $zoneCount = LocationZone::get()->count();
        $zone = LocationZone::latest('updated_at')->first();
        if($zone){
            $dt = new Carbon($zone->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $zoneTimestamp = $result;
        }
        else{
            $zoneTimestamp = "None";
        }

        $stateCount = LocationState::get()->count();
        $state = LocationState::latest('updated_at')->first();
        if($state){
            $dt = new Carbon($state->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $stateTimestamp = $result;
        }
        else{
            $stateTimestamp = "None";
        }

        $areaCount = LocationArea::get()->count();
        $area = LocationArea::latest('updated_at')->first();
        if($area){
            $dt = new Carbon($area->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $areaTimestamp = $result;
        }
        else{
            $areaTimestamp = "None";
        }

        $lgaCount = LocationLga::get()->count();
        $lga = LocationLga::latest('updated_at')->first();
        if($lga){
            $dt = new Carbon($lga->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $lgaTimestamp = $result;
        }
        else{
            $lgaTimestamp = "None";
        }

        $territoryList = LocationTerritory::get();
        $territoryCount = $territoryList->count();       
        $territory = LocationTerritory::latest('updated_at')->first();
        if($territory){
            $dt = new Carbon($territory->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $territoryTimestamp = $result;
        }
        else{
            $territoryTimestamp = "None";
        }

        JavaScript::put(['countryCount'=>$countryCount,
        'regionCount'=>$regionCount,
        'zoneCount'=>$zoneCount,
        'stateCount'=>$stateCount,
        'areaCount'=>$areaCount,
        'lgaCount'=>$lgaCount,
        'territoryCount'=>$territoryCount,
        'countryTimestamp' => $countryTimestamp,
        'regionTimestamp' => $regionTimestamp, 
        'zoneTimestamp' => $zoneTimestamp,         
        'stateTimestamp' => $stateTimestamp,        
        'lgaTimestamp' => $lgaTimestamp,        
        'territoryTimestamp' => $territoryTimestamp,        
        'areaTimestamp' => $areaTimestamp,
        ]);

        return view('location.index')->with(['title'=>$title
        ]);
    }
    public function store(Request $request){
        if(isset($request->action)){
            $action = urldecode($request->action);
            //Perform for country
            if($action=="CO"){
                $model = new LocationCountry;
                   //global utility helper
                $utility = new UtilityController();  
               return $utility->saveCountryLocationItem($request->name,$request->code,$model);
            }
            //Perform for Region
            else if($action=="RE"){
                $model = new LocationRegion;
                $utility = new UtilityController();                  
                return $utility->saveLocationItem($model,$request->code,
                "region_code",$request->name,"country_id",$request->countryId,
                "Can add region","region","country");                 
            }
            //Perform for Zone
            else if($action=="ZO"){
                $model = new LocationZone;
                $utility = new UtilityController();                  
                return $utility->saveLocationItem($model,$request->code,
                "zone_code",$request->name,"region_id",$request->regionId,
                "Can add zone","zone","region");                 
            }
             //Perform for State
             else if($action=="ST"){
                $model = new LocationState;
                $utility = new UtilityController();                  
                return $utility->saveLocationItem($model,$request->code,
                "state_code",$request->name,"zone_id",$request->zoneId,
                "Can add state","state","zone");                 
            }
              //Perform for Area
              else if($action=="AR"){
                $model = new LocationArea;
                $utility = new UtilityController();                  
                return $utility->saveLocationItem($model,$request->code,"area_code",$request->name,"state_id",$request->stateId,"Can add area","area","state");                 
            }
               //Perform for LGA
               else if($action=="LG"){
                $model = new LocationLga;
                $utility = new UtilityController();                  
                return $utility->saveLocationItem($model,$request->code,"lga_code",$request->name,"area_id",$request->areaId,"Can add lga","lga","area");                 
            }
            //Perform for Territory
            else if($action=="TE"){
                $model = new LocationTerritory;
                $utility = new UtilityController();                  
                return $utility->saveLocationItem($model,$request->code,"territory_code",$request->name,"lga_id",$request->lgaId,"Can add territory","territory","lga");                 
            }
            //No action type recognized
            else{
                return response()->json(array("validations"=>false,"message"=>"An error occurred. Unrecognized action type","action"=>false));                            
            }
        }
        else{
            return response()->json(array("validations"=>false,"message"=>"Please specify action to perform","action"=>false));                        
        }
        return response()->json(array("validations"=>false,"message"=>"An error occurred while processing this request","action"=>false));            
    }
    public function create(){
        $title = 'Site | '.config('global.app_name');
        $siteCount = LocationSite::get()->count();
        $site = LocationSite::latest('updated_at')->first();
        if($site){
            $dt = new Carbon($site->updated_at);
            $result = $dt->format('F j\\,  Y h:i A');
            $siteTimestamp = $result;
        }
        else{
            $siteTimestamp = "None";
        }
        JavaScript::put([
            'siteCount'=>$siteCount,
            'siteTimestamp' =>$siteTimestamp
        ]);
        return view('location.site')->with(['title'=>$title]);
    }
    public function country(){

    }
}
