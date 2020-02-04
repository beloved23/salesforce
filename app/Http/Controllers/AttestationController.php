<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LocationMovement;

class AttestationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','master','clearance']);
    }
    public function index(Request $request)
    {
        $title = 'Attestation History | Salesforce';
        $locationMovement = LocationMovement::where('attester_id', $request->user()->id)->paginate(20);
        return view('history.attestation')->with([
            'title'=>$title,
            'locationMovement'=>$locationMovement,
        ]);
    }
}
