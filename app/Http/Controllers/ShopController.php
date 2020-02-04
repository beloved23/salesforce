<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Log;

class ShopController extends Controller
{
    public function index(Request $request, $id)
    {
        $context['products'] = Product::with(['category'])->limit(50)->get();
        return view('outlets.shop')->with($context);
    }
}
