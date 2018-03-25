<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerificationMessageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('verificationmessagestatuses')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'sent',
                'displayName' => 'ارسال شده',
                'description' => 'پیام حاوی کد به کاربر ارسال شده ا ست',
            ),
            array(
                'id' => '2',
                'name' => 'successful',
                'displayName' => 'موفق',
                'description' => 'اکانت کاربر با موفقیت توسط این کد تایید شد',
            ),
            array(
                'id' => '3',
                'name' => 'notDelivered',
                'displayName' => 'نرسیده',
                'description' => 'پیام به دست کاربر نرسیده است',
            ),
             array(
                 'id' => '4',
                 'name' => 'expired',
                 'displayName' => 'منقضی شده',
                 'description' => 'از تاریخ استفاده کد این پیام گذشته است',
             )
        );

        DB::table('verificationmessagestatuses')->insert($data); // Query Builder
    }
}
