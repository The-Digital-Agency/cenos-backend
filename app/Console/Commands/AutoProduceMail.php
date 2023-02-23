<?php

namespace App\Console\Commands;

use App\Mail\ProduceMail;
use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class AutoProduceMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:producemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $orders = Order::where('order_status', 'confirmed')
        ->whereDate('delivery_date', Carbon::today())
        ->whereHas('deliveryWindow', function($q){
            $q->where('day', Carbon::now()->englishDayOfWeek);
            // ->whereTime('start_time', Carbon::now()->addMinutes(40)->format('H:i:s'));
        })
        ->get();

        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                Mail::to($order->billing_email)->send(new ProduceMail($order));
            }
        }
        return 0;
    }
}
