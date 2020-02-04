<?php

use Faker\Generator as Faker;
use App\Models\LocationArea;

$factory->define(LocationArea::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
        'state_id'=>$faker->randomDigit,
        'area_code'=>$faker->regexify('AC[0-9]{9}')  
    ];
});
