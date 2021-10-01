<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use Input;
use DB;

class StockAdjustmentReportController extends Controller
{
    public function index(Request $request)
    {
        $product = new StockAdjustment;
        $data = $product->readByDate($request->date_from, $request->date_to);
        if(request()->ajax())
        { 
            return datatables()->of($data)
                ->make(true);
        }

        return view('admin.reports.stock-adjustment-report');
    }

    public function pdf($date_from, $date_to){

        $product = new StockAdjustment;
        $items = $product->readByDate($date_from, $date_to);
        $output = $this->reportLayout($items, $date_from, $date_to);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->stream('Stock Adjustment'.$date_from.' - '.$date_to);
    }
    
    public function downloadPDF($date_from, $date_to){
        $data = Input::all();
        $product = new StockAdjustment;
        $items = $product->readByDate($date_from, $date_to);
        $output = $this->reportLayout($items, $date_from, $date_to);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->download();
    }

    public function reportLayout($items, $date_from, $date_to){
        
        $output = '
        <div style="width:100%">
        <p style="text-align:right;">Date: '. date("F j, Y", strtotime($date_from)) .' - '. date("F j, Y", strtotime($date_to)) .'</p>
        <h1 style="text-align:center;">Val Construction Supply</h1>
        <h2 style="text-align:center;">Stock Adjustment Report</h2>
    
        <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                      
            <thead>
                <tr>
                    <th style="border: 1px solid;">Product Code</th>
                    <th style="border: 1px solid;">Description</th> 
                    <th style="border: 1px solid;">Unit</th>    
                    <th style="border: 1px solid;">Category</th>
                    <th style="border: 1px solid;">Supplier</th>  
                    <th style="border: 1px solid;">Qty adjusted</th>   
                    <th style="border: 1px solid;">Action</th>   
                    <th style="border: 1px solid;">Remarks</th>
                    <th style="border: 1px solid;">Date adjusted</th>      
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
                    <td style="border: 1px solid; padding:10px;">'. $data->qty_adjusted .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->action .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->remarks .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->date_adjusted .'</td>  
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
