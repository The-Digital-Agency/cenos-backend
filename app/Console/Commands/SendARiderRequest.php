<?php

namespace App\Console\Commands;

use App\Company;
use App\Jobs\SendRiderRequest;
use App\Location;
use App\Order;
use App\Zone;
use DB;
use Illuminate\Console\Command;
use Log;

class SendARiderRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rider:request {order} {--queue=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Rider Request';

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
        $order = Order::find($this->argument('order'));
        $location = Location::find($order->location_id);
        $zone = Zone::find($location->zone_id);
        $rider_request = DB::table('request_rider')->where('order_id', '=', $order->id)->first();
        $companies = Company::where('zone_one', $location->zone_id)->orWhere('zone_two', $location->zone_id)->get();
        if (!empty($companies)) {
            foreach ($companies as $company) {
                SendRiderRequest::dispatch($rider_request->id, $company);
            }
        } else {
            Log::info('No rider in zone '.$zone->name);
        }
    }
}
