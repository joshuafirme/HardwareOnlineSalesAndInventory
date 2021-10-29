<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $table = 'product_return';

    protected $fillable = [
        'invoice_no',
        'product_code',
        'qty',
        'reason',
        'date_returned'
    ];
}
