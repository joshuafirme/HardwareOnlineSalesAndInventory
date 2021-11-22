<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayMongo;
use App\Models\Order;
use App\Models\Cart;
use Auth;

class CheckoutController extends Controller
{
    public function index() {
        return view('checkout');
    }

    public function placeOrder(Cart $cart) {
        $cart = $cart->readCart();
        $user_id = Auth::id();
        $order_no = $this->generateOrderNumber();
        if ($cart) {
            foreach ($cart as $item) {
                Order::create([
                    'user_id' => $user_id,
                    'order_no' => $order_no,
                    'qty' => $item->qty,
                    'amount' => $item->amount,
                    'payment_method' => request()->payment_method
    
                ]);
            }
        }
    }

    public function generateOrderNumber() {
        $today = date("Ymd");
        return  $today .'-'. uniqid();
    }
  
}
