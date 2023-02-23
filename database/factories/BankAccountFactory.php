<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BankAccount;
use Faker\Generator as Faker;

$factory->define(BankAccount::class, function (Faker $faker) {
    return [
        'account_name' => $faker->name(),
        'account_number' => $faker->bankAccountNumber,
        'bank_name' => $faker->firstName() . ' Bank',
        'author_id' => 2
    ];
});
