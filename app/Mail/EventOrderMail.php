<?php

namespace App\Mail;

use App\EventOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eventOrder;
    public $forAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EventOrder $eventOrder, $forAdmin = false)
    {
        $this->eventOrder = $eventOrder;
        $this->forAdmin = $forAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->forAdmin) {
            return $this->from('hello@smallchops.ng')
                ->subject('New Event-Order Request')
                ->view('emails.event_order_email_admin');
        } else {
            return $this->from('hello@smallchops.ng')
                ->subject('Thank you for your request.')
                ->view('emails.event_order_email');
        }
    }
}
