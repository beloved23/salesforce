<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Facades\MyFacades\QuickTaskFacade;

class LocationMovementInform extends Mailable
{
    use Queueable, SerializesModels;

    public $locationMovement;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($locationMovement)
    {
        $this->locationMovement  = $locationMovement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $requester_auuid = $this->locationMovement->requester_auuid;
        $fullName = QuickTaskFacade::getUserFullName($this->locationMovement->requester_id);
        $initialLocation = $this->locationMovement->location_model::where('id', $this->locationMovement->requester_location_id)->get()[0];
        $newLocation = $this->locationMovement->location_model::where('id', $this->locationMovement->location_id)->get()[0];
        $locationType = substr($this->locationMovement->location_model, 19, strlen($this->locationMovement)-19);
        return $this->from(env('MAIL_FROM_ADDRESS'))->view('mails.locationmovementinform')->with([
            'siteLogo'=>asset('images/airtel.png'),
            'requesterName' =>$fullName,
            'initialLocation'=>$initialLocation->name,
            'resourceAuuid'=>$requester_auuid,
            'destinationLocation'=>$newLocation->name,
            'locationType'=>$locationType,
            'requestComment'=>$this->locationMovement->profile->requester_comment,
            'time'=>QuickTaskFacade::formatEmailTime($this->locationMovement->created_at),
            'company'=>'SalesForce'
        ]);
    }
}
