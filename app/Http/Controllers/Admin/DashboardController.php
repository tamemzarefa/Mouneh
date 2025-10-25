<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'users' => User::count(),
            'sellers_pending' => SellerProfile::where('approved', false)->count(),
            'products' => Product::count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('metrics'));
    }
}
