<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReturn;

class ProductReturnReportController extends Controller
{
    public function index(Request $request)
    {
        $data = new ProductReturn;
        $data = $data->readProductReturn($request->date_from, $request->date_to);
        if(request()->ajax())
        {       
            return datatables()->of($data)
            ->addColumn('selling_price', function($product)
            {
                $button = ' <div class="text-right">'.$product->selling_price.'</div>';
               
                return $button;
            })
            ->rawColumns(['selling_price'])
            ->make(true); 
        }
        return view('admin.reports.product-return-report');
    }

    public function previewReport($date_from, $date_to){

        $data = new ProductReturn;

        $items = $data->readProductReturn($date_from, $date_to);

        $output = $this->reportLayout($items, $date_from, $date_to);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->stream('returns-'.$date_from.'-to-'.$date_to.'.pdf');
    }
    
    public function downloadReport($date_from, $date_to){

        $data = new ProductReturn;

        $items = $data->readProductReturn($date_from, $date_to);

        $output = $this->reportLayout($items, $date_from, $date_to);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->download('returns-'.$date_from.'-to-'.$date_to.'.pdf');
    }

    public function reportLayout($items, $date_from, $date_to){
        
        $output = '
        <div style="width:100%">
        <h1 style="text-align:center;">Val Construction Supply</h1>

        <div style="text-align:center;">Calzada Ermita Balayan, Batangas<div>
        <div style="text-align:center;">Contact number: 09238985588<div>
        <h2 style="text-align:center;">Product Returned Report</h2>

        <p style="text-align:left;">Date: '. date("F j, Y", strtotime($date_from)) .' - '. date("F j, Y", strtotime($date_to)) .'</p>
        <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                      
            <thead>
                <tr>  
                    <th style="border: 1px solid;">Invoice #</th>
                    <th style="border: 1px solid;">Product Code</th>   
                    <th style="border: 1px solid;">Name</th>   
                    <th style="border: 1px solid;">Unit</th>   
                    <th style="border: 1px solid;">Selling price</th>     
                    <th style="border: 1px solid;">Qty returned</th>     
                    <th style="border: 1px solid;">Reason</th>   
                    <th style="border: 1px solid;">Date time Return</th> 
            </thead>
            <tbody>
                ';
    
            if($items){
                foreach ($items as $data) {
                
                $output .='
                <tr>                             
                    <td style="border: 1px solid; padding:10px;">'. $data->invoice_no .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->product_code .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->description .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->unit .'</td>   
                    <td style="border: 1px solid; padding:10px;">'. $data->selling_price .'</td>    
                    <td style="border: 1px solid; padding:10px;">'. $data->qty .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->reason .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->created_at .'</td>  
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
