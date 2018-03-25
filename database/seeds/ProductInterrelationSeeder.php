<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductInterrelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productinterrelations')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'gift',
                'displayName' => 'هدیه',
                'description' => 'به طوری قرارداری دومی هدیه اولی می باشد',
            )
        );
        DB::table('productinterrelations')->insert($data); // Query Builder
    }
}
