<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Order $order, public string $oldStatus, public string $newStatus)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'order_status_updated',
            'order_id' => $this->order->id,
            'seller_id' => $this->order->seller_id,
            'buyer_id' => $this->order->buyer_id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "تم تحديث حالة الطلب إلى {$this->newStatus}",
        ];
    }
}
