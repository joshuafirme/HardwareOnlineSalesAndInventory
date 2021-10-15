<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierDelivery extends Model
{
    use HasFactory;

    protected $table = 'supplier_delivery';

    protected $fillable = [
        'prefix',
        'po_no',
        'product_code',
        'qty_delivered',
        'remarks',
        'date_delivered'
    ];
}
