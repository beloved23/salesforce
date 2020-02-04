<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use Illuminate\Foundation\Inspiring;

class OutletController extends Controller
{
    public function show($id)
    {
        $context['outlet'] = Outlet::find($id);
        $quote = Inspiring::quote();
        $quote_arr = explode('-', $quote);
        $context['quote'] = $quote_arr;
        if (!isset($context['outlet'])) {
            return redirect()->route('home');
        }
        return view('outlets.home')->with($context);
    }
}
