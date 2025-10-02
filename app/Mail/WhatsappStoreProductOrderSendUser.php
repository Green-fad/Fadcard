<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WhatsappStoreProductOrderSendUser extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject(__('messages.mail.product_purchase'))
            ->markdown('emails.whatsapp_store_product_order_send_user')
            ->with(['data' => $this->data]);
    }
}
