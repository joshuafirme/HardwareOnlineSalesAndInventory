<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'prefix',
        'invoice_no',
        'product_code',
        'qty',
        'amount',
        'payment_method',
        'order_from',
        'status'
    ];
}
