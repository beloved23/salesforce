<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationSite;
use App\Models\LocationTerritory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utilities\UtilityController;
use Illuminate\Support\Facades\Auth;


use JavaScript;

class SiteController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','clearance','master']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = LocationSite::get();
        foreach($sites as $site){
          $territory =  $site->territory;
          $lga = $territory->lga;
          $area = $lga->area;          
        }
        $title = "Sites | ".config('global.app_name');
        $territories = LocationTerritory::get();
        JavaScript::put(['siteList'=>$sites,
        'territoryList' =>$territories
        ]);
        return view('location.showsite')->with(['sites'=>$sites,'title'=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Site | '.config('global.app_name');
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
        $territories = LocationTerritory::select('id','name','territory_code','lga_id')->get();
        foreach($territories as $territory){
            $territory->lga;
        }

        JavaScript::put([
            'siteCount'=>$siteCount,
            'siteTimestamp' =>$siteTimestamp,
            'territoryList'=>$territories
        ]);
        return view('location.site')->with(['title'=>$title]);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'siteClassification'=> 'required|bail',
            'selectedTerritory'=> 'required',
            'siteId' =>'required',
            'siteCode'=>'required',
            'townName'=> 'required',
            'siteClassCode'=>'required',
            'siteAddress'=>'required'
        ]);

        if($validator->fails()){
            return redirect('site/create')
            ->withErrors($validator)
            ->withInput();
        }
        $model = new LocationSite;
        $utility = new UtilityController();  
        return $utility->saveSiteLocationItem($model,$request);                                 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
   
    }
      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function modify(Request $request,$id)
     {
        $validator = Validator::make($request->all(),[
            'siteClassification'=> 'required|bail',
            'selectedTerritory'=> 'required',
            'siteId' =>'required',
            'siteCode'=>'required',
            'townName'=> 'required',
            'siteClassCode'=>'required',
            'siteAddress'=>'required'
        ]);

        if($validator->fails()){
            return redirect('site/index')
            ->withErrors($validator)
            ->withInput();
        }

        $site = LocationSite::find($id);
        if(Auth::user()->hasPermissionTo('Can change site')){
            if(!isset($site)){
                $site = new LocationSite;
            }
            $site->site_id = $request->siteId;
            $site->address = $request->siteAddress;
            $site->town_name = $request->townName;
            $site->site_code = $request->siteCode;
            if(isset($request->siteStatus)){
                if($request->siteStatus=="1"){
                    $site->is_active = true;
                }
                else{
                    $site->is_active = false;                        
                }
            }
            $site->territory_id = $request->selectedTerritory; 
            $site->class_code = $request->siteClassCode;
            $site->latitude = $request->siteLatitude;
            $site->longitude = $request->siteLongitude;       
            $site->classification = $request->siteClassification;
            $site->category = $request->siteCategory;
            $site->type = $request->siteType;
            $site->category_code = $request->siteCategoryCode;
            $site->hubcode = $request->siteHubCode;
            $site->commercial_classification = $request->siteCommercialClassification;
            $site->bsc_code = $request->siteBscCode;
            $site->bsc_name = $request->siteBscName;
            $site->bsc_rnc = $request->siteBscRnc;
            $site->bts_type = $request->siteBtsType;
            $site->cell_code = $request->siteCellCode;
            $site->cell_id = $request->siteCellId;
            $site->cgi = $request->siteCgi;
            $site->city =  $request->siteCity;
            $site->ci = $request->siteCi;
            $site->city_code = $request->siteCityCode;
            $site->comment = $request->siteComment;
            $site->corresponding_network  = $request->siteCorrespondingNetwork;
            $site->coverage_area = $request->siteCoverageArea;
            $site->lac = $request->siteLac;
            $site->msc_name = $request->siteMscName;
            $site->msc_code = $request->siteMscCode;
            $site->mss = $request->siteMss;
            $site->network_code = $request->siteNetworkCode;
            $site->new_mss_pool = $request->siteNewMssPool;
            $site->om_classification = $request->siteOmClassification;
            $site->vendor = $request->siteVendor;
            $site->new_zone  = $request->siteNewZone;
            $site->new_region = $request->siteNewRegion;
            $site->operational_date = $request->siteOperationalDate;
            $site->location_information = $request->siteLocationInfo;
            $site->save();
            return redirect()->route('site.index')->with(['actionSuccessMessage'=>'Site was modified successfully']);            
        }
        else{
            return redirect()->route('site.index')->with(['actionWarningMessage'=>'You do not have the authorization or permission for this request']);                        
        }
        return redirect()->route('site.index')->with(['actionErrorMessage'=>'Your request could not be completed. Please try again']);                                                              
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id)){
            if(Auth::user()->hasPermissionTo('Can delete site')){
                LocationSite::find($id)->delete();
                return response()->json(array("validations"=>true,"message"=>"Site Item deleted successfully","action"=>true));             
            }
            else{
                return response()->json(array("validations"=>true,"message"=>"You do not have the authorization or permission for this request","action"=>false));                                                            
            }
        }
        else{
            return response()->json(array("validations"=>true,"message"=>"Please provide site to delete","action"=>false));                                                                        
        }
       
        return response()->json(array("validations"=>false,"message"=>"An error occurred. Please contact administrator","action"=>false));                                                        
    }
}
