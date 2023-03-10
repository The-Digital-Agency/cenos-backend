<?php

namespace App\Jobs;

use App\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SendRiderRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $company;
    private $rider_request;
    private $order;
    private $location;
    private $vendor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct()
    public function __construct($rider_request, $company, $order, $location, $vendor)
    {
        $this->company = $company;
        $this->rider_request = $rider_request;
        $this->order = $order;
        $this->location = $location;
        $this->vendor = $vendor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $send = send_sms('Order '.$this->order->id.' Pickup: '.$this->vendor->address.', Dropoff: '.$this->location->delivery_location.' Fee: '.$this->location->delivery_charge.' Click to accept: https://web.cenos.io/rider/request?rider='.$this->company->phone.'&req='.$this->rider_request, $this->company->phone);
        if($send) {
            Log::info('Request from '.$this->rider_request.' to '.$this->company->phone.' was sent successfully');
        } else {
            Log::info('Request from '.$this->rider_request.' to '.$this->company->phone.' was not sent');
        }
    }
}
