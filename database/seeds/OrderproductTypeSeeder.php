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
        DB::table('orderproducttypes')
          ->delete();
        $data = [
            [
                'id'          => '1',
                'name'        => 'default',
                'displayName' => 'پیش فرض',
                'description' => 'نوع پیش فرض (معمولی)',
                'created_at'  => '2018-01-29 12:26:31',
                'updated_at'  => '2018-01-29 12:26:31',
                'deleted_at'  => null,
            ],
            [
                'id'          => '2',
                'name'        => 'gift',
                'displayName' => 'هدیه',
                'description' => 'نوع هدیه',
                'created_at'  => '2018-01-29 12:26:31',
                'updated_at'  => '2018-01-29 12:26:31',
                'deleted_at'  => null,
            ],
        ];
        DB::table('orderproducttypes')
          ->insert($data); // Query Builder
    }
}
