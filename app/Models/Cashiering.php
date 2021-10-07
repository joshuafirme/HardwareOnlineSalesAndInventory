<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cashiering extends Model
{
    use HasFactory;

    protected $table = 'cashiering_tray';

    protected $fillable = [
        'product_code',
        'qty',
        'amount'
    ];


    public function readCashieringTray(){
        return DB::table('cashiering_tray as C')
            ->select("C.*", 'P.description')
            ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'C.product_code')
            ->get();
    }

    public function readTotalAmount(){
        return $this->max();
    }
}
