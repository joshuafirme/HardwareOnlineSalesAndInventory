<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ArchiveController extends Controller
{
   public function index() {
        return view('admin.utilities.archive.index');
   }

   public function readArchiveProduct()
   {
        $product = new Product;
        $product = $product->readArchiveProduct(request()->date_from, request()->date_to);
        if(request()->ajax())
        {
            return datatables()->of($product)       
            ->addColumn('action', function($product)
            {
                $button = ' <a class="btn btn-sm btn-restore-product" data-id="'. $product->id .'"><i class="fa fa-recycle"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);       
        }
   }

   public function restore($id)
   {
       Product::where('id', $id)
       ->update([
           'status' => 1,
       ]);
   }
}
