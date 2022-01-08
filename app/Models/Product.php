<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Input;

class Product extends Model
{
    

    protected $table = 'product';

    protected $fillable = [
        'id',
        'prefix',
        'description',
        'qty',
        'reorder',
        'orig_price',
        'selling_price',
        'image',
        'unit_id',
        'category_id',
        'supplier_id',
        'markup'
    ];

    public function readAllProduct()
    {
        return DB::table($this->table . ' as P')
            ->select("P.*", DB::raw('CONCAT(prefix, P.id) as product_code'),
                    'description',
                    'reorder', 
                    'orig_price', 
                    'selling_price', 
                    'qty', 
                    'U.name as unit', 
                    'S.supplier_name as supplier', 
                    'C.name as category'
                    )
            ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->where('P.status', 1)
            ->get();
    }

    public function readFastAndSlow($date_from,$date_to)
    {
        $data = DB::table($this->table . ' as P')
            ->select("P.*", DB::raw('CONCAT(P.prefix, P.id) as product_code'),
                    'description',
                    'reorder', 
                    'orig_price', 
                    'selling_price', 
                    'P.qty', 
                    'U.name as unit', 
                    'S.supplier_name as supplier', 
                    'C.name as category',
                    'sales.qty as qty_purchased'
                    )
            ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->leftJoin('sales', 'sales.product_code', '=', DB::raw('CONCAT(P.prefix, P.id)'))
            ->whereBetween(DB::raw('DATE(sales.created_at)'), [$date_from, $date_to])
            ->distinct('sales.product_code')
            ->get();
        return $data;
    }

    public function readArchiveProduct($date_from, $date_to)
    {
        return DB::table($this->table . ' as P')
            ->select("P.*", DB::raw('CONCAT(prefix, P.id) as product_code'),
                    'description',
                    'reorder', 
                    'orig_price', 
                    'selling_price', 
                    'qty', 
                    'U.name as unit', 
                    'S.supplier_name as supplier', 
                    'C.name as category',
                    'P.updated_at'
                    )
            ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->whereBetween(DB::raw('DATE(P.updated_at)'), [$date_from, $date_to])
            ->where('P.status', -1)
            ->get();
    }

    public function readProductByCategory($category_id)
    {
        return DB::table($this->table . ' as P')
            ->select("P.*", DB::raw('CONCAT(prefix, P.id) as product_code'),
                    'description',
                    'reorder', 
                    'orig_price', 
                    'selling_price', 
                    'qty', 
                    'U.name as unit', 
                    'C.name as category'
                    )
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
            ->where('P.status', 1)
            ->where('P.category_id', $category_id)
            ->get();
    }

    public function seachProduct() 
    {
        $data = Input::all();
        $key = $data['search_key'];
        return DB::table($this->table . ' as P')
        ->select("P.*", DB::raw('CONCAT(prefix, P.id) as product_code'),
                'description',
                'reorder', 
                'orig_price', 
                'selling_price', 
                'qty', 
                'U.name as unit', 
                'S.supplier_name as supplier', 
                'C.name as category'
                )
        ->leftJoin('supplier as S', 'S.id', '=', 'P.supplier_id')
        ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->where('P.status', 1)
        ->where('P.description', 'LIKE', '%'.$key.'%')
        ->orWhere(DB::raw('CONCAT(P.prefix, P.id)'), 'LIKE', '%'.$key.'%')
        ->get();
    }

    public function readReorderBySupplier($supplier_id){
        return DB::table($this->table . ' as P')
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
}
