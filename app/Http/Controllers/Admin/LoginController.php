<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;

class LoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function login(Request $data) {
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) 
        {
            $access_level = Auth::user()->access_level;

            if (in_array($access_level, array( 3, 4 )))
                return redirect()->intended('/users');  
            else if (in_array($access_level, array( 1 )))
                return redirect()->intended('/cashiering');  
            else if (in_array($access_level, array( 2 )))
                return redirect()->intended('/stock-adjustment'); 
                 
        }
        else {
            return redirect()->back()->with('danger', 'Invalid username or password.');  
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->intended('/admin');
    }
}
