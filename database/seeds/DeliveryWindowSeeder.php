<?php

use App\DeliveryWindow;
use Illuminate\Database\Seeder;

class DeliveryWindowSeeder extends Seeder
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
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '09:00',
                'end_time' => '11:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '10:00',
                'end_time' => '12:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '11:00',
                'end_time' => '13:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '12:00',
                'end_time' => '14:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '13:00',
                'end_time' => '15:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '14:00',
                'end_time' => '16:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '15:00',
                'end_time' => '17:00'
            ]);
            DeliveryWindow::create([
                'day' => $day,
                'start_time' => '16:00',
                'end_time' => '18:00'
            ]);
        }
    }
}
