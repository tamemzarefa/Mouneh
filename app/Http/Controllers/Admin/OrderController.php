<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['buyer','seller','payment'])->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['buyer','seller','address','items.product','payment','statusHistory.updatedBy']);
        $workflowService = new OrderWorkflowService();
        $workflow = $workflowService->getOrderWorkflow($order);
        return view('admin.orders.show', compact('order', 'workflow'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,shipped,delivered,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000']
        ]);

        $workflowService = new OrderWorkflowService();
        
        if (!$workflowService->canUpdateToStatus($order, $data['status'])) {
            return back()->withErrors(['status' => 'لا يمكن تحديث الحالة إلى هذه القيمة']);
        }

        $workflowService->updateOrderStatus($order, $data['status'], $data['notes']);

        return back()->with('status', 'تم تحديث حالة الطلب');
    }

    public function updatePayment(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
            'reference' => ['nullable', 'string', 'max:120']
        ]);

        $workflowService = new OrderWorkflowService();
        
        try {
            $workflowService->updatePaymentStatus($order, $data['payment_status'], $data['reference']);
            return back()->with('status', 'تم تحديث حالة الدفع');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
