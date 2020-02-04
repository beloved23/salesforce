<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\MyFacades\QuickTaskFacade;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\User;

class ApplicationUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function hierachyprofile($id)
    {
        $title = 'User HierachyProfile | '.config('global.app_name');
        $fullname = QuickTaskFacade::getUserFullname($id);
        return view('users.hierachyprofiles')->with([
            'title'=>$title,
            'user'=>$id,
            'userFullName'=>$fullname,
            'userRole' => QuickTaskFacade::getUserRole($id),
            'rodCollection'=> QuickTaskFacade::getUserRod($id),
            'zbmCollection'=>QuickTaskFacade::getUserZbm($id),
            'asmCollection'=>QuickTaskFacade::getUserAsm($id),
            'mdCollection'=>QuickTaskFacade::getUserMd($id),
        ]);
    }
    public function locationprofile($id)
    {
        $title = 'User LocationProfile | '.config('global.app_name');
        $fullname =  QuickTaskFacade::getUserFullname($id);
        return view('users.locationprofiles')->with([
            'title'=>$title,
            'userFullName'=>$fullname,
            'userRole' => QuickTaskFacade::getUserRole($id),
            'territoryCollection'=>QuickTaskFacade::getUserTerritory($id),
            'siteCollection'=>QuickTaskFacade::getUserSite($id)
        ]);
    }
    public function manage(Request $request)
    {
        $title = 'Application Users Profile | Salesforce';
        $collection = User::paginate(200);
        if($request->has('role'))
        {
            $collection = User::role($request->role)->paginate(200); 
        }
        return view('manage.index')->with([
            'title'=>$title,
            'collection'=>$collection
        ]);
    }
    public function deactivate($id)
    {
        if (Auth::user()->hasRole('HR')) {
            QuickTaskFacade::deactivateUser($id);
            return response()->json(array('action'=>true,'message'=>'User successfully removed'));
        } else {
            return response()->json(array('action'=>false,'message'=>'Request declined  because you do not have the permission for this request'));
        }
    }
    public function activate(Request $request, $id)
    {
        if ($request->user()->hasRole('HR')) {
            QuickTaskFacade::activateUser($id);
            return response()->json(array('action'=>true,'message'=>'User successfully activated'));
        } else {
            return response()->json(array('action'=>false,'message'=>'Request declined  because you do not have the permission for this request'));
        }
    }
    public function updateProfile(Request $request, $id)
    {
        if (Auth::user()->hasRole('HR')) {
            //If request is made for picture  upload
            if ($request->action =="UploadPicture") {
                if ($request->hasFile('picture')) {
                    $this->validate($request, [
                            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                ]);
                    if ($request->file('picture')->isValid()) {
                        $path = $request->file('picture')->store('public');
                        //get the filename
                        $filename = substr($path, 7);
                        $profile = UserProfile::where('user_id', $id);
                        $user = User::find($id);
                        if ($profile->count() ==0) {
                            $profile = new UserProfile;
                            $profile->user_id = $id;
                            $profile->auuid = $user->auuid;
                            $profile->profile_picture = $filename;
                            $profile->first_name = '';
                            $profile->last_name  = '';
                            $profile->phone_number = '';
                            $profile->save();
                        } else {
                            $profile = UserProfile::where('user_id', $id)->update([
                            'profile_picture'=>$filename
                        ]);
                        }
                  
                        return redirect()->route('application.users.manage')->with([
                        'actionSuccessMessage'=>'Profile picture uploaded successfully'
                     ]);
                    } else {
                        return redirect()->route('application.users.manage')->with([
                        'actionErrorMessage'=> "Invalid file selected"
                    ]);
                    }
                } else {
                    return redirect()->route('application.users.manage')->with([
                    'actionErrorMessage'=> "No file selected for upload"
                ]);
                }
            }
            //handle other request
            elseif ($request->action=="update") {
                $profile = UserProfile::where('user_id', $id)->update([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'phone_number'=>$request->msisdn
            ]);
                if ($request->has('email')) {
                    if (strlen($request->email) > 5) {
                        User::find($id)->update([
                        'email'=>$request->email
                    ]);
                    }
                }
                $user = User::select('id', 'email', 'is_deactivated')->where('id', $id)->get()[0];
                $user->profile;
                $user["role"] = $user->roles()->select('id', 'name')->get()[0];
                $user["zbmCount"] = count(QuickTaskFacade::getUserZbm($id));
                $user["asmCount"] = count(QuickTaskFacade::getUserAsm($id));
                $user["mdCount"] = count(QuickTaskFacade::getUserMd($id));
                $user["action"] = true;
                return response()->json($user);
            }
        } else {
            return reponse()->json([
                'action'=>false,
                'message'=>'You do not have the permission to perform this request'
            ]);
        }
    }
}
