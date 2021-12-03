<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayMongo;
use App\Models\Order;
use App\Models\Cart;
use App\Models\UserAddress;
use App\Models\DeliveryArea;
use Auth;
use DB;

class CheckoutController extends Controller
{
    public function index() {
        $address = UserAddress::where('user_id', Auth::id())->first();
        if (isset($address)) {
            $charge = $this->getDeliveryCharge();
        }
        else {
            $charge = 0.00;
        }
        $subtotal = $this->cartTotal();
        return view('checkout', compact('charge', 'address', 'subtotal'));
    }

    public function cartTotal(){
        return Cart::where('user_id', Auth::id())->sum('amount');
    }

    public function getDeliveryCharge() {

        $address = UserAddress::where('user_id', Auth::id())->first();

        $charge = DeliveryArea::where('municipality', $address->municipality)
        ->where('brgy', $address->brgy)
        ->value('shipping_fee');
        return $charge;    
    }

    public function placeOrder(Cart $cart) {
        $cart = $cart->readCart();
        $user_id = Auth::id();
        $order_no = $this->generateOrderNumber();
        $shipping_fee = $this->getDeliveryCharge();
        $payment_method = request()->payment_method;
        if ($cart) {
            $total = 0;
            foreach ($cart as $item) {
                Order::create([
                    'user_id' => $user_id,
                    'product_code' => $item->product_code,
                    'order_no' => $order_no,
                    'qty' => $item->qty,
                    'amount' => $item->amount,
                    'payment_method' => request()->payment_method
                ]);
                $total = $total + $item->amount;
            }
            Cart::truncate();

            DB::table('order_shipping_fee')->insert([
                'order_no' => $order_no,
                'shipping_fee' => $shipping_fee
            ]);

            return $order_no;
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

    public function orderInfo($source_id, $payment_method) {
        if ($payment_method == 'COD') {
            return view('payment-info')->with('success', 'test cod');
        }
        else {
            // get source id from session is temporary, use paymongo_payment table to save source id with order #.
            if (session()->get('source_id') == $source_id) {
                return view('payment-info');
            }
            else {
                abort(404);
            }
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
