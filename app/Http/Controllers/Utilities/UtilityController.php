<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Support\Facades\Auth;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use JavaScript;
use Illuminate\Support\Facades\Mail;
use App\Mail\TargetAssigned;
use App\Models\RoleMovement;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\RoleMovementMail;
use App\Mail\RoleMovementApproval;
use Illuminate\Http\Request;
use App\Models\User;
use App\Facades\MyFacades\QuickTaskFacade;

class UtilityController
{
    //for saving location e.g region, zone etc.
    public function saveLocationItem($model, $valueName, $keyCode, $valueCode, $keyId, $valueId, $permissionName, $itemName, $itemParentName)
    {
        if (isset($valueName) && isset($keyCode)) {
            $checkItem = $model::where('name', $valueName)->orWhere($keyCode, $valueCode)->count();
            if ($checkItem==0) {
                if (Auth::user()->hasPermissionTo($permissionName) || Auth::user()->hasRole('GeoMarketing')) {
                    $item = new $model;
                    $item->name = $valueName;
                    $item->$keyCode = $valueCode;
                    $item->$keyId = $valueId;
                    $item->save();
                    $itemCount = $model::get()->count();
                    return response()->json(array("validations"=>true,"count"=>$itemCount,"message"=>$itemName." Item saved successfully","action"=>true));
                } else {
                    return response()->json(array("validations"=>true,"message"=>"You do not have the permission to execute this request","action"=>false));
                }
            } else {
                return response()->json(array("validations"=>true,"message"=>"".$itemName." item with this name or code already exist","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"An error occurred. Please provide ".$itemName." name, ".$itemName." code and ".$itemParentName." code","action"=>false));
        }
    }
    //for saving only country location
    public function saveCountryLocationItem($name, $code, $model)
    {
        if (isset($name) && isset($code)) {
            $country = $model::where('name', $name)->orWhere('country_code', $code)->count();
            if ($country==0) {
                if (Auth::user()->hasPermissionTo('Can add country') || Auth::user()->hasRole('GeoMarketing')) {
                    $country = new $model;
                    $country->name = $name;
                    $country->country_code = $code;
                    $country->save();
                    $countryCount = $model::get()->count();
                    return response()->json(array("validations"=>true,"count"=>$countryCount,"message"=>"Country Item saved successfully","action"=>true));
                } else {
                    return response()->json(array("validations"=>true,"message"=>"You do not have the permission to execute this request","action"=>false));
                }
            } else {
                return response()->json(array("validations"=>true,"message"=>"A country item with this name or code already exist","action"=>false));
            }
        } else {
            return response()->json(array("validations"=>false,"message"=>"An error occurred. Please provide country name and country code","action"=>false));
        }
    }
    //for saving only site location
    public function saveSiteLocationItem($model, $request)
    {
        $checkSite = $model::where('site_id', $request->siteId)->orWhere('site_code', $request->siteCode)->count();
        if ($checkSite==0) {
            if (Auth::user()->hasPermissionTo('Can add site') || Auth::user()->hasRole('GeoMarketing')) {
                $site = new $model;
                $site->site_id = $request->siteId;
                $site->address = $request->siteAddress;
                $site->town_name = $request->townName;
                $site->site_code = $request->siteCode;
                if (isset($request->siteStatus)) {
                    if ($request->siteStatus=="1") {
                        $site->is_active = true;
                    } else {
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
                return redirect()->route('site.create')->with(['actionSuccessMessage'=>"Site Item saved successfully"]);
            } else {
                return redirect()->route('site.create')->with(['actionSuccessMessage'=>'You do not have the permission to execute this request']);
            }
        } else {
            return redirect()->route('site.create')->with(['actionWarningMessage'=>'A site item with this id or code already exist']);
        }
    }
    public function PrepareDashboardForRod($totalZbm, $totalAsm, $totalMd)
    {
        
        //If User is an ROD
        if (Auth::user()->hasRole('ROD')) {
            //Get all Hierachy Relationships
            $rod = RodProfile::where('auuid', Auth::user()->id)->withCount(['zbms'])->get();
            foreach ($rod[0]->zbms as $zbm) {
                $zbm->asms_count += $zbm->asms->count();
                foreach ($zbm->asms as $asm) {
                    $zbm->mds_count += $asm->mds->count();
                }
            }
            $totalZbmPercentage  = round(($rod[0]->zbms_count/$totalZbm)*100);
            $totalAsmPercentage = round(($rod[0]->zbms[0]->asms_count/$totalAsm)*100);
            $totalMdPercentage = round(($rod[0]->zbms[0]->mds_count/$totalMd)*100);
            JavaScript::put([
                'totalZbm' => $totalZbm,
                'totalAsm' =>$totalAsm,
                'totalMd' =>$totalMd,
                'rod' =>$rod,
                'profile'=>'ROD'
                ]);
        }
        //End ROD
    }
    public function deliverEmailsForRoleMovementToHr($roleMovementItem)
    {
        $allHR = Role::where('name', 'hr')->with('users')->get()[0]->users;
        Mail::to($allHR)->queue(new RoleMovementMail($roleMovementItem));
    }
    public function deliverEmailsForRoleMovementApproval($allRecipients, $roleMovementItem)
    {
        Mail::to($allRecipients)->queue(new RoleMovementApproval($roleMovementItem));
    }
    public function getUserRod($auuid)
    {
    }
    public function getUserZbm($auuid)
    {
    }
    public function prepareOrganogram($id)
    {
        $role = User::where('id', $id)->get()[0]->roles[0]->name;
        if ($role=="HR"|| $role=="GeoMarketing" || $role=="HQ") {
            $anchor["auuid"] = "Salesforce";
            $anchor["title"] = "Geography | Master";
            //prepare profile
            $profile["last_name"] = "Salesforce";
            $profile["first_name"] = "";
            $profile["profile_picture"] = "avatar.jpg";
            $anchor["userprofile"] = $profile;
            $anchor["geography"] = json_decode(json_encode(array('name'=>'Salesforce')));
            $rods = RodProfile::all();
            foreach ($rods as $rod) {
                $rod["title"]  = "ROD | ".$rod->auuid;
                $rod["geography"] = $rod->region;
                // $rod["className"] = "middle-level";
                $rod["name"] = $rod->userprofile->first_name.' '.$rod->userprofile->last_name;
                $rod["children"] = QuickTaskFacade::getUserZbm($rod->user_id);
                //retrieve more information on zbm
                foreach ($rod["children"] as $zbm) {
                    $zbm["title"] = "ZBM | ".$zbm->auuid;
                    $zbm["className"] = "middle-level";
                    $zbm["geography"] = $zbm->zone;
                    $zbm["name"] = $zbm->userprofile->first_name.' '.$zbm->userprofile->last_name;
                    $zbm["children"] = QuickTaskFacade::getUserAsm($zbm->user_id);
                    foreach ($zbm["children"] as $asm) {
                        //     //format asm data
                        $asm["title"] = "ASM | ".$asm->auuid;
                        $asm["className"] = "product-dept";
                        $asm["geography"] = $asm->area;
                        $asm["name"] = $asm->userprofile->first_name.' '.$asm->userprofile->last_name;
                        $asm["children"] = QuickTaskFacade::getUserMd($asm->user_id);
                        //format md data
                        foreach ($asm["children"] as $md) {
                            $md["title"] = "MD | ".$md->auuid;
                            $md["className"] = "rd-dept";
                            $md["geography"] = $md->territory;
                            $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name;
                        }
                    }
                }
            }
            $anchor["children"] =$rods;
            JavaScript::put([
            'datasource'=>collect([$anchor]),
        ]);
        } elseif ($role=='ROD') {
            $rod = RodProfile::where('user_id', $id)->with(['user:id,email','userprofile'])->get();
            if ($rod->count()>0) {
                $rod[0]["title"]  = "ROD | ".$rod[0]->auuid;
                $rod[0]["geography"] = $rod[0]->region;
                $rod[0]["children"] = QuickTaskFacade::getUserZbm($rod[0]->user_id);
                //retrieve more information on zbm
                foreach ($rod[0]["children"] as $zbm) {
                    $zbm["title"] = "ZBM | ".$zbm->auuid;
                    $zbm["className"] = "middle-level";
                    $zbm["geography"] = $zbm->zone;
                    $zbm["name"] = $zbm->userprofile->first_name.' '.$zbm->userprofile->last_name;
                    $zbm["children"] = QuickTaskFacade::getUserAsm($zbm->user_id);
                    foreach ($zbm["children"] as $asm) {
                        //format asm data
                        $asm["title"] = "ASM | ".$asm->auuid;
                        $asm["className"] = "product-dept";
                        $asm["geography"] = $asm->area;
                        $asm["name"] = $asm->userprofile->first_name.' '.$asm->userprofile->last_name;
                        $asm["children"] = QuickTaskFacade::getUserMd($asm->user_id);
                        //format md data
                        foreach ($asm["children"] as $md) {
                            $md["title"] = "MD | ".$md->auuid;
                            $md["className"] = "rd-dept";
                            $md["geography"] = $md->territory;
                            $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name;
                        }
                    }
                }
                JavaScript::put([
            'datasource'=>$rod,
        ]);
            } else {
                JavaScript::put([
                    'datasource'=>collect([]),
                ]);
            }
        } elseif ($role=='ZBM') {
            $zbm = ZbmProfile::where('user_id', $id)->with(['user:id,email','userprofile'])->get();
            $zbm[0]["title"] = "ZBM | ".$zbm[0]->auuid;
            $zbm[0]["geography"] = $zbm[0]->zone;
            $zbm[0]["children"] = QuickTaskFacade::getUserAsm($zbm[0]->user_id);
            //retrieve more information on zbm
            foreach ($zbm[0]["children"] as $asm) {
                //format asm data
                $asm["title"] = "ASM | ".$asm->auuid;
                $asm["className"] = "product-dept";
                $asm["geography"] = $asm->area;
                $asm["name"] = $asm->userprofile->first_name.' '.$asm->userprofile->last_name;
                $asm["children"] = QuickTaskFacade::getUserMd($asm->user_id);
                //format md data
                foreach ($asm["children"] as $md) {
                    $md["title"] = "MD | ".$md->auuid;
                    $md["className"] = "rd-dept";
                    $md["geography"] = $md->territory;
                    $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name;
                }
            }
            JavaScript::put([
            'datasource'=>$zbm,
        ]);
        } elseif ($role=='ASM') {
            $asm = AsmProfile::where('user_id', $id)->with(['user:id,email','userprofile'])->get();
            $asm[0]["title"] = "ASM | ".$asm[0]->auuid;
            $asm[0]["geography"] = $asm[0]->area;
            $asm[0]["children"] = QuickTaskFacade::getUserMd($asm[0]->user_id);
            //format md data
            foreach ($asm[0]["children"] as $md) {
                $md["title"] = "MD | ".$md->auuid;
                $md["className"] = "rd-dept";
                $md["geography"] = $md->territory;
                $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name;
            }
            JavaScript::put([
            'datasource'=>$asm,
        ]);
        } elseif ($role=='MD') {
            $md = MdProfile::where('user_id', $id)->with(['user:id,email','userprofile'])->get();
            $md[0]["title"] = "MD | ".$md[0]->auuid;
            $md[0]["geography"] = $md[0]->territory;
            JavaScript::put([
            'datasource'=>$md,
        ]);
        }
    }
    public function prepareResourceForRoleMovement($roleMovement)
    {
        $resourceRole = Role::find($roleMovement->resource_role_id);
        $destinationRole = Role::find($roleMovement->requested_role_id);
        //Detach resource role
        $user = User::find($roleMovement->resource_id);
        $user->roles()->detach();
        //clean resource profile
        if ($resourceRole->name=="ZBM") {
            //Remove hierachyprofile
            ZbmProfile::where('user_id', $roleMovement->resource_id)->delete();
            $user->assignRole($destinationRole->name);
        } elseif ($resourceRole->name=="ASM") {
            //Remove hierachyprofile
            AsmProfile::where('user_id', $roleMovement->resource_id)->delete();
            $user->assignRole($destinationRole->name);
        } elseif ($resourceRole->name=="MD") {
            //Remove hierachyprofile
            MdProfile::where('user_id', $roleMovement->resource_id)->delete();
            $user->assignRole($destinationRole->name);
        }

        //prepare resource new hierachy profile
        if ($destinationRole->name=="ROD") {
            $rod = new RodProfile;
            $rod->user_id = $roleMovement->resource_id;
            $rod->region_id = $roleMovement->resource_auuid;
            $rod->auuid = $user->auuid;
            $rod->save();
        } elseif ($destinationRole->name=="ZBM") {
            $zbm = new ZbmProfile;
            $zbm->user_id = $roleMovement->resource_id;
            $zbm->zone_id = $roleMovement->resource_auuid;
            $zbm->auuid = $user->auuid;
            $zbm->save();
        } elseif ($destinationRole->name=="ASM") {
            $asm = new AsmProfile;
            $asm->user_id = $roleMovement->resource_id;
            $asm->area_id = $roleMovement->resource_auuid;
            $asm->auuid = $user->auuid;
            $asm->save();
        } elseif ($destinationRole->name=="MD") {
            $md = new MdProfile;
            $md->user_id = $roleMovement->resource_id;
            $md->territory_id = $roleMovement->resource_auuid;
            $md->auuid = $user->auuid;
            $md->save();
        }
    }
    public function checkLocationAvailability($roleMovement)
    {
        $destinationRole = Role::find($roleMovement->requested_role_id);
        $result = false;
        if ($destinationRole->name=="ROD") {
            $rod = RodProfile::where('region_id', $roleMovement->resource_auuid)->get();
            if ($rod->count()==0) {
                $result = true;
            }
        } elseif ($destinationRole->name=="ZBM") {
            $zbm = ZbmProfile::where('zone_id', $roleMovement->resource_auuid)->get();
            if ($zbm->count()==0) {
                $result = true;
            }
        } elseif ($destinationRole->name=="ASM") {
            $asm = AsmProfile::where('area_id', $roleMovement->resource_auuid)->get();
            if ($asm->count()==0) {
                $result = true;
            }
        } elseif ($destinationRole->name=="MD") {
            $md = MdProfile::where('territory_id', $roleMovement->resource_auuid)->get();
            if ($md->count()==0) {
                $result = true;
            }
        }
        return $result;
    }
    public function apiOrganogram($id)
    {
        $role = User::where('id', $id)->get()[0]->roles[0]->name;
        if ($role=="HR"|| $role=="GeoMarketing" || $role=="HQ") {
            $anchor["auuid"] = "Salesforce";
            $anchor["title"] = "Role | Auuid";
            //prepare profile
            $anchor['name'] = 'FullName | Location';
            $profile["profile_picture"] = "avatar.jpg";
            $anchor["userprofile"] = $profile;
            $anchor["geography"] = json_decode(json_encode(array('name'=>'Salesforce')));
            $rods = RodProfile::all();
            foreach ($rods as $rod) {
                $rod["title"]  = "ROD | ".$rod->auuid;
                $rod["geography"] = $rod->region()->select('name')->get()[0];
                // $rod["className"] = "middle-level";
                $r_profile = $rod->userprofile()->get()[0];
                $rod["name"] = $r_profile->first_name.' '.$r_profile->last_name.' | '.$rod["geography"]->name;
                $rod["children"] = QuickTaskFacade::getUserZbm($rod->user_id);
                //retrieve more information on zbm
                foreach ($rod["children"] as $zbm) {
                    $zbm["title"] = "ZBM | ".$zbm->auuid;
                    $zbm["className"] = "middle-level";
                    $zbm["geography"] = $zbm->zone;
                    $zbm["name"] = $zbm->userprofile->first_name.' '.$zbm->userprofile->last_name.' | '.$zbm["geography"]->name;
                    $zbm["children"] = QuickTaskFacade::getUserAsm($zbm->user_id);
                    foreach ($zbm["children"] as $asm) {
                        //     //format asm data
                        $asm["title"] = "ASM | ".$asm->auuid;
                        $asm["className"] = "product-dept";
                        $asm["geography"] = $asm->area;
                        $asm["name"] = $asm->userprofile->first_name.' '.$asm->userprofile->last_name.' | '.$asm["geography"]->name;
                        $asm["children"] = QuickTaskFacade::getUserMd($asm->user_id);
                        //format md data
                        foreach ($asm["children"] as $md) {
                            $md["title"] = "MD | ".$md->auuid;
                            $md["className"] = "rd-dept";
                            $md["geography"] = $md->territory;
                            if ($md->userprofile != null) {
                                $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name.' | '.$md["geography"]->name;
                            } else {
                                $md["name"] = 'NA | NA';
                            }
                            $md['title'] = $md['title'].' | '.$md['geography']->name;
                        }
                    }
                }
            }
            $anchor["children"] =$rods;
            return $anchor;
        } elseif ($role=='ROD') {
            $rod = RodProfile::where('user_id', $id)->with(['user:id,email'])->get();
            if ($rod->count()>0) {
                $rod[0]["title"]  = "ROD | ".$rod[0]->auuid;
                $rod[0]["geography"] = $rod[0]->region;
                $rod[0]["children"] = QuickTaskFacade::getUserZbm($rod[0]->user_id);
                $r_profile = $rod[0]->userprofile()->get()[0];
                $rod[0]["name"] = $r_profile->first_name.' '.$r_profile->last_name.' | '.$rod[0]["geography"]->name;
                
                //retrieve more information on zbm
                foreach ($rod[0]["children"] as $zbm) {
                    $zbm["title"] = "ZBM | ".$zbm->auuid;
                    $zbm["className"] = "middle-level";
                    $zbm["geography"] = $zbm->zone;
                    $zbm["name"] = $zbm->userprofile->first_name.' '.$zbm->userprofile->last_name.' | '.$zbm["geography"]->name;
                    ;
                    $zbm["children"] = QuickTaskFacade::getUserAsm($zbm->user_id);
                    foreach ($zbm["children"] as $asm) {
                        //format asm data
                        $asm["title"] = "ASM | ".$asm->auuid;
                        $asm["className"] = "product-dept";
                        $asm["geography"] = $asm->area;
                        $asm["name"] = $asm->userprofile->first_name.' '.$asm->userprofile->last_name.' | '.$asm["geography"]->name;
                        ;
                        $asm["children"] = QuickTaskFacade::getUserMd($asm->user_id);
                        //format md data
                        foreach ($asm["children"] as $md) {
                            $md["title"] = "MD | ".$md->auuid;
                            $md["className"] = "rd-dept";
                            $md["geography"] = $md->territory;
                            $md->userprofile ?  $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name.' | '.$md["geography"]->name 
                            : "N/A | ".$md["geography"]->name;
                        }
                    }
                }
                return $rod[0];
            } else {
                return collect([]);
            }
        } elseif ($role=='ZBM') {
            $zbm = ZbmProfile::where('user_id', $id)->with(['user:id,email'])->get();
            $zbm[0]["title"] = "ZBM | ".$zbm[0]->auuid;
            $zbm[0]["geography"] = $zbm[0]->zone;
            $zbm[0]["children"] = QuickTaskFacade::getUserAsm($zbm[0]->user_id);
            $r_profile = $zbm[0]->userprofile()->get()[0];
            $zbm[0]["name"] = $r_profile->first_name.' '.$r_profile->last_name.' | '.$zbm[0]["geography"]->name;
           
            //retrieve more information on zbm
            foreach ($zbm[0]["children"] as $asm) {
                //format asm data
                $asm["title"] = "ASM | ".$asm->auuid;
                $asm["className"] = "product-dept";
                $asm["geography"] = $asm->area;
                $asm["name"] = $asm->userprofile->first_name.' '.$asm->userprofile->last_name.' | '.$asm["geography"]->name;
                $asm["children"] = QuickTaskFacade::getUserMd($asm->user_id);
                //format md data
                foreach ($asm["children"] as $md) {
                    $md["title"] = "MD | ".$md->auuid;
                    $md["className"] = "rd-dept";
                    $md["geography"] = $md->territory;
                    if ($md->userprofile!=null) {
                        $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name.' | '.$md["geography"]->name;
                    } else {
                        $md['name'] = "N/A | ".$md["geography"]->name;
                    }
                }
            }
            return $zbm[0];
        } elseif ($role=='ASM') {
            $asm = AsmProfile::where('user_id', $id)->with(['user:id,email'])->get();
            $asm[0]["title"] = "ASM | ".$asm[0]->auuid;
            $asm[0]["geography"] = $asm[0]->area;
            $asm[0]["children"] = QuickTaskFacade::getUserMd($asm[0]->user_id);
            $r_profile = $asm[0]->userprofile()->get()[0];
            $asm[0]["name"] = $r_profile->first_name.' '.$r_profile->last_name.' | '.$asm[0]["geography"]->name;
            //format md data
            foreach ($asm[0]["children"] as $md) {
                $md["title"] = "MD | ".$md->auuid;
                $md["className"] = "rd-dept";
                $md["geography"] = $md->territory;
                $md["name"] = $md->userprofile->first_name.' '.$md->userprofile->last_name.' | '.$md["geography"]->name;
            }
            return $asm[0];
        } elseif ($role=='MD') {
            $md = MdProfile::where('user_id', $id)->with(['user:id,email'])->get();
            $md[0]["title"] = "MD | ".$md[0]->auuid;
            $md[0]["geography"] = $md[0]->territory;
            $r_profile = $md[0]->userprofile()->get()[0];
            $md[0]["name"] = $r_profile->first_name.' '.$r_profile->last_name.' | '.$md[0]["geography"]->name;
            return $md[0];
        }
    }
    /**
     * Return the Zbm of a location
     *
     * @param string $model model string e.g LocationMovement
     * @param string $modelId model id
     *
     * @return user model
     */
    public static function getLocationZbmAndRod($model, $modelId)
    {
        $user = null;
        $locationmodel_to_name = config('global.locationmodel_to_name');
        $locationType = $locationmodel_to_name[$model];
        if ($locationType=='Zone') {
            $zone = $model::find($modelId);
            $user = ['rod'=>$zone->rodByLocation->user,
             'zbm'=>$zone->zbmByLocation->user];
        }
        if ($locationType=='Area') {
            $area = $model::find($modelId);
            //validate area has state
            if ($area->state()->exists()) {
                if ($area->state->zone()->exists()) {
                    $zone = $area->state->zone;
                    $user = ['rod'=>$zone->rodByLocation->user,
                     'zbm'=>$zone->zbmByLocation->user
                    ];
                }
            }
        }
        return $user;
    }
    /**
    * Return the Asm, Zbm and Rod of a location
    *
    * @param string $model model string e.g LocationRegion
    * @param string $modelId model id
    *
    * @return user model
    */
    public static function getLocationAsmZbmRod($model, $modelId)
    {
        $user = null;
        $locationmodel_to_name = config('global.locationmodel_to_name');
        $locationType = $locationmodel_to_name[$model];
        if ($locationType=='Territory') {
            $territory = $model::find($modelId);
            //validate territory has an area
            if ($territory->lga->exists()) {
                if ($territory->lga->area->exists()) {
                    $area = $territory->lga->area;
                    $user['asm'] = $area->asmByLocation->user;
                    $rodAndZbm = UtilityController::getLocationZbmAndRod('App\Models\LocationArea', $area->id);
                    $user['zbm'] = $rodAndZbm['zbm'];
                    $user['rod'] = $rodAndZbm['rod'];
                }
            }
        }
        return $user;
    }
}
