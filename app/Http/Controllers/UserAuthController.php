<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;

class UserAuthController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function customer_index() {
        return view('login');
    }

    public function signup_view() {
        return view('signup');
    }

    public function login(Request $data) {
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) 
        {
            $access_level = Auth::user()->access_level;

            if (in_array($access_level, array( 3, 4 )))
                return redirect()->intended('/reports/sales');  
            else if (in_array($access_level, array( 1 )))
                return redirect()->intended('/cashiering');  
            else if (in_array($access_level, array( 2 )))
                return redirect()->intended('/stock-adjustment'); 
                 
        }
        else {
            return redirect()->back()->with('danger', 'Invalid username or password.');  
        }
    }

    public function createAccount(Request $data) {
        
        $user = new User;
        $user->name = $data->input('firstname') ." ". $data->input('lastname');
        $user->email = $data->input('email');
        $user->access_level = 5;
        $user->username = $data->input('username');
        $user->password = \Hash::make($data->input('password'));
        $user->identification_photo = $data->input('identification_photo');
        $user->phone = $data->input('phone');
        $user->status = 0;
        $user->save();

        return redirect()->back()
            ->with('success', 'You have successfully registered!');
    
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->intended('/admin');
    }
}
