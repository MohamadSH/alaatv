<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'admin',
                'display_name' => 'مدیر کل',
                'description' => 'اکانت مدیریتی اصلی سایت',
            ),
        );
        DB::table('roles')->insert($data); // Query Builder
    }
}
