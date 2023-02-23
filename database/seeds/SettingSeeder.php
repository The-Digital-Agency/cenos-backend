<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'tax',
            'value' => '{"value": 12}'
        ]);
        
        Setting::create([
            'key' => 'delivery_span',
            'value' => '{"value": 70}'
        ]);
        
        Setting::create([
            'key' => 'sunday_delivery',
            'value' => '{"value": "17:00"}'
        ]);
    }
}
