<?php

use Illuminate\Database\Seeder;

class BlocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blockables')->delete();
        DB::table('blocks')->delete();
        $data = [
            [
                'id' => 1,
                'title' => 'کنکور نظام جدید',
                'tags' => json_encode(["نظام_آموزشی_جدید", "کنکور"], JSON_UNESCAPED_UNICODE),
                'order' => 1,
                'enable' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class' => 'konkoor'
            ],
            [
                'id' => 2,
                'title' => 'کنکور نظام قدیم',
                'tags' => json_encode(["نظام_آموزشی_قدیم", "کنکور"], JSON_UNESCAPED_UNICODE),
                'order' => 2,
                'enable' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class' => 'konkoor'
            ],
            [
                'id' => 3,
                'title' => 'یازدهم',
                'tags' => json_encode(["یازدهم"], JSON_UNESCAPED_UNICODE),
                'order' => 3,
                'enable' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class' => 'yazdahom'
            ],
            [
                'id' => 4,
                'title' => 'دهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),
                'order' => 4,
                'enable' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class' => 'dahom'
            ],
            [
                'id' => 5,
                'title' => 'همایش رایگان',
                'tags' => json_encode(["همایش"], JSON_UNESCAPED_UNICODE),
                'order' => 5,
                'enable' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class' => 'hamayesh'
            ],
        ];
        DB::table('blocks')->insert($data); // Query Builder
        \App\Block::find(1)->sets()->saveMany(\App\Contentset::find([202, 208, 214, 217, 216, 191, 220, 221]));
        \App\Block::find(2)->sets()->saveMany(\App\Contentset::find([195, 170, 37, 179, 187, 183, 189, 186, 188, 180, 191, 114, 112, 137, 121, 175, 50, 152]));
        \App\Block::find(3)->sets()->saveMany(\App\Contentset::find([218, 204, 181, 194, 193, 171, 178, 182, 169, 170, 192]));
        \App\Block::find(4)->sets()->saveMany(\App\Contentset::find([203, 215, 185, 190, 153, 172, 137, 177, 170, 168, 184, 174]));
        \App\Block::find(5)->sets()->saveMany(\App\Contentset::find([163, 157, 159, 160, 162, 164, 155, 150]));
    }
}
