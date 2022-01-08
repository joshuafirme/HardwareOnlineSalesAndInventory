<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SupplierDelivery extends Model
{
    

    protected $table = 'supplier_delivery';

    protected $fillable = [
        'po_id',
        'prefix',
        'po_no',
        'product_code',
        'qty_delivered',
        'remarks',
        'date_delivered'
    ];

    public function readSupplierDelivery($supplier_id, $date_from, $date_to){
        return DB::table('supplier_delivery AS SD')
        ->select('SD.*', 'P.*',
                'SD.remarks',
                'SD.id as id',
                'PO.qty_order',
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category',
                DB::raw('CONCAT(SD.prefix, SD.id) as del_no'),
                'SD.date_delivered')
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'SD.product_code')
        ->leftJoin('purchase_order AS PO', 'PO.id', '=', 'SD.po_id')
        ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->where('P.supplier_id', $supplier_id)
        ->whereBetween(DB::raw('DATE(SD.date_delivered)'), [$date_from, $date_to])
        ->get();
    }
}
