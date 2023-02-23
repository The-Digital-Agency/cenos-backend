<?php

namespace App\Mail;

use App\CorporateOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorporateOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $corporateOrder;
    public $forAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CorporateOrder $corporateOrder, $forAdmin = false)
    {
        $this->corporateOrder = $corporateOrder;
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
                ->subject('New Corporate-Order Request')
                ->view('emails.corporate_order_email_admin');
        } else {
            return $this->from('hello@smallchops.ng')
                ->subject('Thank you for your request.')
                ->view('emails.corporate_order_email');
        }


        return $this->from('hello@smallchops.ng')
            ->subject('Thank you for your request.')
            ->view('emails.corporate_order_email');
    }
}
