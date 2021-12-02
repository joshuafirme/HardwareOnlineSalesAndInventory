<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

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
        'payment_method'
    ];

    public function readOrders($user_id)
    {
        return DB::table($this->table . ' as O')
            ->select("O.amount", 'O.qty', DB::raw('CONCAT(prefix, P.id) as product_code'), 'O.order_no', 'O.payment_method',
                'P.image', 'P.description', 'selling_price', 'U.name as unit'
                    )
            ->leftJoin('product as P', DB::raw('CONCAT(prefix, P.id)'), '=', 'O.product_code')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->where('O.user_id', $user_id)
            ->groupBy('O.order_no', 'O.amount', 'O.qty', 'P.prefix', 'P.id', 'P.description', 'P.image', 'O.payment_method', 'selling_price', 'U.name')
            ->get();
    }

}
