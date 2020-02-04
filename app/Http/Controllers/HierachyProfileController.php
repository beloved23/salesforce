<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationRegion;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use App\Facades\MyFacades\QuickTaskFacade;

class HierachyProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function rod(Request $request)
    {
        //customize title based on role
        if (Auth::user()->hasRole('HR')) {
            $title = 'ZBM List | '.env('app_name');
        } else {
            $title = 'My ZBM | '.env('app_name');
        }
        $collection = collect([]);
        //Define actions for an authenticated ROD user
        if (Auth::user()->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $request->user()->id)->get();
            $collection = $rod[0]->region->zbms;
        } elseif (Auth::user()->hasRole('ASM')) {
            $asm = AsmProfile::where('user_id', $request->user()->id)->get()[0];
            $zbm = $asm->state->zone->zbmByLocation;
            if (!is_null($zbm)) {
                $collection[] = $zbm;
            }
        } elseif (Auth::user()->hasRole('MD')) {
            $md = MdProfile::where('user_id', $request->user()->id)->get()[0];
            $zbm = $md->territory->lga->area->state->zone->zbmByLocation;
            if (!is_null($zbm)) {
                $collection[] = $zbm;
            }
        } elseif (Auth::user()->hasRole('HR')) {
            $collection = ZbmProfile::all();
            $title = 'ZBM List | '.env('app_name');
        }
        return view('hierachyprofiles.zbm')->with([
            'title'=>$title,
            'data'=>$collection,
        ]);
    }
    public function zbm(Request $request)
    {
        //customize title based on role
        if (Auth::user()->hasRole('HR')) {
            $title = 'ASM List | '.env('app_name');
        } else {
            $title = 'My ASM | '.env('app_name');
        }
        //Define actions for an authenticated ROD user
        if (Auth::user()->hasRole('ROD')) {
            $collection = QuickTaskFacade::getUserAsm($request->user()->id);
            // $rod = RodProfile::where('user_id', $request->user()->id)->get();
            // foreach ($rod[0]->region->zones as $zone) {
            //     $collection = $collection->concat($zone->asms);
            // }
        }
        //Define actions for an authenticated ZBM user
        elseif (Auth::user()->hasRole('ZBM')) {
            $collection = QuickTaskFacade::getUserAsm($request->user()->id);
            // $zbm = ZbmProfile::where('user_id', $request->user()->id)->get();
            // $collection = $zbm[0]->zone->asms;
        }
        //Define actions for an authenticated MD user
        elseif (Auth::user()->hasRole('MD')) {
            $collection = QuickTaskFacade::getUserAsm($request->user()->id);
            // $md = MdProfile::where('user_id', $request->user()->id)->get()[0];
            // $collection[] = $md->territory->lga->area->state->asm;
        }
        //Define actions for an authenticated HR user
        elseif (Auth::user()->hasRole('HR')) {
            $collection = AsmProfile::all();
        }

        return view('hierachyprofiles.asm')->with([
            'title'=>$title,
            'data'=>$collection
        ]);
    }
    public function asm(Request $request)
    {
        //customize title
        if (Auth::user()->hasRole('HR')) {
            $title = 'MD List | '.env('app_name');
        } else {
            $title = 'My MD | '.env('app_name');
        }
        $collection = collect([]);
        //Define actions for an authentication ROD user
        if (Auth::user()->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $request->user()->id)->get();
            foreach ($rod[0]->region->zones as $zone) {
                foreach ($zone->areas as $area) {
                    foreach ($area->territories as $territory) {
                        $collection = $collection->concat($territory->mds);
                    }
                }
            }
        }
        //actions for ZBM user
        elseif (Auth::user()->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $request->user()->id)->get();
            foreach ($zbm[0]->zone->areas as $area) {
                foreach ($area->territories as $territory) {
                    $collection = $collection->concat($territory->mds);
                }
            }
        }
        //actions for ASM user
        elseif (Auth::user()->hasRole('ASM')) {
            $zbm = AsmProfile::where('user_id', $request->user()->id)->get();
            foreach ($zbm[0]->area->territories as $territory) {
                $collection = $collection->concat($territory->mds);
            }
        }
        //actions for MD user
        elseif (Auth::user()->hasRole('MD')) {
            $zbm = MdProfile::where('user_id', $request->user()->id)->with(['area'])->get();
            foreach ($zbm[0]->area->territories as $territory) {
                $collection = $collection->concat($territory->mds);
            }
        }
        //actions for HR user
        elseif (Auth::user()->hasRole('HR')) {
            $collection = MdProfile::all();
        }
    

        return view('hierachyprofiles.md')->with([
            'title'=>$title,
            'data'=>$collection
        ]);
    }

    public function territories(Request $request)
    {
        $title = 'My Territories | '.env('app_name');
        $collection = collect([]);
        //Define actions for an authentication ROD user
        if (Auth::user()->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $request->user()->id)->with(['region'])->get();
            foreach ($rod[0]->region->zones as $zone) {
                foreach ($zone->areas as $area) {
                    $collection = $collection->concat($area->territories);
                }
            }
        }
        //actions for ZBM user
        elseif (Auth::user()->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $request->user()->id)->with(['zone'])->get();
            foreach ($zbm[0]->zone->areas as $area) {
                $collection = $collection->concat($area->territories);
            }
        }
        //actions for ASM user
        elseif (Auth::user()->hasRole('ASM')) {
            $zbm = AsmProfile::where('user_id', $request->user()->id)->with(['area'])->get();
            $collection = $zbm[0]->area->territories;
        }
        //actions for MD user
        elseif (Auth::user()->hasRole('MD')) {
            $md = MdProfile::where('user_id', $request->user()->id)->get();
            $item[]  = $md[0]->territory;
            $collection = $collection->concat($item);
        }
        return view('hierachyprofiles.territories')->with([
            'title'=>$title,
            'data'=>$collection
        ]);
    }
    public function sites(Request $request)
    {
        $title= "My Sites | ".env('app_name');
        $collection = collect([]);
        //Define actions for an authentication ROD user
        if (Auth::user()->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $request->user()->id)->get();
            foreach ($rod[0]->region->zones as $zone) {
                foreach ($zone->areas as $area) {
                    foreach ($area->territories as $territory) {
                        $collection = $collection->concat($territory->sites);
                    }
                }
            }
        }
        //actions for ZBM user
        elseif (Auth::user()->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $request->user()->id)->get();
            foreach ($zbm[0]->zone->areas as $area) {
                foreach ($area->territories as $territory) {
                    $collection = $collection->concat($territory->sites);
                }
            }
        }
        //actions for ASM user
        elseif (Auth::user()->hasRole('ASM')) {
            $zbm = AsmProfile::where('user_id', $request->user()->id)->get();
            foreach ($zbm[0]->area->territories as $territory) {
                $collection = $collection->concat($territory->sites);
            }
        }
        //actions for MD user
        elseif (Auth::user()->hasRole('MD')) {
            $md = MdProfile::where('user_id', $request->user()->id)->get();
            $collection = $collection->concat($md[0]->territory->sites);
        }
        return view('hierachyprofiles.sites')->with([
            'title'=>$title,
            'data'=>$collection
        ]);
    }

    public function md(Request $request)
    {
        return redirect()->route('hierachy.downlines.territories');
    }

    public function hr(Request $request)
    {
        if (Auth::user()->hasRole('HR')) {
            $collection = RodProfile::all();
            $title = 'ROD List | '.config('global.app_name');
        } else {
            $title = 'My ROD | '.config('global.app_name');
        }
        if (Auth::user()->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $request->user()->id)->with(['zone'])->get()[0];
            $rod = $zbm->zone->rodByLocation;
            if (is_null($rod)) {
                $collection = collect([]);
            } else {
                $collection[] = $rod;
            }
        } elseif (Auth::user()->hasRole('ASM')) {
            $asm = AsmProfile::where('user_id', $request->user()->id)->with(['state'])->get()[0];
            $rod = $asm->state->zone->region->rodByLocation;
            if (is_null($rod)) {
                $collection = collect([]);
            } else {
                $collection[] = $rod;
            }
        } elseif (Auth::user()->hasRole('MD')) {
            $md = MdProfile::where('user_id', $request->user()->id)->with(['territory'])->get()[0];
            $rod = $md->territory->lga->area->state->zone->rodByLocation;
            if (is_null($rod)) {
                $collection = collect([]);
            } else {
                $collection[] = $rod;
            }
        }
        return view('hierachyprofiles.rod')->with([
                    'title' =>$title,
                    'data' =>$collection
                    ]);
    }
    public function hq(Request $request)
    {
        $title = 'HQ List | '.config('global.app_name');
        $collection = User::role('HQ')->get();
        return view('hierachyprofiles.hq')->with([
                'title'=>$title,
                'data'=>$collection
             ]);
    }
}
