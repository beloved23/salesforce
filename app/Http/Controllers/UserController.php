<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserProfile;

use App\Models\User;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('users.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Account | ".config('global.app_name');
        $roles = Role::get();

        foreach ($roles as $role) {
            $roleUsers[] = User::role($role->name)->get()->count();
            $rolePermissions[] = Role::find($role->id)->permissions;
        }

        $bannerclasses = array('bg-danger','bg-warning','bg-primary','bg-success',
        'bg-blue-soft','bg-purple','bg-green-meadow',
        'bg-green-turquoise','bg-yellow-crusta',
        'bg-yellow-casablanca');

        return view('users.create')->with([
            'title'=>$title,
            'roles'=>$roles,
        'bannerClasses'=>$bannerclasses,
        'roleUsers'=>$roleUsers,
        'rolePermissions'=>$rolePermissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validates data
        $validator = Validator::make(
        $request->all(),
        [
        'auuid' => 'bail|required|numeric',
        'email' => 'required|email',
        'msisdn'=>'required',
        // 'password'=> 'required',
        // 'cpassword' => 'required',
        'profileRole'=>'required',
    ],
    $messages = [
        'required' => 'The :attribute field is required.',
        'email' => 'The :attribute field must be a valid email address'
    ]
);
        //on validation failure
        if ($validator->fails()) {
            return redirect('users/create')
        ->withErrors($validator)
        ->withInput();
        }
        //on validation success
        $userValidate = User::where('auuid', $request->auuid)->orWhere('email', $request->email)->first();
        //check if user with auuid or email already exists
        if (isset($userValidate)&& !empty($userValidate)) {
            return redirect()->route('users.create')->with(['userCreationError'=>'User with Auuid '.$request->auuid.' or Email '.$request->email.' already exist']);
        } else {
            //fetch role
            $role = Role::where('name', $request->profileRole)->first();
            // create a new user
            $user = User::create([
        'auuid' => $request->auuid,
        'email' => $request->email,
        'last_login_date'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
        'password' => Hash::make('dummy'),
        'remember_token' => SHA1($request->auuid)
    ]);
            //$user = User::find($request->auuid);
            $user->assignRole($role);
            //create dummy user profile
            $profile = new UserProfile;
            $profile->user_id = $user->id;
            $profile->auuid = $request->auuid;
            $profile->profile_picture = config('global.avatar');
            $profile->last_name = '';
            $profile->phone_number = $request->msisdn;
            $profile->first_name = '';
            $profile->save();

            //create Role Profile
            //create ROD
            if ($request->profileRole=="ROD") {
                $this->validate($request, [
            'selectedRegion' => 'required|numeric',
        ]);
                $rod = new RodProfile;
                $rod->user_id = $user->id;
                $rod->auuid = $request->auuid;
                $rod->region_id = $request->selectedRegion;
                $rod->save();
            }
            //create ZBM
            elseif ($request->profileRole=="ZBM") {
                $this->validate($request, [
            'selectedZone'=>'required|numeric',
        ]);
                $zbm = new ZbmProfile;
                $zbm->user_id = $user->id;
                $zbm->auuid = $request->auuid;
                $zbm->zone_id = $request->selectedZone;
                $zbm->save();
            }
            //create asm
            elseif ($request->profileRole=="ASM") {
                $this->validate($request, [
                'selectedArea'=>'required|numeric',
        ]);
                $asm = new AsmProfile;
                $asm->user_id = $user->id;
                $asm->auuid = $request->auuid;
                #$asm->state_id = $request->selectedState;
                $asm->area_id = $request->selectedArea;
                $asm->save();
            }
            //create asm
            elseif ($request->profileRole=="MD") {
                $this->validate($request, [
                'selectedTerritory' =>'required|numeric',
        ]);
                $asm = new MdProfile;
                $asm->user_id = $user->id;
                $asm->auuid = $request->auuid;
                $asm->territory_id = $request->selectedTerritory;
                $asm->save();
            }
            return redirect()->route('users.create')->with(['userCreationSuccess'=>'User Created Successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $users = User::select('id', 'auuid', 'email')->where('auuid', 'like', $request->input('q').'%')->orWhere('email', 'like', $request->input('q').'%')->get();
        foreach ($users as $user) {
            $profile = $user->profile;
            if (!isset($profile)) {
                $profile["profile_picture"] = "avatar.jpg";
            }
            $user["profile_main"] = $profile;
        }
        return response()->json(array("items"=>$users,"total_count"=>$users->count(),"pagination"=>array("more"=>true)));
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
        //
        if (isset($request->users)) {
            //assign users array
            $users = json_decode($request->users);
            if (isset($request->roles)) {
                //assign roles

                $roles = json_decode($request->roles);
                $usersFromDb = User::find($users);
                $rolesFromDb = Role::find($roles);
                foreach ($usersFromDb as $currentUser) {
                    $currentUser->roles()->sync($rolesFromDb);
                }
                if (isset($request->permissions)) {
                    //assign permissions
                    $permissions= json_decode($request->permissions);
                    $permissionsFromDb = Permission::find($permissions);
                    foreach ($usersFromDb as $currentUser) {
                        $currentUser->permissions()->sync($permissionsFromDb);
                    }
                }
            }
            return response()->json(array("validations"=>true,"action"=>true,"message"=>"Role(s) and Permission(s) assigned successfully"));
        } else {
            return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a user and a role"));
        }
        return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a user and a role"));
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
        return "destroy";
    }
}
