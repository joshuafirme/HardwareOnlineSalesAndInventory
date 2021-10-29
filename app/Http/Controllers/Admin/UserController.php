<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('status', 1)->paginate(5);

        return view('admin.utilities.user.index', compact('user'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.utilities.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required:users',
            'email' => 'required|unique:users',
            'password' => 'required:users',
            'access_level' => 'required:users',
        ]);
        
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->access_level = $request->input('access_level');
        $user->username = $request->input('username');
        $user->password = \Hash::make($request->input('password'));
        $user->status = 1;
        $user->save();

        return redirect()->back()
            ->with('success', 'User was created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.utilities.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required:users',
            'username' => 'required:users',
            'email' => 'required:users',
            'access_level' => 'required:users',
        ]);

        User::where('id', $id)
        ->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'access_level' => $request->input('access_level')
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        User::where('id', $id)
        ->update([
            'status' => 0
        ]);

        return redirect()->back()
            ->with('success', 'User was archived.');
    }
}
