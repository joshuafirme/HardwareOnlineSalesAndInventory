<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $walk_in_sales = Sales::whereRaw('Date(created_at) = CURDATE()')->where('order_from', 'walk-in')->sum('amount');
        $online_sales = Sales::whereRaw('Date(created_at) = CURDATE()')->where('order_from', 'online')->sum('amount');
        $orders_today = Order::whereRaw('Date(created_at) = CURDATE()')->count('order_no');
        $total_users = User::count('id');
        return view('admin.dashboard', compact('walk_in_sales', 'online_sales', 'orders_today', 'total_users'));
    }
}
