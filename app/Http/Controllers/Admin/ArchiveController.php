<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use DB;

class ArchiveController extends Controller
{
   public function index() {
        return view('admin.utilities.archive.index');
   }

   public function readArchiveProduct()
   {
        $product = new Product;
        $product = $product->readArchiveProduct(request()->date_from, request()->date_to);
        if(request()->ajax())
        {
            return datatables()->of($product)       
            ->addColumn('action', function($product)
            {
                $button = ' <a class="btn btn-sm btn-restore" data-id="'. $product->id .'"><i class="fa fa-recycle"></i></a>';
                return $button;
            })
            ->addColumn('updated_at', function($p)
            {
                $date_time = date('F d, Y h:i A', strtotime($p->updated_at));
                return $date_time;
            })
            ->rawColumns(['action', 'updated_at'])
            ->make(true);       
        }
   }

   public function readArchiveSales()
   {
        $product = DB::table('sales as S')
        ->select('S.*', 'P.*', 'S.qty', 'S.id as id', 'S.updated_at',
                'U.name as unit', 
                DB::raw('S.created_at as date_time'))
        ->leftJoin('product as P', DB::raw('CONCAT(P.prefix, P.id)'), '=', 'S.product_code')
        ->leftJoin('unit as U', 'U.id', '=', 'P.unit_id')
        ->where('S.status', -1)
        ->orderBy   ('S.invoice_no', 'desc')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($product)       
            ->addColumn('action', function($product)
            {
                $button = ' <a class="btn btn-sm btn-restore" data-id="'. $product->id .'"><i class="fa fa-recycle"></i></a>';
                return $button;
            })
            //->rawColumns(['action', 'updated_at'])
            ->make(true);       
        }
   }

   public function readArchiveUsers()
   {
        $user = User::whereBetween(DB::raw('DATE(users.updated_at)'), [request()->date_from, request()->date_to])
        ->where('status', -1)->get();
        if(request()->ajax())
        {
            return datatables()->of($user)       
            ->addColumn('action', function($user)
            {
                $button = ' <a class="btn btn-sm btn-restore" data-id="'. $user->id .'"><i class="fa fa-recycle"></i></a>';
                return $button;
            })
            ->addColumn('updated_at', function($p)
            {
                $date_time = date('F d, Y h:i A', strtotime($p->updated_at));
                return $date_time;
            })
            ->addColumn('access_level', function($p)
            {
                $access_level = "";
                switch($p->access_level) {
                    case 1:
                        $access_level = "Sales Clerk";
                        break;
                    case 2:
                        $access_level = "Inventory Clerk";
                        break;
                    case 3:
                        $access_level = "Owner";
                        break;
                    case 4:
                        $access_level = "Administrator";
                        break;
                    case 5:
                        $access_level = "Customer";
                        break;
                }

                return $access_level;
            })
            ->rawColumns(['action', 'updated_at', 'access_level'])
            ->make(true);       
        }
   }

   public function restore($id)
   {
       if (request()->object == 'product') {
            Product::where('id', $id)
            ->update([
                'status' => 1,
            ]);
       }
       else { 
            User::where('id', $id)
            ->update([
                'status' => 1,
            ]);
       }
   }
}
