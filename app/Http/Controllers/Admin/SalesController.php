<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use DB;
use App\Models\Sales;

class SalesController extends Controller
{
    public function index()
    {
        return view('admin.reports.sales-report');
    }

    public function readSales(Request $request) {
        $data = new Sales;
        $data = $data->readSales($request->date_from, $request->date_to);
        if(request()->ajax())
        {       
            return datatables()->of($data)
            ->make(true); 
        }
    }
}
