<?php
// app/Mail/AdminOrderNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class AdminOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Nouvelle commande #' . $this->order->order_number . ' - ' . number_format($this->order->total, 2, ',', ' ') . '€')
                    ->replyTo($this->order->billing_email, $this->order->full_name)
                    ->view('emails.admin-order-notification');
    }
}