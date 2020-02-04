<?php
namespace App\Facades;

use App\Models\User;
use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationArea;
use App\Models\LocationTerritory;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LocationFacade
{
    public function allRegions()
    {
        $regions = LocationRegion::all();
        return $regions;
    }
    public function getLocationsForMovement($id)
    {
        $user = User::where('id', $id)->get()[0];
        $collection = collect([]);
        //return regions for rod
        if ($user->hasRole('ROD')) {
            $collection = LocationRegion::all();
        }
        //return zones for ZBM
        elseif ($user->hasRole('ZBM')) {
            $collection = LocationZone::all();
        }
        //return areas for ASM
        elseif ($user->hasRole('ASM')) {
            $collection = LocationArea::all();
        }
        //return territories for MD
        elseif ($user->hasRole('MD')) {
            $collection = LocationTerritory::all();
        }
        return $collection;
    }
    public function getCountryByRegion($id)
    {
        $region = LocationRegion::where('id', $id)->get();
        $collection = collect([]);
        if ($region->count() ==1) {
            $collection = $region[0]->country;
        }
        return $collection;
    }
    //retrieves location by Model and Id
    public function getLocation($locationModel, $locationId)
    {
        return $locationModel::where('id', $locationId)->get()[0];
    }
    public function moveUserToLocation($id, $locationId)
    {
        $user = User::where('id', $id)->get()[0];
        if ($user->hasRole('ROD')) {
            $checkIfRodExistForRegion = RodProfile::where('region_id', $locationId)->get();
            if ($checkIfRodExistForRegion->count() >0) {
                return false;
            } else {
                RodProfile::where('user_id', $id)->update([
                'region_id'=>$locationId
            ]);
                return true;
            }
        } elseif ($user->hasRole('ZBM')) {
            $check = ZbmProfile::where('zone_id', $locationId)->get();
            if ($check->count()>0) {
                return false;
            } else {
                ZbmProfile::where('user_id', $id)->update([
                    'zone_id'=>$locationId
                ]);
                return true;
            }
        } elseif ($user->hasRole('ASM')) {
            $check = AsmProfile::where('area_id', $locationId)->get();
            if ($check->count()>0) {
                return false;
            } else {
                AsmProfile::where('user_id', $id)->update([
                'area_id'=>$locationId,
            ]);
                return true;
            }
        } elseif ($user->hasRole('MD')) {
            $check = MdProfile::where('territory_id', $locationId)->get();
            if ($check->count()>0) {
                return false;
            } else {
                MdProfile::where('user_id', $id)->update([
                    'territory_id'=>$locationId
                ]);
                return true;
            }
        }
    }
    public function userLocation($user_id)
    {
        $user = User::where('id', $user_id)->get()[0];
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $user_id)->get();
            if ($rod->count()>0) {
                return $rod[0]->region;
            } else {
                $dummy["name"] = "N/A";
                $dummy = json_decode(json_encode($dummy));
                return $dummy;
            }
        } elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $user_id)->get();
            if ($zbm->count()>0) {
                return $zbm[0]->zone;
            } else {
                $dummy["name"] = "N/A";
                $dummy = json_decode(json_encode($dummy));
                return $dummy;
            }
        } elseif ($user->hasRole('ASM')) {
            $asm = AsmProfile::where('user_id', $user_id)->get();
            if ($asm->count()>0) {
                return $asm[0]->area;
            } else {
                $dummy["name"] = "N/A";
                $dummy = json_decode(json_encode($dummy));
                return $dummy;
            }
        } elseif ($user->hasRole('MD')) {
            $md = MdProfile::where('user_id', $user_id)->get();
            if ($md->count()>0) {
                return $md[0]->territory;
            } else {
                $dummy["name"] = "N/A";
                $dummy = json_decode(json_encode($dummy));
                return $dummy;
            }
        }
    }
    public function getUpline($id)
    {
        if (Auth::user()->hasRole('ZBM')) {
            $zone = LocationZone::where('id', $id)->get()[0];
            $rod = $zone->rodByLocation;
            if (is_null($rod)) {
                return '{"first_name":"","last_name":"N/A","profile_picture":"avatar.jpg"}';
            } else {
                return $rod->userprofile;
            }
        } elseif (Auth::user()->hasRole('ASM')) {
            $area = LocationArea::where('id', $id)->get()[0];
            return $area->state->zone->zbmByLocation->userprofile;
        } elseif (Auth::user()->hasRole('MD')) {
            $territory = LocationTerritory::where('id', $id)->get()[0];
            $zbm = $territory->lga->area->state->zone->zbmByLocation;
            if (is_null($zbm)) {
                return '{"first_name":"","last_name":"N/A","profile_picture":"avatar.jpg"}';
            } else {
                return $zbm->userprofile;
            }
        }
    }
    public function getUserLocationId($id)
    {
        $role = User::where('id', $id)->get()[0]->roles[0]->name;
        if ($role=="ROD") {
            $rod = RodProfile::where('user_id', $id)->get()[0];
            return $rod->region_id;
        } elseif ($role=='ZBM') {
            $zbm = ZbmProfile::where('user_id', $id)->get()[0];
            return $zbm->zone_id;
        } elseif ($role=='ASM') {
            $asm = AsmProfile::where('user_id', $id)->get()[0];
            return $asm->area_id;
        } elseif ($role=='MD') {
            $md = MdProfile::where('user_id', $id)->get()[0];
            return $md->territory_id;
        }
    }
    public function getUserZone($id)
    {
        $user = User::find($id);
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $id)->get();
            return $rod[0]->region->zones;
        } elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $id)->get();
            return $zbm[0]->zone;
        }
    }

    /**
    * Create a new Auth manager instance.
    *
    * @param  \Illuminate\Foundation\Application  $userId
    * @return void
    */
    public function logWorkHistory($userId, $locationId, $locationModel, $type)
    {
        $dt = Carbon::now();
        $initialStatus =   WorkHistory::where('to_date', 'Till date')->where('user_id', $userId)->get();

        
        if ($initialStatus->count()>0) {
            WorkHistory::where('to_date', 'Till date')->where('user_id', $userId)->update([
                'to_date'=>$dt->toDateString()
            ]);
            //log new entry
            $workHistory = new WorkHistory;
            $workHistory->user_id = $userId;
            $workHistory->type = $type;
            $workHistory->from_id =$initialStatus[0]->destination_id;
            $workHistory->from_model=$initialStatus[0]->destination_model;
            $workHistory->from_date =$dt->toDateString();
            $workHistory->to_date = 'Till date';
            $workHistory->destination_id = $locationId;
            $workHistory->destination_model =$locationModel;
            $workHistory->save();
        } else {
            WorkHistory::where('to_date', 'Till date')->where('user_id', $userId)->update([
                'to_date'=>$dt->toDateString()
            ]);
            $workHistory = new WorkHistory;
            $workHistory->user_id = $userId;
            $workHistory->type = $type;
            $workHistory->to_date = 'Till date';
            $workHistory->destination_id = $locationId;
            $workHistory->destination_model =$locationModel;
            $workHistory->save();
        }
    }
    public function checkUniqueLocationMovement($user_id, $role, $locationId)
    {
        $roleProfile = config('global.models')[$role]::where('user_id', $user_id)->get();
        $result = true;
        if ($roleProfile->count()>0) {
            $column = config('global.location_column')[$role];
            if ($roleProfile[0]->$column==$locationId) {
                $result = false;
            }
        }
        return $result;
    }
}
