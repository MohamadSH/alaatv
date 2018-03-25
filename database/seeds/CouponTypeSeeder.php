<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupontypes')->delete();
        $data = array(
            array(
                'id' => '1',
                'displayName' => 'کلی',
                'name' => 'overall',
                'description' => 'کپن برای همه محصولات سبد'
            ),
            array(
                'id' => '2',
                'displayName' => 'جزئی',
                'name' => 'partial',
                'description' => 'کپن برای بعضی از محصولات سبد'
            )
        );
        DB::table('coupontypes')->insert($data); // Query Builder
    }
}
