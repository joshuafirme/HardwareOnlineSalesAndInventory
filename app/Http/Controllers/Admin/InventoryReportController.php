<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class InventoryReportController extends Controller
{
    public function index()
    {
        
        return view('admin.reports.inventory-report');
    }
}
