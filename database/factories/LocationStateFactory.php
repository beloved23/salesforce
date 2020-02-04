<?php

use Faker\Generator as Faker;
use App\Models\LocationState;

$factory->define(LocationState::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
        'zone_id'=>$faker->randomDigit,
        'state_code'=>$faker->regexify('GO[0-9]{9}')  
    ];
});
