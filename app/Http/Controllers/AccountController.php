<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AccountController extends Controller
{
    public function index() {
        $user = User::where('id', Auth::id())->first();
        return view('account', compact('user'));
    }

    public function editAccount() {
        $user = User::where('id', Auth::id())->first();
        return view('edit-account', compact('user'));
    }

    public function update(Request $request, $id) {
      
        User::where('id', $id)
        ->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'access_level' => 5,
            'phone' => $request->input('phone'),
        ]);

        if ($request->input('password')) {
            User::where('id', $id)
            ->update([
                'password' => \Hash::make($request->input('password'))
            ]);
        }

        return redirect()->back()
            ->with('success', 'User was updated.');
    }
}
