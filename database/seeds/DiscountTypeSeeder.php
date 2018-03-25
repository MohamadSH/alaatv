<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounttypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'percentage',
                'displayName' => 'درصد',
                'description' => 'تخفیف درصدی می باشد',
            ),
            array(
                'id' => '2',
                'name' => 'cost',
                'displayName' => 'مبلغ',
                'description' => 'تخفیف به صورت مبلغی',
            )
        );

        DB::table('discounttypes')->insert($data); // Query Builder
    }
}
