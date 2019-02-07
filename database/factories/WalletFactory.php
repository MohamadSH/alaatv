<?php

use Faker\Generator as Faker;

$factory->define(App\Wallet::class, function (Faker $faker) {
    $wallettype = [
        1, //main
        2 //gift
    ];
    return [
        'wallettype_id' => $wallettype[rand(0,1)],
    ];
});
