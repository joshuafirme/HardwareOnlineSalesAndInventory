<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function index(Order $order)
    {
        $user_id = Auth::id();
        $orders = $order->readOrders($user_id);

        return view('orders', compact('orders'));
    }
}
