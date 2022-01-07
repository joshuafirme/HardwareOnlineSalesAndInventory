<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function contactUs() {
        return view('pages.contact-us');
    }

    public function aboutUs() {
        return view('pages.about-us');
    }

    public function privacyPolicy() {
        return view('pages.privacy-policy');
    }

    public function returnAndCancellationPolicy() {
        return view('pages.return-and-cancellation-policy');
    }

    public function weDeliver() {
        return view('pages.we-deliver');
    }

    
}
