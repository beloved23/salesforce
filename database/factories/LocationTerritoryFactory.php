<?php

use Faker\Generator as Faker;
use App\Models\LocationTerritory;

$factory->define(LocationTerritory::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
        'lga_id'=>$faker->randomDigit,
        'territory_code'=>$faker->regexify('AC[0-9]{9}')  
    ];
});
