<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification
{
    use Queueable;

    public function __construct(public Order $order, public string $role)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'order_created',
            'order_id' => $this->order->id,
            'seller_id' => $this->order->seller_id,
            'buyer_id' => $this->order->buyer_id,
            'total_cents' => $this->order->total_cents,
            'currency' => $this->order->currency,
            'role' => $this->role, // 'buyer' or 'seller'
            'message' => $this->role === 'seller'
                ? 'تم إنشاء طلب جديد لمنتجاتك'
                : 'تم إنشاء طلبك بنجاح',
        ];
    }
}
