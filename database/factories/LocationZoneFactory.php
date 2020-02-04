<?php

use Faker\Generator as Faker;
use App\Models\LocationZone;

$factory->define(LocationZone::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
        'region_id'=>$faker->randomDigit,
        'zone_code'=>$faker->regexify('FO[0-9]{9}')  
    ];
});
