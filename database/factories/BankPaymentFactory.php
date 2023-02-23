<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BankPayment;
use Faker\Generator as Faker;

$factory->define(BankPayment::class, function (Faker $faker) {
    return [
        'payer_name' => $faker->name(),
        'ammount_paid' =>  $faker->unique()->randomNumber(4),
        'paid_at' => $faker->dateTimeBetween('-30 days')
    ];
});
