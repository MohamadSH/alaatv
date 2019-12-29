<?php

namespace App\HelpDesk\Database\seeds;

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

        $tickets = [
            [
                'id'          => 1,
                'subject'     => 'asdcad',
                'content'     => 'sdcsd',
                'user_id'     => 37191,
                'agent_id'    => 37189,
                'category_id' => 1,
                'priority_id' => 1,
                'status_id'   => 1,
            ],
            [
                'id'          => 2,
                'subject'     => 'saxas',
                'content'     => 'fyukfgu',
                'user_id'     => 37189,
                'agent_id'    => 37190,
                'category_id' => 2,
                'priority_id' => 2,
                'status_id'   => 2,
            ],
        ];
        DB::table('help_tickets')->insert($tickets);

        $data = [
            ['user_id' => $uid = User::inRandomOrder()->first()->id, 'category_id' => 1],
            ['user_id' => $uid, 'category_id' => 2],
            ['user_id' => $uid, 'category_id' => 3],
            ['user_id' => User::inRandomOrder()->first()->id, 'category_id' => 2],
            ['user_id' => User::inRandomOrder()->first()->id, 'category_id' => 3],
            ['user_id' => User::inRandomOrder()->first()->id, 'category_id' => 3],
            ['user_id' => User::inRandomOrder()->first()->id, 'category_id' => 3],
        ];
        \DB::table('help_categories_users')->insert($data);
    }
}
