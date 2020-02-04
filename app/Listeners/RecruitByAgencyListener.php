<?php

namespace App\Listeners;

use App\Events\RecruitByAgency;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\MdAgencyLocation;
use App\Mail\RecruitByAgencyMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Mail;
use Log;

class RecruitByAgencyListener 
{
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  RecruitByAgency  $event
     * @return void
     */
    public function handle(RecruitByAgency $event)
    {
        //   Log::info('From RecruitByListener '.json_encode($event->vacancies));
        $agencies = MdAgencyLocation::all();
        $vacantPositions = Vacancy::whereIn('id', $event->vacancies)->get();
        foreach ($agencies as $agent) {
            $vacancyByAgency = collect([]);
            foreach ($vacantPositions as $item) {
                //check ROD role
                if ($item->required_profile=='ROD') {
                    if ($item->location_id==$agent->location_id) {
                        $vacancyByAgency = $vacancyByAgency->concat([$item->id]);
                    }
                }
                //check ZBM role
                if ($item->required_profile=='ZBM') {
                    $locationModel = $item->location_model::find($item->location_id);
                    $region = $locationModel->region;
                    if (isset($region)) {
                        if ($region->id==$agent->location_id) {
                            $vacancyByAgency = $vacancyByAgency->concat([$item->id]);
                        }
                    }
                }
                //check ASM role
                if ($item->required_profile=='ASM') {
                    $locationModel = $item->location_model::find($item->location_id);
                    $state = $locationModel->state;
                    if (isset($state)) {
                        $region = $state->zone->region;
                        if (isset($region)) {
                            if ($region->id==$agent->location_id) {
                                $vacancyByAgency = $vacancyByAgency->concat([$item->id]);
                            }
                        }
                    }
                }
                //check MD role
                if ($item->required_profile=='MD') {
                    $locationModel = $item->location_model::find($item->location_id);
                    $state = $locationModel->lga->area->state;
                    if (isset($state)) {
                        $region = $state->zone->region;
                        if (isset($region)) {
                            if ($region->id==$agent->location_id) {
                                $vacancyByAgency = $vacancyByAgency->concat([$item->id]);
                            }
                        }
                    }
                }
            }
            if ($vacancyByAgency->count()>0) {
                Mail::to($agent->agency->email)->queue(new RecruitByAgencyMail($vacancyByAgency));
            }
        }
    }
}
