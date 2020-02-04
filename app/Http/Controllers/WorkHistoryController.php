<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkHistory;
use App\Facades\MyFacades\QuickTaskFacade;
use App\Http\Controllers\Controller;
use App\Models\User;

class WorkHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','master','clearance']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->hasRole('ROD')) {
            $zbm = QuickTaskFacade::getUserZbm($request->user()->id);
            $filtered = $zbm->pluck('user_id');
        } elseif ($request->user()->hasRole('ZBM')) {
            $asm = QuickTaskFacade::getUserAsm($request->user()->id);
            $filtered = $asm->pluck('user_id');
        } elseif ($request->user()->hasRole('ASM')) {
            $md = QuickTaskFacade::getUserMd($request->user()->id);
            $filtered = $md->pluck('user_id');
        } elseif ($request->user()->hasRole('HR')) {
            $all = User::all();
            $filtered = $all->pluck('id');
        } elseif ($request->user()->hasRole('HQ')) {
            $all = User::all();
            $filtered = $all->pluck('id');
        } elseif ($request->user()->hasRole('MD')) {
            $filtered = collect([$request->user()->id]);
        }
        $histories = WorkHistory::whereIn('user_id', $filtered->all())->paginate(500);
        $title = 'Work History | '.config('global.app_name');
        return view('history.work')->with([
            'title'=>$title,
            'histories'=>$histories,
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
        //
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
        //
    }
}
