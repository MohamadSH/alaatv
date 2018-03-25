<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductFileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productfiletypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'pamphlet',
                'displayName' => 'جزوه',
                'description' => 'فایل از نوع جزوه است',
            ),
            array(
                'id' => '2',
                'name' => 'video',
                'displayName' => 'فیلم',
                'description' => 'فایل از نوع فیلم است',
            )
        );

        DB::table('productfiletypes')->insert($data); // Query Builder
    }
}
