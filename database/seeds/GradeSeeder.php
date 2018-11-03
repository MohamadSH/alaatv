<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')
          ->delete();
        $data = [
            [
                'id'          => '1',
                'name'        => 'dahom',
                'displayName' => 'دهم',
                'description' => 'مقطع دهم نظام آموزشی جدید',
            ],
            [
                'id'          => '2',
                'name'        => 'yazdahom',
                'displayName' => 'یازدهم',
                'description' => 'مقطع یازدهم نظام آموزشی جدید',
            ],
            [
                'id'          => '3',
                'name'        => 'konkoor',
                'displayName' => 'کنکوری',
                'description' => 'مقطع کنکور(دوازدهم نظام آموزشی جدید)',
            ],
        ];

        DB::table('grades')
          ->insert($data); // Query Builder
    }
}
