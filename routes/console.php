<?php

use Illuminate\Foundation\Inspiring;
use App\Models\WorkHistory;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('kimberly', function () {
    $profiles = collect([[
        'role'=>'ROD',
        'model'=>'App\Models\RodProfile',
        'model_id'=>'region_id',
        'destination_model'=>'App\Models\LocationRegion'
        ],
        [
            'role'=>'ZBM',
            'model'=>'App\Models\ZbmProfile',
            'model_id'=>'zone_id',
            'destination_model'=>'App\Models\LocationZone'
        ],
        [
            'role'=>'ASM',
            'model'=>'App\Models\AsmProfile',
            'model_id'=>'area_id',
            'destination_model'=>'App\Models\LocationArea'
        ],
        [
            'role'=>'MD',
            'model'=>'App\Models\MdProfile',
            'model_id'=>'territory_id',
            'destination_model'=>'App\Models\LocationTerritory'
        ],
        ]);
    //prepare work history for new app
    foreach ($profiles as $profile) {
        $users = User::role($profile['role'])->get();
        foreach ($users as $user) {
            $roleProfile = $profile['model']::where('user_id', $user->id)->get();
            if ($roleProfile->count()==1) {
                $workHistory = new WorkHistory;
                $workHistory->user_id = $roleProfile[0]->user_id;
                $workHistory->type = 'Location Movement';
                $workHistory->to_date = 'Till date';
                $location_id_str = $profile['model_id'];
                $workHistory->destination_id = $roleProfile[0]->$location_id_str;
                $workHistory->destination_model =$profile['destination_model'];
                $workHistory->save();
            }
        }
    }
    $this->comment('Work history populated successfully');
    $this->comment('Booty o che che che!');
})->describe('Populates the application with dummy work history');

Artisan::command(
    'hr',
    function () {
        $hr = User::role('HR')->inRandomOrder()->first();
        $this->comment($hr->auuid);
    }
)->describe('Display the auuid of a randomly selected hr');
Artisan::command(
    'hq',
    function () {
        $hq = User::role('HQ')->inRandomOrder()->first();
        $this->comment($hq->auuid);
    }
)->describe('Display the auuid of a randomly selected hr');
Artisan::command(
    'rod',
    function () {
        $rod = User::role('ROD')->inRandomOrder()->first();
        $this->comment($rod->auuid);
    }
)->describe('Display the auuid of a randomly selected rod');
Artisan::command(
    'zbm',
    function () {
        $zbm = User::role('ZBM')->inRandomOrder()->first();
        $this->comment($zbm->auuid);
    }
)->describe('Display the auuid of a randomly selected zbm');
Artisan::command(
    'asm',
    function () {
        $asm = User::role('ASM')->inRandomOrder()->first();
        $this->comment($asm->auuid);
    }
)->describe('Display the auuid of a randomly selected asm');
Artisan::command(
    'md',
    function () {
        $md = User::role('MD')->inRandomOrder()->first();
        $this->comment($md->auuid);
    }
)->describe('Display the auuid of a randomly selected md');
Artisan::command(
    'geomarketing',
    function () {
        $geo = User::role('GeoMarketing')->inRandomOrder()->first();
        $this->comment($geo->auuid);
    }
)->describe('Display the auuid of a randomly selected md');
