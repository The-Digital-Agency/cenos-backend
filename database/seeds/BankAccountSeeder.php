<?php

use App\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankAccount::create([
            'account_name' => 'Primary Account',
            'account_number' => '0123456789',
            'bank_name' => 'First Bank',
            'author_id' => 2
        ]);

        factory(BankAccount::class, 50)->create();
    }
}
