<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paymentmethods')->delete();
        $data = array(
            array(
                'id' => '1',
                'name'=>'online',
                'displayName' => 'آنلاین',
                'description' => 'پرداخت به روش آنلاین',
            ),
            array(
                'id' => '2',
                'name' => 'ATM',
                'displayName' => 'عابر بانک',
                'description' => 'پرداخت از طریق عابر بانک',
            ),
            array(
                'id' => '3',
                'name' => 'POS',
                'displayName' => 'کارت خوان',
                'description' => 'پرداخت از طریق کارت خوان',
            ),
            array(
                'id' => '4',
                'name' => 'paycheck',
                'displayName' => 'چک بانکی',
                'description' => 'پرداخت با چک بانکی',
            )
//            ,
//            array(
//                'id' => '5',
//                'name' => 'cash',
//                'displayName' => 'نقدی',
//                    'description' => 'پرداخت به صورت نقدی',
//            )
        );

        DB::table('paymentmethods')->insert($data); // Query Builder
    }
}
