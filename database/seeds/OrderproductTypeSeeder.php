<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderproductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orderproducttypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'default',
                'displayName' => 'پیش فرض',
                'description' => 'نوع پیش فرض (معمولی)',
            ),
            array(
                'id' => '2',
                'name' => 'gift',
                'displayName' => 'هدیه',
                'description' => 'نوع هدیه',
            )
        );
        DB::table('orderproducttypes')->insert($data); // Query Builder
    }
}
