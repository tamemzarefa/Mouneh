<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentPaid extends Notification
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'payment_paid',
            'order_id' => $this->order->id,
            'seller_id' => $this->order->seller_id,
            'buyer_id' => $this->order->buyer_id,
            'amount_cents' => optional($this->order->payment)->amount_cents,
            'currency' => optional($this->order->payment)->currency,
            'message' => 'تم تأكيد الدفع لهذا الطلب',
        ];
    }
}
