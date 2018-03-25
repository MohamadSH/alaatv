<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('producttypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'displayName' => 'ساده',
                'name' => 'simple',
                'description' => 'کالای بدون انواع صفت مانند رنگهای مختلف',
            ),
            array(
                'id' => '2',
                'displayName' => 'قابل پیکربندی',
                'name' => 'configurable',
                'description' => 'کالای دارای انواع مختلف صفت مانند رنگ های مختلف',
            ),
            array(
                'id' => '3',
                'displayName' => 'قابل انتخاب',
                'name' => 'selectable',
                'description' => 'کالا قابل انتخاب از بین کالاهای زیر مجموعه خود است',
            ),
        );
        DB::table('producttypes')->insert($data); // Query Builder
    }
}
