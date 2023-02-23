<?php

use App\OrderDay;
use Illuminate\Database\Seeder;

class OrderDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            OrderDay::create([
                'day' => $day
            ]);
        }
    }
}
