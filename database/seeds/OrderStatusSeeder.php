<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orderstatuses')->delete();

        $data = array(
            array(
                'id' => '1',
                'name' => 'open',
                'displayName' => 'باز',
                'description' => 'این سفارش توسط کاربر باز شده است و در حال حاضر باز و قابل استفاده می باشد',
            ),
            array(
                'id' => '2',
                'name' => 'closed',
                'displayName' => 'ثبت نهایی',
                'description' => 'مراحل این سفارش با موفقیت به اتمام رسیده و بسته شده است',
            ),
            array(
                'id' => '3',
                'name' => 'canceled',
                'displayName' => 'لغو شده',
                'description' => 'این سفارش توسط کاربر لغو شده است',
            ),
            array(
                'id' => '4',
                'name' => 'openByAdmin',
                'displayName' => 'باز مدیریتی',
                'description' => 'سفارش توسط مسئول سایت باز شده است',
            ),
            array(
                'id' => '5',
                'name' => 'posted',
                'displayName' => 'تحویل پست شده',
                'description' => 'سفارش تحویل پست داده شده',
            ),
            array(
                'id' => '6',
                'name' => 'refunded',
                'displayName' => 'بازگشت هزینه',
                'description' => 'هزینه ی سفارش به دلایلی مانند لغو سفارش از طرف مشتری بازگردانده شده است',
            ),
            array(
                'id' => '7',
                'name' => 'readyToPost',
                'displayName' => 'آماده به ارسال',
                'description' => 'مرسوله ی سفارش آماده برای ارسال می باشد',
            ),
        );

        DB::table('orderstatuses')->insert($data); // Query Builder

    }
}
