<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationLga;

class LgaController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','clearance','master']);
    }
    public function index(){
        $title = 'Lga | '.config('global.app_name');
        $lgas = LocationLga::all();
        return view('location.lga')->with([
            'title'=>$title,
            'lgas'=>$lgas
        ]);
    }
}
