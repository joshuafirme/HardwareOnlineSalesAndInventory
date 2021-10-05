<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashiering extends Model
{
    use HasFactory;

    protected $table = 'cashiering_tray';

    protected $fillable = [
        'product_code',
        'qty',
        'amount'
    ];
}
