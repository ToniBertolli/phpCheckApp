<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Instance;
use Faker\Generator as Faker;

$factory->define(Instance::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'logo' => 'logo.png'
    ];
});
