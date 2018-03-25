<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paymentstatuses')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'unpaid',
                'displayName' => 'پرداخت نشده',
                'description' => 'هیچ مبلغی پرداخت نشده است',
            ),
            array(
                'id' => '2',
                'name' => 'indebted',
                'displayName' => 'پرداخت قسطی',
                'description' => 'بخشی از مبلغ پرداخت شده است',
            ),
            array(
                'id' => '3',
                'name' => 'paid',
                'displayName' => 'پرداخت شده',
                'description' => 'تمام مبلغ پرداخت شده است',
            ),
        );

        DB::table('paymentstatuses')->insert($data); // Query Builder
    }
}
