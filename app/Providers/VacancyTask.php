<?php

namespace App\Providers;

use App;
use App\Facades\VacancyFacade;
use Illuminate\Support\ServiceProvider;

class VacancyTask extends ServiceProvider
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
        App::bind('vacancy', function () {
            return new VacancyFacade;
        });
    }
}
