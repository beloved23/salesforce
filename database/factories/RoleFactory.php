<?php

use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;


$factory->define(Role::class, function (Faker $faker) {
    return [
        'name'=>'HR',
        'guard_name'=>'web',
    ];
});
