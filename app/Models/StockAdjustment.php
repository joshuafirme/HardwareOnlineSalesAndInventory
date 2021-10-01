<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StockAdjustment extends Model
{
    use HasFactory;

    protected $table = 'stock_adjustment';

    protected $fillable = [
        'product_code',
        'qty_adjusted',
        'action',
        'remarks'

    ];

    public function readByDate($date_from, $date_to){
        return DB::table('stock_adjustment AS SA')
        ->select('SA.*', 'P.*',
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category',
                DB::raw('SA.created_at as date_adjusted'))
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'SA.product_code')
        ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->whereBetween(DB::raw('DATE(SA.created_at)'), [$date_from, $date_to])
        ->get();
    }
}
