<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


use JavaScript;
use App\Models\User;

class RolePermission extends Controller
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
        $roles = Role::get();
        $permissions = Permission::get();
        foreach ($roles as $role) {
            $usersPerRole[] = User::role($role->name)->get()->count();
        }
        
        JavaScript::put(['roles'=>$roles,'usersPerRole'=>$usersPerRole,'appPermissions'=>$permissions]);
        $title = "Role Permission | ".config('global.app_name');
        return view('rolepermission.index')->with([
            'title' =>$title

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
        //validates data
        $validator = Validator::make(
        $request->all(),
        [
        'name' => 'bail|required',
    ]
);
        //on validation failure
        if ($validator->fails()) {
            return response()->json(array("validations"=>false));
        } else {
            $inputRoleName = urldecode($request->name);
            //check if role already exist
            $checkRole = Role::where('name', $inputRoleName)->count();
            if ($checkRole==0) {
                $role = new Role();
                $role->name = $inputRoleName;
                $role->save();
                $roles = Role::get();
                foreach ($roles as $role) {
                    $usersPerRole[] = User::role($role->name)->get()->count();
                }
                return response()->json(array("validations"=>true,"data"=>$roles,'usersPerRole'=>$usersPerRole,"action"=>true));
            } else {
                return response()->json(array("validations"=>true,"data"=>"","action"=>false));
            }
        }
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function save(Request $request)
    {
        //validates data
        $validator = Validator::make(
         $request->all(),
         [
         'name' => 'bail|required',
     ]
 );
        //on validation failure
        if ($validator->fails()) {
            return response()->json(array("validations"=>false));
        } else {
            $inputPermissionName = urldecode($request->name);
            //check if permission already exist
            $checkPermission = Permission::where('name', $inputPermissionName)->count();
            if ($checkPermission==0) {
                $permission = new Permission();
                $permission->name = $inputPermissionName;
                $permission->save();
                $permissions = Permission::get();
                return response()->json(array("validations"=>true,"permissions"=>$permissions,"action"=>true));
            } else {
                return response()->json(array("validations"=>true,"data"=>"","action"=>false));
            }
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
        $users = User::select('id', 'email', 'auuid')->where('auuid', 'like', $request->input('q').'%')->orWhere('email', 'like', $request->input('q').'%')->get();
        $roles = Role::select('id', 'name')->where('name', 'like', $request->input('q').'%')->get();
        foreach ($users as $user) {
            $rows[] = $user;
        }
        $profile = $user->profile;
        if (!isset($profile)) {
            $profile["profile_picture"] = "avatar.png";
        }
        $user["profile_main"] = $profile;
        foreach ($roles as $role) {
            $rows[] = $role;
        }
        return response()->json(array("items"=>$rows,"total_count"=>$users->count()+$roles->count(),"pagination"=>array("more"=>true)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return "edit me";
    }

    public function revokeUserPermission(Request $request)
    {
        if (isset($request->userId) && isset($request->permissionId)) {
            $userId = $request->userId;
            $permissionId = $request->permissionId;
            $user = User::find($userId);
            $permission = Permission::find($permissionId);
            if ($user&&$permission) {
                $user->revokePermissionTo($permission);
                $permissions = $user->permissions;
                return response()->json(array("validations"=>true,'permissions'=>$permissions,"action"=>true,"message"=>"The user permission has been successfully revoked"));
            }
            return response()->json(array("validations"=>true,"action"=>false,"message"=>"The provided user and/ permission could not be retrieved"));
        }
        return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a user and a permission"));
    }

    public function revokeRolePermission(Request $request)
    {
        if (isset($request->roleId) && isset($request->permissionId)) {
            $roleId = $request->roleId;
            $permissionId = $request->permissionId;
            $role = Role::find($roleId);
            $permission = Permission::find($permissionId);
            if ($role&&$permission) {
                $role->revokePermissionTo($permission);
                $permissions = $role->permissions;
                return response()->json(array("validations"=>true,'permissions'=>$permissions,"action"=>true,"message"=>"The role permission has been successfully revoked"));
            }
            return response()->json(array("validations"=>true,"action"=>false,"message"=>"The provided role and/ permission could not be retrieved"));
        }
        return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a role and a permission"));
    }


    public function removeUserRole(Request $request)
    {
        if (isset($request->userId) && isset($request->roleId)) {
            $userId = $request->userId;
            $roleId = $request->roleId;
            $user = User::find($userId);
            $role = Role::find($roleId);
            if ($role&&$user) {
                $user->removeRole($role);
                $roles = $user->roles;
                return response()->json(array("validations"=>true,'roles'=>$roles,"action"=>true,"message"=>"The role has been successfully detached from the user"));
            }
            return response()->json(array("validations"=>true,"action"=>false,"message"=>"The provided role and/ user could not be retrieved"));
        }
        return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a user and a role"));
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
        if (isset($request->roles)&& isset($request->permissions)) {
            //assign roles
            $roles = json_decode($request->roles);
            $rolesFromDb = Role::find($roles);
            //assign permissions
            $permissions= json_decode($request->permissions);
            $permissionsFromDb = Permission::find($permissions);
            foreach ($rolesFromDb as $currentRole) {
                $currentRole->permissions()->sync($permissionsFromDb);
            }
            return response()->json(array("validations"=>true,"action"=>true,"message"=>"Role(s) and Permission(s) assigned successfully to selected users"));
        }
        return response()->json(array("validations"=>false,"action"=>false,"message"=>"Please select atleast a role and a permission"));
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

    public function roledestroy($id)
    {
        if (Auth::user()->hasPermissionTo('Can delete role')) {
            Role::find($id)->delete();
            $roles = Role::get();
            return response()->json(array("action"=>true,'roles'=>$roles,"message"=>"Role deleted successfully"));
        }
        return response()->json(array("action"=>false,"message"=>"You do not have the permission to delete this role"));
    }

    public function permissiondestroy($id)
    {
        if (Auth::user()->hasPermissionTo('Can delete permission')) {
            Permission::find($id)->delete();
            $permissions = Permission::get();
            return response()->json(array("action"=>true,'permissions'=>$permissions,"message"=>"Permission deleted successfully"));
        }
        return response()->json(array("action"=>false,"message"=>"You do not have the permission to delete this permit"));
    }

    public function userpermissions(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $permissions = $user->permissions;
            $roles = $user->roles;
            return response()->json(array("action"=>true,"permissions"=>$permissions,'roles'=>$roles));
        } else {
            return response()->json(array("action"=>false,"message"=>"Specified user could not be found"));
        }
    }
    public function rolepermissions(Request $request, $id)
    {
        $role = Role::find($id);
        if ($role) {
            return response()->json(array("action"=>true,'rolename'=>$role->name,'permissions'=>$role->permissions));
        } else {
            return response()->json(array("action"=>false,"message"=>"Specified role could not be found"));
        }
    }
}
