<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewOrderPlaced extends Notification
{
    public function __construct(public $order) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'user_name' => $this->order->user->name ?? 'Guest',
            'total_amount' => $this->order->total_amount,
            'payment_method' => $this->order->payment_method,
            'message' => 'New order #'.$this->order->id.' has been placed',
        ];
    }
}
