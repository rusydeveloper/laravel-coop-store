<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSubmit extends Mailable
{
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'rusy@nectico.com';
        $subject = 'Ada pesanan baru!';
        $name = 'Admin Belanja Bersama Koperasi';

        return $this->view('emails.order_submit')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([ 'cooperative' => $this->data['cooperative'], 'name' => $this->data['name'], 'phone' => $this->data['phone'], 'email' => $this->data['email'], 'address' => $this->data['address'], 'order' => $this->data['order'] ]);
    }
}
