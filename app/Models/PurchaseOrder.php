<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PurchaseOrder extends Model
{
    

    protected $table = 'purchase_order';

    protected $fillable = [
        'prefix',
        'po_no',
        'product_code',
        'qty_order',
        'amount',
        'remarks',
        'status'
    ];

    public function readReorderBySupplier($supplier_id){
        return DB::table('product as P')
            ->select("P.*", DB::raw('CONCAT(prefix, P.id) as product_code'),
                    'description',
                    'reorder', 
                    'qty', 
                    'U.name as unit', 
                    'S.supplier_name as supplier', 
                    'C.name as category'
                    )
            ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->where('P.status', 1)
            ->where('P.supplier_id', $supplier_id)
            ->whereColumn('P.reorder','>=', 'P.qty')
            ->get();
    }

    public function readRequestOrderBySupplier($supplier_id){
        return DB::table('purchase_order AS PO')
        ->select("PO.*",
                'P.description',
                'P.orig_price',
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category')
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'PO.product_code')
        ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->where('P.supplier_id', $supplier_id)
        ->where('PO.status', 1)
        ->get();
    }

    public function readPurchasedOrder($supplier_id, $date_from, $date_to){
        return DB::table('purchase_order AS PO')
        ->select('PO.*', 'P.*',
                'PO.id as id',
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category',
                DB::raw('CONCAT(PO.prefix, PO.po_no) as po_num'),
                DB::raw('PO.updated_at as date_order'))
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'PO.product_code')
        ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->where('P.supplier_id', $supplier_id)
        ->where('PO.status', 2)
        ->whereBetween(DB::raw('DATE(PO.updated_at)'), [$date_from, $date_to])
        ->get();
    }
}
