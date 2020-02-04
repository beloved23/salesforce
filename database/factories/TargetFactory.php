<?php

use Faker\Generator as Faker;
use App\Models\Target;

$factory->define(Target::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->randomDigit,
        'owner'=>$faker->randomDigit,
        'gross_ads'=>$faker->randomElement($array = array (3000,2500,4000)),
        'decrement'=>$faker->randomElement($array = array (3000,2500,4000)),
        'kit'=>$faker->randomElement($array = array (1000,3500,5000)),
        'tag'=>$faker->randomElement($array = array ('Xmas Bonus','Jumia','black Friday')) ,
    ];
});
