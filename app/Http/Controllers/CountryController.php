<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationCountry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

use JavaScript;

class CountryController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','clearance','master']);
    }
    public function index(){
        $title = 'Countries | '.config('global.app_name');
        $countries = LocationCountry::withCount(['regions','zones'])->get();
        foreach($countries as $country){
            $country->regions_count;
            $country->zones_count;
            foreach($country->zones as $zone){
                $country->states_count += $zone->states->count();
                $country->areas_count += $zone->areas->count();                
                }        
        }
        JavaScript::put([
            'countryList'=>$countries
        ]);
        return view('location.country')->with(['title'=>$title,
        'countries'=>$countries
        ]);
    }
    public function modify(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'countryName'=> 'bail|required',
            'countryCode'=> 'required'
        ]);
        
        if($validator->fails()){
            return redirect()->route('country.show')
            ->withErrors($validator)
            ->withInput();
        }
        if(Auth::user()->hasPermissionTo('Can change country')){            
        $country = LocationCountry::find($id);
        if(!isset($country)){
            $country = new LocationCountry;
        }
        $country->name = $request->countryName;
        $country->country_code = $request->countryCode;
        $country->save();
        return redirect()->route('country.show')->with(['actionSuccessMessage'=>'Country was modified successfully']); 
    }
    else{
        return redirect()->route('country.show')->with(['actionWarningMessage'=>'You do not have the authorization or permission for this request']);                                
    }                   
    return redirect()->route('country.show')->with(['actionErrorMessage'=>'Your request could not be completed. Please try again']);                                                                  
    }
    public function destroy($id){
        try{
        if(isset($id)){
        if(Auth::user()->hasPermissionTo('Can delete country')){
            
            LocationCountry::find($id)->delete();
            return response()->json(array("validations"=>true,"message"=>"Country Item deleted successfully","action"=>true));       
           
        }
        else{
            return response()->json(array("validations"=>true,"message"=>"You do not have the authorization or permission for this request","action"=>false));                                                            
        }
    }else{
        return response()->json(array("validations"=>false,"message"=>"Please provide country to delete","action"=>false));          
    }
        return response()->json(array("validations"=>false,"message"=>"An error occurred. Please contact administrator","action"=>false));  
}
catch(QueryException $e){
    return response()->json(array("validations"=>true,"message"=>"This country cannot be deleted because of associated relations. Remove associations then try again","action"=>false));                                                                            
}
    }

        public function filter($id){
            $title = 'Countries | '.config('global.app_name');
            $countries = LocationCountry::where('id',$id)->withCount(['regions','zones'])->get();
            foreach($countries as $country){
                $country->regions_count;
                $country->zones_count;
                foreach($country->zones as $zone){
                    $country->states_count = $zone->states->count();
                    $country->areas_count += $zone->areas->count();                
                    }        
            }
            JavaScript::put([
                'countryList'=>$countries
            ]);
            return view('location.country')->with(['title'=>$title,
            'countries'=>$countries
            ]);
        }
}
