<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class InitializeCategoryTreeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:seed:categorise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed Category Table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("get Start");

        Category::truncate();
        Category::create($this->makeAlaaArray());

        $this->info("Finish!");

    }

    /**
     * @return array
     */
    private function makeAlaaArray(): array
    {
        $omoomi = [
            [
                'name' => 'دین و زندگی',
                'tags' => json_encode(["دین_و_زندگی"], JSON_UNESCAPED_UNICODE),
                'children' => []
            ],
            [
                'name' => 'زبان و ادبیات فارسی',
                'tags' => json_encode(["زبان_و_ادبیات_فارسی"], JSON_UNESCAPED_UNICODE),
                'children' => []
            ],
            [
                'name' => 'عربی',
                'tags' => json_encode(["عربی"], JSON_UNESCAPED_UNICODE),
                'children' => []
            ],
            [
                'name' => 'زبان انگلیسی',
                'tags' => json_encode(["زبان_انگلیسی"], JSON_UNESCAPED_UNICODE),
                'children' => []
            ],
            [
                'name' => 'مشاوره',
                'tags' => json_encode(["مشاوره"], JSON_UNESCAPED_UNICODE),
                'children' => []
            ],
        ];

        $dahomR =
            $omoomi + [
                [
                    'name' => 'ریاضی پایه',
                    'tags' => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'هندسه پایه',
                    'tags' => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];
        $dahomT =
            $omoomi + [
                [
                    'name' => 'ریاضی 1',
                    'tags' => json_encode(["ریاضی_پایه", "ریاضی", "نظام_آموزشی_جدید", "ریاضی1"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'زیست شناسی',
                    'tags' => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ]
                ,
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];
        $dahomE =
            $omoomi + [
                [
                    'name' => 'اقتصاد',
                    'tags' => json_encode(["اقتصاد"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'تاریخ',
                    'tags' => json_encode(["تاریخ"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'جامعه شناسی',
                    'tags' => json_encode(["جامعه_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'جغرافیای ایران',
                    'tags' => json_encode(["جغرافیای_ایران"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'ریاضی و آمار',
                    'tags' => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'علوم و فنون ادبی',
                    'tags' => json_encode(["علوم_و_فنون_ادبی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'منطق',
                    'tags' => json_encode(["منطق"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ]
            ];

        $yazdahomR =
            $omoomi + [
                [
                    'name' => 'حسابان',
                    'tags' => json_encode(["حسابان"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'آمار و احتمال',
                    'tags' => json_encode(["آمار_و_احتمال"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'هندسه پایه',
                    'tags' => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'زمین شناسی',
                    'tags' => json_encode(["زمین_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];
        $yazdahomT =
            $omoomi + [
                [
                    'name' => 'ریاضی پایه',
                    'tags' => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'زیست شناسی',
                    'tags' => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ]
                ,
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'زمین شناسی',
                    'tags' => json_encode(["زمین_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];
        $yazdahomE =
            $omoomi + [
                [
                    'name' => 'تاریخ',
                    'tags' => json_encode(["تاریخ"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'جامعه شناسی',
                    'tags' => json_encode(["جامعه_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'جغرافیا',
                    'tags' => json_encode(["جغرافیا"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'روان شناسی',
                    'tags' => json_encode(["روان_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'ریاضی و آمار',
                    'tags' => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'علوم و فنون ادبی',
                    'tags' => json_encode(["علوم_و_فنون_ادبی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'فلسفه',
                    'tags' => json_encode(["فلسفه   "], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ]
                ,
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];

        $davazdahomR =
            $omoomi + [
                [
                    'name' => 'حسابان',
                    'tags' => json_encode(["حسابان"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'گسسته',
                    'tags' => json_encode(["گسسته"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'هندسه پایه',
                    'tags' => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];
        $davazdahomT = $omoomi + [
                [
                    'name' => 'ریاضی پایه',
                    'tags' => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'زیست شناسی',
                    'tags' => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ]
                ,
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];
        $davazdahomE = $omoomi + [
                [
                    'name' => 'تاریخ',
                    'tags' => json_encode(["تاریخ"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'جامعه شناسی',
                    'tags' => json_encode(["جامعه_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'جغرافیا',
                    'tags' => json_encode(["جغرافیا"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'ریاضی و آمار',
                    'tags' => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'علوم و فنون ادبی',
                    'tags' => json_encode(["علوم_و_فنون_ادبی"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
                [
                    'name' => 'فلسفه',
                    'tags' => json_encode(["فلسفه   "], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ]
                ,
                [
                    'name' => 'نگارش',
                    'tags' => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable' => false,
                    'children' => []
                ],
            ];

        $ghadimR = $omoomi + [
                [
                    'name' => 'دبفرانسیل',
                    'tags' => json_encode(["دبفرانسیل"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'تحلیلی',
                    'tags' => json_encode(["تحلیلی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'گسسته',
                    'tags' => json_encode(["گسسته"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'حسابان',
                    'tags' => json_encode(["حسابان"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'جبر و احتمال',
                    'tags' => json_encode(["جبر_و_احتمال"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'ریاضی پایه',
                    'tags' => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'هندسه پایه',
                    'tags' => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'آمار و مدلسازی',
                    'tags' => json_encode(["آمار_و_مدلسازی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'المپیاد نجوم',
                    'tags' => json_encode(["المپیاد_نجوم"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'المپیاد فیزیک',
                    'tags' => json_encode(["المپیاد_فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'اخلاق',
                    'tags' => json_encode(["اخلاق"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
            ];
        $ghadimT = $omoomi + [
                [
                    'name' => 'زیست شناسی',
                    'tags' => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'ریاضی تجربی',
                    'tags' => json_encode(["ریاضی_تجربی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'ریاضی پایه',
                    'tags' => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'هندسه پایه',
                    'tags' => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'فیزیک',
                    'tags' => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'شیمی',
                    'tags' => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'آمار و مدلسازی',
                    'tags' => json_encode(["آمار_و_مدلسازی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'المپیاد نجوم',
                    'tags' => json_encode(["المپیاد_نجوم"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'المپیاد فیزیک',
                    'tags' => json_encode(["المپیاد_فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'اخلاق',
                    'tags' => json_encode(["اخلاق"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],

            ];
        $ghadimE = $omoomi + [
                [
                    'name' => 'ریاضی انسانی',
                    'tags' => json_encode(["ریاضی_انسانی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'ریاضی و آمار',
                    'tags' => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'منطق',
                    'tags' => json_encode(["منطق"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'آمار و مدلسازی',
                    'tags' => json_encode(["آمار_و_مدلسازی"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
                [
                    'name' => 'اخلاق',
                    'tags' => json_encode(["اخلاق"], JSON_UNESCAPED_UNICODE),
                    'children' => []
                ],
            ];

        $riazi = [
            [
                'name' => 'نظام قدیم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $ghadimR,
            ],
            [
                'name' => 'دهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $dahomR,
            ],
            [
                'name' => 'یازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $yazdahomR,
            ],
            [
                'name' => 'دوازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $davazdahomR,
            ],
        ];
        $tajrobi = [
            [
                'name' => 'نظام قدیم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $ghadimT,
            ],
            [
                'name' => 'دهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $dahomT,
            ],
            [
                'name' => 'یازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $yazdahomT,
            ],
            [
                'name' => 'دوازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $davazdahomT,
            ],
        ];
        $ensani = [
            [
                'name' => 'نظام قدیم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $ghadimE,
            ],
            [
                'name' => 'دهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $dahomE,
            ],
            [
                'name' => 'یازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $yazdahomE,
            ],
            [
                'name' => 'دوازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $davazdahomE,
            ],
        ];
        $reshteh = [
            [
                'name' => 'رشته ریاضی',
                'tags' => json_encode(["رشته_ریاضی"], JSON_UNESCAPED_UNICODE),

                'children' => $riazi,
            ],
            [
                'name' => 'رشته تجربی',
                'tags' => json_encode(["رشته_تجربی"], JSON_UNESCAPED_UNICODE),

                'children' => $tajrobi,
            ],
            [
                'name' => 'رشته انسانی',
                'tags' => json_encode(["رشته_انسانی"], JSON_UNESCAPED_UNICODE),

                'children' => $ensani,
            ]
        ];
        $paye = [
            [
                'name' => 'ابتدایی',
                'tags' => json_encode(["ابتدایی"], JSON_UNESCAPED_UNICODE),

                'children' => [],
            ],
            [
                'name' => 'متوسطه1',
                'tags' => json_encode(["متوسطه1"], JSON_UNESCAPED_UNICODE),

                'children' => [],
            ],
            [
                'name' => 'متوسطه2',
                'tags' => json_encode(["متوسطه2"], JSON_UNESCAPED_UNICODE),

                'children' => $reshteh,
            ],
            [
                'name' => 'مهارتی',
                'tags' => json_encode(["مهارتی"], JSON_UNESCAPED_UNICODE),

                'children' => [],
            ],

        ];
        $alaa = [
            'name' => 'آلاء',
            'children' => $paye,
        ];
        return $alaa;
    }
}
