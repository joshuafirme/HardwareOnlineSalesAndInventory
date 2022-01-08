<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductReturn extends Model
{
    

    protected $table = 'product_return';

    protected $fillable = [
        'invoice_no',
        'product_code',
        'qty',
        'reason',
        'date_returned',
        'type_reason'
    ];
    
    public function readProductReturn($date_from, $date_to) {
        return DB::table($this->table . ' as PR')
                ->select('PR.*', 'P.*', 'PR.qty',
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category')
                ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'PR.product_code')
                ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
                ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
                ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
                ->whereBetween(DB::raw('DATE(PR.created_at)'), [$date_from, $date_to])
                ->get();
    }
}
