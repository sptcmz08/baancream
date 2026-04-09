<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $products = \App\Models\Product::with('category')->get();
        return view('welcome', compact('products'));
    }

    public function search(Request $request)
    {
        $products = \App\Models\Product::where('name', 'like', '%'.$request->q.'%')->get();
        return response()->json($products);
    }
}
