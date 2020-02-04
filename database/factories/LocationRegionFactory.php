<?php

use Faker\Generator as Faker;
use App\Models\LocationRegion;

$factory->define(LocationRegion::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
        'country_id'=>$faker->randomDigit,
        'region_code'=>$faker->regexify('[A-Z]+[0-9]{9}')   
    ];
});
