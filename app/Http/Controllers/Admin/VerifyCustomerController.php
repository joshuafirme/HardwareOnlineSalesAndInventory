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
                    $button = '<a class="btn btn-sm btn-full-view" data-id='. $data->id .' 
                    data-image="/images/'.$data->identification_photo.'" data-selfie-image="/images/'.$data->selfie_with_identification_photo.'"
                    data-id-type="'.$data->id_type.'">
                    <i class="fa fa-eye"></i></a>';
                    return $button;
                })
                ->addColumn('status', function($data){
                    $status = '<span class="badge badge-success">Verified</span>';
                    if ($data->status == 0) {
                        $status = '<span class="badge badge-danger">Unverified</span>';
                    }
                    return $status;
                })
                ->addColumn('created_at', function($data){
                    return $this->timeAgo($data->created_at);
                })
                ->addColumn('identification_photo', function($data){
                    return '<img class="img-fluid" width="200"; heigth="200"; src="/images/'.$data->identification_photo.'">';
                })
                ->rawColumns(['action', 'status', 'created_at','identification_photo'])
                ->make(true);
        }

        return view('admin.verify-customer.index');
    }

    public function readAllVerifiedCustomer() 
    {
        $data = User::where('status', 1)
                    ->where('access_level', 5)->get();

        if(request()->ajax())
        { 
            return datatables()->of($data)
                ->addColumn('updated_at', function($data){
                    return $this->timeAgo($data->updated_at);
                })
                ->addColumn('status', function($data){
                    $status = '<span class="badge badge-success">Verified</span>';
                    if ($data->status == 0) {
                        $status = '<span class="badge badge-danger">Unverified</span>';
                    }
                    return $status;
                })
                ->addColumn('identification_photo', function($data){
                    return '<img class="img-fluid" width="200"; heigth="200"; src="/images/'.$data->identification_photo.'">';
                })
                ->rawColumns(['status', 'created_at','identification_photo'])
                ->make(true);
        }

    }

    public function verifyCustomer($user_id) {
        User::where('id', $user_id)->update(['status' => 1]);
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
