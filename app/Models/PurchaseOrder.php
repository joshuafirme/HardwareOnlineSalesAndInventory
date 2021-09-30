<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_order';

    protected $fillable = [
        'prefix',
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

    public function readAllOrders($date_from, $date_to, $supplier){
        return DB::table($this->table_po.' AS PO')
        ->select("PO.*", DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num'),
                'P.description',
                'P.orig_price',
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category')
        ->leftJoin('product AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
        ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->whereBetween('PO.created_at', [$date_from, $date_to])
        ->where('P.supplier_id', $supplier_id)
        ->where('PO.remarks', 'Pending')
        ->get();
    }
}
