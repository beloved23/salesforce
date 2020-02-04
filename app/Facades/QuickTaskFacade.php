<?php
namespace App\Facades;

use App\Models\User;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use App\Models\UserProfile;
use App\Models\RodProfile;
use App\Models\RoleMovement;
use App\Models\LocationMovement;
use App\Models\TargetProfile;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use JavaScript;
use App\Models\Inbox;
use Illuminate\Support\Facades\Auth;
use Log;

class QuickTaskFacade
{

    //get the specified user ROD
    public function getUserRod($user_id)
    {
        $user = User::where('id', $user_id)->get()[0];
        if ($user->hasRole('ROD')) {
            $collection = collect([]);
        } elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $user_id)->with(['zone'])->get()[0];
            $collection[] = $zbm->zone->rodByLocation;
        } elseif ($user->hasRole('ASM')) {
            $asm = AsmProfile::where('user_id', $user_id)->with(['state'])->get()[0];
            $collection[] = $asm->state->zone->region->rodByLocation;
        } elseif ($user->hasRole('MD')) {
            $md = MdProfile::where('user_id', $user_id)->with(['territory'])->get()[0];
            $collection[] = $md->territory->lga->area->state->zone->rodByLocation;
        }
        return $collection;
    }
    //get the specified user ZBM
    public function getUserZbm($user_id)
    {
        $user = User::where('id', $user_id)->get()[0];
        if ($user->hasRole('ZBM')) {
            $collection = collect([]);
        }
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $user_id)->get();
            if ($rod->count() > 0) {
                $collection = $rod[0]->region->zbms;
                if ($collection->count()==0) {
                    $collection = collect([]);
                }
            } else {
                $collection = collect([]);
            }
        } elseif ($user->hasRole('ASM')) {
           
            $asm = AsmProfile::where('user_id', $user_id)->get()[0];
            $zbm = $asm->area->state->zone->zbmByLocation;
            if (!is_null($zbm)) {
                $collection[] = $zbm;
            } else {
                $collection = collect([]);
            }
        } elseif ($user->hasRole('MD')) {
            
            $md = MdProfile::where('user_id', $user_id)->get()[0];
            $zbm = $md->territory->lga->area->state->zone->zbmByLocation;
            if (!is_null($zbm)) {
                $collection[] = $zbm;
            } else {
                $collection = collect([]);
            }
        } else {
            Log::info($user_id);
            $collection = collect([]);
        }
        return $collection;
    }
    //get the specified user ASM
    public function getUserAsm($user_id)
    {
        $user = User::where('id', $user_id)->get()[0];
        $collection = collect([]);
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $user_id)->get();
            if ($rod->count()>0) {
                foreach ($rod[0]->region->zones as $zone) {
                    foreach ($zone->areas as $area) {
                        $locationAsm = $area->asmByLocation;
                        if (!is_null($locationAsm)) {
                            $collection[] = $locationAsm;
                        }
                    }
                }
            } else {
                $collection = collect([]);
            }
        } elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $user_id)->get();
            if ($zbm->count() != 0) {
                foreach ($zbm[0]->zone->areas as $area) {
                    $locationAsm = $area->asmByLocation;
                    if (!is_null($locationAsm)) {
                        $collection[] = $locationAsm;
                    }
                }
            }
        } elseif ($user->hasRole('MD')) {
            $md = MdProfile::where('user_id', $user_id)->get()[0];
            $locationAsm = $md->territory->lga->area->asmByLocation;
            if (!is_null($locationAsm)) {
                $collection[] = $locationAsm;
            }
        }
        return $collection;
    }
      
    public function getUserMd($user_id)
    {
        //get the specified user ASM
        $user = User::find($user_id);
        $collection = collect([]);
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $user_id)->get();
            if ($rod->count()>0) {
                foreach ($rod[0]->region->zones as $zone) {
                    foreach ($zone->areas as $area) {
                        foreach ($area->territories as $territory) {
                            $collection = $collection->concat($territory->mds);
                        }
                    }
                }
            } else {
                $collection = collect([]);
            }
        }
        //actions for ZBM user
        elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $user_id)->get();
            foreach ($zbm[0]->zone->areas as $area) {
                foreach ($area->territories as $territory) {
                    $collection = $collection->concat($territory->mds);
                }
            }
        }
        //actions for ASM user
        elseif ($user->hasRole('ASM')) {
            $zbm = AsmProfile::where('user_id', $user_id)->get();
            foreach ($zbm[0]->area->territories as $territory) {
                if ($territory->mds()->exists()) {
                    $collection = $collection->concat($territory->mds);
                }
            }
        }
        return $collection;
    }
    public function getUserTerritory($id)
    {
        //get the specified user
        $user = User::where('id', $id)->get()[0];
        $collection = collect([]);
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $id)->get();
            foreach ($rod[0]->region->zones as $zone) {
                foreach ($zone->areas as $area) {
                    $collection = $collection->concat($area->territories);
                }
            }
        } elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $id)->get();
            foreach ($zbm[0]->zone->areas as $area) {
                $collection = $collection->concat($area->territories);
            }
        } elseif ($user->hasRole('ASM')) {
            $zbm = AsmProfile::where('user_id', $id)->get();
            $collection = $zbm[0]->area->territories;
        } elseif ($user->hasRole('MD')) {
            $md = MdProfile::where('user_id', $id)->get();
            $item[]  = $md[0]->territory;
            $collection = $collection->concat($item);
        }
        return $collection;
    }
    public function getUserSite($id)
    {
        //get the specified user
        $user = User::where('id', $id)->get()[0];
        $collection = collect([]);
        if ($user->hasRole('ROD')) {
            $rod = RodProfile::where('user_id', $id)->get();
            foreach ($rod[0]->region->zones as $zone) {
                foreach ($zone->areas as $area) {
                    foreach ($area->territories as $territory) {
                        $collection = $collection->concat($territory->sites);
                    }
                }
            }
        } elseif ($user->hasRole('ZBM')) {
            $zbm = ZbmProfile::where('user_id', $id)->get();
            foreach ($zbm[0]->zone->areas as $area) {
                foreach ($area->territories as $territory) {
                    $collection = $collection->concat($territory->sites);
                }
            }
        } elseif ($user->hasRole('ASM')) {
            $zbm = AsmProfile::where('user_id', $id)->get();
            foreach ($zbm[0]->area->territories as $territory) {
                $collection = $collection->concat($territory->sites);
            }
        } elseif ($user->hasRole('MD')) {
            $md = MdProfile::where('user_id', $id)->get();
            $collection = $collection->concat($md[0]->territory->sites);
        }
        return $collection;
    }
    public function getUser($auuid)
    {
        //get the specified user
        $user = User::where('id', $auuid)->get()[0];
        return $user;
    }
    public function getUserProfile($auuid)
    {
        //get the specified user profile
        $userProfile = UserProfile::where('auuid', $auuid)->get()[0];
        return $userProfile;
    }
    public function getUserFullName($id)
    {
        //get the specified user fullname
        $userProfile = UserProfile::where('user_id', $id)->get()[0];
        return $userProfile->first_name.' '.$userProfile->last_name;
    }

    public function getUserRole($id)
    {
        //get the specified user role e.g rod,zbm,asm,md
        $user = User::where('id', $id)->get()[0];
        $roles = $user->roles;
        return $roles[0]->name;
    }
    public function formatEmailTime($time)
    {
        $dt = new Carbon($time);
        return $dt->format('l jS \\of F Y h:i A');         // Saturday 19th of December 2015 10:10:16 AM
    }

    public function locationClaimRoute($id)
    {
        //setup claim route
        $claimRouteToken = Crypt::encryptString(config('global.location_movement_secret'));
        return  config('app.url').'/'.'location/movement/claim/'.$id.'?token='.$claimRouteToken;
    }
    public function getAllHrForEmail()
    {
        $allHR = Role::where('name', 'hr')->with('users')->get()[0]->users;
        foreach ($allHR as $hr) {
            $collection[]  = ["email"=>$hr->email,'name'=>$hr->profile->first_name.' '.$hr->profile->last_name];
        }
        return $collection;
    }
    public function formatUsersForEmail($users)
    {
        foreach ($users as $user) {
            $collection[]  = ["email"=>$user->email,'name'=>$user->profile->first_name.' '.$user->profile->last_name];
        }
        return $collection;
    }
    public function curlGetRequest($api)
    {
        // init the resource
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
            CURLOPT_URL => $api,
            CURLOPT_RETURNTRANSFER => true
        )
        );
        
        $output = curl_exec($ch);
        return $output;
    }
    public function deactivateUser($id)
    {
        $user = User::find($id);
        if ($user->hasRole('ROD')) {
            //remove rod profile
            RodProfile::where('user_id', $id)->delete();
        } elseif ($user->hasRole('ZBM')) {
            //remove zbm profile
            ZbmProfile::where('user_id', $id)->delete();
        } elseif ($user->hasRole('ASM')) {
            //remove asm profile
            AsmProfile::where('user_id', $id)->delete();
        } elseif ($user->hasRole('MD')) {
            //remove md profile
            MdProfile::where('user_id', $id)->delete();
        }
        //deactivate user
        User::where('id', $id)->delete();
    }
    public function activateUser($id)
    {
        //activate user
        User::where('id', $id)->update(['is_deactivated'=>false]);
    }
    public function PrepareMasterPageNotification()
    {
        $inbox = Inbox::where('recipient_id', Auth::user()->id)->where('is_read', false)->with(['sender','senderProfile'])->orderBy('created_at', 'desc');
        $totalUnreadInbox = $inbox->count();
        $selectTopFour = $inbox->limit(4)->get();
        foreach ($selectTopFour as $message) {
            $message["timeline"] = $this->getTimeLine($message->created_at);
        }

        $taskNotificationCount = 0;
        $pendingAttestationNotification = collect([]);
        //pending attestation notification for only zbm
        $pendingAttestation  = RoleMovement::where('attester_id', Auth::user()->id)
        ->where('is_approved', false)->where('is_denied', false)->with(['requesterProfile','resourceRole','destinationRole'])->limit(3)->get();
        foreach ($pendingAttestation as $pending) {
            $pending["timeline"] = $this->getTimeLine($pending->created_at);
            if (!$pending->profile->is_attested) {
                $pendingAttestationNotification[] = $pending;
            }
        }
        //pending attestation notification for only zbm for location movement
        $pendingMovementAttestation = collect([]);
        $pendingAttestation  = LocationMovement::where('attester_id', Auth::user()->id)
         ->where('is_approved', false)->where('is_denied', false)->with(['requesterProfile','resourceRole','destinationRole'])->limit(3)->get();
        foreach ($pendingAttestation as $pending) {
            $pending["timeline"] = $this->getTimeLine($pending->created_at);
            if (!$pending->profile->is_attested) {
                $pendingMovementAttestation[] = $pending;
            }
        }

        //retrieve uncompleted targets
        $uncompletedTargets = TargetProfile::where('assigned_to_user_id', Auth::user()->id)->where('completed', false)->get();
        foreach ($uncompletedTargets as $target) {
            $target->target->ownerProfile;
            $target["timeline"] = $this->toFormattedDateString($target->created_at);
        }
        $taskNotificationCount = $uncompletedTargets->count()+count($pendingAttestationNotification)+count($pendingMovementAttestation);
        JavaScript::put([
            'newMessagesCount'=>$totalUnreadInbox,
            'unreadInbox'=>$selectTopFour,
            'pendingAttestation'=>$pendingAttestationNotification,
            'taskNotificationCount'=>$taskNotificationCount,
            'uncompletedTargets'=>$uncompletedTargets,
            'pendingMovementAttestation'=>$pendingMovementAttestation,
        ]);
    }
    public function getTimeLine($datetime)
    {
        $getDateTime = new Carbon($datetime);
        $time = Carbon::now();
        return str_replace('after', 'ago', $time->diffForHumans($getDateTime));
    }
    public function toFormattedDateString($datetime)
    {
        $getDateTime = new Carbon($datetime);
        return $getDateTime->toFormattedDateString();
    }
}
