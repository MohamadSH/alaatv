<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentTypeInterrelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contenttypeinterrelations')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'parent-child',
                'displayName' => 'فرزند-والد',
                'description' => 'به طوری قرارداری اولی والد دومی می باشد',
            ),
        );

        DB::table('contenttypeinterrelations')->insert($data); // Query Builder
    }
}
