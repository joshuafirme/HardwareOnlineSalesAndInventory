<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'supplier_name',
        'address',
        'person',
        'contact',
        'email',
        'markup',
        'status'
    ];

    public function getSupplierNameByID($id) {
        return $this::where('id', $id)->first('supplier_name');
    }
}
