<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ProcedureType;
use App\Model;
use App\Models\Procedure;
use Faker\Generator as Faker;

$factory->define(Procedure::class, function (Faker $faker) {
    return [
        'code' => NULL,
        'status' => NULL,
        'type' => ProcedureType::REQUEST,
    ];
});
