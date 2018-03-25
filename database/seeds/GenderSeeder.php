<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'آقا',
                'description' => 'جنست مذکر',
            ),
            array(
                'id' => '2',
                'name' => 'خانم',
                'description' => 'جنسست مونث',
            )
        );

        DB::table('genders')->insert($data); // Query Builder
    }
}
