<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignmentstatuses')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'active',
                'displayName' => 'فعال',
                'description' => 'قابل مشاهده برای کاربران',
            ),
            array(
                'id' => '2',
                'name' => 'inactive',
                'displayName' => 'غیر فعال',
                'description' => 'غیر قابل مشاهده برای کاربران',
            )
        );

        DB::table('assignmentstatuses')->insert($data); // Query Builder
    }
}
