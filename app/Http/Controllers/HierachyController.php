<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use JavaScript;
use Illuminate\Database\QueryException;

class HierachyController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','master','clearance']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Hierachy | ".config('global.app_name');;
        $rodCount = RodProfile::get()->count();
        $zbmCount = RodProfile::get()->count();
        $asmCount = AsmProfile::get()->count();
        $mdCount= MdProfile::get()->count();
        JavaScript::put([
        'rodCount' =>$rodCount,
        'zbmCount'=>$zbmCount,
        'asmCount'=>$asmCount,
        'mdCount'=>$mdCount
        ]);
        return view('hierachy.index')->with(['title'=>$title,
        
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
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
    public function update(Request $request, $id)
    {
        try{
        if(isset($request->users) && isset($request->action)){
            
                        $users = json_decode($request->users);
                        $action = urldecode($request->action);
                        //Define ROD relationship
                        if($action=="ROD"){
                            //assign users array
                            if(isset($request->regionId)){
                               foreach($users as $user){
                                   $rodProfile = RodProfile::where('auuid',$user)->delete();
                                    $rodProfile = new RodProfile;
                                    $rodProfile->auuid = $user;
                                    $rodProfile->region_id = $request->regionId;
                                    $rodProfile->save();
                                    $count = RodProfile::get()->count();
                               }
                            }
                        }
                        //Define ZBM relationship
                        else if($action=="ZBM"){
                            //assign users array
                            if(isset($request->zoneId) && isset($request->selectedRod)){
                               foreach($users as $user){
                                   $zbmProfile = ZbmProfile::where('auuid',$user)->delete();
                                    $zbmProfile = new ZbmProfile;
                                    $zbmProfile->auuid = $user;
                                    $zbmProfile->zone_id = $request->zoneId;
                                    $zbmProfile->rod_auuid = $request->selectedRod;
                                    $zbmProfile->save();
                                    $count = ZbmProfile::get()->count();
                               }
                            }
                            else{
                                return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please provide zone id and selected rod "));                                                                
                            }
                        }
                        //Define ASM relationship
                        else if($action=="ASM"){
                            //assign users array
                            if(isset($request->stateId) && isset($request->selectedZbm) && isset($request->areaId)){
                               foreach($users as $user){
                                   $asmProfile = AsmProfile::where('auuid',$user)->delete();
                                    $asmProfile = new AsmProfile;
                                    $asmProfile->auuid = $user;
                                    $asmProfile->area_id = $request->areaId;
                                    $asmProfile->state_id = $request->stateId;
                                    $asmProfile->zbm_auuid = $request->selectedZbm;
                                    $asmProfile->save();
                                    $count = AsmProfile::get()->count();
                               }
                            }
                            else{
                                return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please provide state, area and zbm "));                                                                
                            }
                        }
                          //Define MD relationship
                          else if($action=="MD"){
                            //assign users array
                            if(isset($request->selectedAsm) && isset($request->selectedTerritory)){
                               foreach($users as $user){
                                   $mdProfile = MdProfile::where('auuid',$user)->delete();
                                    $mdProfile = new MdProfile;
                                    $mdProfile->auuid = $user;
                                    $mdProfile->territory_id = $request->selectedTerritory;
                                    $mdProfile->asm_auuid = $request->selectedAsm;
                                    $mdProfile->save();
                                    $count = MdProfile::get()->count();
                               }
                            }
                            else{
                                return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please provide state, area and zbm "));                                                                
                            }
                        }
                        //define other relationship requests
                        else{
            
                        }
                        //defaults count to zero
                        if(!isset($count)){
                            $count = 0;
                        }
                        return response()->json(array("validations"=>true,"action"=>true,"count"=>$count,"message"=>"Hierachy Relationship successfully defined "));     
                    }
                    else{
                        return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a user and an action to perform"));            
                    }
                    return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please provide atleast a user"));  
                }
                catch(QueryException $e){
                    return response()->json(array("validations"=>false,"action"=>false,"message"=>json_encode($e)));                                
                }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
