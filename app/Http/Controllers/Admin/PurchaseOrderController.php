<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Supplier;
use Input;
use DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $supplier = Supplier::where('status', 1)->get();
        return view('admin.inventory.purchase-order.index', ['supplier' => $supplier]);
    }

    public function displayReorders(Request $request){
        $data = new PurchaseOrder;
        if(request()->ajax())
        {       
            if($request->supplier_id){
                return datatables()->of($data->readReorderBySupplier($request->supplier_id))
                ->addColumn('action', function($data){
                    $button = '<a class="btn btn-sm btn-add-to-order" data-id='. $data->id .'>
                    <i class="fa fa-cart-plus"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);   
            }
                    
        }
    }

    public function addOrder(){

        $product_code = Input::input('product_code');
        $qty_order = Input::input('qty_order');
        $amount = Input::input('amount');
    
        if($this->isAlreadyOrder($product_code)){
            PurchaseOrder::where('product_code', $product_code)
            ->update(array(
                'amount' => DB::raw('amount + '. $amount),
                'qty_order' => DB::raw('qty_order + '. $qty_order),
                ));
        }
        else{
            PurchaseOrder::create([
                    'product_code' => $product_code,
                    'qty_order' => $qty_order,
                    'amount' => $amount,
                    'status' => 1
                ]);
        }      
    }

    public function isAlreadyOrder($product_code){
        $p = PurchaseOrder::where('product_code', $product_code)->where('status', 1);
        if($p->count() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
