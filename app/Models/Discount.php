<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    

    protected $table = 'discount';

    protected $fillable = [
        'discount_percentage',
        'minimum_purchase',
        'pwd_discount',
        'senior_discount'
    ];
}
