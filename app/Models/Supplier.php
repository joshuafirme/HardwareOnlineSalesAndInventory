<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Supplier extends Model
{
    

    protected $table = 'supplier';

    protected $fillable = [
        'supplier_name',
        'address',
        'person',
        'contact',
        'email',
        'status'
    ];

    public function getSupplierNameByID($id) {
        if ($id) {
            return $this::where('id', $id)->pluck('supplier_name')[0];
        }
    }

    public function getSupplierContact($id) {
        if ($id) {
            return $this::where('id', $id)->value('contact');
        }
    }
}
