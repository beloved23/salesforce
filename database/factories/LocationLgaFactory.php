<?php

use Faker\Generator as Faker;
use App\Models\LocationLga;

$factory->define(LocationLga::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
        'area_id'=>$faker->randomDigit,
        'lga_code'=>$faker->regexify('LGA[0-9]{4}')  
    ];
});
