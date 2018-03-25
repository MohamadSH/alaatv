<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContacttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacttypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'simple',
                'displayName' => 'ساده',
                'description' => 'دفترچه تلفن از ساده است',
            ),

            array(
                'id' => '2',
                'name' => 'emergency',
                'displayName' => 'اضطراری',
                'description' => 'دفترچه تلفن از اضطراری است',
            )
        );

        DB::table('contacttypes')->insert($data); // Query Builder
    }
}
