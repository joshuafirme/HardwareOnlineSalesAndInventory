<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\AuditTrail;
use Input;

class SupplierController extends Controller
{
    public $module = "Supplier Maintenance";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::paginate(10);

        return view('admin.maintenance.supplier.index', compact('supplier'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.maintenance.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $at = new AuditTrail;
        $at->audit($this->module, 'Add');

        $request->validate([
            'supplier_name' => 'required|unique:supplier',
            'address' => 'required:supplier',
            'person' => 'required:supplier',
            'contact' => 'required:supplier'
        ]);

        Supplier::create($request->all());

        return redirect()->back()
            ->with('success', 'Supplier was created.');
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
    public function edit(Supplier $supplier)
    {
        return view('admin.maintenance.supplier.edit', compact('supplier'));
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
        $at = new AuditTrail;
        $at->audit($this->module, 'Update');

        $request->validate([
            'supplier_name' => 'required:supplier',
            'address' => 'required:supplier',
            'person' => 'required:supplier',
            'contact' => 'required:supplier'
        ]);

        Supplier::where('id', $id)->update([
            'supplier_name' => $request->input('supplier_name'),
            'address' => $request->input('address'),
            'person' => $request->input('person'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'status' => $request->input('status')
        ]);

        return redirect()->back()
            ->with('success', 'Supplier was updated.');
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

    public function getMarkupBySupplier(Supplier $supplier) 
    {
        return Supplier::where('id', Input::input('id'))->first('markup');
    }
}
