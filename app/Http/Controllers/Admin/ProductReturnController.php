<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\ProductReturn;
use Input;
use DB;

class ProductReturnController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.inventory.product-return.index');
    }

    public function readSales(Request $request) {
        $data = new Sales;
        $data = $data->readSales($request->date_from, $request->date_to, $request->order_from, $request->payment_method);
        if(request()->ajax())
        {       
            return datatables()->of($data)
            ->addColumn('action', function($data)
                {
                    $button = ' <a style="color:#1970F1;" class="btn btn-sm btn-return" data-id="'. $data->id .'">Return</a>';
                    return $button;
                })
                ->rawColumns(['action'])
            ->make(true); 
        }
    }

    public function return()
    {
        $invoice_no = Input::input('invoice_no');
        $product_code = Input::input('product_code');
        $selling_price = Input::input('selling_price');
        $qty_return = Input::input('qty_return');
        $qty_purchased = Input::input('qty_purchased');
        $reason = Input::input('reason');
        $other_reason = Input::input('other_reason');
        $date_returned = date('Y-m-d');

        if($reason == 'Damaged'){
            $this->recordReturn($invoice_no, $product_code, $qty_return, $reason, $date_returned, "");
            $this->updateSales($invoice_no, $product_code, $qty_return , $qty_purchased, $selling_price);
        }
        else if($reason == 'Wrong item'){
            $this->recordReturn($invoice_no, $product_code, $qty_return, $reason, $date_returned, "");
            $this->updateInventory($product_code, $qty_return);
            $this->updateSales($invoice_no, $product_code, $qty_return , $qty_purchased, $selling_price);
        }  
        else {
            $this->recordReturn($invoice_no, $product_code, $qty_return, $reason, $date_returned, $other_reason);
            $this->updateSales($invoice_no, $product_code, $qty_return , $qty_purchased, $selling_price);
        }      

    }

    public function recordReturn($invoice_no, $product_code, $qty_return, $reason, $date_returned, $other_reason){
        $return = new ProductReturn;
        $return->invoice_no = $invoice_no;
        $return->product_code = $product_code;
        $return->qty = $qty_return;  
        $return->reason = $reason; 
        $return->date_returned = $date_returned;  
        $return->type_reason = $other_reason; 
        $return->save();     
    }

    public function updateInventory($product_code, $qty_return){
            DB::table('product')
            ->where(DB::raw('CONCAT(prefix, id)'), $product_code)
            ->update(array(
                'qty' => DB::raw('qty + '. $qty_return .'')));
    }

    public function updateSales($invoice_no, $product_code, $qty_return, $qty_purchased, $selling_price){
        if ($qty_return == $qty_purchased) {
            DB::table('sales')
            ->where('invoice_no', $invoice_no)
            ->where('product_code', $product_code)
            ->delete();
        }
        else {
            $amount = $qty_return * $selling_price;
            DB::table('sales')
            ->where('invoice_no', $invoice_no)
            ->where('product_code', $product_code)
            ->update(array(
                'qty' => DB::raw('qty - '. $qty_return .''),
                'amount' => DB::raw('amount - '. $amount .'')));
        }
    }
}
