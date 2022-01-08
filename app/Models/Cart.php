<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Cart extends Model
{
    

    protected $table = 'cart';

    protected $fillable = [
        'id',
        'user_id',
        'product_code',
        'qty',
        'amount'
    ];

    public function readCart(){
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

}
