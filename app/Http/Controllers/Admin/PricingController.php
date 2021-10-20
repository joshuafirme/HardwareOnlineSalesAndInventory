<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use App\Models\Product;

class PricingController extends Controller
{
    public function index(){
        $product = new Product;
        $product = $product->readAllProduct();
        if(request()->ajax())
        { 
            return datatables()->of($product)
                ->addColumn('action', function($product)
                {
                    $button = ' <a style="color:#1970F1;" class="btn btn-sm btn-adjust-qty" data-id="'. $product->id .'">Show</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pricing.index');
    }

    public function updatePricing(Request $request){
        Product::where('id', $request['product_id'])
            ->update([
                'markup' => $request['markup'],
                'selling_price' => $request['selling_price'],
            ]);
    }
}
