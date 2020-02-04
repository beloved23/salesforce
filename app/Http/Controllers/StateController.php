<?php

namespace App\Http\Controllers;

use App\Models\LocationState;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','clearance','master']);
    }
    public function index(){
        $title = "States | ".config('global.app_name');
        $states = LocationState::all();
        return view('location.state')->with([
            'title'=>$title,
            'states' =>$states
        ]);
    }
}
