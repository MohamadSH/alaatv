<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBonStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userbonstatuses')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'active',
                'displayName' => 'فعال',
                'description' => 'کاربر از بن استفاده نکرده و آماده استفاده است',
            ),
            array(
                'id' => '2',
                'name' => 'expired',
                'displayName' => 'باطل شده',
                'description' => 'بن کاربر قبل از استفاده غیر فعال(باطل) شده است ',
            ),
            array(
                'id' => '3',
                'name' => 'used' ,
                'displayName' => 'استفاده کرده',
                'description' => 'کاربر از بن خود با موفقیت استفاده کرده است',
            ),
        );

        DB::table('userbonstatuses')->insert($data); // Query Builder
    }
}
