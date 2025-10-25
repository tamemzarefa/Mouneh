<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\PaymentPaid;
use App\Notifications\OrderStatusUpdated;

class OrderWorkflowService
{
    public function updateOrderStatus(Order $order, string $status, ?string $notes = null): Order
    {
        // Update order status
        $oldStatus = $order->status;
        $order->update(['status' => $status]);
        
        // Create status history record
        OrderStatus::create([
            'order_id' => $order->id,
            'status' => $status,
            'notes' => $notes,
            'updated_by' => Auth::id(),
        ]);

        // Handle stock management based on order status
        $this->handleStockManagement($order, $status);

        // Handle payment status based on order status
        if ($status === 'confirmed' && $order->payment && $order->payment->status === 'pending') {
            $this->markPaymentAsPaid($order);
        }

        // Notify buyer and seller about status change
        try {
            $fresh = $order->fresh(['buyer','seller']);
            if ($fresh?->buyer) { $fresh->buyer->notify(new OrderStatusUpdated($fresh, $oldStatus, $status)); }
            if ($fresh?->seller) { $fresh->seller->notify(new OrderStatusUpdated($fresh, $oldStatus, $status)); }
        } catch (\Throwable $e) {
            \Log::warning('OrderStatusUpdated notification failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
        }

        return $order->fresh();
    }

    public function updatePaymentStatus(Order $order, string $status, ?string $reference = null): Payment
    {
        if (!$order->payment) {
            throw new \Exception('No payment record found for this order');
        }

        $payment = $order->payment;
        $payment->update([
            'status' => $status,
            'reference' => $reference ?? $payment->reference,
            'paid_at' => $status === 'paid' ? now() : null,
        ]);

        // If payment is marked as paid
        if ($status === 'paid') {
            // Ensure we have a transaction record
            $this->ensurePaidTransaction($order);
            // Update order status if still pending
            if ($order->status === 'pending') {
                $this->updateOrderStatus($order, 'confirmed', 'تم تأكيد الدفع');
            }
            // Notify buyer and seller payment paid
            try {
                $fresh = $order->fresh(['buyer','seller','payment']);
                if ($fresh?->buyer) { $fresh->buyer->notify(new PaymentPaid($fresh)); }
                if ($fresh?->seller) { $fresh->seller->notify(new PaymentPaid($fresh)); }
            } catch (\Throwable $e) {
                \Log::warning('PaymentPaid notification failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            }
        }

        return $payment;
    }

    private function markPaymentAsPaid(Order $order): void
    {
        $order->payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Ensure we have a transaction record
        $this->ensurePaidTransaction($order);
    }

    /**
     * Create a paid transaction for the order if it does not already exist
     */
    private function ensurePaidTransaction(Order $order): void
    {
        if (!$order->payment) { return; }

        $exists = Transaction::where('order_id', $order->id)
            ->where('type', 'order_payment')
            ->exists();
        if ($exists) { return; }

        Transaction::create([
            'user_id' => $order->buyer_id,
            'order_id' => $order->id,
            'type' => 'order_payment',
            'amount_cents' => $order->total_cents ?? $order->payment->amount_cents,
            'currency' => $order->currency ?? $order->payment->currency ?? 'SYP',
            'status' => 'paid',
            'meta' => [
                'provider' => $order->payment->provider,
                'payment_id' => $order->payment->id,
                'reference' => $order->payment->reference ?? null,
            ],
        ]);
    }

    public function getOrderWorkflow(Order $order): array
    {
        $workflow = [
            'pending' => [
                'label' => 'معلق',
                'description' => 'الطلب في انتظار التأكيد',
                'next' => ['confirmed', 'cancelled'],
            ],
            'confirmed' => [
                'label' => 'مؤكد',
                'description' => 'تم تأكيد الطلب من قبل البائع',
                'next' => ['shipped', 'cancelled'],
            ],
            'shipped' => [
                'label' => 'تم الشحن',
                'description' => 'تم شحن الطلب',
                'next' => ['delivered'],
            ],
            'delivered' => [
                'label' => 'تم التسليم',
                'description' => 'تم تسليم الطلب بنجاح',
                'next' => [],
            ],
            'cancelled' => [
                'label' => 'ملغي',
                'description' => 'تم إلغاء الطلب',
                'next' => [],
            ],
        ];

        return $workflow[$order->status] ?? $workflow['pending'];
    }

    public function canUpdateToStatus(Order $order, string $newStatus): bool
    {
        $workflow = $this->getOrderWorkflow($order);
        return in_array($newStatus, $workflow['next']);
    }

    /**
     * Handle stock management based on order status changes
     */
    private function handleStockManagement(Order $order, string $status): void
    {
        // Load order items with products
        $order->load('items.product');

        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product) continue;

            switch ($status) {
                case 'confirmed':
                    // Reduce stock when order is confirmed
                    $this->reduceStock($product, $item->quantity);
                    break;
                
                case 'cancelled':
                    // Restore stock when order is cancelled
                    $this->restoreStock($product, $item->quantity);
                    break;
            }
        }
    }

    /**
     * Reduce product stock
     */
    private function reduceStock(Product $product, int $quantity): void
    {
        DB::transaction(function () use ($product, $quantity) {
            $product->lockForUpdate();
            $currentStock = $product->stock;
            
            if ($currentStock >= $quantity) {
                $product->update(['stock' => $currentStock - $quantity]);
            } else {
                // Log insufficient stock warning
                \Log::warning("Insufficient stock for product {$product->id}. Required: {$quantity}, Available: {$currentStock}");
            }
        });
    }

    /**
     * Restore product stock
     */
    private function restoreStock(Product $product, int $quantity): void
    {
        DB::transaction(function () use ($product, $quantity) {
            $product->lockForUpdate();
            $currentStock = $product->stock;
            $product->update(['stock' => $currentStock + $quantity]);
        });
    }
}
