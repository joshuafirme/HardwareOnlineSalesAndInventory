<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use DateTime;

class VerifyCustomerController extends Controller
{
    public function index(Request $request)
    {
        $data = User::where('status', 0)->get();
        if(request()->ajax())
        { 
            return datatables()->of($data)
                ->addColumn('action', function($data){
                    $button = '<a class="btn btn-sm btn-view" data-id='. $data->id .'>
                    <i class="fa fa-eye"></i></a>';
                    return $button;
                })
                ->addColumn('status', function($data){
                    $status = "Verified";
                    if ($data->status == 0) {
                        $status = "Not verified";
                    }
                    return $status;
                })
                ->addColumn('created_at', function($data){
                    return $this->timeAgo($data->created_at);
                })
                ->rawColumns(['action', 'status'. 'created_at'])
                ->make(true);
        }

        return view('admin.verify-customer.index');
    }

    function timeAgo($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
