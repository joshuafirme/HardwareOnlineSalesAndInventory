<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use DB;

class OrderController extends Controller
{
    public function index(Order $order)
    {
        $user_id = Auth::id();
        $orders = $order->readOrders($user_id);

        return view('orders', compact('orders'));
    }

    public function cancelOrder($order_no)
    {
        $date_order = strtotime(request()->date_time_order);
        $five_minutes_ago = strtotime("-5 minutes");
    
        if ($date_order >= $five_minutes_ago) {
            Order::where('order_no', $order_no)->update([
                'status' => 0
            ]);
            return 'status changed to cancel';
        }
        else {
            return 'more than 5 mins';
        }
    }
}
