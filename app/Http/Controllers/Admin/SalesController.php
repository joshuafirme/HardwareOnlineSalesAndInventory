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
        $data = $data->readSales($request->date_from, $request->date_to, $request->order_from, $request->payment_method);
        if(request()->ajax())
        {       
            return datatables()->of($data)
            ->make(true); 
        }
    }

    public function computeTotalSales() {

        $input = Input::all();
        $date_from = $input['date_from'];
        $date_to = $input['date_to'];
        $order_from = $input['order_from'];
        $payment_method = $input['payment_method'];

        $data = new Sales;
        return $data->computeTotalSales($date_from, $date_to, $order_from, $payment_method);
    }
    
    public function previewSalesReport($date_from, $date_to, $order_from, $payment_method){

        $data = new Sales;
        $data = $data->readSales($date_from, $date_to, $order_from, $payment_method);
        $output = $this->generateSalesReport($data, $date_from, $date_to, $order_from, $payment_method);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->stream('Invoice-#');
    }

    public function downloadSalesReport($date_from, $date_to, $order_from, $payment_method){
        $data = new Sales;
        $data = $data->readSales($date_from, $date_to, $order_from, $payment_method);
        $output = $this->generateSalesReport($data, $date_from, $date_to, $order_from, $payment_method);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->download();
    }

    public function generateSalesReport($items, $date_from, $date_to, $order_from, $payment_method){
        $sales = new Sales;
        $total_sales = $sales->computeTotalSales($date_from, $date_to, $order_from, $payment_method);
        $output = '
        <!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">';

        $output .= $this->style();

        $output .='
        </style>
        </head>

        <body>

        <div style="width:100%">
        
        <h1 class="p-name">VAL CONSTRUCTION SUPPLY</h1>
        <div style="text-align:center;">Calzada Ermita Balayan, Batangas<div>
        <div style="text-align:center;">Contact number: 09238985588<div>
        <h2 style="text-align:center;">Sales Report</h2>
        <p style="text-align:left;">Total sales: <span>&#8369;</span> <b>'. number_format($total_sales,2,'.',',') .'</b></p>
        <p style="text-align:left;">Date: '. date("F j, Y", strtotime($date_from)) .' - '. date("F j, Y", strtotime($date_to)) .'</p>
        <p style="text-align:left;">Payment method: '.$payment_method.'</p>
        <p style="text-align:left;">Order from: '.$order_from.'</p>
    
        <table width="100%" style="border-collapse:collapse; border: 1px solid;">                
            <thead>
                <tr>
                    <th>Invoice #</th>  
                    <th>Product Code</th>    
                    <th>Name</th>   
                    <th>Unit</th>   
                    <th>Qty</th>  
                    <th>Amount</th>  
                    <th>Payment method</th>  
                    <th>Order from</th>   
                    <th>Date time</th>  
               
            <tbody>';

                if($items){
                    foreach ($items as $data) {
                    
                        $output .='
                    <tr class="align-text">                             
                        <td>'. $data->invoice_no .'</td>  
                        <td>'. $data->product_code .'</td>  
                        <td>'. $data->description .'</td>
                        <td>'. $data->unit .'</td>
                        <td>'. $data->qty .'</td>
                        <td><span>&#8369;</span>'. number_format($data->amount,2,'.',',') .'</td>   
                        <td>'. $data->payment_method .'</td>  
                        <td>'. $data->order_from .'</td>
                        <td>'. $data->date_time .'</td>
                    </tr>';
                
                } 
            }
            else{
                echo "No data found";
            }
            
            
        $output .='
 
        </tbody>
        </table>
    </div>


        </body>

        </html>
        
       ';

        return $output;
    }

    public function style() {
       return '
        @page { margin: 20px; }
        body{ font-family: sans-serif; }
        th{
            border: 1px solid;
        }
        td{
            font-size: 14px;
            border: 1px solid;
            padding-right: 2px;
            padding-left: 2px;
        }

        .p-name{
            text-align:center;
            margin-bottom:5px;
        }

        .address{
            text-align:center;
            margin-top:0px;
        }

        .p-details{
            margin:0px;
        }

        .ar{
            text-align:right;
        }

        .al{
            text-left:right;
        }

        .align-text{
            text-align:center;
        }

        .align-text td{
            text-align:center;
        }

        .w td{
            width:20px;
        }

   

        .b-text .line{
            margin-bottom:0px;
        }

        .b-text .b-label{
            font-size:12px;
            margin-top:-7px;
            margin-right:12px;
            font-style:italic;
        }

        .f-courier{
            font-family: monospace, sans-serif;
            font-size:14px;
        }

        span {
            font-family: DejaVu Sans; sans-serif;
        }
        
        ';
    }
}
