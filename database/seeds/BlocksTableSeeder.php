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
        DB::table('blockables')
          ->delete();
        DB::table('blocks')
          ->delete();
        //HomePage
        $data = [
            [
                'id'         => 1,
                'title'      => 'کنکور نظام جدید',
                'tags'       => json_encode([
                                                "نظام_آموزشی_جدید",
                                                "کنکور",
                                            ], JSON_UNESCAPED_UNICODE),
                'order'      => 1,
                'enable'     => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'konkoor2',
                'type'       => 1,
            ],
            [
                'id'         => 2,
                'title'      => 'کنکور نظام قدیم',
                'tags'       => json_encode([
                                                "نظام_آموزشی_قدیم",
                                                "کنکور",
                                            ], JSON_UNESCAPED_UNICODE),
                'order'      => 2,
                'enable'     => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'konkoor1',
                'type'       => 1,
            ],
            [
                'id'         => 3,
                'title'      => 'پایه یازدهم',
                'tags'       => json_encode(["یازدهم"], JSON_UNESCAPED_UNICODE),
                'order'      => 3,
                'enable'     => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'yazdahom',
                'type'       => 1,
            ],
            [
                'id'         => 4,
                'title'      => 'پایه دهم',
                'tags'       => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),
                'order'      => 4,
                'enable'     => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'dahom',
                'type'       => 1,
            ],
            [
                'id'         => 5,
                'title'      => 'همایش رایگان',
                'tags'       => json_encode(["همایش"], JSON_UNESCAPED_UNICODE),
                'order'      => 5,
                'enable'     => 1,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'hamayesh',
                'type'       => 1,
            ],
        ];
        DB::table('blocks')
          ->insert($data); // Query Builder
        \App\Block::find(1)
                  ->sets()
                  ->attach(\App\Contentset::find([
                                                       202,
                                                       208,
                                                       214,
                                                       217,
                                                       216,
                                                       191,
                                                       220,
                                                       221,
                                                   ]));
        \App\Block::find(2)
                  ->sets()
                  ->attach(\App\Contentset::find([
                                                       195,
                                                       170,
                                                       37,
                                                       179,
                                                       187,
                                                       189,
                                                       186,
                                                       188,
                                                       180,
                                                       191,
                                                       114,
                                                       112,
                                                       121,
                                                       175,
                                                       50,
                                                       152,
                                                   ]));
        \App\Block::find(3)
                  ->sets()
                  ->attach(\App\Contentset::find([
                                                       218,
                                                       204,
                                                       181,
                                                       194,
                                                       171,
                                                       169,
                                                       170,
                                                       192,
                                                   ]));
        \App\Block::find(4)
                  ->sets()
                  ->attach(\App\Contentset::find([
                                                       203,
                                                       215,
                                                       185,
                                                       190,
                                                       172,
                                                       137,
                                                       177,
                                                       170,
                                                       168,
                                                       184,
                                                       174,
                                                   ]));
        \App\Block::find(5)
                  ->sets()
                  ->attach(\App\Contentset::find([
                                                       163,
                                                       157,
                                                       159,
                                                       160,
                                                       162,
                                                       164,
                                                       155,
                                                   ]));
    
        \App\Block::find(1)
            ->products()
            ->attach(\App\Product::find([
                291,
                292,
            ]));
        \App\Block::find(1)
            ->contents()
            ->attach(\App\Content::find([
                3927,
                6320,
                6920,
                1442,
            ]));
    
        //ShopPage
        $data = [
            [
                'id'         => 10,
                'title'      => 'پروژه تفتان آلاء( کنکور نظام جدید)',
                'tags'       => json_encode([
                    "محصول",
                    "نظام_آموزشی_جدید",
                    "کنکور",
                ], JSON_UNESCAPED_UNICODE),
                'order'      => 1,
                'enable'     => 1,
                'type'       => 2,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'taftan',
                
            ],
            [
                'id'         => 6,
                'title'      => 'کنکور نظام جدید',
                'tags'       => json_encode([
                    "محصول",
                    "نظام_آموزشی_جدید",
                    "کنکور",
                ], JSON_UNESCAPED_UNICODE),
                'order'      => 1,
                'enable'     => 1,
                'type'       => 2,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'konkoor2',
            ],
            [
                'id'         => 7,
                'title'      => 'کنکور نظام قدیم',
                'tags'       => json_encode([
                    "محصول",
                    "نظام_آموزشی_قدیم",
                    "کنکور",
                ], JSON_UNESCAPED_UNICODE),
                'order'      => 2,
                'enable'     => 1,
                'type'       => 2,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'konkoor1',
            ],
            [
                'id'         => 8,
                'title'      => 'پایه یازدهم',
                'tags'       => json_encode([
                    "محصول",
                    "نظام_آموزشی_جدید",
                    "یازدهم"
                ], JSON_UNESCAPED_UNICODE),
                'order'      => 3,
                'enable'     => 1,
                'type'       => 2,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'yazdahom',
            ],
            [
                'id'         => 9,
                'title'      => 'پایه دهم',
                'tags'       => json_encode([
                    "محصول",
                    "نظام_آموزشی_جدید",
                    "دهم"
                ], JSON_UNESCAPED_UNICODE),
                'order'      => 4,
                'enable'     => 1,
                'type'       => 2,
                'created_at' => \Carbon\Carbon::now(),
                'class'      => 'dahom',
            ],
        ];
        DB::table('blocks')
          ->insert($data); // Query Builder
        \App\Block::find(6)
                  ->products()
                  ->attach(\App\Product::find([
                      275,
                      265,
                      266,
                      267,
                      268,
                      269,
                      270,
                      272,
                      226,
                      225,

                  ]));
        \App\Block::find(7)
                  ->products()
                  ->attach(\App\Product::find([
                      210,
                      213,
                      222,
                      242,
                      240,
                      238,
                      236,
                      234,
                      232,
                      230,
                      226
                  ]));
        \App\Block::find(8)
                  ->products()
                  ->attach(\App\Product::find([
                      275,
                      226
                  ]));
        \App\Block::find(9)
                  ->products()
                  ->attach(\App\Product::find([
                      181,
                      225
                  ]));
    
        \App\Block::find(10)
            ->products()
            ->attach(\App\Product::find([
                285,
                286,
                287,
                288,
                289,
                290,
                291,
                292,
                293,
            ]));
    }
}
