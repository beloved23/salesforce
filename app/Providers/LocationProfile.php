<?php

namespace App\Providers;

use App;
use App\Facades\LocationFacade;
use Illuminate\Support\ServiceProvider;

class LocationProfile extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('location',function() {
            return new LocationFacade;
         });
    }
}
