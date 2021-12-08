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

    public function getMunicipalityList(){

        $json = @file_get_contents($this->getBrgyAPI());
        $obj = $json === FALSE ? array() : json_decode($json, true);

        return $obj['4A']['province_list']['BATANGAS']['municipality_list'];
    }

    public function getMunicipality(){
        return $this::select('municipality')->distinct('municipality')->where('status', 1)->get();
    }

    public function getBrgy(){
        return $this::select('brgy')->distinct('brgy')->where('status', 1)->get();
    }

    public function getBrgyByMunicipality($municipality){
        return $this::select('brgy')->where('municipality', $municipality)->where('status', 1)->get();
    }
}
