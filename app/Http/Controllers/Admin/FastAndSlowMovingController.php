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
            ->addColumn('selling_price', function($product)
            {
                $button = ' <div class="text-right">'.$product->selling_price.'</div>';
               
                return $button;
            })
            ->rawColumns(['action', 'selling_price'])
                ->make(true);
        }

        return view('admin.reports.fast-and-slow');
    }
}
