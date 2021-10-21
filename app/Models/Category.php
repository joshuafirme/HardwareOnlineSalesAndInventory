<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'status'
    ];

    public function getCategoryName($category_id) {
        if ($category_id != 0) {
            return $this::where('id', $category_id)->pluck('name')[0];
        }
        else {
            return "";
        }
    }
}
