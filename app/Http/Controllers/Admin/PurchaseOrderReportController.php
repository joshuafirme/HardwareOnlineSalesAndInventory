<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Supplier;

class PurchaseOrderReportController extends Controller
{
    public function index(Request $request)
    {
        $supplier = Supplier::where('status', 1)->get();
        $data = new PurchaseOrder;
        $data = $data->readPurchasedOrder($request->supplier_id, $request->date_from, $request->date_to);
        if(request()->ajax())
        {       
            return datatables()->of($data)
            ->make(true);            
        }
        return view('admin.reports.purchased-order-report', compact('supplier'));
    }

    public function previewReport($supplier_id, $date_from, $date_to){

        $data = new PurchaseOrder;
        $supplier = new Supplier;

        $items = $data->readPurchasedOrder($supplier_id, $date_from, $date_to);
        $supplier_name = $supplier->getSupplierNameByID($supplier_id);

        $output = $this->reportLayout($items, $supplier_name, $date_from, $date_to);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->stream($supplier_name .' PO-'.$date_from.'-to-'.$date_to.'.pdf');
    }
    
    public function downloadReport($supplier_id, $date_from, $date_to){

        $data = new PurchaseOrder;
        $supplier = new Supplier;

        $items = $data->readPurchasedOrder($supplier_id, $date_from, $date_to);
        $supplier_name = $supplier->getSupplierNameByID($supplier_id);

        $output = $this->reportLayout($items, $supplier_name, $date_from, $date_to);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->download($supplier_name .' PO-'.$date_from.'-to-'.$date_to.'.pdf');
    }

    public function reportLayout($items, $supplier_name, $date_from, $date_to){
        
        $output = '
        <div style="width:100%">
        <h1 style="text-align:center;">Val Construction Supply</h1>
        <h2 style="text-align:center;">Purchased Order Report</h2>

        <p style="text-align:left;">Date: '. date("F j, Y", strtotime($date_from)) .' - '. date("F j, Y", strtotime($date_to)) .'</p>
        <p style="text-align:left;">Supplier: <b> '. $supplier_name .' </b> </p>

        <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                      
            <thead>
                <tr>
                    <th style="border: 1px solid;">PO #</th>
                    <th style="border: 1px solid;">Product Code</th>     
                    <th style="border: 1px solid;">Description</th>   
                    <th style="border: 1px solid;">Supplier</th>  
                    <th style="border: 1px solid;">Unit</th>                                 
                    <th style="border: 1px solid;">Qty Order</th>        
                    <th style="border: 1px solid;">Amount</th>
                    <th style="border: 1px solid;">Date Order</th>   
            </thead>
            <tbody>
                ';
    
            if($items){
                foreach ($items as $data) {
                
                $output .='
                <tr>                             
                    <td style="border: 1px solid; padding:10px;">'. $data->po_no .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->product_code .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->description .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->supplier .'</td>    
                    <td style="border: 1px solid; padding:10px;">'. $data->unit .'</td>     
                    <td style="border: 1px solid; padding:10px;">'. $data->qty_order .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->amount .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->updated_at .'</td>  
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
