<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cashiering;
use DB;
use Input;

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

    public function void($id){
        return DB::table('cashiering_tray')->where('id', $id)->delete();
    }
}
