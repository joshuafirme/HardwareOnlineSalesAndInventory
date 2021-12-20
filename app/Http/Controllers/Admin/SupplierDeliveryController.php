<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierDelivery;
use App\Models\Product;
use App\Models\PurchaseOrder;
use DB;
use Input;

class SupplierDeliveryController extends Controller
{
    public function index()
    {
        $supplier = Supplier::where('status', 1)->get();
        return view('admin.inventory.supplier-delivery.index',['supplier' => $supplier]);
    }

    public function readSupplierDelivery(Request $request)
    {
        $product = new SupplierDelivery;
        $product = $product->readSupplierDelivery($request->supplier_id, $request->date_from, $request->date_to);
        if(request()->ajax())
        { 
            return datatables()->of($product)
            ->addColumn('action', function($data){
                if ($data->remarks == 'Partially Completed') {
                    $button = '<a class="btn btn-sm btn-outline-success btn-show-order"
                    data-toggle="modal" data-target="#delivery-modal" 
                    data-id="'. $data->id .'">Add delivery</a>';
                    return $button;
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

    }

    public function createDelivery(){

        $data = Input::all();
        $qty_delivered = "";
        if (request()->active_tab == 'delivered') {
            SupplierDelivery::where('id', request()->data_id)
            ->update([
                'qty_delivered' => DB::raw('qty_delivered + '. request()->qty_delivered .'')
            ]);

            $qty_delivered = SupplierDelivery::where('id', request()->data_id)->value('qty_delivered');
           // $qty_delivered = (int)$qty_delivered + (int)request()->qty_delivered;
            $remarks = $this->validateDeliveredQty($data['po_no'], $data['product_code'], $qty_delivered);

            SupplierDelivery::where('id', request()->data_id)
            ->update([
                'remarks' => $remarks
            ]);
        }
        else {
            $s = new SupplierDelivery;
            $s->po_id = $data['data_id'];
            $s->po_no = $data['po_no'];
            $s->product_code = $data['product_code'];
            $s->qty_delivered = $data['qty_delivered'];
            $s->date_delivered = $data['date_recieved'];
            $qty_delivered = $data['qty_delivered'];

            $remarks = $this->validateDeliveredQty($data['po_no'], $data['product_code'], $qty_delivered);
            $s->remarks = $remarks;
            $s->save();

        }

        $this->updatePurchaseOrder($data['po_no'], $data['product_code'], $remarks);
        $this->updateInventory($data['product_code'], $data['qty_delivered']); 
    }

    public function updateDelivery() {

    }

    public function updatePurchaseOrder($po_no, $product_code, $remarks){
        $status = 3;
    //    $remarks = "Pending";
    /*    if($remarks == 'Partially Completed'){
            $status = 3;
            $remarks = "Partially Completed";
        }
        else if($remarks == 'Completed'){
            $status = 4;
            $remarks = "Completed";
        }
    */
        DB::table('purchase_order as PO')
            ->where('PO.product_code', '=', $product_code)
            ->where(DB::raw('CONCAT(PO.prefix, PO.po_no)'), '=', $po_no)
            ->update([
                'PO.status' => $status,
              //  'PO.remarks' => $remarks
            ]);
    }

    public function validateDeliveredQty($po_no, $product_code, $qty_delivered){
        $qty_order = DB::table('purchase_order as PO')
        ->where(DB::raw('CONCAT(PO.prefix, PO.po_no)'), $po_no)
        ->where('product_code', $product_code)
        ->value('qty_order');
        
        $res = '';
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
