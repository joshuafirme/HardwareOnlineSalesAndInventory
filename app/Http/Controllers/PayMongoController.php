<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayMongo;

class PayMongoController extends Controller
{
    
    public function createSource(PayMongo $paymongo) {
        return $paymongo->createSource();
    }

    public function retrieveSource(PayMongo $paymongo){
        return $paymongo->retrieveSource();
    }

    public function createPayment(PayMongo $paymongo) {
        return $paymongo->createPayment();
    }
}
