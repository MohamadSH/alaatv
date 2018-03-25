<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsitePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('websitepages')->delete();
        $data = array(
            array(
                'url' => '/home',
                'displayName' => 'خانه',
            ),
            array(
                'url' => '/لیست-مقالات',
                'displayName' => 'مقالات',
            ),
        );
        DB::table('websitepages')->insert($data); // Query Builder
    }
}
