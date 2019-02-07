<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'firstName'           => $faker->firstName,
        'lastName'           => $faker->lastName,
        'mobile'           => $faker->phoneNumber,
        'nationalCode'           => '0000000000',
        'password'       => '$2y$10$1miB41i89cT3XSYYCkRJbO.KHeIts.6sdRtkkSCZtqiGcmd4FqfSC',
        'email'          => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
        'userstatus_id' => 1,
    ];
});
