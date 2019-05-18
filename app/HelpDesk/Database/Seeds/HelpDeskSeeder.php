<?php

namespace App\HelpDesk\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpDeskSeeder extends Seeder
{
    public function run()
    {
        $helpCategories = [
            [
                'id'    => 1,
                'name'  => 'سفارشات',
                'color' => '',
            ],
            [
                'id'    => 2,
                'name'  => 'مالی',
                'color' => '',
            ],
            [
                'id'    => 3,
                'name'  => 'فنی',
                'color' => '',
            ],
            [
                'id'    => 4,
                'name'  => 'محتوایی',
                'color' => '',
            ],
            [
                'id'    => 5,
                'name'  => 'دیگر',
                'color' => '',
            ],
        ];
        DB::table('help_categories')
            ->insert($helpCategories);
        //
        $status = [
            [
                'id'    => 1,
                'name'  => 'باز',
                'color' => '',
            ],
            [
                'id'    => 2,
                'name'  => 'در حال بررسی',
                'color' => '',
            ],
            [
                'id'    => 3,
                'name'  => 'حل شده',
                'color' => '',
            ],
        ];
        DB::table('help_statuses')
            ->insert($status);
        
        $priorities = [
            [
                'id'    => 1,
                'name'  => 'کم',
                'color' => '',
            ],
            [
                'id'    => 2,
                'name'  => 'متوسط',
                'color' => '',
            ],
            [
                'id'    => 3,
                'name'  => 'زیاد',
                'color' => '',
            ],
            [
                'id'    => 4,
                'name'  => 'بحرانی',
                'color' => '',
            ],
        ];
        DB::table('help_priorities')
            ->insert($priorities);
    }
}
