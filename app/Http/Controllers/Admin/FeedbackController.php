<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use DB;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $data = Feedback::select('feedback.*', 'feedback.created_at as created_at', 'U.*')
            ->leftJoin('users as U', 'U.id', '=', 'feedback.user_id')
            ->whereBetween(DB::raw('DATE(feedback.created_at)'), [$request->date_from, $request->date_to])
            ->get();

        if(request()->ajax())
        {
            return datatables()->of($data)       
                ->addColumn('created_at', function($p)
                {
                    $date_time = date('F d, Y h:i A', strtotime($p->created_at));
                    return $date_time;
                })
                ->rawColumns(['created_at'])
                ->make(true);            
        }
        return view('admin.utilities.feedback.index');
    }
}
