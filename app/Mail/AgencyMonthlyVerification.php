<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Carbon\Carbon;
use App\Models\ZbmProfile;
use App\Models\MdProfile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AgencyMonthlyVerification extends Mailable
{
    use Queueable, SerializesModels;
    public $mdsToVerify;
    public $zbm;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mdsToVerify, $zbm)
    {
        $this->mdsToVerify = $mdsToVerify;
        $this->zbm = $zbm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dt = Carbon::now();
        $month = $dt->format('F');
        $zbm = ZbmProfile::where('user_id', $this->zbm)->get()[0];
        $mds = MdProfile::whereIn('user_id', $this->mdsToVerify)->get();
        return $this->from(env('MAIL_FROM_ADDRESS'))->view('mails.hrmonthlyverification')->with([
            'siteLogo'=>asset('images/airtel.png'),
            'greetingsName'=>'Agency',
            'month'=>$month,
            'appUrl'=>env('APP_URL'),
            'zone'=>$zbm->zone->name,
            'fullName'=>$zbm->userprofile->last_name.' '.$zbm->userprofile->last_name,
            'mds'=>$mds,
             'company'=>'SalesForce',
             'year'=>$dt->year,
        ]);
    }
}
