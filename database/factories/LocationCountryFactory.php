<?php

use Faker\Generator as Faker;
use App\Models\LocationCountry;

$factory->define(LocationCountry::class, function (Faker $faker) {
    return [
        'name'=>$faker->country,
        'country_code'=>$faker->regexify('[A-Z]+[0-9]{3}')
    ];
});
