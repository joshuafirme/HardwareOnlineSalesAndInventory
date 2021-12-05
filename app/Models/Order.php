<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_no',
        'product_code',
        'qty',
        'amount',
        'payment_method',
    ];

    public function readOrders($user_id)
    {
        return DB::table($this->table . ' as O')
            ->select("O.amount", 'O.qty', DB::raw('CONCAT(prefix, P.id) as product_code'), 'O.order_no', 'O.payment_method', 'O.created_at', 
                'P.image', 'P.description', 'selling_price', 'U.name as unit', 'S.shipping_fee'
                    )
            ->leftJoin('product as P', DB::raw('CONCAT(prefix, P.id)'), '=', 'O.product_code')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->leftJoin('order_shipping_fee as S', 'S.order_no', '=', 'O.order_no')
            ->where('O.user_id', $user_id)
            ->groupBy('O.order_no', 'O.amount', 'O.qty', 'P.prefix', 'P.id', 'P.description', 'P.image', 
            'O.payment_method', 'selling_price', 'U.name', 'O.created_at', 'S.shipping_fee')
            ->orderBy('O.id', 'desc')
            ->get();
    }

    public function readPendingOrders()
    {
        $data = DB::table($this->table . ' as O')
            ->select('O.*', 'O.created_at as date_order', 'users.*')
            ->leftJoin('order_shipping_fee as S', 'S.order_no', '=', 'O.order_no')
            ->leftJoin('users', 'users.id', '=', 'O.user_id')
            ->where('O.status', 1)
            ->orderBy('O.id', 'desc')
            ->get();

        return $data->unique('order_no');
    }

    public function readOneOrder($order_no)
    {
        return DB::table($this->table . ' as O')
            ->select('O.*', 'P.description', 'P.selling_price', 'U.name as unit', 'O.qty as qty', 'O.created_at as date_order', 'users.*', 'S.shipping_fee')
            ->leftJoin('product as P', DB::raw('CONCAT(prefix, P.id)'), '=', 'O.product_code')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->leftJoin('order_shipping_fee as S', 'S.order_no', '=', 'O.order_no')
            ->leftJoin('users', 'users.id', '=', 'O.user_id')
            ->where('O.order_no', $order_no)
            ->get();
    }

    public function getTotalAmount($order_no)
    {
        return DB::table('orders')->where('order_no', $order_no)->sum('amount');
    }
  
}
