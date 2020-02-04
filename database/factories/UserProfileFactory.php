<?php

use Faker\Generator as Faker;
use App\Models\UserProfile;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->randomDigit,
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'profile_picture'=>'13b73edae8443990be1aa8f1a483bc27.jpg',
        'auuid'=>$faker->randomNumber($nbDigits = 7),
        'phone_number'=>$faker->phoneNumber,
    ];
});
