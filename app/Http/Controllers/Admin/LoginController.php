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
            return redirect()->intended('/users');  
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
