<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryArea;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_area = DeliveryArea::paginate(10);
 
        return view('admin.maintenance.delivery_area.index', compact('delivery_area'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $municipalities = $this->getMunicipalityList();
        return view('admin.maintenance.delivery_area.create', ['municipalities' => $municipalities]);
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
            'municipality' => 'required:delivery_area',
            'brgy' => 'required:delivery_area',
            'shipping_fee' => 'required:delivery_area',
        ]);

        DeliveryArea::create($request->all());

        return redirect()->back()
            ->with('success', 'Delivery area was created.');
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
    public function edit(DeliveryArea $delivery_area)
    {
        $municipalities = $this->getMunicipalityList();
        return view('admin.maintenance.delivery_area.edit', ['delivery_area' => $delivery_area, 'municipalities' => $municipalities]);
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
        $data = $request->except(['_token', '_method']);
        DeliveryArea::where('id', $id)->update($data);

        $municipalities = $this->getMunicipalityList();
        return redirect()->back()
            ->with('success', 'Delivery Area was updated.',['municipalities' => $municipalities]);
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

    public function getMunicipalityList(DeliveryArea $d){
        return $d->getMunicipalityList();
     }
  
     public function getBrgyList($municipality_name){
  
        $api = new DeliveryArea;

    /*    $path = public_path() . "/cache";
        $path_file = $path."/{$municipality_name}.json";

        if (!file_exists($path_file)) {
            $json = @file_get_contents($api->getBrgyAPI());
            $obj = $json === FALSE ? array() : json_decode($json, true);
    
            $data = $obj['4A']['province_list']['BATANGAS']['municipality_list'][$municipality_name];
    
            // caching
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            file_put_contents($path_file, json_encode($data));
            return $path_file;
        }
        else {
             
        }
       
        */

        $json = @file_get_contents($api->getBrgyAPI());
        $obj = $json === FALSE ? array() : json_decode($json, true);
    
        return $obj['4A']['province_list']['BATANGAS']['municipality_list'][$municipality_name];
     }
}
