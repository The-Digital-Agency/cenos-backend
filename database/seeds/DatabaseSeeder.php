<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CouponsSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(DeliveryWindowSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(OrderDaysSeeder::class);
        $this->call(OrderDateSeeder::class);
    }
}
