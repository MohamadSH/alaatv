<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckoutStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checkoutstatuses')
          ->delete();
        $data = [
            [
                'id'          => '1',
                'name'        => 'unpaid',
                'displayName' => 'تسویه نشده',
                'description' => 'تسویه نشده است',
            ],
            [
                'id'          => '2',
                'name'        => 'paid',
                'displayName' => 'تسویه شده',
                'description' => 'تسویه شده است',
            ],

        ];

        DB::table('checkoutstatuses')
          ->insert($data); // Query Builder
    }
}
