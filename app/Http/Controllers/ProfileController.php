<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
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
        $profile = Auth::user()->profile;
        return view('profile.index')->with([
            'title'=>"My Profile | SalesForce",
            'profile'=> (isset($profile) ? $profile : null)
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
                    $profile = UserProfile::where('user_id', $request->user()->id);
                    if ($profile->count() ==0) {
                        $profile = new UserProfile;
                        $profile->user_id = $request->user()->id;
                        $profile->auuid = $request->user()->auuid;
                        $profile->profile_picture = $filename;
                        $profile->first_name = '';
                        $profile->last_name  = '';
                        $profile->phone_number = '';
                        $profile->save();
                    } else {
                        $profile = UserProfile::where('user_id', $request->user()->id)->update([
                        'profile_picture'=>$filename
                    ]);
                    }
              
                    return redirect()->route('profile.index')->with([
                    'actionSuccessMessage'=>'Profile picture uploaded successfully'
                 ]);
                } else {
                    return redirect()->route('profile.index')->with([
                    'actionErrorMessage'=> "Invalid file selected"
                ]);
                }
            } else {
                return redirect()->route('profile.index')->with([
                'actionErrorMessage'=> "No file selected for upload"
            ]);
            }
        }
        //handle other request
        elseif ($request->action=="update") {
            $this->validate($request, [
        'first_name' => 'bail|required',
        'last_name' => 'required',
        'msisdn'=>'required'
]);
            $profile = UserProfile::where('user_id', $request->user()->id)->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone_number'=>$request->msisdn
        ]);
            if ($request->has('email')) {
                if (strlen($request->email) > 5) {
                    $user = User::find($request->user()->id)->update([
                    'email'=>$request->email
                ]);
                }
            }
            return redirect()->route('profile.index')->with([
            'actionSuccessMessage'=>'Profile updated successfully'
         ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        // $path = $request->file('avatar')->store('avatars');
        return $id." upload picture";
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
}
