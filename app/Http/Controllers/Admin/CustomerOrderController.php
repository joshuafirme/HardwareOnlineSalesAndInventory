<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use DB;

class CustomerOrderController extends Controller
{
    public function index()
    {

        return view('admin.customer-orders.index');
    }

    public function readPendingOrders(Order $o)
    {
        $order = $o->readPendingOrders();
        if(request()->ajax())
        { 
            return datatables()->of($order)
                ->addColumn('action', function($order)
                {
                    $button = '<a class="btn btn-sm btn-show-order" data-name="'. $order->name .'" data-order-no="'. $order->order_no .'" ';
                    $button .= 'data-user-id="'. $order->user_id .'" style="color:#1970F1;">Show orders</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function readShippingAddress($user_id) {
        return DB::table('user_address')->where('user_id', $user_id)->first();
    }

    public function readOneOrder($order_no) {
        $order = new Order;
        return $order->readOneOrder($order_no);
    }

    public function readTotalAmount($order_no) {
        return DB::table('orders')
        ->where('order_no', $order_no)
        ->sum('amount');
    }
    
    public function getShippingFee($order_no) {
        return DB::table('order_shipping_fee')
        ->where('order_no', $order_no)
        ->value('shipping_fee');
    }

    public function prepareOrder($order_no) {
        Order::where('order_no', $order_no)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order prepared'
        ]);
    }

}