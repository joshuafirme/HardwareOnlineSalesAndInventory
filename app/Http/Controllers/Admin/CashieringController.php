<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cashiering;
use App\Models\Sales;
use DB;
use Input;
use Hash;

class CashieringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sales.cashiering');
    }

    public function addToTray()
    {
            $product_code = Input::input('product_code');
            $qty = Input::input('qty');
            $amount = Input::input('amount');
           
            if($this->isProductExists($product_code)){
                DB::table('cashiering_tray')
                ->where('product_code', $product_code)
                ->update(array(
                    'amount' => DB::raw('amount + '. $amount),
                    'qty' => DB::raw('qty + '. $qty)));
            }
            else{
                $c = new Cashiering;
                $c->product_code = $product_code;
                $c->qty = $qty;
                $c->amount = $amount;
                $c->save();
            }
    }

    public function checkProductQty($product_code, $qty_order)
    {
        $inventory_qty = DB::table('tblexpiration')
            ->where('cashiering_tray', $product_code)
            ->sum('qty');
            
        
        return $inventory_qty >= $qty_order ? '1' : '0';

    }

    public function isProductExists($product_code){
        $p = DB::table('cashiering_tray')->where('product_code', $product_code);
        if($p->count() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function readTray(){
        return DB::table('cashiering_tray as C')
        ->select('C.*', 'P.*', 'C.qty as qty_order', 'C.id as id')
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'C.product_code')->get();
    }

    public function void($id)
    {
        $input = Input::all();
        
        $data = DB::table('users')
            ->where('username', $input['username'])
            ->where('access_level', 4)
            ->first();
            
        if ($data) {
            // if password is correct, void the item. 
            if (Hash::check($input['password'], $data->password)) {      
                DB::table('cashiering_tray')->where('id', $id)->delete();
                return 'success';
            }
            else {
                return 'failed';
            }
        }
        else {
            return 'failed';
        }
       
    }

    public function recordSale()
    {
        $input = Input::all();
        $cashiering = new Cashiering;
        $data = $cashiering->readCashieringTray();
        $invoice_no = $input['invoice_no'];

        if (!$this->isInvoiceExists($invoice_no)) {
            foreach ($data as $items) {
                $sales = new Sales;
                $sales->prefix = date('Ymd');
                $sales->invoice_no = $invoice_no;
                $sales->product_code = $items->product_code;
                $sales->qty = $items->qty;
                $sales->amount = $items->amount;
                $sales->payment_method = $input['payment_method'];
                $sales->order_from = 'walk-in';
                $sales->status = 1;
                $sales->save();
    
                $this->updateInventory($items->product_code, $items->qty);
            }
    
            $cashiering->truncate();
   
            return 'success';
        }
        else {
            return 'invoice_exists';
        }
       

        
    }

    public function isInvoiceExists($invoice_no){
        $row = DB::table('sales')->where('invoice_no', $invoice_no)->get();
        return count($row) > 0 ? true : false;
    }

    public function updateInventory($product_code, $qty){
        
        DB::table('product')
            ->where(DB::raw('CONCAT(prefix, id)'), $product_code)
            ->update([
                'qty' => DB::raw('qty - '. $qty .'')
            ]);
    }

    public function readOneQty($product_code){
        return DB::table('cashiering_tray')
            ->where('product_code', $product_code)
            ->first('qty');
    }
}
