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
            $total = 0;
            foreach ($cart as $item) {
                Order::create([
                    'user_id' => $user_id,
                    'order_no' => $order_no,
                    'qty' => $item->qty,
                    'amount' => $item->amount,
                    'payment_method' => request()->payment_method
                ]);
                $total = $total + $item->amount;
            }
            Cart::truncate();
        }
    }

    
    public function createPaymayaPaymentMethod(PayMongo $paymongo) {

        $payment_method = request()->payment_method;
        $amount = request()->total;
        $amount = (float)$amount*100;
        $pm = $paymongo->createPaymayaPaymentMethod();
        $payment_method_id = $pm->data->id;

        if ($payment_method_id) {
            session()->put('amount', $amount);
            $pi = $paymongo->createPaymayaPaymentIntent($amount);
            $payment_intent_id = $pi->data->id;
            
            $attach_pi = $paymongo->attatchPaymayaPaymentIntent($payment_intent_id, $payment_method_id);
            
            session()->put('source_id',$paymongo->getSourceID($attach_pi));
     
            return redirect($paymongo->getSourceURL($attach_pi));
        }
    }

    public function orderInfo($source_id) {
        if (session()->get('source_id') == $source_id) {
            return view('payment-info');
        }
        else {
            abort(404);
        }
    }

    public function createSource(PayMongo $paymongo) {
        $amount = request()->total;
        $amount = (float)$amount*100;
        session()->put('amount', $amount);
        return $paymongo->createSource($amount);
    }

    public function retrieveSource(PayMongo $paymongo){
        return $paymongo->retrieveSource();
    }

    public function createPayment(PayMongo $paymongo) {
        return $paymongo->createPayment();
    }

    public function generateOrderNumber() {
        $today = date("Ymd");
        return  $today .'-'. uniqid();
    }
  
}
