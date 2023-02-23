<?php

use App\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::truncate();

        Coupon::create([
            'code' => 'ABC123',
            'type' => 'fixed',
            'value' => 400,
            'max_usage' => 100,
            'expires_at' => Carbon::now()->addDay()
        ]);

        Coupon::create([
            'code' => 'PROVIDUS',
            'type' => 'percent',
            'percent_off' => 10,
            'payment_metadata' => '{"custom_filters":{"banks": ["101"]}}',
            'max_usage' => 100,
            'expires_at' => Carbon::now()->addYear()
        ]);

        Coupon::create([
            'code' => 'UNIONBANK',
            'type' => 'percent',
            'percent_off' => 20,
            'payment_metadata' => '{"custom_filters":{"banks": ["032"]}}',
            'max_usage' => 100,
            'expires_at' => Carbon::now()->addYear()
        ]);

        Coupon::create([
            'code' => 'DEF456',
            'type' => 'percent',
            'max_usage' => 10,
            'percent_off' => 50,
            'expires_at' => Carbon::now()->addDay()
        ]);
    }
}
