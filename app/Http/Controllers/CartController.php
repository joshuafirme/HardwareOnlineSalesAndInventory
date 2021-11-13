<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;
use Input;
use DB;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function readCart()
    {
        return Cart::where('user_id', Auth::id())
        ->select("cart.*", 'P.*',
                'cart.id',
                'description',
                'selling_price', 
                'cart.qty', 
                'U.name as unit', 
                'C.name as category'
                )
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'cart.product_code')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->get();
    }

    public function addToCart()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $input = Input::all();
            $product_code = $input['product_code'];
            $qty = $input['qty'];
            $amount = $input['amount'];
    
            if($this->isProductExists($product_code, $user_id) == true){
            Cart::where([
                ['user_id', $user_id],
                ['product_code', $product_code]
            ])
                ->update([
                    'amount' => DB::raw('amount + '. $amount .''),
                    'qty' => DB::raw('qty + '. $qty)
                ]);
                
                return response()->json([
                    'status' =>  'success',
                    'data' => $input
                ], 200);
            }
            else
            {
            Cart::create([
                    'user_id' => $user_id,
                    'product_code' => $product_code, 
                    'qty' => $qty,
                    'amount' => $amount
                ]);

                return response()->json([
                    'status' =>  'success',
                    'data' => $input
                ], 200);
            }

            return response()->json([
                'status' =>  'fail',
                'data' => $input
            ], 200);
        }
        else {
            return response()->json([
                'status' =>  'not_auth',
                'message' => 'login first'
            ], 200);
        }
    }

    public function isProductExists($product_code, $user_id){
        $cart = Cart::where([
                ['user_id', $user_id],
                ['product_code', $product_code]
            ])->get();

        return $cart->count() > 0 ? true : false;
    }

    public function cartCount(){
        return Cart::where('user_id', Auth::id())->count();
    }

    public function cartTotal(){
        return Cart::where('user_id', Auth::id())->sum('amount');
    }

    public function removeItem($id){

        $cart = Cart::where('id', $id);
        if ($cart->delete()) {
            return response()->json([
                'status' =>  'success',
                'message' => 'remove success'
            ], 200);
        }
        
        return response()->json([
            'status' =>  'not_auth',
            'message' => 'fail',
            'message' => 'remove fail'
        ], 200);
    }

    public function changeQuantity(){

        $input = Input::all();
        $id = $input['id'];
        $qty = $input['qty'];
        $amount = $input['amount'];

        if ($qty > 0 || $qty != null) {
            Cart::where('id', $id)
            ->update([
                'amount' => $amount,
                'qty' => $qty
            ]);
        }else {
            Cart::where('id', $id)
            ->delete();
        }
            
        return response()->json([
            'status' =>  'success',
            'data' => $input
        ], 200);
    }
}
