<?php

namespace App\Http\Controllers;

use App\Models\LocationTerritory;
use Illuminate\Http\Request;
use App\Models\MdProfile;
use App\Models\User;

class TerritoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index(Request $request)
    {
        $title = 'Territories | '.config('global.app_name');
        $collection = LocationTerritory::all();
        return view('location.territory.index')->with(
            [
            'title'=>$title,
            'territories'=>$collection
            ]
        );
    }
    public function edit($id)
    {
        if (LocationTerritory::find($id)->exists()) {
            $territory = LocationTerritory::find($id);
            //set empty variables
            $lga = '';
            $region = '';
            $zone = '';
            $country = '';
            //get lga
            if ($territory->lga()->exists()) {
                $item = $territory->lga()->get()[0];
                if ($item->area()->exists()) {
                    $itemArea = $item->area()->get()[0];
                    if ($itemArea->state()->exists()) {
                        $itemState = $itemArea->state()->get()[0];
                        if ($itemState->zone()->exists()) {
                            $itemZone = $itemState->zone()->get()[0];
                            $zone = $itemZone->name;
                            if($itemZone->region()->exists()) {
                                $itemRegion = $itemZone->region()->get()[0];
                                $region = $itemRegion->name;
                                if($itemRegion->country()->exists()) {
                                    $country = $itemRegion->country()->get()[0]->name;
                                }
                            }
                        }
                    }
                }
                $lga = $item->name;
            }

            $title = $territory->name.' | '.config('global.app_name');
            $mds = MdProfile::all();
            $profiles = [];
            //get vacant mds
            foreach($mds as $md){
                if(!$md->territory()->exists())
                {
                    $profiles[] = $md;
                }
            }
            return view('location.territory.show')->with(
                [
                'title'=>$title,
                'territory'=>$territory,
                'lga'=>$lga,
                'zone'=>$zone,
                'region'=>$region,
                'country'=>$country,
                'siteCount'=>$territory->sites()->count(),
                'profiles'=>$profiles
                ]
            );
        } else {
            return redirect()->route('territory.index')->with(
                [
                'actionError'=>'Specified territory could not be found'
                ]
        );
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'code'=>'required',
            'selected_md'=>'required|numeric'
        ]);
        $territory = LocationTerritory::find($id);
        $territory->name = $request->name;
        $territory->territory_code = $request->code;
        $user = User::find($request->selected_md);
        $territory->save();
        $territory->mdByLocation()->update(
            [
            'user_id'=>$user->id
            ]
        );
        return redirect()->route('territory.index')->with([
            'actionSuccessMessage'=>'Territory modified successfully'
        ]) ;
    }
    public function destroy($id)
    {
       LocationTerritory::with(['sites','mdByLocation'])->find($id)->delete();
       return redirect()->route('territory.index')->with([
        'actionSuccessMessage'=>'Territory deleted successfully'
    ]) ;
    }
}
