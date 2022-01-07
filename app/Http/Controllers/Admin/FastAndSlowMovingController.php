<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class FastAndSlowMovingController extends Controller
{
    public function index()
    {
        $product = new Product;
        $product = $product->readFastAndSlow(request()->date_from,request()->date_to);

        if(request()->ajax())
        { 
            return datatables()->of($product)
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.reports.fast-and-slow');
    }
}
