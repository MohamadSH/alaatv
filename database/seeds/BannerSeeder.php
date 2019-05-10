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
                'photo'            => '1000003403.jpg',
                'link'             => '/landing/5',
                'order'            => '1',
                'isEnable'         => '1',
            ],
            [
                'websitepage_id'   => optional($w)->id,
                'title'            => '',
                'shortDescription' => '',
                'photo'            => '1000003383.jpg',
                'link'             => '/landing/6',
                'order'            => '2',
                'isEnable'         => '1',
            ],
        ];
        DB::table('slideshows')
            ->insert($slideshows); // Query Builder
    }
}
