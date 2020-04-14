<?php

use Faker\Generator as Faker;
use Nikservik\Subscriptions\Models\Tariff;

$factory->define(Tariff::class, function (Faker $faker) {
    return [
        'short_name' => $faker->city, 
        'name' => $faker->country,
        'price' => $faker->randomFloat(2, 0, 1000), 
        'currency' => 'RUB', 
        'period' => '1M',
        'prolongable' => $faker->boolean,
    ];
});
