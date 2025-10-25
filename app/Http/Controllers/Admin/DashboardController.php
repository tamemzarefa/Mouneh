<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'users' => User::count(),
            'sellers_pending' => SellerProfile::where('approved', false)->count(),
            'products' => Product::count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            // Orders by status
            'orders_processing' => Order::whereIn('status', ['confirmed','shipped'])->count(),
            'orders_completed' => Order::where('status', 'delivered')->count(),
            // Transactions totals (paid only)
            'transactions_paid_total_cents' => (int) Transaction::where('status', 'paid')->sum('amount_cents'),
            'net_balance_cents' => (int) (Transaction::where('status', 'paid')
                ->select(DB::raw("SUM(CASE WHEN type='charge' THEN amount_cents WHEN type='refund' THEN -amount_cents WHEN type='payout' THEN -amount_cents ELSE 0 END) as net"))
                ->value('net') ?? 0),
        ];

        $latestOrders = Order::with(['buyer','seller'])
            ->latest()
            ->take(5)
            ->get();

        $latestPendingProducts = Product::with(['seller','brand'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'latestOrders' => $latestOrders,
            'latestPendingProducts' => $latestPendingProducts,
        ]);
    }
}
