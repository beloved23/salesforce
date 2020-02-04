<?php

use Faker\Generator as Faker;
use App\Models\LocationSite;

$factory->define(LocationSite::class, function (Faker $faker) {
    return [
        'site_id'=>$faker->regexify('siteid[0-9]{3}'),
        'address'=>$faker->address,
        'town_name'=>$faker->city,
        'site_code'=>$faker->regexify('SITE[0-9A-Z]{3}'),
        'is_active'=>true,
        'territory_id'=>$faker->randomDigit,
        'class_code'=>$faker->regexify('CLS[0-9]{4}'),
        'latitude'=>$faker->randomFloat($nbMaxDecimals = 7, $min = 6, $max = 7),
        'longitude'=>$faker->randomFloat($nbMaxDecimals = 7, $min = 3, $max = 4),
        'classification'=>$faker->text($maxNbChars = 20),
        'category'=>$faker->regexify('site category[0-9A-Z]{4}'),
        'type'=>$faker->regexify('site type[0-9A-Z]{4}'),
        'category_code'=>$faker->regexify('category code [0-9A-Z]{4}'),
        'hubcode'=>$faker->regexify('hub code [0-5A-Z]{3}'),
        'commercial_classification'=>$faker->regexify('commercial classification [0-5A-Z]{3}'),
    ];
});
