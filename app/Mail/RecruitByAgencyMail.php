<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Vacancy;
use Carbon\Carbon;
use Log;

class RecruitByAgencyMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $vacancies;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vacancies)
    {
        $this->vacancies = $vacancies;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        $arr  = $this->vacancies;
        $retrieved = Vacancy::whereIn('id', $arr)->get();
        $dt = Carbon::now();
        return $this->from('support@salesforce.com.ng')->view('mails.recruit')->with([
            'siteLogo'=>asset('images/airtel.png'),
            'greetingsName'=>'Agency',
            'items'=>$retrieved,
            'appUrl'=>env('APP_URL'),
             'company'=>'SalesForce',
             'year'=>$dt->year,
        ]);
    }
}
