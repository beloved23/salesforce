<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\Trending;
use Log;
use App\Models\Outlet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $context['trending'] = Trending::get(10);
        $context['entry_slides'] = Outlet::inRandomOrder()->limit(5)->get();
        $context['sidebar_top'] = Outlet::inRandomOrder()->limit(2)->get();
        return  view('home')->with($context);
    }
}