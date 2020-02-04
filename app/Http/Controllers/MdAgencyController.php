<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LocationRegion;
use App\Models\MdAgency;
use App\Models\MdAgencyLocation;

class MdAgencyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'MD Agencies | '.config('global.app_name');
        $agencies = MdAgency::all();
        $occupiedRegions = MdAgencyLocation::select('location_id')->get();
        return view('agency.md')->with([
            'title'=>$title,
            'regions'=>LocationRegion::whereNotIn('id', $occupiedRegions)->get(),
            'agencies'=>$agencies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'bail|required|unique:md_agencies',
            'email'=>'required|string|email|unique:md_agencies',
            'regions'=>'required',
        ]);
        $agency['name'] = $request->name;
        $agency['email'] = $request->email;
        $createdAgency = MdAgency::create($agency);
        foreach ($request->regions as $region) {
            $mdAgency = new MdAgencyLocation;
            $mdAgency->agency_id = $createdAgency->id;
            $mdAgency->location_id = $region;
            $mdAgency->model_type = 'App\Models\LocationRegion';
            $mdAgency->save();
        }
        return redirect()->route('agency.index')->with([
            'actionSuccessMessage' =>'MD Agency created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MdAgency::where('id', $id)->delete();
        return redirect()->route('agency.index')->with([
            'actionSuccessMessage'=>'MD Agency deleted successfully'
        ]);
    }
    public function detach(Request $request, $id)
    {
        MdAgencyLocation::where('id', $id)->delete();
        return redirect()->route('agency.index')->with([
            'actionSuccessMessage'=>'Region detached from agency successfully'
        ]);
    }
}
