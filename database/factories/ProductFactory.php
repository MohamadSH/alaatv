<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {

    $images = [
        'https://sanatisharif.ir/image/4/338/338/A19_20190109163129.jpg',
        'https://sanatisharif.ir/image/4/338/338/A18_20190115104024.jpg',
        'https://sanatisharif.ir/image/4/338/338/poster-zist%20200%20%282%29_20190103162949.jpg',
        'https://sanatisharif.ir/image/4/338/338/A21_20190115104041.jpg',
        'https://sanatisharif.ir/image/4/338/338/A17_20190108110031.jpg',
        'https://sanatisharif.ir/image/4/338/338/Jozve%20Moqari_20190120152947.jpg',
        'https://sanatisharif.ir/image/4/338/338/A20_20190115104001.jpg'
    ];

    $introVideo = [
        'https://cdn.sanatisharif.ir/upload/hamayeshBahar97Intro/aminiIntro.mp4',
        'https://cdn.sanatisharif.ir/upload/hamayeshBahar97Intro/nabakhteIntro.mp4',
        null,
        null,
        null
    ];

    /**
     * producttype_id [1=>simple, 2=>configurable, 3=>selectable]
     */

    /**
     * attributeset_id [
     *  1=>ordoo
     *  2=>hamayesh
     *  3=>fime studio
     *  4=>jozve
     *  5=>ketab
     *  6=>pishfarz
     * ]
     */

    return [
        'name'           => $faker->name,
        'basePrice'           => rand(1000,100000),
        'shortDescription'           => $faker->sentence,
        'longDescription'           => $faker->paragraph,
        'image'           => $images[rand(0,6)],
        'attributeset_id' => 3,
        'introVideo'           => $introVideo[rand(0,4)]
    ];
});
