<?php

namespace App\Http\Controllers;

use App\Models\LocationArea;
use App\Models\LocationState;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    public function index()
    {
        $title = 'Areas | '.config('global.app_name');
        $areas = LocationArea::all();
        return view('location.area')->with([
            'title'=>$title,
            'areas'=>$areas
        ]);
    }
}
