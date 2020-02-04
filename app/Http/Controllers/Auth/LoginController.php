<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JavaScript;
use Illuminate\Support\Facades\Crypt;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\User;
use App\Models\UserProfile;


use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index(Request $request)
    {
        try {
            $title = config('global.app_name')." | Login";
            //check if Auuid cookie exists
            if (isset($_COOKIE['Auuid'])) {
                $cookieAuuid = $_COOKIE["Auuid"];
            }
            //for automatic authentication and redirecting during HR rolemovement claiming
            if ($request->has('token') && $request->has('redirect_route')) {
                $user =  Crypt::decryptString($request->token);
                $redirectRoute =  Crypt::decryptString($request->redirect_route);
                Auth::loginUsingId($user);
                return redirect()->route($redirectRoute, ['id'=>$request->id]);
            }
            if (isset($cookieAuuid)) {
                JavaScript::put([
                'auuid'=>$cookieAuuid,
            ]);
                return view('auth.login')->with(['title'=>$title,'auuid'=>$cookieAuuid]);
            } else {
                JavaScript::put([
                    'auuid'=>'',
                ]);
                return view('auth.login')->with(['title'=>$title,'auuid'=>'']);
            }
        } catch (DecryptException $e) {
            return redirect()->route('login');
        }
    }

    public function login(Request $request)
    {
        //server side validation
        $request->validate([
            'auuid' => 'bail|required|numeric',
            'password' => 'required',
        ]);
        // $ad_api = sprintf(config('global.ad_api'), $request->auuid, $request->password);
        // //send request to AD api
        // $adResponse = QuickTaskFacade::curlGetRequest($ad_api);
        // $adResponse= json_decode($adResponse);
        //if AD response is false
        $adResponse =true;
        if (!$adResponse) {
            $title = config('global.app_name')." | Login";
            $invalid =  "Incorrect auuid or password";
            $auuid  = $request->auuid;
            return view('auth.login')->with(['title'=>$title,'invalid'=>$invalid,'auuid'=>$auuid]);
        } else {
            //validate user in app
            $user = User::where('auuid', $request->auuid)->where('is_deactivated', false)->get();
            if ($user->count()>0) {
                //set cookie for Auuid
                setcookie("Auuid", $request->auuid, time() + (2592000 * 30), "/");
                Auth::loginUsingId($user[0]->id);
                if ($user[0]->new_user) {
                    //update new_user status to false
                    User::where('auuid', $request->auuid)->update([
                        'new_user'=>false,
                    ]);
                    return redirect()->route('dashboard.index')->with([
                                'welcome'=>'show',
                                'profile'=>'show profile modal'
                                ]);
                } else {
                    return redirect()->route('dashboard.index')->with([
                            'welcome'=>'show'
                            ]);
                }
            }
            //If no account is associated with auuid
            else {
                $title = config('global.app_name')." | Login";
                $invalid =  "Account non-existent or deactivated. Please contact Human Resources";
                $auuid  = $request->auuid;
                return view('auth.login')->with(['title'=>$title,'invalid'=>$invalid,'auuid'=>$auuid]);
            }
            return response()->json($adResponse);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
