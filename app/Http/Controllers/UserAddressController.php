<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\DeliveryArea;
use Auth;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryArea $d)
    {
        $address = UserAddress::where('user_id', Auth::id())->first();
        $municipalities = $d->getMunicipality();
        $brgys = $d->getBrgy();
        return view('edit-address', compact('address', 'municipalities', 'brgys'));
    }

    public function getBrgyByMunicipality(DeliveryArea $d,$municipality)
    {
        return $d->getBrgyByMunicipality($municipality);
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
        //return $request->all();
        if ($this->isAddressExists(Auth::id())) {
            UserAddress::where('user_id', Auth::id())->update($request->except(['_token', '_method']));
        }
        else {
            $request['user_id'] = Auth::id();
            UserAddress::create($request->all());
        }
        return redirect()->back()->with('success', 'Address was updated.');
    }

    public function isAddressExists($user_id)
    {
        $res = UserAddress::where('user_id', $user_id)->get();
        return count($res) > 0 ? true : false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
