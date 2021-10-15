<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierDelivery;
use App\Models\Product;
use DB;
use Input;

class SupplierDeliveryController extends Controller
{
    public function index()
    {
        $supplier = Supplier::where('status', 1)->get();
        return view('admin.inventory.supplier-delivery.index',['supplier' => $supplier]);
    }

    public function createDelivery(){

        $data = Input::all();
        
        $this->updatePurchaseOrder($data['po_no'], $data['product_code']);
        $this->updateInventory($data['product_code'], $data['qty_delivered']); 

        $s = new SupplierDelivery;
        $s->po_no = $data['po_no'];
        $s->product_code = $data['product_code'];
        $s->qty_delivered = $data['qty_delivered'];
        $s->date_delivered = $data['date_recieved'];
        $s->remarks = $this->validateDeliveredQty($s->po_no, $s->product_code, $s->qty_delivered);
        $s->save();
    }

    public function updatePurchaseOrder($po_no, $product_code){
        DB::table('purchase_order as PO')
            ->where('PO.product_code', '=', $product_code)
            ->where(DB::raw('CONCAT(PO.prefix, PO.po_no)'), '=', $po_no)
            ->update(
                ['PO.status' => 3]
            );
    }

    public function validateDeliveredQty($po_no, $product_code, $qty_delivered){
        $qty_order = DB::table('purchase_order as PO')
        ->where(DB::raw('CONCAT(PO.prefix, PO.po_no)'), $po_no)
        ->where('product_code', $product_code)
        ->value('qty_order');
        
        $res = 'Completed';
        if($qty_order == $qty_delivered){
            $res = 'Completed';
        }
        else if($qty_order > $qty_delivered){
            $res = 'Partially Completed';
        }
        
        return $res;
    }

    public function updateInventory($product_code, $qty_delivered)
    {
        DB::table('product as P')
            ->where(DB::raw('CONCAT(P.prefix, P.id)'), '=',  $product_code)
            ->update(array(
                'P.qty' => DB::raw('P.qty + '. $qty_delivered .'')));
        
    }

}
