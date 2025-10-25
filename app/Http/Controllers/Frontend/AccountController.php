<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $myProducts = Product::where('seller_id', $user->id)
            ->latest()->get(['id','title_ar','price_cents','currency','stock','status','is_active']);
        $myOrders = Order::with(['items.product'])
            ->where('buyer_id', $user->id)
            ->latest()->get();
        return view('frontend.account', compact('user','myProducts','myOrders'));
    }

    public function edit(Request $request): View
    {
        $user = $request->user();
        return view('frontend.account-edit', compact('user'));
    }

    public function orders(Request $request): View
    {
        $user = $request->user();
        $orders = Order::with(['seller', 'items.product', 'payment'])
            ->where('buyer_id', $user->id)
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.index', compact('orders'));
    }

    public function showOrder(Request $request, Order $order): View
    {
        $user = $request->user();
        
        // Ensure user can only view their own orders
        if ($order->buyer_id !== $user->id) {
            abort(403);
        }
        
        $order->load(['seller', 'address', 'items.product', 'payment']);
        return view('frontend.orders.show', compact('order'));
    }

    public function sellerDashboard(Request $request): View
    {
        $user = $request->user();
        
        // Get product statistics
        $approvedProducts = Product::where('seller_id', $user->id)->where('status', 'approved')->count();
        $pendingProducts = Product::where('seller_id', $user->id)->where('status', 'pending')->count();
        $rejectedProducts = Product::where('seller_id', $user->id)->where('status', 'rejected')->count();
        
        // Get recent approvals (last 5)
        $recentApprovals = Product::where('seller_id', $user->id)
            ->where('status', 'approved')
            ->with('approver')
            ->latest('approved_at')
            ->limit(5)
            ->get();
        
        // Get all user's products
        $myProducts = Product::where('seller_id', $user->id)
            ->with('approver')
            ->latest()
            ->get();
        
        return view('frontend.seller-dashboard', compact(
            'approvedProducts', 
            'pendingProducts', 
            'rejectedProducts', 
            'recentApprovals', 
            'myProducts'
        ));
    }
}
