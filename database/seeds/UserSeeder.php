<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Okubanjo Oluwafunsho',
            'email' => 'signups@funsho.me',
            'role' => 'admin',
            'admin_role' => 'customer_service',
            'phone' => '1234567',
            'address' => 'Ikoyi',
            'location_id' => '1',
            'password' => Hash::make('devdevdev'),
        ]);

        User::create([
            'name' => 'Adedoyin Admin',
            'email' => 'doyin.admin@check-dc.com',
            'role' => 'admin',
            'admin_role' => 'super_admin',
            'phone' => '09011550391',
            'address' => '364, Borno Way, Yaba, Lagos',
            'location_id' => '1',
            'password' => Hash::make('devdevdev'),
        ]);

        User::create([
            'name' => 'Adedoyin Customer',
            'email' => 'doyin@check-dc.com',
            'role' => 'customer',
            'admin_role' => '',
            'phone' => '09011550391',
            'address' => '364, Borno Way, Yaba, Lagos',
            'location_id' => '1',
            'password' => Hash::make('devdevdev'),
        ]);

        User::create([
            'name' => 'Admin Tester',
            'email' => 'admin@smallchops.ng',
            'role' => 'admin',
            'admin_role' => 'super_admin',
            'phone' => '080123456789',
            'address' => '364, Borno Way, Yaba, Lagos',
            'location_id' => '1',
            'password' => Hash::make('tester2020'),
        ]);

        User::create([
            'name' => 'Uche',
            'email' => 'uche@smallchops.ng',
            'role' => 'admin',
            'admin_role' => 'super_admin',
            'phone' => '080123456789',
            'address' => '2nd Floor, 23 Jimoh Odutola St, Iganmu, Lagos',
            'location_id' => '1',
            'password' => Hash::make(';uche@smallchops2020'),
        ]);

        User::create([
            'name' => 'Michael',
            'email' => 'emeka@smallchops.ng',
            'role' => 'admin',
            'admin_role' => 'super_admin',
            'phone' => '08130630784',
            'address' => '2nd Floor, 23 Jimoh Odutola St, Iganmu, Lagos',
            'location_id' => '1',
            'password' => Hash::make('loveth24'),
        ]);

        User::create([
            'name' => 'Rebecca',
            'email' => 'doyin.admin@come.com',
            'role' => 'shop',
            'admin_role' => 'shop',
            'phone' => '09333333333',
            'address' => '364, Borno Way, Yaba, Lagos',
            'location_id' => '1',
            'password' => Hash::make('loveth24'),
        ]);

    }
}
