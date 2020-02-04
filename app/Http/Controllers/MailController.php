<?php
namespace App\Http\Controllers;

use App\Mail\TargetAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\SendMails;
use App\Mail\RoleMovementMail;
use App\Mail\LocationMovementApprovalInform;
use App\Mail\HRMonthlyVerification;
use App\Mail\LocationMovementInform;
use App\Models\RoleMovement;
use App\Models\LocationMovement;
use App\Models\MdAgencyLocation;
use App\Models\ZbmProfile;
use App\Events\LocationMovementApproved;
use App\Mail\RoleMovementMail as MailModel;
use App\Mail\HierachyNotificationForRoleMovement;
use App\Events\HierachyNotificationForRoleMovementEvent;
class MailController extends Controller
{
    public function index(Request $request)
    {
        // $when = Carbon::now()->addMinutes(1);
        // Mail::to($request->user())->later($when,new TargetAssigned);
        // return view('mails.index');
        // $locationMovementItem = LocationMovement::where('id', 1)->get()[0];
        $userId = 1294;
        $roleMovementId = 17;
        $model = RoleMovement::find($roleMovementId);
        return new MailModel(
            $model
        );
    }
}
