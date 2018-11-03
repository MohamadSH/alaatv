<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhonetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phonetypes')
          ->delete();
        $data = [
            [
                'id'          => '1',
                'name'        => 'mobile',
                'displayName' => 'موبایل',
                'description' => 'شماره تلفن از نوع موبایل است',
            ],
            [
                'id'          => '2',
                'name'        => 'home',
                'displayName' => 'منزل',
                'description' => 'شماره تلفن از نوع ثابت است',
            ],
        ];

        DB::table('phonetypes')
          ->insert($data); // Query Builder
    }
}
