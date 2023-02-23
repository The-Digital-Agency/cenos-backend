<?php

use App\BankPayment;
use Illuminate\Database\Seeder;

class BankPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BankPayment::class, 50)->create();
    }
}
