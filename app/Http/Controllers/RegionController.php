<?php

namespace App\Http\Controllers;
use App\Models\LocationRegion;
use App\Models\LocationCountry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use JavaScript;

use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','clearance','master']);
    }
    public function index(){
        $title = 'Regions | '.config('global.app_name');
        $regions = LocationRegion::withCount(['zones','states'])->get();
        foreach($regions as $region){
            $region->country;            
           foreach($region->states as $state){
            $state->areas_count += $state->areas->count();
           $state->lgas_count += $state->lgas->count();
            }  
        }
        $countries = LocationCountry::get();
        JavaScript::put([
            'regionList'=>$regions,
            'countryList'=>$countries
        ]);
        return view('location.region')->with(['title'=>$title,
        'regions'=>$regions
        ]);    
    }
    public function modify(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'selectedCountry'=> 'bail|required',
            'regionName'=> 'required',
            'regionCode'=> 'required'
        ]);
        
        if($validator->fails()){
            return redirect()->route('region.show')
            ->withErrors($validator)
            ->withInput();
        }
        if(Auth::user()->hasPermissionTo('Can change region')){            
        $region = LocationRegion::find($id);
        if(!isset($region)){
            $region = new LocationRegion;
        }
        $region->country_id = $request->selectedCountry;
        $region->name = $request->regionName;
        $region->region_code = $request->regionCode;
        $region->save();
        return redirect()->route('region.show')->with(['actionSuccessMessage'=>'Region was modified successfully']); 
    }
    else{
        return redirect()->route('region.show')->with(['actionWarningMessage'=>'You do not have the authorization or permission for this request']);                                
    }                   
    return redirect()->route('region.show')->with(['actionErrorMessage'=>'Your request could not be completed. Please try again']);                                                                  
    }
    public function destroy($id){
        try{
        if(isset($id)){
        if(Auth::user()->hasPermissionTo('Can delete region')){
            LocationRegion::find($id)->delete();
            return response()->json(array("validations"=>true,"message"=>"Region Item deleted successfully","action"=>true));       
           
        }
        else{
            return response()->json(array("validations"=>true,"message"=>"You do not have the authorization or permission for this request","action"=>false));                                                            
        }
    }else{
        return response()->json(array("validations"=>false,"message"=>"Please provide region to delete","action"=>false));          
    }
        return response()->json(array("validations"=>false,"message"=>"An error occurred. Please contact administrator","action"=>false));  
}
catch(QueryException $e){
    return response()->json(array("validations"=>true,"message"=>"This region cannot be deleted because of associated relations. Remove associations then try again","action"=>false));                                                                            
}
    }

    public function filter($id){
        $title = 'Regions | '.config('global.app_name');
        $regions = LocationRegion::where('id',$id)->withCount(['zones','states'])->get();
        foreach($regions as $region){
            $region->country;            
           foreach($region->states as $state){
            $state->areas_count += $state->areas->count();
           $state->lgas_count += $state->lgas->count();
            }  
        }
        $countries = LocationCountry::get();
        JavaScript::put([
            'regionList'=>$regions,
            'countryList'=>$countries
        ]);
        return view('location.region')->with(['title'=>$title,
        'regions'=>$regions
        ]);   
    }

}
