<?php

namespace App\Http\Middleware;


use Closure;
use JavaScript;
use Illuminate\Support\Facades\Auth;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;


class ClearanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->hasRole('ROD')) {
            $rodProfile = RodProfile::where('user_id', Auth::user()->id)->get();
            if ($rodProfile->count()==0) {
                Auth::logout();
                return redirect()->route('login')->with([
                    'actionError'=>'Rod Profile must be assigned to this account before usage',
                ]);
            }
        }
        if (Auth::user()->hasRole('ZBM')) {
            $zbmProfile = ZbmProfile::where('user_id', Auth::user()->id)->get();
            if ($zbmProfile->count()==0) {
                Auth::logout();
                return redirect()->route('login')->with([
                    'actionError'=>'Zbm Profile must be assigned to this account before usage',
                ]);
            }
        }
        if (Auth::user()->hasRole('ASM')) {
            $asmProfile = AsmProfile::where('user_id', Auth::user()->id)->get();
            if ($asmProfile->count()==0) {
                Auth::logout();
                return redirect()->route('login')->with([
                    'actionError'=>'Asm Profile must be assigned to this account before usage',
                ]);
            }
        }
        if (Auth::user()->hasRole('MD')) {
            $mdProfile = MdProfile::where('user_id', Auth::user()->id)->get();
            if ($mdProfile->count()==0) {
                Auth::logout();
                return redirect()->route('login')->with([
                    'actionError'=>'Md Profile must be assigned to this account before usage',
                ]);
            }
        }

        //If a user attempts to access account creation page
        if ($request->is('users/create')) {
            if (!Auth::user()->hasRole('HR')) {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            } 
        }

        if ($request->is('rolepermission')) {
            if (!Auth::user()->hasRole('HR')) {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            } 
        }
        if ($request->is('location')) {
            if (!Auth::user()->hasRole('GeoMarketing')) {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            } 
        }
        if ($request->is('retrieve')) {
            if (!Auth::user()->hasRole('HR')) {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            }
        }
        if ($request->is('targetsprofile')) {
            if (Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ') || Auth::user()->hasRole('GeoMarketing')) {
               // return $next($request);
            } else {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            }
        }
        if ($request->is('targets')) {
            if (Auth::user()->hasRole('HR') || Auth::user()->hasRole('GeoMarketing')) {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            }
        }
        if ($request->is('role/movement/*')) {
            if (!Auth::user()->hasRole('HR')) {
                return redirect()->route('dashboard.index')->with(['authorizationError'=>'Access Denied. You do not have the authorization for the request']);
            }
        }
        $role =  Auth::user()->roles()->pluck('name')[0];
        JavaScript::put([
            'currentRoleFromMaster'=>$role
           ]);
        return $next($request);
    }
}
