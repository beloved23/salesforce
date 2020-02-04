<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MessageReceived' => [
            'App\Listeners\SendMessageNotification',
        ],
        'App\Events\LocationMovementCreated' => [
            'App\Listeners\LocationMovementCreatedListener',
        ],
        'App\Events\LocationMovementApproved' => [
            'App\Listeners\LocationMovementApprovedListener',
        ],
        'App\Events\HrMonthlyVerification' => [
            'App\Listeners\HrMonthlyVerificationListener',
        ],
        'App\Events\AgencyMonthlyVerification' => [
            'App\Listeners\AgencyMonthlyVerificationListener',
        ],
        'App\Events\RecruitByAgency' => [
            'App\Listeners\RecruitByAgencyListener',
        ],
        'App\Events\HierachyNotificationForLocationMovementEvent' => [
            'App\Listeners\HierachyNotificationForLocationMovementListener',
        ],
        'App\Events\HierachyNotificationForRoleMovementEvent' => [
            'App\Listeners\HierachyNotificationForRoleMovementListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
