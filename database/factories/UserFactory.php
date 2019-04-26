<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'firstName'         => $faker->firstName,
        'lastName'          => $faker->lastName,
        'mobile'            => $faker->phoneNumber,
        'nationalCode'      => '0000000000',
        'password'          => '$2y$10$1miB41i89cT3XSYYCkRJbO.KHeIts.6sdRtkkSCZtqiGcmd4FqfSC',
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'remember_token'    => Str::random(10),
        'userstatus_id'     => 1,
    ];
});
