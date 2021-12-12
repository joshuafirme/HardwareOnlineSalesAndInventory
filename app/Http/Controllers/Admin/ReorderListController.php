<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;

class ReorderListController extends Controller
{
    public function index(Request $request)
    {
        $supplier = Supplier::where('status', 1)->get();
        $data = new Product;
        if(request()->ajax())
        {       
            if($request->supplier_id){
                return datatables()->of($data->readReorderBySupplier($request->supplier_id))
                ->make(true);   
            }
                    
        }

        return view('admin.reports.reorder-list-report', compact('supplier'));
    }

    public function previewReport($supplier_id){

        $data = $this->readReportData($supplier_id);
        $supplier = new Supplier;
        $supplier_name = $supplier->getSupplierNameByID($supplier_id);
    
        return $data->stream('reorder-list-' . $supplier_name . '.pdf');
    }
    
    public function downloadReport($supplier_id){

        $data = $this->readReportData($supplier_id);
        $supplier = new Supplier;
        $supplier_name = $supplier->getSupplierNameByID($supplier_id);
    
        return $data->download('reorder-list-' . $supplier_name . '.pdf');
    }

    public function readReportData($supplier_id) {
        $data = new Product;
        $supplier = new Supplier;

        $items = $data->readReorderBySupplier($supplier_id);
        $supplier_name = $supplier->getSupplierNameByID($supplier_id);

        return $this->setReportLayout($items, $supplier_name);
    }

    public function setReportLayout($items, $supplier_name) {
        $output = $this->reportLayout($items, $supplier_name);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        return $pdf->setPaper('A4', 'landscape');
    }

    public function reportLayout($items, $supplier_name){
        
        $output = '
        <div style="width:100%">
        <h1 style="text-align:center;">Val Construction Supply</h1>
        <h2 style="text-align:center;">Reorder List Report</h2>

        <p style="text-align:left;">As of: '. date("F j, Y") .'</p>
        <p style="text-align:left;">Supplier: <b> '. $supplier_name .' </b> </p>

        <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                      
            <thead>
                <tr>  
                    <th style="border: 1px solid;">Product Code</th>
                    <th style="border: 1px solid;">Name</th> 
                    <th style="border: 1px solid;">Unit</th>      
                    <th style="border: 1px solid;">Category</th>      
                    <th style="border: 1px solid;">Supplier</th>   
                    <th style="border: 1px solid;">Original price</th>               
                    <th style="border: 1px solid;">Stock</th>                                
                    <th style="border: 1px solid;">Reorder Point</th>   
            </thead>
            <tbody>
                ';
    
            if($items){
                foreach ($items as $data) {
                
                $output .='
                <tr>                             
                    <td style="border: 1px solid; padding:10px;">'. $data->product_code .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->description .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->unit .'</td>     
                    <td style="border: 1px solid; padding:10px;">'. $data->category .'</td>     
                    <td style="border: 1px solid; padding:10px;">'. $data->supplier .'</td>    
                    <td style="border: 1px solid; padding:10px;">'. $data->orig_price .'</td>     
                    <td style="border: 1px solid; padding:10px;">'. $data->qty.'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->reorder .'</td>  
                </tr>
                ';
                
                } 
            }
            else{
                echo "No data found";
            }
        
          
            $output .='
            </tbody>
        </table>
            </div>';
    
        return $output;
    }
}
