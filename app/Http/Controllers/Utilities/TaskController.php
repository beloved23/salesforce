<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use App\Models\LocationRegion;
use App\Http\Controllers\Utilities\UtilityController;
use Cookie;
use App\Jobs\SendMails;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TargetAssigned;
use App\Events\MessageReceived;
use App\Utilities\Broadcast;
use App\Utilities\Pusher;



class TaskController extends Controller
{
    public function showTime(){
        return Carbon::now('Africa/Lagos')->toDateTimeString();
    }
    public function getToken(Request $request){
       return csrf_token(); 
    }
    public function custom(Request $request){
    event(new MessageReceived());
        return 'hello ';
    }
    public function roles(Request $request){
        $role = Role::create(['name' => 'HR']);
        $role = Role::create(['name' => 'HQ']);
        $role = Role::create(['name' => 'ROD']);
        $role = Role::create(['name' => 'ZBM']);
        $role = Role::create(['name' => 'ASM']);
        $role = Role::create(['name' => 'MD']);
        return "done";
    }
}
