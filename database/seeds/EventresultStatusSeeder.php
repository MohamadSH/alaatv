<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventresultStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eventresultstatuses')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'unseen',
                'displayName' => 'دیده نشده',
                'description' => 'هنوز دیده نشده',
            ),
            array(
                'id' => '2',
                'name' => 'published',
                'displayName' => 'منتشر شده',
                'description' => 'این نتیجه منتشر شده است',
            ),
            array(
                'id' => '3',
                'name' => 'unpublishable',
                'displayName' => 'منتشر نشود',
                'description' => 'نامناسب برای انتشار',
            ),
        );

        DB::table('eventresultstatuses')->insert($data); // Query Builder
    }
}
