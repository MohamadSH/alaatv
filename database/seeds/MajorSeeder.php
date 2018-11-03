<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('majors')
          ->delete();
        $data = [
            [
                'id'          => '1',
                'name'        => 'ریاضی',
                'description' => 'رشته ریاضی مقطع متوسطه',
            ],
            [
                'id'          => '2',
                'name'        => 'تجربی',
                'description' => 'رشته تجربی مقطع متوسطه',
            ],
            [
                'id'          => '3',
                'name'        => 'انسانی',
                'description' => 'رشته انسانی مقطع متوسطه',
            ],
        ];

        DB::table('majors')
          ->insert($data); // Query Builder
    }
}
