<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    use HasFactory;

    protected $table = 'delivery_area';
    private $url = 'https://raw.githubusercontent.com/flores-jacob/philippine-regions-provinces-cities-municipalities-barangays/master/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';

    public function getBrgyAPI()
    {
        return $this->url;
    }


    protected $fillable = [
        'municipality',
        'brgy',
        'shipping_fee',
        'status'
    ];
}
