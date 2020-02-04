<?php

namespace App\Http\Controllers;
use App\Models\LocationZone;
use App\Models\LocationRegion;
use App\Models\LocationCountry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\QueryException;

use JavaScript;

use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index(){
        $title = 'Zones | '.config('global.app_name');
        $zones = LocationZone::withCount(['states','areas'])->get();
        foreach($zones as $zone){
            $region = $zone->region;
            $region->country;
            $zone->country;
            $zone->region;
           foreach($zone->areas as $area){
            $area->lgas_count += $area->lgas->count();
           $area->territories_count += $area->territories->count();
        //   
      }  
    }
        $countries = LocationCountry::get();
        $regions = LocationRegion::get();

        JavaScript::put([
            'zoneList'=>$zones,
            'regionList'=>$regions,
            'countryList'=>$countries
        ]);
        return view('location.zone')->with(['title'=>$title,
        'zones'=>$zones
        ]); 
    }
    public function modify(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'selectedRegion'=> 'required',
            'zoneCode'=> 'required',
            'zoneName' => 'required'
        ]);
        
        if($validator->fails()){
            return redirect()->route('zone.show')
            ->withErrors($validator)
            ->withInput();
        }
        if(Auth::user()->hasPermissionTo('Can change zone')){            
        $zone = LocationZone::find($id);
        if(!isset($zone)){
            $zone = new LocationZone;
        }
        $zone->region_id = $request->selectedRegion;
        $zone->name = $request->zoneName;
        $zone->zone_code = $request->zoneCode;
        $zone->save();
        return redirect()->route('zone.show')->with(['actionSuccessMessage'=>'Zone was modified successfully']); 
    }
    else{
        return redirect()->route('zone.show')->with(['actionWarningMessage'=>'You do not have the authorization or permission for this request']);                                
    }                   
    return redirect()->route('zone.show')->with(['actionErrorMessage'=>'Your request could not be completed. Please try again']);                                                                  
    }
    public function destroy($id){
        try{
        if(isset($id)){
        if(Auth::user()->hasPermissionTo('Can delete zone')){
            LocationZone::find($id)->delete();
            return response()->json(array("validations"=>true,"message"=>"Zone Item deleted successfully","action"=>true));       
           
        }
        else{
            return response()->json(array("validations"=>true,"message"=>"You do not have the authorization or permission for this request","action"=>false));                                                            
        }
    }else{
        return response()->json(array("validations"=>false,"message"=>"Please provide zone to delete","action"=>false));          
    }
        return response()->json(array("validations"=>false,"message"=>"An error occurred. Please contact administrator","action"=>false));  
}
catch(QueryException $e){
    return response()->json(array("validations"=>true,"message"=>"This zone cannot be deleted because of associated relations. Remove associations then try again","action"=>false));                                                                            
}
    }
}
