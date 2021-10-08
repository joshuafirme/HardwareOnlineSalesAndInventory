<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'prefix',
        'invoice_no',
        'product_code',
        'qty',
        'amount',
        'payment_method',
        'order_from',
        'status'
    ];

    public function readSales($date_from, $date_to){
        return DB::table('sales as S')
        ->select('S.*', 'P.*',
                'U.name as unit', 
                DB::raw('S.created_at as date_time'))
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'S.product_code')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->where('S.status', 1)
        ->whereBetween(DB::raw('DATE(S.created_at)'), [$date_from, $date_to])
        ->orderBy   ('S.invoice_no', 'desc')
        ->get();
    }
}
