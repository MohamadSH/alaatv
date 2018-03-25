<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactionstatuses')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'transferredToPay',
                'displayName' => 'ارجاع به بانک',
                'description' => 'ارجاع داده شده با بانک جهت پرداخت',
            ),
            array(
                'id' => '2',
                'name' => 'unsuccessful',
                'displayName' => 'نا موفق',
                'description' => 'تراکنش بانکی ناموفق بوده است',
            ),
            array(
                'id' => '3',
                'name' => 'successful',
                'displayName' => 'موفق',
                'description' => 'تراکنش بانکی موفق بوده است',
            ),
            array(
                'id' => '4',
                'name' => 'pending',
                'displayName' => 'منتظر تایید',
                'description' => 'پرداخت انجام شده هنوز تایید نشده است',
            ),
            array(
                'id' => '5',
                'name' => 'archivedSuccessful',
                'displayName' => 'موفق بایگانی شده',
                'description' => 'تراکنش موفقی که بایگانی شده است',
            ),
            array(
                'id' => '6',
                'name' => 'unpaid',
                'displayName' => 'منتظر پرداخت',
                'description' => 'تراکنشی که قرار است در تاریخ معین شده پرداخت شود',
            ),
        );
        DB::table('transactionstatuses')->insert($data); // Query Builder
    }
}
