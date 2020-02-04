<?php

namespace App\Providers;

use App;
use App\Facades\QuickTaskFacade;
use Illuminate\Support\ServiceProvider;

class QuickTask extends ServiceProvider
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
        App::bind('test',function() {
            return new QuickTaskFacade;
         });
    }
}
