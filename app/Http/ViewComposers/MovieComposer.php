<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class MovieComposer
{
    public $movieList = "";
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->movieList = '';
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['testMessageFromProvider'=>$this->movieList]);
    }
}