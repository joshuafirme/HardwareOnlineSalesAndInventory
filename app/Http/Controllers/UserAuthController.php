<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;

class UserAuthController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $access_level = Auth::user()->access_level;
            // 5 = customer
            if (in_array($access_level, array( 5 )))
                 return redirect()->intended('/');  
            else if (in_array($access_level, array( 3, 4 )))
                return redirect()->intended('/dashboard');  
            else if (in_array($access_level, array( 1 )))
                return redirect()->intended('/cashiering');  
            else if (in_array($access_level, array( 2 )))
                return redirect()->intended('/stock-adjustment'); 
        }
        return view('admin.login');
    }

    public function customer_index() {
        if (Auth::check()) {
            return redirect()->intended('/');  
        }
        return view('login');
    }

    public function signup_view() {
        if (Auth::check()) {
            return redirect()->intended('/');  
        }
        return view('signup');
    }

    public function login(Request $data) {
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) 
        {
            $access_level = Auth::user()->access_level;
            // 5 = customer
            if (in_array($access_level, array( 5 )))
                 return redirect()->intended('/');  
            else if (in_array($access_level, array( 3, 4 )))
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

        $alert = 'success';
        $message = 'You have successfully registered!';

        if ($this->isEmailExists($data->input('email'))) {
            $alert = 'danger';
            $message = 'Email is already exists.';
        }
        else if ($this->isUsernameExists($data->input('username'))) {
            $alert = 'danger';
            $message = 'Username is already exists.';
        }
        else {
            $user = new User;
            $user->name = $data->input('firstname') ." ". $data->input('lastname');
            $user->email = $data->input('email');
            $user->access_level = 5;
            $user->username = $data->input('username');
            $user->password = \Hash::make($data->input('password'));

            if ($data->hasFile('identification_photo')) {
                $user->identification_photo = $this->imageUpload($data, 'id_only');
            }

            if ($data->hasFile('selfie_with_identification_photo')) {
                $user->selfie_with_identification_photo = $this->imageUpload($data, 'selfie_with_id');
            }

            $user->phone = $data->input('phone');
            $user->status = 0;
            $user->save();
        }

        return redirect()->back()
            ->with($alert, $message);
    
    }

    public function isEmailExists($email)
    {
        $res = User::where('email', $email)->get();
        return count($res) == 1 ? true : false;
    }

    public function isUsernameExists($username)
    {
        $res = User::where('username', $username)->get();
        return count($res) == 1 ? true : false;
    }

    public function imageUpload($request, $type) 
    {
        $folder_to_save = 'user-identification';

        if ($type == 'id_only') {
            $image_name = uniqid() . "." . $request->identification_photo->extension();
            $request->identification_photo->move(public_path('images/' . $folder_to_save), $image_name);
            return $folder_to_save . "/" . $image_name;
        }
        else {
            $image_name = uniqid() . "." . $request->selfie_with_identification_photo->extension();
            $request->selfie_with_identification_photo->move(public_path('images/' . $folder_to_save), $image_name);
            return $folder_to_save . "/" . $image_name;
        }
    }

    public function logout()
    {
        $access_level = Auth::user()->access_level;

        Auth::logout();
        Session::flush();

        if ($access_level == 5) {
            return redirect()->intended('/');
        }
        else {
            return redirect()->intended('/admin');
        }
    }
}
