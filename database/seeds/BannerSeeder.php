<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $w          = \App\Websitepage::where('url', '/shop')
            ->first();
        $slideshows = [
            [
                'websitepage_id'   => optional($w)->id,
                'title'            => '',
                'shortDescription' => '',
                'photo'            => 'slide1_20170521212318.jpg',
                'link'             => 'https://sanatisharif.ir/product/227',
                'order'            => '1',
                'isEnable'         => '1',
            ],
            [
                'websitepage_id'   => optional($w)->id,
                'title'            => '',
                'shortDescription' => '',
                'photo'            => 'slide2_20170412111654.jpg',
                'link'             => 'https://sanatisharif.ir/c/6560',
                'order'            => '2',
                'isEnable'         => '1',
            ],
        ];
        DB::table('slideshows')
            ->insert($slideshows); // Query Builder
    }
}
