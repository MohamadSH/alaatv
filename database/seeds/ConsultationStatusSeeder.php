<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('consultationstatuses')->delete();
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

        DB::table('consultationstatuses')->insert($data); // Query Builder
    }
}
