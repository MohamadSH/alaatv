<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributetypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'main',
                'description' => 'صفت اصلی',
            ),
            array(
                'id' => '2',
                'name' => 'extra',
                'description' => 'صفت غیر اصلی',
            ),
            array(
                'id' => '3',
                'name' => 'information',
                'description' => 'صفت توضیحی',
            )
        );

        DB::table('attributetypes')->insert($data); // Query Builder
    }
}
