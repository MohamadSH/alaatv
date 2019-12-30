<?php

namespace App\Console\Commands;

use App\Category;
use App\Console\Commands\CategoryTree\Ensani;
use App\Console\Commands\CategoryTree\Riazi;
use App\Console\Commands\CategoryTree\Tajrobi;
use Illuminate\Console\Command;

class InitializeCategoryTreeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:seed:init:categorise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seeds category table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("get Start - Category Tree");
        $data = $this->makeAlaaArray();
        Category::truncate();
        Category::create($data);
        $this->info("Finish!");
    }

    /**
     * @return array
     */
    private function makeAlaaArray(): array
    {
        $omoomi = [
            [
                'name'     => 'دین و زندگی',
                'tags'     => json_encode(["دین_و_زندگی"], JSON_UNESCAPED_UNICODE),
                'children' => [],
            ],
            [
                'name'     => 'زبان و ادبیات فارسی',
                'tags'     => json_encode(["زبان_و_ادبیات_فارسی"], JSON_UNESCAPED_UNICODE),
                'children' => [],
            ],
            [
                'name'     => 'عربی',
                'tags'     => json_encode(["عربی"], JSON_UNESCAPED_UNICODE),
                'children' => [],
            ],
            [
                'name'     => 'زبان انگلیسی',
                'tags'     => json_encode(["زبان_انگلیسی"], JSON_UNESCAPED_UNICODE),
                'children' => [],
            ],
            [
                'name'     => 'مشاوره',
                'tags'     => json_encode(["مشاوره"], JSON_UNESCAPED_UNICODE),
                'children' => [],
            ],
        ];

        $dahomR = $omoomi + [
                [
                    'name'     => 'ریاضی پایه',
                    'tags'     => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'هندسه پایه',
                    'tags'     => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];
        $dahomT = $omoomi + [
                [
                    'name'     => 'ریاضی 1',
                    'tags'     => json_encode([
                        "ریاضی_پایه",
                        "ریاضی",
                        "نظام_آموزشی_جدید",
                        "ریاضی1",
                    ], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'زیست شناسی',
                    'tags'     => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];
        $dahomE = $omoomi + [
                [
                    'name'     => 'اقتصاد',
                    'tags'     => json_encode(["اقتصاد"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'تاریخ',
                    'tags'     => json_encode(["تاریخ"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'جامعه شناسی',
                    'tags'     => json_encode(["جامعه_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'جغرافیای ایران',
                    'tags'     => json_encode(["جغرافیای_ایران"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی و آمار',
                    'tags'     => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'علوم و فنون ادبی',
                    'tags'     => json_encode(["علوم_و_فنون_ادبی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'منطق',
                    'tags'     => json_encode(["منطق"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
            ];

        $yazdahomR = $omoomi + [
                [
                    'name'     => 'حسابان',
                    'tags'     => json_encode(["حسابان"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'آمار و احتمال',
                    'tags'     => json_encode(["آمار_و_احتمال"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'هندسه پایه',
                    'tags'     => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'زمین شناسی',
                    'tags'     => json_encode(["زمین_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];
        $yazdahomT = $omoomi + [
                [
                    'name'     => 'ریاضی پایه',
                    'tags'     => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'زیست شناسی',
                    'tags'     => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'زمین شناسی',
                    'tags'     => json_encode(["زمین_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];
        $yazdahomE = $omoomi + [
                [
                    'name'     => 'تاریخ',
                    'tags'     => json_encode(["تاریخ"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'جامعه شناسی',
                    'tags'     => json_encode(["جامعه_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'جغرافیا',
                    'tags'     => json_encode(["جغرافیا"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'روان شناسی',
                    'tags'     => json_encode(["روان_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی و آمار',
                    'tags'     => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'علوم و فنون ادبی',
                    'tags'     => json_encode(["علوم_و_فنون_ادبی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'فلسفه',
                    'tags'     => json_encode(["فلسفه   "], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];

        $davazdahomR = $omoomi + [
                [
                    'name'     => 'حسابان',
                    'tags'     => json_encode(["حسابان"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'گسسته',
                    'tags'     => json_encode(["گسسته"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'هندسه پایه',
                    'tags'     => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];
        $davazdahomT = $omoomi + [
                [
                    'name'     => 'ریاضی پایه',
                    'tags'     => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'زیست شناسی',
                    'tags'     => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];
        $davazdahomE = $omoomi + [
                [
                    'name'     => 'تاریخ',
                    'tags'     => json_encode(["تاریخ"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'جامعه شناسی',
                    'tags'     => json_encode(["جامعه_شناسی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'جغرافیا',
                    'tags'     => json_encode(["جغرافیا"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی و آمار',
                    'tags'     => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'علوم و فنون ادبی',
                    'tags'     => json_encode(["علوم_و_فنون_ادبی"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
                [
                    'name'     => 'فلسفه',
                    'tags'     => json_encode(["فلسفه   "], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'نگارش',
                    'tags'     => json_encode(["نگارش"], JSON_UNESCAPED_UNICODE),
                    'enable'   => false,
                    'children' => [],
                ],
            ];

        $ghadimR = $omoomi + [
                [
                    'name'     => 'دبفرانسیل',
                    'tags'     => json_encode(["دبفرانسیل"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'تحلیلی',
                    'tags'     => json_encode(["تحلیلی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'گسسته',
                    'tags'     => json_encode(["گسسته"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'حسابان',
                    'tags'     => json_encode(["حسابان"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'جبر و احتمال',
                    'tags'     => json_encode(["جبر_و_احتمال"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی پایه',
                    'tags'     => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'هندسه پایه',
                    'tags'     => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'آمار و مدلسازی',
                    'tags'     => json_encode(["آمار_و_مدلسازی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'المپیاد نجوم',
                    'tags'     => json_encode(["المپیاد_نجوم"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'المپیاد فیزیک',
                    'tags'     => json_encode(["المپیاد_فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'اخلاق',
                    'tags'     => json_encode(["اخلاق"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
            ];
        $ghadimT = $omoomi + [
                [
                    'name'     => 'زیست شناسی',
                    'tags'     => json_encode(["زیست_شناسی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی تجربی',
                    'tags'     => json_encode(["ریاضی_تجربی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی پایه',
                    'tags'     => json_encode(["ریاضی_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'هندسه پایه',
                    'tags'     => json_encode(["هندسه_پایه"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'فیزیک',
                    'tags'     => json_encode(["فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'شیمی',
                    'tags'     => json_encode(["شیمی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'آمار و مدلسازی',
                    'tags'     => json_encode(["آمار_و_مدلسازی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'المپیاد نجوم',
                    'tags'     => json_encode(["المپیاد_نجوم"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'المپیاد فیزیک',
                    'tags'     => json_encode(["المپیاد_فیزیک"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'اخلاق',
                    'tags'     => json_encode(["اخلاق"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],

            ];
        $ghadimE = $omoomi + [
                [
                    'name'     => 'ریاضی انسانی',
                    'tags'     => json_encode(["ریاضی_انسانی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'ریاضی و آمار',
                    'tags'     => json_encode(["ریاضی_و_آمار"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'منطق',
                    'tags'     => json_encode(["منطق"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'آمار و مدلسازی',
                    'tags'     => json_encode(["آمار_و_مدلسازی"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
                [
                    'name'     => 'اخلاق',
                    'tags'     => json_encode(["اخلاق"], JSON_UNESCAPED_UNICODE),
                    'children' => [],
                ],
            ];

        $riazi   = (new Riazi)->getTree();
        $tajrobi = (new Tajrobi)->getTree();
        $ensani  = (new Ensani)->getTree();
        $reshteh = [
            [
                'name'     => 'رشته تجربی',
                'tags'     => json_encode(["رشته_تجربی"], JSON_UNESCAPED_UNICODE),
                'children' => $tajrobi,
            ],
            [
                'name'     => 'رشته ریاضی',
                'tags'     => json_encode(["رشته_ریاضی"], JSON_UNESCAPED_UNICODE),
                'children' => $riazi,
            ],
            [
                'name'     => 'رشته انسانی',
                'tags'     => json_encode(["رشته_انسانی"], JSON_UNESCAPED_UNICODE),
                'children' => $ensani,
            ],
        ];
        $paye    = [
            [
                'name'     => 'ابتدایی',
                'tags'     => json_encode(["ابتدایی"], JSON_UNESCAPED_UNICODE),
                'enable'   => false,
                'children' => [],
            ],
            [
                'name'     => 'متوسطه1',
                'tags'     => json_encode(["متوسطه1"], JSON_UNESCAPED_UNICODE),
                'enable'   => false,
                'children' => [
                    [
                        'id'       => '543',
                        'name'     => 'هفتم',
                        'tags'     => json_encode(['هفتم'], JSON_UNESCAPED_UNICODE),
                        'children' => [
                            [
                                'id'       => '41',
                                'name'     => 'ریاضی',
                                'tags'     => json_encode(['ریاضی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '0',
                                        'name'     => 'فصل 1: راهبرد‌های حل مسئله',
                                        'tags'     => json_encode(['فصل_1:_راهبرد‌های_حل_مسئله'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [

                                        ],
                                    ],
                                    [
                                        'id'       => '5',
                                        'name'     => 'فصل 2: عددهای صحیح',
                                        'tags'     => json_encode(['فصل_2:_عددهای_صحیح'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1',
                                                'name'     => 'معرفی عددهای علامت‌دار',
                                                'tags'     => json_encode(['معرفی_عددهای_علامت‌دار'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '2',
                                                'name'     => 'جمع و تفریق عددهای صحیح (1)',
                                                'tags'     => json_encode(['جمع_و_تفریق_عددهای_صحیح_(1)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '3',
                                                'name'     => 'جمع و تفریق عددهای صحیح (2)',
                                                'tags'     => json_encode(['جمع_و_تفریق_عددهای_صحیح_(2)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '4',
                                                'name'     => 'ضرب و تقسیم عددهای صحیح',
                                                'tags'     => json_encode(['ضرب_و_تقسیم_عددهای_صحیح'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '10',
                                        'name'     => 'فصل 3: جبر و معادله',
                                        'tags'     => json_encode(['فصل_3:_جبر_و_معادله'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '6',
                                                'name'     => 'الگوهای عددی',
                                                'tags'     => json_encode(['الگوهای_عددی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '7',
                                                'name'     => 'عبارت‌های جبری',
                                                'tags'     => json_encode(['عبارت‌های_جبری'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '8',
                                                'name'     => 'مقدار عددی یک عبارت جبری',
                                                'tags'     => json_encode(['مقدار_عددی_یک_عبارت_جبری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '9',
                                                'name'     => 'معادله',
                                                'tags'     => json_encode(['معادله'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '15',
                                        'name'     => 'فصل 4: هندسه و استدلال',
                                        'tags'     => json_encode(['فصل__4:_هندسه_و_استدلال'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '11',
                                                'name'     => 'روابط بین پاره‌خط‌ها',
                                                'tags'     => json_encode(['روابط_بین_پاره‌خط‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '12',
                                                'name'     => 'روابط بین زاویه‌ها',
                                                'tags'     => json_encode(['روابط_بین_زاویه‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '13',
                                                'name'     => 'تبدیلات هندسی (انتقال، تقارن، دوران)',
                                                'tags'     => json_encode(['تبدیلات_هندسی_(انتقال،_تقارن،_دوران)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '14',
                                                'name'     => 'شکل‌های مساوی (همنهشت)',
                                                'tags'     => json_encode(['شکل‌های_مساوی_(همنهشت)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '20',
                                        'name'     => 'فصل 5: شمارنده‌ها و اعداد اول',
                                        'tags'     => json_encode(['فصل_5:_شمارنده‌ها_و_اعداد_اول'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '16',
                                                'name'     => 'عدد اول',
                                                'tags'     => json_encode(['عدد_اول'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '17',
                                                'name'     => 'شمارندۀ اول',
                                                'tags'     => json_encode(['شمارندۀ_اول'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '18',
                                                'name'     => 'بزرگ‌ترین شمارندۀ مشترک',
                                                'tags'     => json_encode(['بزرگ‌ترین_شمارندۀ_مشترک'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '19',
                                                'name'     => 'کوچک‌ترین مضرب مشترک',
                                                'tags'     => json_encode(['کوچک‌ترین_مضرب_مشترک'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '25',
                                        'name'     => 'فصل 6: سطح و حجم',
                                        'tags'     => json_encode(['فصل_6:_سطح_و_حجم'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '21',
                                                'name'     => 'حجم‌های هندسی',
                                                'tags'     => json_encode(['حجم‌های_هندسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '22',
                                                'name'     => 'محاسبۀ حجم‌های منشوری',
                                                'tags'     => json_encode(['محاسبۀ_حجم‌های_منشوری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '23',
                                                'name'     => 'مساحت جانبی و کل',
                                                'tags'     => json_encode(['مساحت_جانبی_و_کل'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '24',
                                                'name'     => 'حجم و سطح',
                                                'tags'     => json_encode(['حجم_و_سطح'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '30',
                                        'name'     => 'فصل 7: توان و جذر',
                                        'tags'     => json_encode(['فصل_7:_توان_و_جذر'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '26',
                                                'name'     => 'تعریف توان',
                                                'tags'     => json_encode(['تعریف_توان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '27',
                                                'name'     => 'محاسبۀ عبارت توان‌دار',
                                                'tags'     => json_encode(['محاسبۀ_عبارت_توان‌دار'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '28',
                                                'name'     => 'ساده‌کردن عبارت‌های توان‌دار',
                                                'tags'     => json_encode(['ساده‌کردن_عبارت‌های_توان‌دار'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '29',
                                                'name'     => 'جذر و ریشه',
                                                'tags'     => json_encode(['جذر_و_ریشه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '35',
                                        'name'     => 'فصل 8: بردار و مختصات',
                                        'tags'     => json_encode(['فصل_8:_بردار_و_مختصات'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '31',
                                                'name'     => 'پاره‌خط جهت‌دار',
                                                'tags'     => json_encode(['پاره‌خط_جهت‌دار'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '32',
                                                'name'     => 'بردارهای مساوی و قرینه',
                                                'tags'     => json_encode(['بردارهای_مساوی_و_قرینه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '33',
                                                'name'     => 'مختصات',
                                                'tags'     => json_encode(['مختصات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '34',
                                                'name'     => 'بردار انتقال',
                                                'tags'     => json_encode(['بردار_انتقال'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '40',
                                        'name'     => 'فصل 9: آمار و احتمال',
                                        'tags'     => json_encode(['فصل_9:_آمار_و_احتمال'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '36',
                                                'name'     => 'جمع‌آوری و نمایش داده‌ها',
                                                'tags'     => json_encode(['جمع‌آوری_و_نمایش_داده‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '37',
                                                'name'     => 'نمودارها و تفسیر نتیجه‌ها',
                                                'tags'     => json_encode(['نمودارها_و_تفسیر_نتیجه‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '38',
                                                'name'     => 'احتمال یا اندازه‌گیری شانس',
                                                'tags'     => json_encode(['احتمال_یا_اندازه‌گیری_شانس'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '39',
                                                'name'     => 'احتمال و تجربه',
                                                'tags'     => json_encode(['احتمال_و_تجربه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '113',
                                'name'     => 'زبان انگلیسی',
                                'tags'     => json_encode(['زبان_انگلیسی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '49',
                                        'name'     => 'Lesson 1: My Name',
                                        'tags'     => json_encode(['Lesson_1:_My_Name'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '42',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '43',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '44',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '45',
                                                'name'     => 'Listening',
                                                'tags'     => json_encode(['Listening'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '46',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '47',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '48',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '57',
                                        'name'     => 'Lesson 2: My Classmates',
                                        'tags'     => json_encode(['Lesson_2:_My_Classmates'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '50',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '51',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '52',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '53',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '54',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '55',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '56',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '65',
                                        'name'     => 'Lesson 3: My Age',
                                        'tags'     => json_encode(['Lesson_3:_My_Age'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '58',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '59',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '60',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '61',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '62',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '63',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '64',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '73',
                                        'name'     => 'Lesson 4: My Family',
                                        'tags'     => json_encode(['Lesson_4:_My_Family'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '66',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '67',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '68',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '69',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '70',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '71',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '72',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '81',
                                        'name'     => 'Lesson 5: My Appearance',
                                        'tags'     => json_encode(['Lesson_5:_My_Appearance'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '74',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '75',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '76',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '77',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '78',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '79',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '80',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '89',
                                        'name'     => 'Lesson 6: My House',
                                        'tags'     => json_encode(['Lesson_6:_My_House'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '82',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '83',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '84',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '85',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '86',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '87',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '88',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '97',
                                        'name'     => 'Lesson 7: My Address',
                                        'tags'     => json_encode(['Lesson_7:_My_Address'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '90',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '91',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '92',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '93',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '94',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '95',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '96',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '105',
                                        'name'     => 'Lesson 8: My Favorite Food',
                                        'tags'     => json_encode(['Lesson_8:_My_Favorite_Food'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '98',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '99',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '100',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '101',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '102',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '103',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '104',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '112',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '106',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '107',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '108',
                                                'name'     => 'Sounds & Letters',
                                                'tags'     => json_encode(['Sounds_&_Letters'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '109',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '110',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '111',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '166',
                                'name'     => 'عربی',
                                'tags'     => json_encode(['عربی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '117',
                                        'name'     => 'الدرس الأول: قیمة العلم، نور الکلام و کنز الکنوز',
                                        'tags'     => json_encode(['الدرس_الأول:_قیمة_العلم،_نور_الکلام_و_کنز_الکنوز'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '114',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '115',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '116',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '121',
                                        'name'     => 'الدرس الثانی: جواهر الکلام، کنوز الحکم و کنز النصیحة',
                                        'tags'     => json_encode(['الدرس_الثانی:_جواهر_الکلام،_کنوز_الحکم_و_کنز_النصیحة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '118',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '119',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '120',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '125',
                                        'name'     => 'الدرس الثانی عشر: الأیام و الفصول و الالوان',
                                        'tags'     => json_encode(['الدرس_الثانی_عشر:_الأیام_و_الفصول_و_الالوان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '122',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '123',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '124',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '129',
                                        'name'     => 'الدرس الثالث: الحکم النافعة و المواعظ العددیة',
                                        'tags'     => json_encode(['الدرس_الثالث:_الحکم_النافعة_و_المواعظ_العددیة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '126',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '127',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '128',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '133',
                                        'name'     => 'الدرس الرابع: حوار بین ولدین',
                                        'tags'     => json_encode(['الدرس_الرابع:_حوار_بین_ولدین'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '130',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '131',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '132',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '137',
                                        'name'     => 'الدرس الخامس: فی السوق',
                                        'tags'     => json_encode(['الدرس_الخامس:_فی_السوق'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '134',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '135',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '136',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '141',
                                        'name'     => 'الدرس السادس: الجملات الذهبیة',
                                        'tags'     => json_encode(['الدرس_السادس:_الجملات_الذهبیة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '138',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '139',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '140',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '145',
                                        'name'     => 'الدرس السابع: حوار فی الاسرة',
                                        'tags'     => json_encode(['الدرس_السابع:_حوار_فی_الاسرة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '142',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '143',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '144',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '149',
                                        'name'     => 'الدرس الثامن: فی الحدود',
                                        'tags'     => json_encode(['الدرس_الثامن:_فی_الحدود'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '146',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '147',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '148',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '153',
                                        'name'     => 'الدرس التاسع: الأسرة الناجحة',
                                        'tags'     => json_encode(['الدرس_التاسع:_الأسرة_الناجحة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '150',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '151',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '152',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '157',
                                        'name'     => 'الدرس العاشر: زینة الباطن',
                                        'tags'     => json_encode(['الدرس_العاشر:_زینة_الباطن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '154',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '155',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '156',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '161',
                                        'name'     => 'الدرس الحادی عشر: الإخلاص فی العمل',
                                        'tags'     => json_encode(['الدرس_الحادی_عشر:_الإخلاص_فی_العمل'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '158',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '159',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '160',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '165',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '162',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '163',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '164',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '256',
                                'name'     => 'علوم',
                                'tags'     => json_encode(['علوم'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '167',
                                        'name'     => 'فصل 1: تجربه و تفکر',
                                        'tags'     => json_encode(['فصل_1:_تجربه_و_تفکر'], JSON_UNESCAPED_UNICODE),
                                        'children' => [

                                        ],
                                    ],
                                    [
                                        'id'       => '174',
                                        'name'     => 'فصل 2: اندازه‌گیری در علوم و ابزارهای آن',
                                        'tags'     => json_encode(['فصل_2:_اندازه‌گیری_در_علوم_و_ابزارهای_آن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '168',
                                                'name'     => 'اندازه‌گیری و واحد‌های استاندارد',
                                                'tags'     => json_encode(['اندازه‌گیری_و_واحد‌های_استاندارد'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '169',
                                                'name'     => 'جرم و وزن',
                                                'tags'     => json_encode(['جرم_و_وزن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '170',
                                                'name'     => 'طول، مساحت و حجم',
                                                'tags'     => json_encode(['طول،_مساحت_و_حجم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '171',
                                                'name'     => 'چگالی',
                                                'tags'     => json_encode(['چگالی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '172',
                                                'name'     => 'زمان',
                                                'tags'     => json_encode(['زمان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '173',
                                                'name'     => 'دقت در اندازه‌گیری',
                                                'tags'     => json_encode(['دقت_در_اندازه‌گیری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '181',
                                        'name'     => 'فصل 3: اتم‌ها، الفبای مواد',
                                        'tags'     => json_encode(['فصل_3:_اتم‌ها،_الفبای_مواد'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '175',
                                                'name'     => 'مواد در زندگی ما',
                                                'tags'     => json_encode(['مواد_در_زندگی_ما'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '176',
                                                'name'     => 'عنصر‌ها و ترکیب‌ها',
                                                'tags'     => json_encode(['عنصر‌ها_و_ترکیب‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '177',
                                                'name'     => 'ویژگی‌های فلزات و نافلزات',
                                                'tags'     => json_encode(['ویژگی‌های_فلزات_و_نافلزات'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '178',
                                                'name'     => 'ذرات تشکیل‌دهندۀ اتم',
                                                'tags'     => json_encode(['ذرات_تشکیل‌دهندۀ_اتم'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '179',
                                                'name'     => 'تراکم‌پذیری و انبساط مواد',
                                                'tags'     => json_encode(['تراکم‌پذیری_و_انبساط_مواد'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '180',
                                                'name'     => 'گرما و تغییر حالت ماده',
                                                'tags'     => json_encode(['گرما_و_تغییر_حالت_ماده'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '187',
                                        'name'     => 'فصل 4: مواد پیرامون ما',
                                        'tags'     => json_encode(['فصل_4:_مواد_پیرامون_ما'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '182',
                                                'name'     => 'مواد طبیعی و مصنوعی',
                                                'tags'     => json_encode(['مواد_طبیعی_و_مصنوعی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '183',
                                                'name'     => 'ویژگی‌های مواد',
                                                'tags'     => json_encode(['ویژگی‌های_مواد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '184',
                                                'name'     => 'کاربرد مواد',
                                                'tags'     => json_encode(['کاربرد_مواد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '185',
                                                'name'     => 'آلیاژها',
                                                'tags'     => json_encode(['آلیاژها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '186',
                                                'name'     => 'مواد هوشمند',
                                                'tags'     => json_encode(['مواد_هوشمند'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '193',
                                        'name'     => 'فصل 5: از معدن تا خانه',
                                        'tags'     => json_encode(['فصل_5:_از_معدن_تا_خانه'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '188',
                                                'name'     => 'اندوخته‌های زمین',
                                                'tags'     => json_encode(['اندوخته‌های_زمین'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '189',
                                                'name'     => 'چگونه می‌توان به آهن دست یافت؟',
                                                'tags'     => json_encode(['چگونه_می‌توان_به_آهن_دست_یافت؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '190',
                                                'name'     => 'به دنبال سرپناهی ایمن',
                                                'tags'     => json_encode(['به_دنبال_سرپناهی_ایمن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '191',
                                                'name'     => 'اندوخته‌های طبیعی و ظروف آشپزخانه',
                                                'tags'     => json_encode(['اندوخته‌های_طبیعی_و_ظروف_آشپزخانه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '192',
                                                'name'     => 'سرعت مصرف منابع و راه‌های محافظت از آن',
                                                'tags'     => json_encode(['سرعت_مصرف_منابع_و_راه‌های_محافظت_از_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '200',
                                        'name'     => 'فصل 6: سفر آب روی زمین',
                                        'tags'     => json_encode(['فصل_6:_سفر_آب_روی_زمین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '194',
                                                'name'     => 'آب، فراوان اما کمیاب',
                                                'tags'     => json_encode(['آب،_فراوان_اما_کمیاب'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '195',
                                                'name'     => 'آب‌های جاری',
                                                'tags'     => json_encode(['آب‌های_جاری'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '196',
                                                'name'     => 'دریاچه‌ها',
                                                'tags'     => json_encode(['دریاچه‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '197',
                                                'name'     => 'دریاها و اقیانوس‌ها',
                                                'tags'     => json_encode(['دریاها_و_اقیانوس‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '198',
                                                'name'     => 'باران چگونه تشکیل و به کجا می‌رود؟',
                                                'tags'     => json_encode(['باران_چگونه_تشکیل_و_به_کجا_می‌رود؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '199',
                                                'name'     => 'یخچال‌ها',
                                                'tags'     => json_encode(['یخچال‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '204',
                                        'name'     => 'فصل 7: سفر آب درون زمین',
                                        'tags'     => json_encode(['فصل_7:_سفر_آب_درون_زمین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '201',
                                                'name'     => 'آب‌های زیر‌زمینی و عوامل مؤثر در آن',
                                                'tags'     => json_encode(['آب‌های_زیر‌زمینی_و_عوامل_مؤثر_در_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '202',
                                                'name'     => 'سفره‌های آب زیرزمینی (آبخوان) و ویژگی‌های آن',
                                                'tags'     => json_encode(['سفره‌های_آب_زیرزمینی_(آبخوان)_و_ویژگی‌های_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '203',
                                                'name'     => 'قنات - چرخۀ آب',
                                                'tags'     => json_encode(['قنات_-_چرخۀ_آب'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '210',
                                        'name'     => 'فصل 8: انرژی و تبدیل‌های آن',
                                        'tags'     => json_encode(['فصل_8:_انرژی_و_تبدیل‌های_آن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '205',
                                                'name'     => 'کار',
                                                'tags'     => json_encode(['کار'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '206',
                                                'name'     => 'انرژی جنبشی',
                                                'tags'     => json_encode(['انرژی_جنبشی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '207',
                                                'name'     => 'انرژی پتانسیل',
                                                'tags'     => json_encode(['انرژی_پتانسیل'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '208',
                                                'name'     => 'اصل پایستگی انرژی و تبدیلات انرژی',
                                                'tags'     => json_encode(['اصل_پایستگی_انرژی_و_تبدیلات_انرژی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '209',
                                                'name'     => 'انرژی شیمیایی مواد غذایی و آهنگ مصرف انرژی',
                                                'tags'     => json_encode(['انرژی_شیمیایی_مواد_غذایی_و_آهنگ_مصرف_انرژی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '213',
                                        'name'     => 'فصل 9: منابع انرژی',
                                        'tags'     => json_encode(['فصل_9:_منابع_انرژی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '211',
                                                'name'     => 'منابع تجدید ناپذیر',
                                                'tags'     => json_encode(['منابع_تجدید_ناپذیر'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '212',
                                                'name'     => 'منابع تجدید پذیر',
                                                'tags'     => json_encode(['منابع_تجدید_پذیر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '219',
                                        'name'     => 'فصل 10: گرما و مصرف انرژی',
                                        'tags'     => json_encode(['فصل_10:_گرما_و_مصرف_انرژی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '214',
                                                'name'     => 'دما و دماسنجی',
                                                'tags'     => json_encode(['دما_و_دماسنجی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '215',
                                                'name'     => 'انواع دماسنج‌ها',
                                                'tags'     => json_encode(['انواع_دماسنج‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '216',
                                                'name'     => 'تعریف گرما - دمای تعادل',
                                                'tags'     => json_encode(['تعریف_گرما_-_دمای_تعادل'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '217',
                                                'name'     => 'روش‌های انتقال گرما',
                                                'tags'     => json_encode(['روش‌های_انتقال_گرما'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '218',
                                                'name'     => 'کاربرد‌های مربوط به گرما',
                                                'tags'     => json_encode(['کاربرد‌های_مربوط_به_گرما'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '224',
                                        'name'     => 'فصل 11: یاخته‌ها و سازمان‌بندی آن',
                                        'tags'     => json_encode(['فصل_11:_یاخته‌ها_و_سازمان‌بندی_آن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '220',
                                                'name'     => 'یاخته، کوچک‌ترین واحد زنده',
                                                'tags'     => json_encode(['یاخته،_کوچک‌ترین_واحد_زنده'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '221',
                                                'name'     => 'نگاهی به درون یاخته و شباهت‌های آن',
                                                'tags'     => json_encode(['نگاهی_به_درون_یاخته_و_شباهت‌های_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '222',
                                                'name'     => 'مقایسۀ یاخته‌های گیاهی و جانوری',
                                                'tags'     => json_encode(['مقایسۀ_یاخته‌های_گیاهی_و_جانوری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '223',
                                                'name'     => 'سازمان‌بندی یاخته‌ها',
                                                'tags'     => json_encode(['سازمان‌بندی_یاخته‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '233',
                                        'name'     => 'فصل 12: سفرۀ سلامت',
                                        'tags'     => json_encode(['فصل_12:_سفرۀ_سلامت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '225',
                                                'name'     => 'موادی که غذاها دارند',
                                                'tags'     => json_encode(['موادی_که_غذاها_دارند'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '226',
                                                'name'     => 'کربوهیدرات‌ها (قندها)',
                                                'tags'     => json_encode(['کربوهیدرات‌ها_(قندها)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '227',
                                                'name'     => 'لیپید‌ها (چربی‌ها)',
                                                'tags'     => json_encode(['لیپید‌ها_(چربی‌ها)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '228',
                                                'name'     => 'پروتئین‌ها',
                                                'tags'     => json_encode(['پروتئین‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '229',
                                                'name'     => 'ویتامین‌ها',
                                                'tags'     => json_encode(['ویتامین‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '230',
                                                'name'     => 'مواد معدنی',
                                                'tags'     => json_encode(['مواد_معدنی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '231',
                                                'name'     => 'آب',
                                                'tags'     => json_encode(['آب'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '232',
                                                'name'     => 'تغذیۀ سالم',
                                                'tags'     => json_encode(['تغذیۀ_سالم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '240',
                                        'name'     => 'فصل 13: سفر غذا',
                                        'tags'     => json_encode(['فصل_13:_سفر_غذا'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '234',
                                                'name'     => 'گوارش غذا',
                                                'tags'     => json_encode(['گوارش_غذا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '235',
                                                'name'     => 'لولۀ گوارش و غدد گوارشی',
                                                'tags'     => json_encode(['لولۀ_گوارش_و_غدد_گوارشی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '236',
                                                'name'     => 'از دهان تا معده',
                                                'tags'     => json_encode(['از_دهان_تا_معده'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '237',
                                                'name'     => 'رودۀ باریک',
                                                'tags'     => json_encode(['رودۀ_باریک'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '238',
                                                'name'     => 'رودۀ بزرگ',
                                                'tags'     => json_encode(['رودۀ_بزرگ'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '239',
                                                'name'     => 'کبد',
                                                'tags'     => json_encode(['کبد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '247',
                                        'name'     => 'فصل 14: گردش مواد',
                                        'tags'     => json_encode(['فصل_14:_گردش_مواد'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '241',
                                                'name'     => 'رابطه بین همه دستگاه‌های بدن',
                                                'tags'     => json_encode(['رابطه_بین_همه_دستگاه‌های_بدن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '242',
                                                'name'     => 'قلب',
                                                'tags'     => json_encode(['قلب'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '243',
                                                'name'     => 'رگ‌های قلب - رگ‌های بدن',
                                                'tags'     => json_encode(['رگ‌های_قلب_-_رگ‌های_بدن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '244',
                                                'name'     => 'گردش کوچک و بزرگ خون',
                                                'tags'     => json_encode(['گردش_کوچک_و_بزرگ_خون'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '245',
                                                'name'     => 'فشار خون و نبض',
                                                'tags'     => json_encode(['فشار_خون_و_نبض'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '246',
                                                'name'     => 'خون',
                                                'tags'     => json_encode(['خون'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '255',
                                        'name'     => 'فصل 15: تبادل با محیط',
                                        'tags'     => json_encode(['فصل_15:_تبادل_با_محیط'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '251',
                                                'name'     => 'دستگاه تنفس',
                                                'tags'     => json_encode(['دستگاه_تنفس'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '248',
                                                        'name'     => 'ساختار دستگاه تنفس',
                                                        'tags'     => json_encode(['ساختار_دستگاه_تنفس'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '249',
                                                        'name'     => 'تبادل هوا - تولید صدا',
                                                        'tags'     => json_encode(['تبادل_هوا_-_تولید_صدا'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '250',
                                                        'name'     => 'انتقال گازها',
                                                        'tags'     => json_encode(['انتقال_گازها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '254',
                                                'name'     => 'دستگاه دفع ادرار',
                                                'tags'     => json_encode(['دستگاه_دفع_ادرار'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '252',
                                                        'name'     => 'چگونگی کار کلیه',
                                                        'tags'     => json_encode(['چگونگی_کار_کلیه'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '253',
                                                        'name'     => 'تنظیم محیط داخلی',
                                                        'tags'     => json_encode(['تنظیم_محیط_داخلی'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '394',
                                'name'     => 'فارسی',
                                'tags'     => json_encode(['فارسی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '263',
                                        'name'     => 'درس اول: زنگ آفرینش',
                                        'tags'     => json_encode(['درس_اول:_زنگ_آفرینش'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '257',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '258',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '259',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '260',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '261',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '262',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '270',
                                        'name'     => 'درس دوم: چشمۀ معرفت',
                                        'tags'     => json_encode(['درس_دوم:_چشمۀ_معرفت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '264',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '265',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '266',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '267',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '268',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '269',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '278',
                                        'name'     => 'درس سوم: نسل آینده‌ساز',
                                        'tags'     => json_encode(['درس_سوم:_نسل_آینده‌ساز'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '271',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '272',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '273',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '274',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '275',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '276',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '277',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '285',
                                        'name'     => 'درس چهارم: با بهاری که می‌رسد از راه، زیبایی شکفتن',
                                        'tags'     => json_encode(['درس_چهارم:_با_بهاری_که_می‌رسد_از_راه،_زیبایی_شکفتن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '279',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '280',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '281',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '282',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '283',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '284',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '292',
                                        'name'     => 'درس ششم: قلب کوچکم را به چه‌کسی بدهم؟',
                                        'tags'     => json_encode(['درس_ششم:_قلب_کوچکم_را_به_چه‌کسی_بدهم؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '286',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '287',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '288',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '289',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '290',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '291',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '299',
                                        'name'     => 'درس هفتم: علم زندگانی',
                                        'tags'     => json_encode(['درس_هفتم:_علم_زندگانی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '293',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '294',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '295',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '296',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '297',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '298',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '306',
                                        'name'     => 'درس هشتم: زندگی همین لحظه‌‎هاست',
                                        'tags'     => json_encode(['درس_هشتم:_زندگی_همین_لحظه‌‎هاست'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '300',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '301',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '302',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '303',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '304',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '305',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '313',
                                        'name'     => 'درس نهم: نصیحت امام (ره)، شوق خواندن',
                                        'tags'     => json_encode(['درس_نهم:_نصیحت_امام_(ره)،_شوق_خواندن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '307',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '308',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '309',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '310',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '311',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '312',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '321',
                                        'name'     => 'درس دهم: کلاس ادبیات، مرواریدی در صدف، زندگی حسابی، فرزند انقلاب',
                                        'tags'     => json_encode(['درس_دهم:_کلاس_ادبیات،_مرواریدی_در_صدف،_زندگی_حسابی،_فرزند_انقلاب'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '314',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '315',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '316',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '317',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '318',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '319',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '320',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '328',
                                        'name'     => 'درس یازدهم: عهد و پیمان، عشق به مردم، رفتار بهشتی، گرمای محبت',
                                        'tags'     => json_encode(['درس_یازدهم:_عهد_و_پیمان،_عشق_به_مردم،_رفتار_بهشتی،_گرمای_محبت'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '322',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '323',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '324',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '325',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '326',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '327',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '336',
                                        'name'     => 'درس دوازدهم: خدمات متقابل اسلام و ایران',
                                        'tags'     => json_encode(['درس_دوازدهم:_خدمات_متقابل_اسلام_و_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '329',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '330',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '331',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '332',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '333',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '334',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '335',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '343',
                                        'name'     => 'درس سیزدهم: اسوۀ نیکو',
                                        'tags'     => json_encode(['درس_سیزدهم:_اسوۀ_نیکو'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '337',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '338',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '339',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '340',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '341',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '342',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '350',
                                        'name'     => 'درس چهاردهم: امام خمینی (ره)',
                                        'tags'     => json_encode(['درس_چهاردهم:_امام_خمینی_(ره)'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '344',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '345',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '346',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '347',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '348',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '349',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '357',
                                        'name'     => 'درس پانزدهم: روان‌خوانی: چرا زبان فارسی را دوست دارم؟',
                                        'tags'     => json_encode(['درس_پانزدهم:_روان‌خوانی:_چرا_زبان_فارسی_را_دوست_دارم؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '351',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '352',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '353',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '354',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '355',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '356',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '364',
                                        'name'     => 'درس شانزدهم: آدم‌آهنی و شاپرک',
                                        'tags'     => json_encode(['درس_شانزدهم:_آدم‌آهنی_و_شاپرک'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '358',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '359',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '360',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '361',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '362',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '363',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '371',
                                        'name'     => 'درس هفدهم: ما‌ می‌توانیم',
                                        'tags'     => json_encode(['درس_هفدهم:_ما‌_می‌توانیم'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '365',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '366',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '367',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '368',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '369',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '370',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '378',
                                        'name'     => 'ستایش: یاد تو',
                                        'tags'     => json_encode(['ستایش:_یاد_تو'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '372',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '373',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '374',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '375',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '376',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '377',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '385',
                                        'name'     => 'نیایش',
                                        'tags'     => json_encode(['نیایش'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '379',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '380',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '381',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '382',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '383',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '384',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '393',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '386',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '387',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '388',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '389',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '390',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '391',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '392',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '493',
                                'name'     => 'مطالعات اجتماعی',
                                'tags'     => json_encode(['مطالعات_اجتماعی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '397',
                                        'name'     => 'درس 1: من حق دارم',
                                        'tags'     => json_encode(['درس_1:_من_حق_دارم'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '395',
                                                'name'     => 'تعریف حق',
                                                'tags'     => json_encode(['تعریف_حق'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '396',
                                                'name'     => 'حقوق افراد در محیط‌های گوناگون',
                                                'tags'     => json_encode(['حقوق_افراد_در_محیط‌های_گوناگون'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '398',
                                        'name'     => 'درس 3: چرا به مقررات و قوانین نیاز داریم؟',
                                        'tags'     => json_encode(['درس_3:_چرا_به_مقررات_و_قوانین_نیاز_داریم؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [

                                        ],
                                    ],
                                    [
                                        'id'       => '404',
                                        'name'     => 'درس 4: قانونگذاری',
                                        'tags'     => json_encode(['درس_4:_قانونگذاری'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '399',
                                                'name'     => 'تعریف قانون و انواع آن',
                                                'tags'     => json_encode(['تعریف_قانون_و_انواع_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '400',
                                                'name'     => 'قانون اساسی',
                                                'tags'     => json_encode(['قانون_اساسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '403',
                                                'name'     => 'قوۀ مقننه',
                                                'tags'     => json_encode(['قوۀ_مقننه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '401',
                                                        'name'     => 'مجلس شورای اسلامی',
                                                        'tags'     => json_encode(['مجلس_شورای_اسلامی'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '402',
                                                        'name'     => 'شورای نگهبان',
                                                        'tags'     => json_encode(['شورای_نگهبان'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '407',
                                        'name'     => 'درس 5: همدلی و همیاری در حوادث',
                                        'tags'     => json_encode(['درس_5:_همدلی_و_همیاری_در_حوادث'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '405',
                                                'name'     => 'تعریف همدلی و همیاری',
                                                'tags'     => json_encode(['تعریف_همدلی_و_همیاری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '406',
                                                'name'     => 'کدام مؤسسات اجتماعی در حوادث به‌ ما کمک می‌کنند؟',
                                                'tags'     => json_encode(['کدام_مؤسسات_اجتماعی_در_حوادث_به‌_ما_کمک_می‌کنند؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '410',
                                        'name'     => 'درس 6: بیمه و مقابله با حوادث',
                                        'tags'     => json_encode(['درس_6:_بیمه_و_مقابله_با_حوادث'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '408',
                                                'name'     => 'بیمه چیست و چرا به وجود آمده است؟',
                                                'tags'     => json_encode(['بیمه_چیست_و_چرا_به_وجود_آمده_است؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '409',
                                                'name'     => 'انواع بیمه',
                                                'tags'     => json_encode(['انواع_بیمه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '413',
                                        'name'     => 'درس 7: تولید و توزیع',
                                        'tags'     => json_encode(['درس_7:_تولید_و_توزیع'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '411',
                                                'name'     => 'تولید و انواع آن',
                                                'tags'     => json_encode(['تولید_و_انواع_آن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '412',
                                                'name'     => 'توزیع کالا و خدمات',
                                                'tags'     => json_encode(['توزیع_کالا_و_خدمات'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '416',
                                        'name'     => 'درس 8: مصرف',
                                        'tags'     => json_encode(['درس_8:_مصرف'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '414',
                                                'name'     => 'مصرف‌کننده و حقوق او',
                                                'tags'     => json_encode(['مصرف‌کننده_و_حقوق_او'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '415',
                                                'name'     => 'مسئولیت‌های مصرف‌کننده',
                                                'tags'     => json_encode(['مسئولیت‌های_مصرف‌کننده'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '420',
                                        'name'     => 'درس 9: من کجا زندگی می‌کنم؟',
                                        'tags'     => json_encode(['درس_9:_من_کجا_زندگی_می‌کنم؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '417',
                                                'name'     => 'ویژگی‌های طبیعی و انسانی',
                                                'tags'     => json_encode(['ویژگی‌های_طبیعی_و_انسانی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '418',
                                                'name'     => 'ویژگی‌های جغرافیایی هر مکان',
                                                'tags'     => json_encode(['ویژگی‌های_جغرافیایی_هر_مکان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '419',
                                                'name'     => 'چه وسایلی به شناخت محیط زندگی کمک می‌کنند',
                                                'tags'     => json_encode(['چه_وسایلی_به_شناخت_محیط_زندگی_کمک_می‌کنند'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '425',
                                        'name'     => 'درس 10: ایران، خانۀ ما',
                                        'tags'     => json_encode(['درس_10:_ایران،_خانۀ_ما'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '421',
                                                'name'     => 'تقسیمات کشوری ایران',
                                                'tags'     => json_encode(['تقسیمات_کشوری_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '424',
                                                'name'     => 'اشکال زمین در ایران',
                                                'tags'     => json_encode(['اشکال_زمین_در_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '422',
                                                        'name'     => 'نواحی مرتفع و بلند',
                                                        'tags'     => json_encode(['نواحی_مرتفع_و_بلند'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '423',
                                                        'name'     => 'نواحی پست و هموار',
                                                        'tags'     => json_encode(['نواحی_پست_و_هموار'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '428',
                                        'name'     => 'درس 11: تنوع آب‌و‌هوای ایران',
                                        'tags'     => json_encode(['درس_11:_تنوع_آب‌و‌هوای_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '426',
                                                'name'     => 'محیط طبیعی ایران متنوع است',
                                                'tags'     => json_encode(['محیط_طبیعی_ایران_متنوع_است'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '427',
                                                'name'     => 'آب‌و‌هوای ایران',
                                                'tags'     => json_encode(['آب‌و‌هوای_ایران'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '434',
                                        'name'     => 'درس 12: حفاظت از زیستگاه‌های ایران',
                                        'tags'     => json_encode(['درس_12:_حفاظت_از_زیستگاه‌های_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '429',
                                                'name'     => 'گونه‌های گیاهی و جانوری ایران',
                                                'tags'     => json_encode(['گونه‌های_گیاهی_و_جانوری_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '430',
                                                'name'     => 'چرا زیستگاه‌ها تخریب می‌شوند؟',
                                                'tags'     => json_encode(['چرا_زیستگاه‌ها_تخریب_می‌شوند؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '431',
                                                'name'     => 'چرا از زیستگاه‌ها حفاظت می‌کنیم؟',
                                                'tags'     => json_encode(['چرا_از_زیستگاه‌ها_حفاظت_می‌کنیم؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '432',
                                                'name'     => 'چگونه از زیستگاه‌ها حفاظت می‌کنیم؟',
                                                'tags'     => json_encode(['چگونه_از_زیستگاه‌ها_حفاظت_می‌کنیم؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '433',
                                                'name'     => 'مناطق حفاظت‌شده',
                                                'tags'     => json_encode(['مناطق_حفاظت‌شده'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '438',
                                        'name'     => 'درس 13: جمعیت ایران',
                                        'tags'     => json_encode(['درس_13:_جمعیت_ایران'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '435',
                                                'name'     => 'سرشماری جمعیت ایران',
                                                'tags'     => json_encode(['سرشماری_جمعیت_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '436',
                                                'name'     => 'جمعیت چگونه افزایش می‌یابد؟',
                                                'tags'     => json_encode(['جمعیت_چگونه_افزایش_می‌یابد؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '437',
                                                'name'     => 'تراکم جمعیت و پراکندگی آن',
                                                'tags'     => json_encode(['تراکم_جمعیت_و_پراکندگی_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '445',
                                        'name'     => 'درس 14: منابع آب و خاک',
                                        'tags'     => json_encode(['درس_14:_منابع_آب_و_خاک'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '441',
                                                'name'     => 'آب',
                                                'tags'     => json_encode(['آب'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '439',
                                                        'name'     => 'منابع آب در ایران',
                                                        'tags'     => json_encode(['منابع_آب_در_ایران'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '440',
                                                        'name'     => 'مصرف آب',
                                                        'tags'     => json_encode(['مصرف_آب'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '444',
                                                'name'     => 'خاک',
                                                'tags'     => json_encode(['خاک'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '442',
                                                        'name'     => 'خاک چگونه تشکیل می‌شود؟',
                                                        'tags'     => json_encode(['خاک_چگونه_تشکیل_می‌شود؟'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '443',
                                                        'name'     => 'عوامل ازبین‌رفتن خاک',
                                                        'tags'     => json_encode(['عوامل_ازبین‌رفتن_خاک'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '448',
                                        'name'     => 'درس 15: گردشگری چیست؟',
                                        'tags'     => json_encode(['درس_15:_گردشگری_چیست؟'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '446',
                                                'name'     => 'گردشگری و انواع آن',
                                                'tags'     => json_encode(['گردشگری_و_انواع_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '447',
                                                'name'     => 'گردشگری و نقشه',
                                                'tags'     => json_encode(['گردشگری_و_نقشه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '452',
                                        'name'     => 'درس 16: جاذبه‌های گردشگری ایران',
                                        'tags'     => json_encode(['درس_16:_جاذبه‌های_گردشگری_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '449',
                                                'name'     => 'سفرهای زیارتی',
                                                'tags'     => json_encode(['سفرهای_زیارتی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '450',
                                                'name'     => 'گردشگری تاریخی',
                                                'tags'     => json_encode(['گردشگری_تاریخی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '451',
                                                'name'     => 'طبیعت‌گردی و حفاظت از طبیعت',
                                                'tags'     => json_encode(['طبیعت‌گردی_و_حفاظت_از_طبیعت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '456',
                                        'name'     => 'درس 17: میراث فرهنگی و تاریخ',
                                        'tags'     => json_encode(['درس_17:_میراث_فرهنگی_و_تاریخ'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '453',
                                                'name'     => 'میراث فرهنگی و حفاظت از آن',
                                                'tags'     => json_encode(['میراث_فرهنگی_و_حفاظت_از_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '454',
                                                'name'     => 'چه کسانی گذشته را مطالعه می‌کنند؟',
                                                'tags'     => json_encode(['چه_کسانی_گذشته_را_مطالعه_می‌کنند؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '455',
                                                'name'     => 'موزه‌ها و زمان میراث فرهنگی',
                                                'tags'     => json_encode(['موزه‌ها_و_زمان_میراث_فرهنگی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '457',
                                        'name'     => 'درس 18: قدیمی‌ترین سکونتگاه‌های ایران',
                                        'tags'     => json_encode(['درس_18:_قدیمی‌ترین_سکونتگاه‌های_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [

                                        ],
                                    ],
                                    [
                                        'id'       => '464',
                                        'name'     => 'درس 19: آریایی‌ها و تشکیل حکومت‌های قدرتمند در ایران',
                                        'tags'     => json_encode(['درس_19:_آریایی‌ها_و_تشکیل_حکومت‌های_قدرتمند_در_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '458',
                                                'name'     => 'آریایی‌ها',
                                                'tags'     => json_encode(['آریایی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '459',
                                                'name'     => 'مادها',
                                                'tags'     => json_encode(['مادها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '460',
                                                'name'     => 'هخامنشیان',
                                                'tags'     => json_encode(['هخامنشیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '461',
                                                'name'     => 'سلوکیان',
                                                'tags'     => json_encode(['سلوکیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '462',
                                                'name'     => 'اشکانیان',
                                                'tags'     => json_encode(['اشکانیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '463',
                                                'name'     => 'ساسانیان',
                                                'tags'     => json_encode(['ساسانیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '469',
                                        'name'     => 'درس 20: امپراتوری‌های ایران باستان چگونه کشور را اداره می‌کردند؟',
                                        'tags'     => json_encode(['درس_20:_امپراتوری‌های_ایران_باستان_چگونه_کشور_را_اداره_می‌کردند؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '465',
                                                'name'     => 'نوع حکومت',
                                                'tags'     => json_encode(['نوع_حکومت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '466',
                                                'name'     => 'مقام‌های حکومتی',
                                                'tags'     => json_encode(['مقام‌های_حکومتی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '467',
                                                'name'     => 'تقسیمات کشوری و پایتخت‌ها',
                                                'tags'     => json_encode(['تقسیمات_کشوری_و_پایتخت‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '468',
                                                'name'     => 'سپاه و قدرت نظامی',
                                                'tags'     => json_encode(['سپاه_و_قدرت_نظامی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '473',
                                        'name'     => 'درس 21: اوضاع اجتماعی ایران باستان',
                                        'tags'     => json_encode(['درس_21:_اوضاع_اجتماعی_ایران_باستان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '470',
                                                'name'     => 'خانواده',
                                                'tags'     => json_encode(['خانواده'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '471',
                                                'name'     => 'زندگی شهری و روستایی',
                                                'tags'     => json_encode(['زندگی_شهری_و_روستایی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '472',
                                                'name'     => 'نابرابری اجتماعی',
                                                'tags'     => json_encode(['نابرابری_اجتماعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '478',
                                        'name'     => 'درس 22: اوضاع اقتصادی در ایران باستان',
                                        'tags'     => json_encode(['درس_22:_اوضاع_اقتصادی_در_ایران_باستان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '474',
                                                'name'     => 'کشاورزی و دامپروری',
                                                'tags'     => json_encode(['کشاورزی_و_دامپروری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '475',
                                                'name'     => 'صنعت',
                                                'tags'     => json_encode(['صنعت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '476',
                                                'name'     => 'تجارت و ضرب سکه',
                                                'tags'     => json_encode(['تجارت_و_ضرب_سکه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '477',
                                                'name'     => 'درآمد‌ها و مخارج حکومت',
                                                'tags'     => json_encode(['درآمد‌ها_و_مخارج_حکومت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '484',
                                        'name'     => 'درس 23: عقاید و سبک زندگی مردم در ایران باستان',
                                        'tags'     => json_encode(['درس_23:_عقاید_و_سبک_زندگی_مردم_در_ایران_باستان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '479',
                                                'name'     => 'دین',
                                                'tags'     => json_encode(['دین'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '480',
                                                'name'     => 'تغذیه و آداب غذا خوردن',
                                                'tags'     => json_encode(['تغذیه_و_آداب_غذا_خوردن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '481',
                                                'name'     => 'پوشاک',
                                                'tags'     => json_encode(['پوشاک'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '482',
                                                'name'     => 'ورزش',
                                                'tags'     => json_encode(['ورزش'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '483',
                                                'name'     => 'جشن‌ها',
                                                'tags'     => json_encode(['جشن‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '489',
                                        'name'     => 'درس 24: دانش و هنر در ایران باستان',
                                        'tags'     => json_encode(['درس_24:_دانش_و_هنر_در_ایران_باستان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '485',
                                                'name'     => 'زبان فارسی',
                                                'tags'     => json_encode(['زبان_فارسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '486',
                                                'name'     => 'خط',
                                                'tags'     => json_encode(['خط'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '487',
                                                'name'     => 'دانش',
                                                'tags'     => json_encode(['دانش'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '488',
                                                'name'     => 'هنر و معماری',
                                                'tags'     => json_encode(['هنر_و_معماری'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '492',
                                        'name'     => 'درس 2: من مسئول هستم',
                                        'tags'     => json_encode(['درس_2:_من_مسئول_هستم'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '490',
                                                'name'     => 'حقوق متقابل و مسئولیت‌ها',
                                                'tags'     => json_encode(['حقوق_متقابل_و_مسئولیت‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '491',
                                                'name'     => 'مسئولیت‌های گوناگون',
                                                'tags'     => json_encode(['مسئولیت‌های_گوناگون'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '542',
                                'name'     => 'پیام‌های آسمان',
                                'tags'     => json_encode(['پیام‌های_آسمان'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '496',
                                        'name'     => 'درس اول: بینای مهربان',
                                        'tags'     => json_encode(['درس_اول:_بینای_مهربان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '494',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '495',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '499',
                                        'name'     => 'درس دوم: استعانت از خداوند',
                                        'tags'     => json_encode(['درس_دوم:_استعانت_از_خداوند'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '497',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '498',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '502',
                                        'name'     => 'درس سوم: تلخ یا شیرین',
                                        'tags'     => json_encode(['درس_سوم:_تلخ_یا_شیرین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '500',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '501',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '505',
                                        'name'     => 'درس چهارم: عبور آسان',
                                        'tags'     => json_encode(['درس_چهارم:_عبور_آسان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '503',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '504',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '508',
                                        'name'     => 'درس پنجم: پیامبر رحمت',
                                        'tags'     => json_encode(['درس_پنجم:_پیامبر_رحمت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '506',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '507',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '511',
                                        'name'     => 'درس ششم: اسوۀ فداکاری و عدالت',
                                        'tags'     => json_encode(['درس_ششم:_اسوۀ_فداکاری_و_عدالت'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '509',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '510',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '514',
                                        'name'     => 'درس هفتم: برترین بانو',
                                        'tags'     => json_encode(['درس_هفتم:_برترین_بانو'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '512',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '513',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '517',
                                        'name'     => 'درس هشتم: افتخار بندگی',
                                        'tags'     => json_encode(['درس_هشتم:_افتخار_بندگی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '515',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '516',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '520',
                                        'name'     => 'درس نهم: به سوی پاکی',
                                        'tags'     => json_encode(['درس_نهم:_به_سوی_پاکی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '518',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '519',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '523',
                                        'name'     => 'درس دهم: ستون دین',
                                        'tags'     => json_encode(['درس_دهم:_ستون_دین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '521',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '522',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '526',
                                        'name'     => 'درس یازدهم: نماز جماعت',
                                        'tags'     => json_encode(['درس_یازدهم:_نماز_جماعت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '524',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '525',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '529',
                                        'name'     => 'درس دوازدهم: نشان عزّت',
                                        'tags'     => json_encode(['درس_دوازدهم:_نشان_عزّت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '527',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '528',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '532',
                                        'name'     => 'درس سیزدهم: بر بال فرشتگان',
                                        'tags'     => json_encode(['درس_سیزدهم:_بر_بال_فرشتگان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '530',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '531',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '535',
                                        'name'     => 'درس چهاردهم: کمال همنشین',
                                        'tags'     => json_encode(['درس_چهاردهم:_کمال_همنشین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '533',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '534',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '538',
                                        'name'     => 'درس پانزدهم: مزدوران شیطان',
                                        'tags'     => json_encode(['درس_پانزدهم:_مزدوران_شیطان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '536',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '537',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '541',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '539',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '540',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],

                        ],
                    ],
                    [
                        'id'       => '1079',
                        'name'     => 'هشتم',
                        'tags'     => json_encode(['هشتم'], JSON_UNESCAPED_UNICODE),
                        'children' => [
                            [
                                'id'       => '587',
                                'name'     => 'ریاضی',
                                'tags'     => json_encode(['ریاضی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '548',
                                        'name'     => 'فصل 1: عددهای صحیح و گویا',
                                        'tags'     => json_encode(['فصل_1:_عددهای_صحیح_و_گویا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '544',
                                                'name'     => 'درس اول: یادآوری عددهای صحیح',
                                                'tags'     => json_encode(['درس_اول:_یادآوری_عددهای_صحیح'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '545',
                                                'name'     => 'درس دوم: معرفی عددهای گویا',
                                                'tags'     => json_encode(['درس_دوم:_معرفی_عددهای_گویا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '546',
                                                'name'     => 'درس سوم: جمع و تفریق عددهای گویا',
                                                'tags'     => json_encode(['درس_سوم:_جمع_و_تفریق_عددهای_گویا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '547',
                                                'name'     => 'درس چهارم: ضرب و تقسیم عددهای گویا',
                                                'tags'     => json_encode(['درس_چهارم:_ضرب_و_تقسیم_عددهای_گویا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '551',
                                        'name'     => 'فصل 2: عددهای اول',
                                        'tags'     => json_encode(['فصل_2:_عددهای_اول'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '549',
                                                'name'     => 'درس اول: یادآوری عددهای اول',
                                                'tags'     => json_encode(['درس_اول:_یادآوری_عددهای_اول'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '550',
                                                'name'     => 'درس دوم: تعیین عددهای اول',
                                                'tags'     => json_encode(['درس_دوم:_تعیین_عددهای_اول'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '557',
                                        'name'     => 'فصل 3: چندضلعی‌ها',
                                        'tags'     => json_encode(['فصل_3:_چندضلعی‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '552',
                                                'name'     => 'درس اول: چندضلعی‌ها و تقارن',
                                                'tags'     => json_encode(['درس_اول:_چندضلعی‌ها_و_تقارن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '553',
                                                'name'     => 'درس دوم: توازی و تعامد',
                                                'tags'     => json_encode(['درس_دوم:_توازی_و_تعامد'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '554',
                                                'name'     => 'درس سوم: چهار ضلعی‌ها',
                                                'tags'     => json_encode(['درس_سوم:_چهار_ضلعی‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '555',
                                                'name'     => 'درس چهارم: زاویه‌های داخلی',
                                                'tags'     => json_encode(['درس_چهارم:_زاویه‌های_داخلی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '556',
                                                'name'     => 'درس پنجم: زاویه‌های خارجی',
                                                'tags'     => json_encode(['درس_پنجم:_زاویه‌های_خارجی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '562',
                                        'name'     => 'فصل 4: جبر و معادله',
                                        'tags'     => json_encode(['فصل_4:_جبر_و_معادله'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '558',
                                                'name'     => 'درس اول: ساده‌کردن عبارت‌های جبری',
                                                'tags'     => json_encode(['درس_اول:_ساده‌کردن_عبارت‌های_جبری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '559',
                                                'name'     => 'درس دوم: پیدا کردن مقدار یک عبارت جبری',
                                                'tags'     => json_encode(['درس_دوم:_پیدا_کردن_مقدار_یک_عبارت_جبری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '560',
                                                'name'     => 'درس سوم: تجزیۀ عبارت‌های جبری',
                                                'tags'     => json_encode(['درس_سوم:_تجزیۀ_عبارت‌های_جبری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '561',
                                                'name'     => 'درس چهارم: معادله',
                                                'tags'     => json_encode(['درس_چهارم:_معادله'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '566',
                                        'name'     => 'فصل 5: بردار و مختصات',
                                        'tags'     => json_encode(['فصل_5:_بردار_و_مختصات'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '563',
                                                'name'     => 'درس اول: جمع بردارها',
                                                'tags'     => json_encode(['درس_اول:_جمع_بردارها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '564',
                                                'name'     => 'درس دوم: ضرب عدد در بردار',
                                                'tags'     => json_encode(['درس_دوم:_ضرب_عدد_در_بردار'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '565',
                                                'name'     => 'درس سوم: بردارهای واحد مختصات',
                                                'tags'     => json_encode(['درس_سوم:_بردارهای_واحد_مختصات'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '571',
                                        'name'     => 'فصل 6: مثلث',
                                        'tags'     => json_encode(['فصل_6:_مثلث'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '567',
                                                'name'     => 'درس اول: رابطۀ فیثاغورس',
                                                'tags'     => json_encode(['درس_اول:_رابطۀ_فیثاغورس'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '568',
                                                'name'     => 'درس دوم: شکل‌های همنهشت',
                                                'tags'     => json_encode(['درس_دوم:_شکل‌های_همنهشت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '569',
                                                'name'     => 'درس سوم: مثلث‌های همنهشت',
                                                'tags'     => json_encode(['درس_سوم:_مثلث‌های_همنهشت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '570',
                                                'name'     => 'درس چهارم: همنهشتی مثلث‌های قائم‌الزاویه',
                                                'tags'     => json_encode(['درس_چهارم:_همنهشتی_مثلث‌های_قائم‌الزاویه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '577',
                                        'name'     => 'فصل 7: توان و جذر',
                                        'tags'     => json_encode(['فصل_7:_توان_و_جذر'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '572',
                                                'name'     => 'درس اول: توان',
                                                'tags'     => json_encode(['درس_اول:_توان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '573',
                                                'name'     => 'درس دوم: تقسیم اعداد توان‌دار',
                                                'tags'     => json_encode(['درس_دوم:_تقسیم_اعداد_توان‌دار'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '574',
                                                'name'     => 'درس سوم: جذر تقریبی',
                                                'tags'     => json_encode(['درس_سوم:_جذر_تقریبی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '575',
                                                'name'     => 'درس چهارم: نمایش اعداد رادیکالی روی محور اعداد',
                                                'tags'     => json_encode(['درس_چهارم:_نمایش_اعداد_رادیکالی_روی_محور_اعداد'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '576',
                                                'name'     => 'درس پنجم: خواص ضرب و تقسیم رادیکال‌ها',
                                                'tags'     => json_encode(['درس_پنجم:_خواص_ضرب_و_تقسیم_رادیکال‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '582',
                                        'name'     => 'فصل 8: آمار و احتمال',
                                        'tags'     => json_encode(['فصل_8:_آمار_و_احتمال'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '578',
                                                'name'     => 'درس اول: دسته‌بندی داده‌ها',
                                                'tags'     => json_encode(['درس_اول:_دسته‌بندی_داده‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '579',
                                                'name'     => 'درس دوم: میانگین داده‌ها',
                                                'tags'     => json_encode(['درس_دوم:_میانگین_داده‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '580',
                                                'name'     => 'درس سوم: احتمال یا اندازه‌گیری شانس',
                                                'tags'     => json_encode(['درس_سوم:_احتمال_یا_اندازه‌گیری_شانس'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '581',
                                                'name'     => 'درس چهارم: بررسی حالت‌های ممکن',
                                                'tags'     => json_encode(['درس_چهارم:_بررسی_حالت‌های_ممکن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '586',
                                        'name'     => 'فصل 9: دایره',
                                        'tags'     => json_encode(['فصل_9:_دایره'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '583',
                                                'name'     => 'درس اول: خط و دایره',
                                                'tags'     => json_encode(['درس_اول:_خط_و_دایره'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '584',
                                                'name'     => 'درس دوم: زاویه‌های مرکزی',
                                                'tags'     => json_encode(['درس_دوم:_زاویه‌های_مرکزی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '585',
                                                'name'     => 'درس سوم: زاویه‌های محاطی',
                                                'tags'     => json_encode(['درس_سوم:_زاویه‌های_محاطی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '643',
                                'name'     => 'زبان انگلیسی',
                                'tags'     => json_encode(['زبان_انگلیسی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '594',
                                        'name'     => 'Lesson 1: My Nationality',
                                        'tags'     => json_encode(['Lesson_1:_My_Nationality'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '588',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '589',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '590',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '591',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '592',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '593',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '601',
                                        'name'     => 'Lesson 2: My Week',
                                        'tags'     => json_encode(['Lesson_2:_My_Week'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '595',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '596',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '597',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '598',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '599',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '600',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '608',
                                        'name'     => 'Lesson 3: My Abilities',
                                        'tags'     => json_encode(['Lesson_3:_My_Abilities'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '602',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '603',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '604',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '605',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '606',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '607',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '615',
                                        'name'     => 'Lesson 4: My Health',
                                        'tags'     => json_encode(['Lesson_4:_My_Health'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '609',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '610',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '611',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '612',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '613',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '614',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '622',
                                        'name'     => 'Lesson 5: My City',
                                        'tags'     => json_encode(['Lesson_5:_My_City'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '616',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '617',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '618',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '619',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '620',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '621',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '629',
                                        'name'     => 'Lesson 6: My Village',
                                        'tags'     => json_encode(['Lesson_6:_My_Village'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '623',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '624',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '625',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '626',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '627',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '628',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '636',
                                        'name'     => 'Lesson 7: My Hobbies',
                                        'tags'     => json_encode(['Lesson_7:_My_Hobbies'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '630',
                                                'name'     => 'Spelling and Pronunciation',
                                                'tags'     => json_encode(['Spelling_and_Pronunciation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '631',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '632',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '633',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '634',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '635',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '642',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '637',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '638',
                                                'name'     => 'Cloze ',
                                                'tags'     => json_encode(['Cloze_'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '639',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '640',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '641',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '688',
                                'name'     => 'عربی',
                                'tags'     => json_encode(['عربی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '647',
                                        'name'     => 'الدرس الأول: مراجعة دروس الصف السابع',
                                        'tags'     => json_encode(['الدرس_الأول:_مراجعة_دروس_الصف_السابع'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '644',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '645',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '646',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '651',
                                        'name'     => 'الدرس الثانی: اهمیة اللغة العربیة',
                                        'tags'     => json_encode(['الدرس_الثانی:_اهمیة_اللغة_العربیة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '648',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '649',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '650',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '655',
                                        'name'     => 'الدرس الثالث: مهنتک فی المستقبل',
                                        'tags'     => json_encode(['الدرس_الثالث:_مهنتک_فی_المستقبل'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '652',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '653',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '654',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '659',
                                        'name'     => 'الدرس الرابع: التجربة الجدیدة',
                                        'tags'     => json_encode(['الدرس_الرابع:_التجربة_الجدیدة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '656',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '657',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '658',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '663',
                                        'name'     => 'الدرس الخامس: الصداقة',
                                        'tags'     => json_encode(['الدرس_الخامس:_الصداقة'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '660',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '661',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '662',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '667',
                                        'name'     => 'الدرس السادس: فی السفر',
                                        'tags'     => json_encode(['الدرس_السادس:_فی_السفر'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '664',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '665',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '666',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '671',
                                        'name'     => 'الدرس السابع: ﴿... ارض الله واسعة﴾',
                                        'tags'     => json_encode(['الدرس_السابع:_﴿..._ارض_الله_واسعة﴾'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '668',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '669',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '670',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '675',
                                        'name'     => 'الدرس الثامن: الاعتماد علی النفس',
                                        'tags'     => json_encode(['الدرس_الثامن:_الاعتماد_علی_النفس'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '672',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '673',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '674',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '679',
                                        'name'     => 'الدرس التاسع: السفرة العلمیة',
                                        'tags'     => json_encode(['الدرس_التاسع:_السفرة_العلمیة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '676',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '677',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '678',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '683',
                                        'name'     => 'الدرس العاشر: الحکم',
                                        'tags'     => json_encode(['الدرس_العاشر:_الحکم'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '680',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '681',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '682',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '687',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '684',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '685',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '686',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '794',
                                'name'     => 'علوم',
                                'tags'     => json_encode(['علوم'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '695',
                                        'name'     => 'فصل اول: مخلوط و جداسازی مواد',
                                        'tags'     => json_encode(['فصل_اول:_مخلوط_و_جداسازی_مواد'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '689',
                                                'name'     => 'مواد خالص و مخلوط',
                                                'tags'     => json_encode(['مواد_خالص_و_مخلوط'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '690',
                                                'name'     => 'انواع مخلوط‌ها (همگن و ناهمگن)',
                                                'tags'     => json_encode(['انواع_مخلوط‌ها_(همگن_و_ناهمگن)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '691',
                                                'name'     => 'اجزای تشکیل‌دهنده و حالت فیزیکی محلول‌ها',
                                                'tags'     => json_encode(['اجزای_تشکیل‌دهنده_و_حالت_فیزیکی_محلول‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '692',
                                                'name'     => 'انحلال‌پذیری و عوامل مؤثر بر آن',
                                                'tags'     => json_encode(['انحلال‌پذیری_و_عوامل_مؤثر_بر_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '693',
                                                'name'     => 'اسیدها و بازها',
                                                'tags'     => json_encode(['اسیدها_و_بازها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '694',
                                                'name'     => 'جداسازی مخلوط‌ها',
                                                'tags'     => json_encode(['جداسازی_مخلوط‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '700',
                                        'name'     => 'فصل دوم: تغییرهای شیمیایی در خدمت زندگی',
                                        'tags'     => json_encode(['فصل_دوم:_تغییرهای_شیمیایی_در_خدمت_زندگی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '696',
                                                'name'     => 'تغییرهای فیزیکی و شیمیایی',
                                                'tags'     => json_encode(['تغییرهای_فیزیکی_و_شیمیایی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '697',
                                                'name'     => 'سوختن و فرآورده‌های آن',
                                                'tags'     => json_encode(['سوختن_و_فرآورده‌های_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '698',
                                                'name'     => 'تغییر شیمیایی در بدن جانداران و عوامل مؤثر بر سرعت تغییرها',
                                                'tags'     => json_encode(['تغییر_شیمیایی_در_بدن_جانداران_و_عوامل_مؤثر_بر_سرعت_تغییرها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '699',
                                                'name'     => 'استفاده از انرژی شیمیایی مواد - پیل‌های شیمیایی',
                                                'tags'     => json_encode(['استفاده_از_انرژی_شیمیایی_مواد_-_پیل‌های_شیمیایی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '706',
                                        'name'     => 'فصل سوم: از درون اتم چه خبر',
                                        'tags'     => json_encode(['فصل_سوم:_از_درون_اتم_چه_خبر'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '701',
                                                'name'     => 'ذره‌های سازنده اتم',
                                                'tags'     => json_encode(['ذره‌های_سازنده_اتم'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '702',
                                                'name'     => 'عنصرها و نشانه شیمیایی آن‌ها',
                                                'tags'     => json_encode(['عنصرها_و_نشانه_شیمیایی_آن‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '703',
                                                'name'     => 'مدلی برای ساختار اتم',
                                                'tags'     => json_encode(['مدلی_برای_ساختار_اتم'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '704',
                                                'name'     => 'ایزوتوپ‌ها',
                                                'tags'     => json_encode(['ایزوتوپ‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '705',
                                                'name'     => 'یون‌ها',
                                                'tags'     => json_encode(['یون‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '713',
                                        'name'     => 'فصل چهارم: تنظیم عصبی',
                                        'tags'     => json_encode(['فصل_چهارم:_تنظیم_عصبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '707',
                                                'name'     => 'دستگاه عصبی',
                                                'tags'     => json_encode(['دستگاه_عصبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '708',
                                                'name'     => 'فعالیت‌های ارادی و غیرارادی',
                                                'tags'     => json_encode(['فعالیت‌های_ارادی_و_غیرارادی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '709',
                                                'name'     => 'مراکز عصبی (مغز و نخاع)',
                                                'tags'     => json_encode(['مراکز_عصبی_(مغز_و_نخاع)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '710',
                                                'name'     => 'اعصاب محیطی (حسی و حرکتی)',
                                                'tags'     => json_encode(['اعصاب_محیطی_(حسی_و_حرکتی)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '711',
                                                'name'     => 'سلول‌های بافت عصبی',
                                                'tags'     => json_encode(['سلول‌های_بافت_عصبی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '712',
                                                'name'     => 'پیام عصبی',
                                                'tags'     => json_encode(['پیام_عصبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '723',
                                        'name'     => 'فصل پنجم: حس و حرکت',
                                        'tags'     => json_encode(['فصل_پنجم:_حس_و_حرکت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '719',
                                                'name'     => 'اندام‌های حسی',
                                                'tags'     => json_encode(['اندام‌های_حسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '714',
                                                        'name'     => 'چشم',
                                                        'tags'     => json_encode(['چشم'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '715',
                                                        'name'     => 'گوش',
                                                        'tags'     => json_encode(['گوش'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '716',
                                                        'name'     => 'بینی',
                                                        'tags'     => json_encode(['بینی'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '717',
                                                        'name'     => 'زبان',
                                                        'tags'     => json_encode(['زبان'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '718',
                                                        'name'     => 'پوست',
                                                        'tags'     => json_encode(['پوست'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '722',
                                                'name'     => 'دستگاه حرکتی',
                                                'tags'     => json_encode(['دستگاه_حرکتی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '720',
                                                        'name'     => 'اسکلت',
                                                        'tags'     => json_encode(['اسکلت'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '721',
                                                        'name'     => 'ماهیچه‌ها',
                                                        'tags'     => json_encode(['ماهیچه‌ها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '732',
                                        'name'     => 'فصل ششم: تنظیم هورمونی',
                                        'tags'     => json_encode(['فصل_ششم:_تنظیم_هورمونی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '724',
                                                'name'     => 'دستگاه هورمونی و اعمال هورمون‌ها',
                                                'tags'     => json_encode(['دستگاه_هورمونی_و_اعمال_هورمون‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '725',
                                                'name'     => 'هیپوفیز',
                                                'tags'     => json_encode(['هیپوفیز'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '726',
                                                'name'     => 'تیروئید',
                                                'tags'     => json_encode(['تیروئید'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '727',
                                                'name'     => 'پانکراس',
                                                'tags'     => json_encode(['پانکراس'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '728',
                                                'name'     => 'فوق کلیوی',
                                                'tags'     => json_encode(['فوق_کلیوی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '729',
                                                'name'     => 'پاراتیروئید',
                                                'tags'     => json_encode(['پاراتیروئید'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '730',
                                                'name'     => 'غدد جنسی',
                                                'tags'     => json_encode(['غدد_جنسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '731',
                                                'name'     => 'تنظیم ترشح هورمون‌ها',
                                                'tags'     => json_encode(['تنظیم_ترشح_هورمون‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '739',
                                        'name'     => 'فصل هفتم: الفبای زیست‌فناوری',
                                        'tags'     => json_encode(['فصل_هفتم:_الفبای_زیست‌فناوری'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '733',
                                                'name'     => 'صفات ارثی',
                                                'tags'     => json_encode(['صفات_ارثی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '734',
                                                'name'     => 'نگاهی دقیق به هستۀ سلول',
                                                'tags'     => json_encode(['نگاهی_دقیق_به_هستۀ_سلول'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '735',
                                                'name'     => 'صفات محیطی',
                                                'tags'     => json_encode(['صفات_محیطی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '736',
                                                'name'     => 'ایجاد صفات جدید در جانداران',
                                                'tags'     => json_encode(['ایجاد_صفات_جدید_در_جانداران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '737',
                                                'name'     => 'تقسیم میتوز',
                                                'tags'     => json_encode(['تقسیم_میتوز'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '738',
                                                'name'     => 'تقسیم مشکل‌ساز (سرطان)',
                                                'tags'     => json_encode(['تقسیم_مشکل‌ساز_(سرطان)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '746',
                                        'name'     => 'فصل هشتم: تولید‌مثل در جانداران',
                                        'tags'     => json_encode(['فصل_هشتم:_تولید‌مثل_در_جانداران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '740',
                                                'name'     => 'تولید مثل غیرجنسی',
                                                'tags'     => json_encode(['تولید_مثل_غیرجنسی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '741',
                                                'name'     => 'تولید مثل‌جنسی',
                                                'tags'     => json_encode(['تولید_مثل‌جنسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '742',
                                                'name'     => 'تقسیم میوز',
                                                'tags'     => json_encode(['تقسیم_میوز'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '743',
                                                'name'     => 'تولید‌مثل جنسی در جانوران',
                                                'tags'     => json_encode(['تولید‌مثل_جنسی_در_جانوران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '744',
                                                'name'     => 'تولید مثل در انسان',
                                                'tags'     => json_encode(['تولید_مثل_در_انسان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '745',
                                                'name'     => 'تولید مثل جنسی در گیاهان گلدار',
                                                'tags'     => json_encode(['تولید_مثل_جنسی_در_گیاهان_گلدار'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '755',
                                        'name'     => 'فصل نهم: الکتریسیته',
                                        'tags'     => json_encode(['فصل_نهم:_الکتریسیته'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '747',
                                                'name'     => 'بارهای الکتریکی',
                                                'tags'     => json_encode(['بارهای_الکتریکی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '748',
                                                'name'     => 'رسانا و نارسانا',
                                                'tags'     => json_encode(['رسانا_و_نارسانا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '749',
                                                'name'     => 'روش‌های باردارکردن اجسام',
                                                'tags'     => json_encode(['روش‌های_باردارکردن_اجسام'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '750',
                                                'name'     => 'آذرخش و تخلیۀ بار الکتریکی',
                                                'tags'     => json_encode(['آذرخش_و_تخلیۀ_بار_الکتریکی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '751',
                                                'name'     => 'برق‌نما',
                                                'tags'     => json_encode(['برق‌نما'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '752',
                                                'name'     => 'اختلاف‌پتانسیل الکتریکی',
                                                'tags'     => json_encode(['اختلاف‌پتانسیل_الکتریکی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '753',
                                                'name'     => 'مدار الکتریکی و جریان الکتریکی',
                                                'tags'     => json_encode(['مدار_الکتریکی_و_جریان_الکتریکی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '754',
                                                'name'     => 'مقاومت الکتریکی',
                                                'tags'     => json_encode(['مقاومت_الکتریکی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '760',
                                        'name'     => 'فصل دهم: مغناطیس',
                                        'tags'     => json_encode(['فصل_دهم:_مغناطیس'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '756',
                                                'name'     => 'قطب‌های آهنربا',
                                                'tags'     => json_encode(['قطب‌های_آهنربا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '757',
                                                'name'     => 'روش‌های ساخت آهنربا',
                                                'tags'     => json_encode(['روش‌های_ساخت_آهنربا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '758',
                                                'name'     => 'آهنربای الکتریکی - موتور الکتریکی',
                                                'tags'     => json_encode(['آهنربای_الکتریکی_-_موتور_الکتریکی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '759',
                                                'name'     => 'تولید برق',
                                                'tags'     => json_encode(['تولید_برق'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '768',
                                        'name'     => 'فصل یازدهم: کانی‌ها',
                                        'tags'     => json_encode(['فصل_یازدهم:_کانی‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '761',
                                                'name'     => 'کانی چیست؟',
                                                'tags'     => json_encode(['کانی_چیست؟'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '762',
                                                'name'     => 'کاربرد کانی‌ها',
                                                'tags'     => json_encode(['کاربرد_کانی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '763',
                                                'name'     => 'تشکیل کانی‌ها',
                                                'tags'     => json_encode(['تشکیل_کانی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '764',
                                                'name'     => 'شناسایی کانی‌ها',
                                                'tags'     => json_encode(['شناسایی_کانی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '765',
                                                'name'     => 'کانی‌های نامهربان',
                                                'tags'     => json_encode(['کانی‌های_نامهربان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '766',
                                                'name'     => 'نام‌گذاری کانی‌ها و کانی‌های ملی',
                                                'tags'     => json_encode(['نام‌گذاری_کانی‌ها_و_کانی‌های_ملی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '767',
                                                'name'     => 'طبقه‌بندی کانی‌ها',
                                                'tags'     => json_encode(['طبقه‌بندی_کانی‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '773',
                                        'name'     => 'فصل دوازدهم: سنگ‌ها',
                                        'tags'     => json_encode(['فصل_دوازدهم:_سنگ‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '769',
                                                'name'     => 'سنگ‌ها، منابع ارزشمند',
                                                'tags'     => json_encode(['سنگ‌ها،_منابع_ارزشمند'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '770',
                                                'name'     => 'سنگ‌های آذرین',
                                                'tags'     => json_encode(['سنگ‌های_آذرین'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '771',
                                                'name'     => 'سنگ‌های رسوبی',
                                                'tags'     => json_encode(['سنگ‌های_رسوبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '772',
                                                'name'     => 'سنگ‌های دگرگونی',
                                                'tags'     => json_encode(['سنگ‌های_دگرگونی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '779',
                                        'name'     => 'فصل سیزدهم: سنگ‌ها چگونه تغییر می‌کنند؟',
                                        'tags'     => json_encode(['فصل_سیزدهم:_سنگ‌ها_چگونه_تغییر_می‌کنند؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '776',
                                                'name'     => 'هوازدگی',
                                                'tags'     => json_encode(['هوازدگی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '774',
                                                        'name'     => 'فیزیکی',
                                                        'tags'     => json_encode(['فیزیکی'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '775',
                                                        'name'     => 'شیمیایی',
                                                        'tags'     => json_encode(['شیمیایی'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '777',
                                                'name'     => 'فرسایش',
                                                'tags'     => json_encode(['فرسایش'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '778',
                                                'name'     => 'چرخۀ سنگ',
                                                'tags'     => json_encode(['چرخۀ_سنگ'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '787',
                                        'name'     => 'فصل چهاردهم: نور و ویژگی‌های آن',
                                        'tags'     => json_encode(['فصل_چهاردهم:_نور_و_ویژگی‌های_آن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '780',
                                                'name'     => 'چشمه‌های نور - چگونگی انتشار نور',
                                                'tags'     => json_encode(['چشمه‌های_نور_-_چگونگی_انتشار_نور'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '781',
                                                'name'     => 'سایه و نیم‌سایه',
                                                'tags'     => json_encode(['سایه_و_نیم‌سایه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '782',
                                                'name'     => 'بازتاب نور',
                                                'tags'     => json_encode(['بازتاب_نور'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '783',
                                                'name'     => 'تصویر در آینۀ تخت',
                                                'tags'     => json_encode(['تصویر_در_آینۀ_تخت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '786',
                                                'name'     => 'آینه‌های کروی',
                                                'tags'     => json_encode(['آینه‌های_کروی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '784',
                                                        'name'     => 'آینه‌های کاو',
                                                        'tags'     => json_encode(['آینه‌های_کاو'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '785',
                                                        'name'     => 'آینه‌های کوژ',
                                                        'tags'     => json_encode(['آینه‌های_کوژ'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '793',
                                        'name'     => 'فصل پانزدهم: شکست نور',
                                        'tags'     => json_encode(['فصل_پانزدهم:_شکست_نور'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '788',
                                                'name'     => 'شکست نور',
                                                'tags'     => json_encode(['شکست_نور'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '789',
                                                'name'     => 'منشور',
                                                'tags'     => json_encode(['منشور'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '792',
                                                'name'     => 'عدسی‌ها',
                                                'tags'     => json_encode(['عدسی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '790',
                                                        'name'     => 'عدسی‌های همگرا',
                                                        'tags'     => json_encode(['عدسی‌های_همگرا'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '791',
                                                        'name'     => 'عدسی‌های واگرا',
                                                        'tags'     => json_encode(['عدسی‌های_واگرا'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '924',
                                'name'     => 'فارسی',
                                'tags'     => json_encode(['فارسی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '801',
                                        'name'     => 'درس اول: پیش از این‌ها',
                                        'tags'     => json_encode(['درس_اول:_پیش_از_این‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '795',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '796',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '797',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '798',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '799',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '800',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '808',
                                        'name'     => 'درس دوم: خوب، جهان را ببین!، صورتگر ماهر',
                                        'tags'     => json_encode(['درس_دوم:_خوب،_جهان_را_ببین!،_صورتگر_ماهر'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '802',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '803',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '804',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '805',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '806',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '807',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '815',
                                        'name'     => 'درس سوم: ارمغان ایران',
                                        'tags'     => json_encode(['درس_سوم:_ارمغان_ایران'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '809',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '810',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '811',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '812',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '813',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '814',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '823',
                                        'name'     => 'درس چهارم: سفر شکفتن',
                                        'tags'     => json_encode(['درس_چهارم:_سفر_شکفتن'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '816',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '817',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '818',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '819',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '820',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '821',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '822',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '830',
                                        'name'     => 'درس ششم: راه نیک‌بختی',
                                        'tags'     => json_encode(['درس_ششم:_راه_نیک‌بختی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '824',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '825',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '826',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '827',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '828',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '829',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '837',
                                        'name'     => 'درس هفتم: آداب نیکان',
                                        'tags'     => json_encode(['درس_هفتم:_آداب_نیکان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '831',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '832',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '833',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '834',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '835',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '836',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '844',
                                        'name'     => 'درس هشتم: آزادگی',
                                        'tags'     => json_encode(['درس_هشتم:_آزادگی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '838',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '839',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '840',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '841',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '842',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '843',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '851',
                                        'name'     => 'درس نهم: نوجوان باهوش، آشپز زادۀ وزیر، گریۀ امیر',
                                        'tags'     => json_encode(['درس_نهم:_نوجوان_باهوش،_آشپز_زادۀ_وزیر،_گریۀ_امیر'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '845',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '846',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '847',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '848',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '849',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '850',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '858',
                                        'name'     => 'درس دهم: قلم سحرآمیز، دو نامه',
                                        'tags'     => json_encode(['درس_دهم:_قلم_سحرآمیز،_دو_نامه'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '852',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '853',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '854',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '855',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '856',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '857',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '866',
                                        'name'     => 'درس یازدهم: پرچم‌داران',
                                        'tags'     => json_encode(['درس_یازدهم:_پرچم‌داران'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '859',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '860',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '861',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '862',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '863',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '864',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '865',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '873',
                                        'name'     => 'درس دوازدهم: شیر حق',
                                        'tags'     => json_encode(['درس_دوازدهم:_شیر_حق'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '867',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '868',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '869',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '870',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '871',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '872',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '880',
                                        'name'     => 'درس سیزدهم: ادبیات انقلاب',
                                        'tags'     => json_encode(['درس_سیزدهم:_ادبیات_انقلاب'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '874',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '875',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '876',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '877',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '878',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '879',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '887',
                                        'name'     => 'درس چهاردهم: یاد حسین',
                                        'tags'     => json_encode(['درس_چهاردهم:_یاد_حسین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '881',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '882',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '883',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '884',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '885',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '886',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '894',
                                        'name'     => 'درس شانزدهم: پرندۀ آزادی، کودکان سنگ',
                                        'tags'     => json_encode(['درس_شانزدهم:_پرندۀ_آزادی،_کودکان_سنگ'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '888',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '889',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '890',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '891',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '892',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '893',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '901',
                                        'name'     => 'درس هفدهم: راه خوشبختی',
                                        'tags'     => json_encode(['درس_هفدهم:_راه_خوشبختی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '895',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '896',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '897',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '898',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '899',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '900',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '908',
                                        'name'     => 'ستایش: به نام خدایی که جان آفرید',
                                        'tags'     => json_encode(['ستایش:_به_نام_خدایی_که_جان_آفرید'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '902',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '903',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '904',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '905',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '906',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '907',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '915',
                                        'name'     => 'نیایش',
                                        'tags'     => json_encode(['نیایش'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '909',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '910',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '911',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '912',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '913',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '914',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '923',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '916',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '917',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '918',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '919',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '920',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '921',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '922',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1032',
                                'name'     => 'مطالعات اجتماعی',
                                'tags'     => json_encode(['مطالعات_اجتماعی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '927',
                                        'name'     => 'درس 1: تعاون (1)',
                                        'tags'     => json_encode(['درس_1:_تعاون_(1)'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '925',
                                                'name'     => 'تعاون و شکل‌های مختلف آن',
                                                'tags'     => json_encode(['تعاون_و_شکل‌های_مختلف_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '926',
                                                'name'     => 'تعاون در خانه، مدرسه و محله',
                                                'tags'     => json_encode(['تعاون_در_خانه،_مدرسه_و_محله'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '931',
                                        'name'     => 'درس 2: تعاون (2)',
                                        'tags'     => json_encode(['درس_2:_تعاون_(2)'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '928',
                                                'name'     => 'انفاق',
                                                'tags'     => json_encode(['انفاق'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '929',
                                                'name'     => 'وقف',
                                                'tags'     => json_encode(['وقف'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '930',
                                                'name'     => 'شرکت‌های تعاونی',
                                                'tags'     => json_encode(['شرکت‌های_تعاونی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '936',
                                        'name'     => 'درس 3: ساختار و تشکیلات دولت',
                                        'tags'     => json_encode(['درس_3:_ساختار_و_تشکیلات_دولت'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '932',
                                                'name'     => 'قوۀ مجریه',
                                                'tags'     => json_encode(['قوۀ_مجریه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '933',
                                                'name'     => 'انتخاب رئیس‌جمهور',
                                                'tags'     => json_encode(['انتخاب_رئیس‌جمهور'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '934',
                                                'name'     => 'تنفیذ و تحلیف',
                                                'tags'     => json_encode(['تنفیذ_و_تحلیف'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '935',
                                                'name'     => 'کابینه',
                                                'tags'     => json_encode(['کابینه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '941',
                                        'name'     => 'درس 4: وظایف دولت',
                                        'tags'     => json_encode(['درس_4:_وظایف_دولت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '937',
                                                'name'     => 'دولت و شهروندان',
                                                'tags'     => json_encode(['دولت_و_شهروندان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '938',
                                                'name'     => 'مهم‌ترین وظایف دولت و رئیس‌جمهور',
                                                'tags'     => json_encode(['مهم‌ترین_وظایف_دولت_و_رئیس‌جمهور'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '939',
                                                'name'     => 'دولت و مجلس',
                                                'tags'     => json_encode(['دولت_و_مجلس'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '940',
                                                'name'     => 'درآمد و هزینه‌های دولت',
                                                'tags'     => json_encode(['درآمد_و_هزینه‌های_دولت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '944',
                                        'name'     => 'درس 5: آسیب‌های اجتماعی و پیشگیری از آن‌ها',
                                        'tags'     => json_encode(['درس_5:_آسیب‌های_اجتماعی_و_پیشگیری_از_آن‌ها'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '942',
                                                'name'     => 'دورۀ نوجوانی',
                                                'tags'     => json_encode(['دورۀ_نوجوانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '943',
                                                'name'     => 'آسیب‌های اجتماعی',
                                                'tags'     => json_encode(['آسیب‌های_اجتماعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '948',
                                        'name'     => 'درس 6: قوۀ قضائیه',
                                        'tags'     => json_encode(['درس_6:_قوۀ_قضائیه'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '945',
                                                'name'     => 'افرادی که از نوجوان در برابر آسیب‌ها و تهدیدات محافظت می‌کنند',
                                                'tags'     => json_encode(['افرادی_که_از_نوجوان_در_برابر_آسیب‌ها_و_تهدیدات_محافظت_می‌کنند'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '946',
                                                'name'     => 'قوۀ قضائیه',
                                                'tags'     => json_encode(['قوۀ_قضائیه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '947',
                                                'name'     => 'رسیدگی به شکایت‌های مردم و حل اختلاف',
                                                'tags'     => json_encode(['رسیدگی_به_شکایت‌های_مردم_و_حل_اختلاف'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '953',
                                        'name'     => 'درس 7: ارتباط و رسانه',
                                        'tags'     => json_encode(['درس_7:_ارتباط_و_رسانه'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '949',
                                                'name'     => 'نیاز به ارتباط',
                                                'tags'     => json_encode(['نیاز_به_ارتباط'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '950',
                                                'name'     => 'عناصر ارتباط',
                                                'tags'     => json_encode(['عناصر_ارتباط'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '951',
                                                'name'     => 'رسانه',
                                                'tags'     => json_encode(['رسانه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '952',
                                                'name'     => 'وزارت ارتباطات و فناوری اطلاعات',
                                                'tags'     => json_encode(['وزارت_ارتباطات_و_فناوری_اطلاعات'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '956',
                                        'name'     => 'درس 8: رسانه‌ها در زندگی ما',
                                        'tags'     => json_encode(['درس_8:_رسانه‌ها_در_زندگی_ما'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '954',
                                                'name'     => 'کاربرد‌های رسانه‌ها در زندگی ما',
                                                'tags'     => json_encode(['کاربرد‌های_رسانه‌ها_در_زندگی_ما'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '955',
                                                'name'     => 'تأثیر وسایل ارتباط جمعی بر فرهنگ عمومی',
                                                'tags'     => json_encode(['تأثیر_وسایل_ارتباط_جمعی_بر_فرهنگ_عمومی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '960',
                                        'name'     => 'درس 9: ظهور اسلام در شبه‌جزیرۀ عربستان',
                                        'tags'     => json_encode(['درس_9:_ظهور_اسلام_در_شبه‌جزیرۀ_عربستان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '957',
                                                'name'     => 'محیط پیدایش اسلام',
                                                'tags'     => json_encode(['محیط_پیدایش_اسلام'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '958',
                                                'name'     => 'طلوع آفتاب اسلام در مکه',
                                                'tags'     => json_encode(['طلوع_آفتاب_اسلام_در_مکه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '959',
                                                'name'     => 'تشکیل امت و حکومت اسلامی به رهبری پیامبر (ص) در مدینه',
                                                'tags'     => json_encode(['تشکیل_امت_و_حکومت_اسلامی_به_رهبری_پیامبر_(ص)_در_مدینه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '965',
                                        'name'     => 'درس 10: از رحلت پیامبر (ص) تا قیام کربلا (نینوا)',
                                        'tags'     => json_encode(['درس_10:_از_رحلت_پیامبر_(ص)_تا_قیام_کربلا_(نینوا)'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '961',
                                                'name'     => 'وفات پیامبر (ص) و ماجرای سقیفه و جانشینی پیامبر (ص)',
                                                'tags'     => json_encode(['وفات_پیامبر_(ص)_و_ماجرای_سقیفه_و_جانشینی_پیامبر_(ص)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '962',
                                                'name'     => 'حکومت امام علی (ع)',
                                                'tags'     => json_encode(['حکومت_امام_علی_(ع)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '963',
                                                'name'     => 'صلح امام حسن (ع) با معاویه و روی کار آمدن امویان',
                                                'tags'     => json_encode(['صلح_امام_حسن_(ع)_با_معاویه_و_روی_کار_آمدن_امویان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '964',
                                                'name'     => 'قیام امام حسین (ع)',
                                                'tags'     => json_encode(['قیام_امام_حسین_(ع)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '969',
                                        'name'     => 'درس 11: ورود اسلام به ایران',
                                        'tags'     => json_encode(['درس_11:_ورود_اسلام_به_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '966',
                                                'name'     => 'حملۀ اعراب مسلمان به ایران و سقوط ساسانیان',
                                                'tags'     => json_encode(['حملۀ_اعراب_مسلمان_به_ایران_و_سقوط_ساسانیان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '967',
                                                'name'     => 'ایران در زمان امویان و عباسیان',
                                                'tags'     => json_encode(['ایران_در_زمان_امویان_و_عباسیان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '968',
                                                'name'     => 'ایرانیان مسلمان می‌شوند',
                                                'tags'     => json_encode(['ایرانیان_مسلمان_می‌شوند'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '973',
                                        'name'     => 'درس 12: عصر طلایی فرهنگ و تمدن ایرانی- اسلامی',
                                        'tags'     => json_encode(['درس_12:_عصر_طلایی_فرهنگ_و_تمدن_ایرانی-_اسلامی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '970',
                                                'name'     => 'تأسیس سلسله‌های ایرانی',
                                                'tags'     => json_encode(['تأسیس_سلسله‌های_ایرانی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '971',
                                                'name'     => 'ایرانیان، پرچمدار علم و دانش',
                                                'tags'     => json_encode(['ایرانیان،_پرچمدار_علم_و_دانش'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '972',
                                                'name'     => 'زبان و ادبیات و معماری',
                                                'tags'     => json_encode(['زبان_و_ادبیات_و_معماری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '977',
                                        'name'     => 'درس 13: غزنویان، سلجوقیان و خوارزمشاهیان',
                                        'tags'     => json_encode(['درس_13:_غزنویان،_سلجوقیان_و_خوارزمشاهیان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '974',
                                                'name'     => 'غزنویان',
                                                'tags'     => json_encode(['غزنویان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '975',
                                                'name'     => 'سلجوقیان',
                                                'tags'     => json_encode(['سلجوقیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '976',
                                                'name'     => 'خوارزمشاهیان',
                                                'tags'     => json_encode(['خوارزمشاهیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '981',
                                        'name'     => 'درس 14: میراث فرهنگی ایران در عصر سلجوقی',
                                        'tags'     => json_encode(['درس_14:_میراث_فرهنگی_ایران_در_عصر_سلجوقی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '978',
                                                'name'     => 'تشکیلات حکومتی',
                                                'tags'     => json_encode(['تشکیلات_حکومتی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '979',
                                                'name'     => 'میراث فرهنگی و تمدنی',
                                                'tags'     => json_encode(['میراث_فرهنگی_و_تمدنی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '980',
                                                'name'     => 'توسعۀ شهرها، معماری و هنر',
                                                'tags'     => json_encode(['توسعۀ_شهرها،_معماری_و_هنر'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '985',
                                        'name'     => 'درس 15: حملۀ چنگیز و تیمور به ایران',
                                        'tags'     => json_encode(['درس_15:_حملۀ_چنگیز_و_تیمور_به_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '982',
                                                'name'     => 'مغولان و هجوم آن‌ها به ایران',
                                                'tags'     => json_encode(['مغولان_و_هجوم_آن‌ها_به_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '983',
                                                'name'     => 'حکومت مغولان (ایلخانان) بر ایران و قیام سربداران',
                                                'tags'     => json_encode(['حکومت_مغولان_(ایلخانان)_بر_ایران_و_قیام_سربداران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '984',
                                                'name'     => 'هجوم تیمور به ایران',
                                                'tags'     => json_encode(['هجوم_تیمور_به_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '989',
                                        'name'     => 'درس 16: پیروزی فرهنگ بر شمشیر',
                                        'tags'     => json_encode(['درس_16:_پیروزی_فرهنگ_بر_شمشیر'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '986',
                                                'name'     => 'تأثیر فرهنگ ایرانی بر مغولان',
                                                'tags'     => json_encode(['تأثیر_فرهنگ_ایرانی_بر_مغولان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '987',
                                                'name'     => 'توجه ایلخانان به معماری و هنر',
                                                'tags'     => json_encode(['توجه_ایلخانان_به_معماری_و_هنر'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '988',
                                                'name'     => 'علاقه‌مندی جانشینان تیمور به معماری و هنر',
                                                'tags'     => json_encode(['علاقه‌مندی_جانشینان_تیمور_به_معماری_و_هنر'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '993',
                                        'name'     => 'درس 17: ویژگی‌های طبیعی آسیا',
                                        'tags'     => json_encode(['درس_17:_ویژگی‌های_طبیعی_آسیا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '990',
                                                'name'     => 'موقعیت و وسعت',
                                                'tags'     => json_encode(['موقعیت_و_وسعت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '991',
                                                'name'     => 'ناهمواری‌ها (اشکال زمین)',
                                                'tags'     => json_encode(['ناهمواری‌ها_(اشکال_زمین)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '992',
                                                'name'     => 'آب‌و‌هوا',
                                                'tags'     => json_encode(['آب‌و‌هوا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '999',
                                        'name'     => 'درس 18: ویژگی‌های انسانی و اقتصادی آسیا',
                                        'tags'     => json_encode(['درس_18:_ویژگی‌های_انسانی_و_اقتصادی_آسیا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '994',
                                                'name'     => 'جمعیت',
                                                'tags'     => json_encode(['جمعیت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '995',
                                                'name'     => 'نژاد و زبان و دین',
                                                'tags'     => json_encode(['نژاد_و_زبان_و_دین'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '996',
                                                'name'     => 'اقتصاد',
                                                'tags'     => json_encode(['اقتصاد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '997',
                                                'name'     => 'جاذبه‌های گردشگری',
                                                'tags'     => json_encode(['جاذبه‌های_گردشگری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '998',
                                                'name'     => 'استفاده از اطلس',
                                                'tags'     => json_encode(['استفاده_از_اطلس'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1002',
                                        'name'     => 'درس 19: ویژگی‌های منطقۀ جنوب غربی آسیا',
                                        'tags'     => json_encode(['درس_19:_ویژگی‌های_منطقۀ_جنوب_غربی_آسیا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1000',
                                                'name'     => 'موقعیت و ویژگی‌های طبیعی',
                                                'tags'     => json_encode(['موقعیت_و_ویژگی‌های_طبیعی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1001',
                                                'name'     => 'ویژگی‌های انسانی و اقتصادی',
                                                'tags'     => json_encode(['ویژگی‌های_انسانی_و_اقتصادی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1007',
                                        'name'     => 'درس 20: ایران و منطقۀ جنوب غربی آسیا',
                                        'tags'     => json_encode(['درس_20:_ایران_و_منطقۀ_جنوب_غربی_آسیا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1003',
                                                'name'     => 'جنوب غربی آسیا، منطقه‌ای استراتژیک و پرتنش',
                                                'tags'     => json_encode(['جنوب_غربی_آسیا،_منطقه‌ای_استراتژیک_و_پرتنش'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1004',
                                                'name'     => 'جایگاه ایران در منطقه',
                                                'tags'     => json_encode(['جایگاه_ایران_در_منطقه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1005',
                                                'name'     => 'فلسطین، موضوع مهم جهان اسلام',
                                                'tags'     => json_encode(['فلسطین،_موضوع_مهم_جهان_اسلام'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1006',
                                                'name'     => 'مقیاس نقشه و محاسبۀ مسافت‌ها',
                                                'tags'     => json_encode(['مقیاس_نقشه_و_محاسبۀ_مسافت‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1014',
                                        'name'     => 'درس 21: ویژگی‌های طبیعی و انسانی اروپا',
                                        'tags'     => json_encode(['درس_21:_ویژگی‌های_طبیعی_و_انسانی_اروپا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1010',
                                                'name'     => 'ویژگی‌های طبیعی',
                                                'tags'     => json_encode(['ویژگی‌های_طبیعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1008',
                                                        'name'     => 'موقعیت، وسعت و ناهمواری‌ها',
                                                        'tags'     => json_encode(['موقعیت،_وسعت_و_ناهمواری‌ها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1009',
                                                        'name'     => 'آب‌و‌هوا و رودها',
                                                        'tags'     => json_encode(['آب‌و‌هوا_و_رودها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '1013',
                                                'name'     => 'ویژگی‌های انسانی',
                                                'tags'     => json_encode(['ویژگی‌های_انسانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1011',
                                                        'name'     => 'جمعیت، نژاد، زبان و دین',
                                                        'tags'     => json_encode(['جمعیت،_نژاد،_زبان_و_دین'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1012',
                                                        'name'     => 'اقتصاد',
                                                        'tags'     => json_encode(['اقتصاد'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1021',
                                        'name'     => 'درس 22: ویژگی‌های طبیعی و انسانی آفریقا',
                                        'tags'     => json_encode(['درس_22:_ویژگی‌های_طبیعی_و_انسانی_آفریقا'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1017',
                                                'name'     => 'ویژگی‌های طبیعی',
                                                'tags'     => json_encode(['ویژگی‌های_طبیعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1015',
                                                        'name'     => 'موقعیت، وسعت و ناهمواری‌ها',
                                                        'tags'     => json_encode(['موقعیت،_وسعت_و_ناهمواری‌ها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1016',
                                                        'name'     => 'آب‌و‌هوا و رودها',
                                                        'tags'     => json_encode(['آب‌و‌هوا_و_رودها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '1020',
                                                'name'     => 'ویژگی‌های انسانی',
                                                'tags'     => json_encode(['ویژگی‌های_انسانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1018',
                                                        'name'     => 'جمعیت، نژاد، زبان و دین',
                                                        'tags'     => json_encode(['جمعیت،_نژاد،_زبان_و_دین'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1019',
                                                        'name'     => 'اقتصاد',
                                                        'tags'     => json_encode(['اقتصاد'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1028',
                                        'name'     => 'درس 23: قارۀ آمریکا',
                                        'tags'     => json_encode(['درس_23:_قارۀ_آمریکا'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1024',
                                                'name'     => 'ویژگی‌های طبیعی',
                                                'tags'     => json_encode(['ویژگی‌های_طبیعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1022',
                                                        'name'     => 'موقعیت، وسعت و ناهمواری‌ها',
                                                        'tags'     => json_encode(['موقعیت،_وسعت_و_ناهمواری‌ها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1023',
                                                        'name'     => 'آب‌و‌هوا و رودها',
                                                        'tags'     => json_encode(['آب‌و‌هوا_و_رودها'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],
                                            [
                                                'id'       => '1027',
                                                'name'     => 'ویژگی‌های انسانی',
                                                'tags'     => json_encode(['ویژگی‌های_انسانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1025',
                                                        'name'     => 'جمعیت، نژاد، زبان و دین',
                                                        'tags'     => json_encode(['جمعیت،_نژاد،_زبان_و_دین'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1026',
                                                        'name'     => 'اقتصاد',
                                                        'tags'     => json_encode(['اقتصاد'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1031',
                                        'name'     => 'درس 24: قارۀ استرالیا و اقیانوسیه',
                                        'tags'     => json_encode(['درس_24:_قارۀ_استرالیا_و_اقیانوسیه'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1029',
                                                'name'     => 'موقعیت و وسعت و ویژگی‌های طبیعی',
                                                'tags'     => json_encode(['موقعیت_و_وسعت_و_ویژگی‌های_طبیعی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1030',
                                                'name'     => 'ویژگی‌های انسانی و اقتصادی',
                                                'tags'     => json_encode(['ویژگی‌های_انسانی_و_اقتصادی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1078',
                                'name'     => 'پیام‌های آسمان',
                                'tags'     => json_encode(['پیام‌های_آسمان'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1035',
                                        'name'     => 'درس اول: آفرینش شگفت‌انگیز',
                                        'tags'     => json_encode(['درس_اول:_آفرینش_شگفت‌انگیز'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1033',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1034',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1038',
                                        'name'     => 'درس دوم: عفو و گذشت',
                                        'tags'     => json_encode(['درس_دوم:_عفو_و_گذشت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1036',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1037',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1041',
                                        'name'     => 'درس سوم: همه‌چیز در دست تو',
                                        'tags'     => json_encode(['درس_سوم:_همه‌چیز_در_دست_تو'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1039',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1040',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1044',
                                        'name'     => 'درس چهارم: پیوند جاودان',
                                        'tags'     => json_encode(['درس_چهارم:_پیوند_جاودان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1042',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1043',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1047',
                                        'name'     => 'درس پنجم: روزی که اسلام کامل شد',
                                        'tags'     => json_encode(['درس_پنجم:_روزی_که_اسلام_کامل_شد'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1045',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1046',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1050',
                                        'name'     => 'درس ششم: نردبان آسمان',
                                        'tags'     => json_encode(['درس_ششم:_نردبان_آسمان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1048',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1049',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1053',
                                        'name'     => 'درس هفتم: یک فرصت طلایی',
                                        'tags'     => json_encode(['درس_هفتم:_یک_فرصت_طلایی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1051',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1052',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1056',
                                        'name'     => 'درس هشتم: نشان ارزشمندی',
                                        'tags'     => json_encode(['درس_هشتم:_نشان_ارزشمندی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1054',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1055',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1059',
                                        'name'     => 'درس نهم: تدبیر زندگانی',
                                        'tags'     => json_encode(['درس_نهم:_تدبیر_زندگانی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1057',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1058',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1062',
                                        'name'     => 'درس دهم: دو سرمایۀ گران‌بها',
                                        'tags'     => json_encode(['درس_دهم:_دو_سرمایۀ_گران‌بها'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1060',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1061',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1065',
                                        'name'     => 'درس یازدهم: آفت‌های زبان',
                                        'tags'     => json_encode(['درس_یازدهم:_آفت‌های_زبان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1063',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1064',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1068',
                                        'name'     => 'درس دوازدهم: ارزش کار',
                                        'tags'     => json_encode(['درس_دوازدهم:_ارزش_کار'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1066',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1067',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1071',
                                        'name'     => 'درس سیزدهم: کلید گنج‌ها',
                                        'tags'     => json_encode(['درس_سیزدهم:_کلید_گنج‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1069',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1070',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1074',
                                        'name'     => 'درس چهاردهم: ما مسلمانان',
                                        'tags'     => json_encode(['درس_چهاردهم:_ما_مسلمانان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1072',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1073',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1077',
                                        'name'     => 'درس پانزدهم: حق‌الناس',
                                        'tags'     => json_encode(['درس_پانزدهم:_حق‌الناس'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1075',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1076',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],

                        ],
                    ],
                    [
                        'id'       => '1612',
                        'name'     => 'نهم',
                        'tags'     => json_encode(['نهم'], JSON_UNESCAPED_UNICODE),
                        'children' => [
                            [
                                'id'       => '1116',
                                'name'     => 'ریاضی',
                                'tags'     => json_encode(['ریاضی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1084',
                                        'name'     => 'فصل 1: مجموعه‌ها',
                                        'tags'     => json_encode(['فصل_1:_مجموعه‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1080',
                                                'name'     => 'درس اول: معرفی مجموعه',
                                                'tags'     => json_encode(['درس_اول:_معرفی_مجموعه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1081',
                                                'name'     => 'درس دوم: مجموعه‌های برابر و نمایش مجموعه‌ها',
                                                'tags'     => json_encode(['درس_دوم:_مجموعه‌های_برابر_و_نمایش_مجموعه‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1082',
                                                'name'     => 'درس سوم: اجتماع، اشتراک و تفاضلِ مجموعه‌ها',
                                                'tags'     => json_encode(['درس_سوم:_اجتماع،_اشتراک_و_تفاضلِ_مجموعه‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1083',
                                                'name'     => 'درس چهارم: مجموعه‌ها و احتمال',
                                                'tags'     => json_encode(['درس_چهارم:_مجموعه‌ها_و_احتمال'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1088',
                                        'name'     => 'فصل 2: عددهای حقیقی',
                                        'tags'     => json_encode(['فصل_2:_عددهای_حقیقی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1085',
                                                'name'     => 'درس اول: عددهای گویا',
                                                'tags'     => json_encode(['درس_اول:_عددهای_گویا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1086',
                                                'name'     => 'درس دوم: عددهای حقیقی',
                                                'tags'     => json_encode(['درس_دوم:_عددهای_حقیقی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1087',
                                                'name'     => 'درس سوم: قدر مطلق و محاسبۀ تقریبی',
                                                'tags'     => json_encode(['درس_سوم:_قدر_مطلق_و_محاسبۀ_تقریبی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1094',
                                        'name'     => 'فصل 3: استدلال و اثبات در هندسه',
                                        'tags'     => json_encode(['فصل_3:_استدلال_و_اثبات_در_هندسه'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1089',
                                                'name'     => 'درس اول: استدلال',
                                                'tags'     => json_encode(['درس_اول:_استدلال'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1090',
                                                'name'     => 'درس دوم: آشنایی با اثبات در هندسه',
                                                'tags'     => json_encode(['درس_دوم:_آشنایی_با_اثبات_در_هندسه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1091',
                                                'name'     => 'درس سوم: همنهشتی مثلث‌ها',
                                                'tags'     => json_encode(['درس_سوم:_همنهشتی_مثلث‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1092',
                                                'name'     => 'درس چهارم: حل مسئله در هندسه',
                                                'tags'     => json_encode(['درس_چهارم:_حل_مسئله_در_هندسه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1093',
                                                'name'     => 'درس پنجم: شکل‌های متشابه',
                                                'tags'     => json_encode(['درس_پنجم:_شکل‌های_متشابه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1099',
                                        'name'     => 'فصل 4: توان و ریشه',
                                        'tags'     => json_encode(['فصل_4:_توان_و_ریشه'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1095',
                                                'name'     => 'درس اول: توان صحیح',
                                                'tags'     => json_encode(['درس_اول:_توان_صحیح'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1096',
                                                'name'     => 'درس دوم: نماد علمی',
                                                'tags'     => json_encode(['درس_دوم:_نماد_علمی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1097',
                                                'name'     => 'درس سوم: ریشه‌گیری',
                                                'tags'     => json_encode(['درس_سوم:_ریشه‌گیری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1098',
                                                'name'     => 'درس چهارم: جمع و تفریق رادیکال‌ها',
                                                'tags'     => json_encode(['درس_چهارم:_جمع_و_تفریق_رادیکال‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1103',
                                        'name'     => 'فصل 5: عبارت‌های جبری',
                                        'tags'     => json_encode(['فصل_5:_عبارت‌های_جبری'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1100',
                                                'name'     => 'درس اول: عبارت‌های جبری و مفهوم اتحاد',
                                                'tags'     => json_encode(['درس_اول:_عبارت‌های_جبری_و_مفهوم_اتحاد'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1101',
                                                'name'     => 'درس دوم: چند اتحاد دیگر، تجزیه و کاربرد‌ها',
                                                'tags'     => json_encode(['درس_دوم:_چند_اتحاد_دیگر،_تجزیه_و_کاربرد‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1102',
                                                'name'     => 'درس سوم: نابرابری‌ها و نامعادله‌ها',
                                                'tags'     => json_encode(['درس_سوم:_نابرابری‌ها_و_نامعادله‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1107',
                                        'name'     => 'فصل 6: خط و معادله‌های خطی',
                                        'tags'     => json_encode(['فصل_6:_خط_و_معادله‌های_خطی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1104',
                                                'name'     => 'درس اول: معادلۀ خط',
                                                'tags'     => json_encode(['درس_اول:_معادلۀ_خط'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1105',
                                                'name'     => 'درس دوم: شیب خط و عرض از مبدأ',
                                                'tags'     => json_encode(['درس_دوم:_شیب_خط_و_عرض_از_مبدأ'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1106',
                                                'name'     => 'درس سوم: دستگاه معادله‌های خطی',
                                                'tags'     => json_encode(['درس_سوم:_دستگاه_معادله‌های_خطی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1111',
                                        'name'     => 'فصل 7: عبارت‌های گویا',
                                        'tags'     => json_encode(['فصل_7:_عبارت‌های_گویا'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1108',
                                                'name'     => 'درس اول: معرفی و ساده‌ کردن عبارت‌های گویا',
                                                'tags'     => json_encode(['درس_اول:_معرفی_و_ساده‌_کردن_عبارت‌های_گویا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1109',
                                                'name'     => 'درس دوم: محاسبات عبارت‌های گویا',
                                                'tags'     => json_encode(['درس_دوم:_محاسبات_عبارت‌های_گویا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1110',
                                                'name'     => 'درس سوم: تقسیم چند‌جمله‌ای‌ها',
                                                'tags'     => json_encode(['درس_سوم:_تقسیم_چند‌جمله‌ای‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1115',
                                        'name'     => 'فصل 8: حجم و مساحت',
                                        'tags'     => json_encode(['فصل_8:_حجم_و_مساحت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1112',
                                                'name'     => 'درس اول: حجم و مساحت کره',
                                                'tags'     => json_encode(['درس_اول:_حجم_و_مساحت_کره'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1113',
                                                'name'     => 'درس دوم: حجم هرم و مخروط',
                                                'tags'     => json_encode(['درس_دوم:_حجم_هرم_و_مخروط'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1114',
                                                'name'     => 'درس سوم: سطح و حجم',
                                                'tags'     => json_encode(['درس_سوم:_سطح_و_حجم'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1180',
                                'name'     => 'زبان انگلیسی',
                                'tags'     => json_encode(['زبان_انگلیسی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1125',
                                        'name'     => 'Lesson 1: Personality',
                                        'tags'     => json_encode(['Lesson_1:_Personality'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1117',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1118',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1119',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1120',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1121',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1122',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1123',
                                                'name'     => 'cloze',
                                                'tags'     => json_encode(['cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1124',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1134',
                                        'name'     => 'Lesson 2: Travel',
                                        'tags'     => json_encode(['Lesson_2:_Travel'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1126',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1127',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1128',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1129',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1130',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1131',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1132',
                                                'name'     => 'cloze',
                                                'tags'     => json_encode(['cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1133',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1143',
                                        'name'     => 'Lesson 3: Festivals and Ceremonies',
                                        'tags'     => json_encode(['Lesson_3:_Festivals_and_Ceremonies'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1135',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1136',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1137',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1138',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1139',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1140',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1141',
                                                'name'     => 'cloze',
                                                'tags'     => json_encode(['cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1142',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1152',
                                        'name'     => 'Lesson 4: Service',
                                        'tags'     => json_encode(['Lesson_4:_Service'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1144',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1145',
                                                'name'     => 'Cloze',
                                                'tags'     => json_encode(['Cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1146',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1147',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1148',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1149',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1150',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1151',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1161',
                                        'name'     => 'Lesson 5: Media',
                                        'tags'     => json_encode(['Lesson_5:_Media'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1153',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1154',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1155',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1156',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1157',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1158',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1159',
                                                'name'     => 'cloze',
                                                'tags'     => json_encode(['cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1160',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1170',
                                        'name'     => 'Lesson 6: Health and Injuries',
                                        'tags'     => json_encode(['Lesson_6:_Health_and_Injuries'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1162',
                                                'name'     => 'Vocabulary',
                                                'tags'     => json_encode(['Vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1163',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1164',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1165',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1166',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1167',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1168',
                                                'name'     => 'cloze',
                                                'tags'     => json_encode(['cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1169',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1179',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1171',
                                                'name'     => 'Reading',
                                                'tags'     => json_encode(['Reading'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1172',
                                                'name'     => 'Writing',
                                                'tags'     => json_encode(['Writing'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1173',
                                                'name'     => '(Language Melody (Intonation',
                                                'tags'     => json_encode(['(Language_Melody_(Intonation'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1174',
                                                'name'     => 'Conversation',
                                                'tags'     => json_encode(['Conversation'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1175',
                                                'name'     => 'cloze',
                                                'tags'     => json_encode(['cloze'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1176',
                                                'name'     => 'vocabulary',
                                                'tags'     => json_encode(['vocabulary'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1177',
                                                'name'     => 'Grammar',
                                                'tags'     => json_encode(['Grammar'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1178',
                                                'name'     => 'Spelling',
                                                'tags'     => json_encode(['Spelling'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1225',
                                'name'     => 'عربی',
                                'tags'     => json_encode(['عربی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1184',
                                        'name'     => 'الدرس الأول: مراجعة دروس الصف السابع و الثامن',
                                        'tags'     => json_encode(['الدرس_الأول:_مراجعة_دروس_الصف_السابع_و_الثامن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1181',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1182',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1183',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1188',
                                        'name'     => 'الدرس الثانی: العبور الآمن',
                                        'tags'     => json_encode(['الدرس_الثانی:_العبور_الآمن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1185',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1186',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1187',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1192',
                                        'name'     => 'الدرس الثالث: جسر الصداقة',
                                        'tags'     => json_encode(['الدرس_الثالث:_جسر_الصداقة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1189',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1190',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1191',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1196',
                                        'name'     => 'الدرس الرابع: الصبر مفتاح الفرج',
                                        'tags'     => json_encode(['الدرس_الرابع:_الصبر_مفتاح_الفرج'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1193',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1194',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1195',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1200',
                                        'name'     => 'الدرس الخامس: الرجاء',
                                        'tags'     => json_encode(['الدرس_الخامس:_الرجاء'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1197',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1198',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1199',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1204',
                                        'name'     => 'الدرس السادس: تغییر الحیاة',
                                        'tags'     => json_encode(['الدرس_السادس:_تغییر_الحیاة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1201',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1202',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1203',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1208',
                                        'name'     => 'الدرس السابع: ثمرة الجد',
                                        'tags'     => json_encode(['الدرس_السابع:_ثمرة_الجد'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1205',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1206',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1207',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1212',
                                        'name'     => 'الدرس الثامن: حوار بین الزائر و سائق سیارة الأجرة',
                                        'tags'     => json_encode(['الدرس_الثامن:_حوار_بین_الزائر_و_سائق_سیارة_الأجرة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1209',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1210',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1211',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1216',
                                        'name'     => 'الدرس التاسع: نصوص حول الصحة',
                                        'tags'     => json_encode(['الدرس_التاسع:_نصوص_حول_الصحة'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1213',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1214',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1215',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1220',
                                        'name'     => 'الدرس العاشر: الأمانة',
                                        'tags'     => json_encode(['الدرس_العاشر:_الأمانة'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1217',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1218',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1219',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1224',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1221',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1222',
                                                'name'     => 'ترجمۀ عبارات',
                                                'tags'     => json_encode(['ترجمۀ_عبارات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1223',
                                                'name'     => 'قواعد',
                                                'tags'     => json_encode(['قواعد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1333',
                                'name'     => 'علوم',
                                'tags'     => json_encode(['علوم'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1230',
                                        'name'     => 'فصل اول: مواد و نقش آن‌ها در زندگی',
                                        'tags'     => json_encode(['فصل_اول:_مواد_و_نقش_آن‌ها_در_زندگی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1226',
                                                'name'     => 'ویژگی‌ها و کاربرد فلزات',
                                                'tags'     => json_encode(['ویژگی‌ها_و_کاربرد_فلزات'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1227',
                                                'name'     => 'ویژگی‌ها و کاربرد نافلزات',
                                                'tags'     => json_encode(['ویژگی‌ها_و_کاربرد_نافلزات'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1228',
                                                'name'     => 'طبقه‌بندی عناصر بر‌اساس آرایش الکترونی',
                                                'tags'     => json_encode(['طبقه‌بندی_عناصر_بر‌اساس_آرایش_الکترونی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1229',
                                                'name'     => 'بسپارهای طبیعی و مصنوعی',
                                                'tags'     => json_encode(['بسپارهای_طبیعی_و_مصنوعی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1234',
                                        'name'     => 'فصل دوم: رفتار اتم‌ها با یکدیگر',
                                        'tags'     => json_encode(['فصل_دوم:_رفتار_اتم‌ها_با_یکدیگر'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1231',
                                                'name'     => 'ذره‌های سازندۀ مواد',
                                                'tags'     => json_encode(['ذره‌های_سازندۀ_مواد'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1232',
                                                'name'     => 'مبادلۀ الکترونی - پیوند یونی',
                                                'tags'     => json_encode(['مبادلۀ_الکترونی_-_پیوند_یونی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1233',
                                                'name'     => 'اشتراک الکترون ها - پیوند کووالانسی',
                                                'tags'     => json_encode(['اشتراک_الکترون_ها_-_پیوند_کووالانسی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1241',
                                        'name'     => 'فصل سوم: به دنبال محیطی بهتر برای زندگی',
                                        'tags'     => json_encode(['فصل_سوم:_به_دنبال_محیطی_بهتر_برای_زندگی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1235',
                                                'name'     => 'چرخه',
                                                'tags'     => json_encode(['چرخه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1236',
                                                'name'     => 'نفت خام و کاربردها',
                                                'tags'     => json_encode(['نفت_خام_و_کاربردها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1237',
                                                'name'     => 'هیدروکربن ها',
                                                'tags'     => json_encode(['هیدروکربن_ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1238',
                                                'name'     => 'اتن و واکنش پلیمری شدن (بسپارشی)',
                                                'tags'     => json_encode(['اتن_و_واکنش_پلیمری_شدن_(بسپارشی)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1239',
                                                'name'     => 'واکنش سوختن و تولید کربن دی اکسید',
                                                'tags'     => json_encode(['واکنش_سوختن_و_تولید_کربن_دی_اکسید'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1240',
                                                'name'     => 'پلاستیک ها؛ معایب و مزایا',
                                                'tags'     => json_encode(['پلاستیک_ها؛_معایب_و_مزایا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1249',
                                        'name'     => 'فصل چهارم: حرکت چیست',
                                        'tags'     => json_encode(['فصل_چهارم:_حرکت_چیست'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1242',
                                                'name'     => 'حرکت در همه‌چیز و همه‌جا',
                                                'tags'     => json_encode(['حرکت_در_همه‌چیز_و_همه‌جا'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1243',
                                                'name'     => 'مسافت و جا‌به‌جایی',
                                                'tags'     => json_encode(['مسافت_و_جا‌به‌جایی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1244',
                                                'name'     => 'تندی و سرعت',
                                                'tags'     => json_encode(['تندی_و_سرعت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1245',
                                                'name'     => 'حرکت یکنواخت',
                                                'tags'     => json_encode(['حرکت_یکنواخت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1246',
                                                'name'     => 'شتاب متوسط',
                                                'tags'     => json_encode(['شتاب_متوسط'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1247',
                                                'name'     => 'حرکت شتابدار با شتاب ثابت',
                                                'tags'     => json_encode(['حرکت_شتابدار_با_شتاب_ثابت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1248',
                                                'name'     => 'نمودارهای حرکت',
                                                'tags'     => json_encode(['نمودارهای_حرکت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1260',
                                        'name'     => 'فصل پنجم: نیرو',
                                        'tags'     => json_encode(['فصل_پنجم:_نیرو'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1250',
                                                'name'     => 'تعریف نیرو و اثرات آن',
                                                'tags'     => json_encode(['تعریف_نیرو_و_اثرات_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1251',
                                                'name'     => 'ریاضیات حاکم بر نیروها (نیروی خالص)',
                                                'tags'     => json_encode(['ریاضیات_حاکم_بر_نیروها_(نیروی_خالص)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1252',
                                                'name'     => 'قانون اول نیوتون (نیروهای متوازن)',
                                                'tags'     => json_encode(['قانون_اول_نیوتون_(نیروهای_متوازن)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1253',
                                                'name'     => 'قانون دوم نیوتون (نیروهای خالص عامل شتاب)',
                                                'tags'     => json_encode(['قانون_دوم_نیوتون_(نیروهای_خالص_عامل_شتاب)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1254',
                                                'name'     => 'قانون سوم نیوتون (نیروی کنش و واکنش)',
                                                'tags'     => json_encode(['قانون_سوم_نیوتون_(نیروی_کنش_و_واکنش)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1259',
                                                'name'     => 'نیروهای خاص',
                                                'tags'     => json_encode(['نیروهای_خاص'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1255',
                                                        'name'     => 'نیروی گرانش (قانون جهانی گرانش)',
                                                        'tags'     => json_encode(['نیروی_گرانش_(قانون_جهانی_گرانش)'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1256',
                                                        'name'     => 'وزن',
                                                        'tags'     => json_encode(['وزن'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1257',
                                                        'name'     => 'عمودی تکیه‌گاه (سطح)',
                                                        'tags'     => json_encode(['عمودی_تکیه‌گاه_(سطح)'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1258',
                                                        'name'     => 'نیروی اصطکاک',
                                                        'tags'     => json_encode(['نیروی_اصطکاک'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1266',
                                        'name'     => 'فصل ششم: زمین‌ساخت ورقه‌ای',
                                        'tags'     => json_encode(['فصل_ششم:_زمین‌ساخت_ورقه‌ای'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1261',
                                                'name'     => 'قاره‌های متحرک',
                                                'tags'     => json_encode(['قاره‌های_متحرک'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1262',
                                                'name'     => 'زمین ساخت ورقه‌ای',
                                                'tags'     => json_encode(['زمین_ساخت_ورقه‌ای'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1263',
                                                'name'     => 'فرضیۀ گسترش بستر اقیانوس‌ها',
                                                'tags'     => json_encode(['فرضیۀ_گسترش_بستر_اقیانوس‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1264',
                                                'name'     => 'حرکت ورقه‌های سنگ‌کره',
                                                'tags'     => json_encode(['حرکت_ورقه‌های_سنگ‌کره'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1265',
                                                'name'     => 'پیامدهای حرکت ورقه‌های سنگ‌کره',
                                                'tags'     => json_encode(['پیامدهای_حرکت_ورقه‌های_سنگ‌کره'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1270',
                                        'name'     => 'فصل هفتم: آثاری از گذشتۀ زمین',
                                        'tags'     => json_encode(['فصل_هفتم:_آثاری_از_گذشتۀ_زمین'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1267',
                                                'name'     => 'فسیل و شرایط لازم برای تشکیل آن',
                                                'tags'     => json_encode(['فسیل_و_شرایط_لازم_برای_تشکیل_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1268',
                                                'name'     => 'راه‌های تشکیل فسیل',
                                                'tags'     => json_encode(['راه‌های_تشکیل_فسیل'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1269',
                                                'name'     => 'کاربرد فسیل‌ها',
                                                'tags'     => json_encode(['کاربرد_فسیل‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1276',
                                        'name'     => 'فصل هشتم: فشار و آثار آن',
                                        'tags'     => json_encode(['فصل_هشتم:_فشار__و_آثار_آن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1271',
                                                'name'     => 'تعریف فشار و واحدهای آن',
                                                'tags'     => json_encode(['تعریف_فشار_و_واحدهای_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1272',
                                                'name'     => 'فشار در جامدات',
                                                'tags'     => json_encode(['فشار_در_جامدات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1273',
                                                'name'     => 'فشار در مایعات',
                                                'tags'     => json_encode(['فشار_در_مایعات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1274',
                                                'name'     => 'اصل پاسکال',
                                                'tags'     => json_encode(['اصل_پاسکال'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1275',
                                                'name'     => 'فشار در گازها',
                                                'tags'     => json_encode(['فشار_در_گازها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1287',
                                        'name'     => 'فصل نهم: ماشین‌ها',
                                        'tags'     => json_encode(['فصل_نهم:_ماشین‌ها'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1277',
                                                'name'     => 'کار و عوامل مؤثر بر آن',
                                                'tags'     => json_encode(['کار_و_عوامل_مؤثر_بر_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1278',
                                                'name'     => 'تعریف ماشین و روش‌های کمک کردن آن',
                                                'tags'     => json_encode(['تعریف_ماشین_و_روش‌های_کمک_کردن_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1279',
                                                'name'     => 'گشتاور نیرو',
                                                'tags'     => json_encode(['گشتاور_نیرو'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1280',
                                                'name'     => 'حالت تعادل',
                                                'tags'     => json_encode(['حالت_تعادل'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1281',
                                                'name'     => 'مزیت مکانیکی',
                                                'tags'     => json_encode(['مزیت_مکانیکی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1282',
                                                'name'     => 'اهرم‌ها',
                                                'tags'     => json_encode(['اهرم‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1283',
                                                'name'     => 'قرقره‌ها',
                                                'tags'     => json_encode(['قرقره‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1284',
                                                'name'     => 'چرخ‌دنده‌ها',
                                                'tags'     => json_encode(['چرخ‌دنده‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1285',
                                                'name'     => 'سطح شیبدار',
                                                'tags'     => json_encode(['سطح_شیبدار'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1286',
                                                'name'     => 'ماشین‌های مرکب',
                                                'tags'     => json_encode(['ماشین‌های_مرکب'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1297',
                                        'name'     => 'فصل دهم: نگاهی به فضا',
                                        'tags'     => json_encode(['فصل_دهم:_نگاهی_به_فضا'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1288',
                                                'name'     => 'علم نجوم',
                                                'tags'     => json_encode(['علم_نجوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1289',
                                                'name'     => 'کهکشان',
                                                'tags'     => json_encode(['کهکشان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1290',
                                                'name'     => 'ستارگان و خورشید',
                                                'tags'     => json_encode(['ستارگان_و_خورشید'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1291',
                                                'name'     => 'صورت‌های فلکی',
                                                'tags'     => json_encode(['صورت‌های_فلکی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1296',
                                                'name'     => 'منظومۀ شمسی',
                                                'tags'     => json_encode(['منظومۀ_شمسی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1292',
                                                        'name'     => 'سیارات',
                                                        'tags'     => json_encode(['سیارات'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1293',
                                                        'name'     => 'قمر',
                                                        'tags'     => json_encode(['قمر'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1294',
                                                        'name'     => 'سیارک',
                                                        'tags'     => json_encode(['سیارک'], JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1295',
                                                        'name'     => 'شهاب و شهاب سنگ',
                                                        'tags'     => json_encode(['شهاب_و_شهاب_سنگ'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1303',
                                        'name'     => 'فصل یازدهم: گوناگونی جانداران',
                                        'tags'     => json_encode(['فصل_یازدهم:_گوناگونی_جانداران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1298',
                                                'name'     => 'طبقه‌بندی جانداران',
                                                'tags'     => json_encode(['طبقه‌بندی_جانداران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1299',
                                                'name'     => 'باکتری‌ها',
                                                'tags'     => json_encode(['باکتری‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1300',
                                                'name'     => 'آغازیان',
                                                'tags'     => json_encode(['آغازیان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1301',
                                                'name'     => 'قارچ‌ها',
                                                'tags'     => json_encode(['قارچ‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1302',
                                                'name'     => 'ویروس‌ها',
                                                'tags'     => json_encode(['ویروس‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1312',
                                        'name'     => 'فصل دوازدهم: دنیای گیاهان',
                                        'tags'     => json_encode(['فصل_دوازدهم:_دنیای_گیاهان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1304',
                                                'name'     => 'آوندها در گیاهان',
                                                'tags'     => json_encode(['آوندها_در_گیاهان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1305',
                                                'name'     => 'ریشه و تارهای کشنده',
                                                'tags'     => json_encode(['ریشه_و_تارهای_کشنده'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1306',
                                                'name'     => 'ساقه و برگ',
                                                'tags'     => json_encode(['ساقه_و_برگ'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1307',
                                                'name'     => 'سرخس‌ها',
                                                'tags'     => json_encode(['سرخس‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1308',
                                                'name'     => 'بازدانگان',
                                                'tags'     => json_encode(['بازدانگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1309',
                                                'name'     => 'نهان‌دانگان',
                                                'tags'     => json_encode(['نهان‌دانگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1310',
                                                'name'     => 'خزه‌ها',
                                                'tags'     => json_encode(['خزه‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1311',
                                                'name'     => 'گیاهان در زندگی ما',
                                                'tags'     => json_encode(['گیاهان_در_زندگی_ما'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1320',
                                        'name'     => 'فصل سیزدهم: جانوران بی‌مهره',
                                        'tags'     => json_encode(['فصل_سیزدهم:_جانوران_بی‌مهره'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1313',
                                                'name'     => 'گوناگونی جانوران',
                                                'tags'     => json_encode(['گوناگونی_جانوران'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1314',
                                                'name'     => 'اسفنج‌ها',
                                                'tags'     => json_encode(['اسفنج‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1315',
                                                'name'     => 'کیسه‌تنان',
                                                'tags'     => json_encode(['کیسه‌تنان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1316',
                                                'name'     => 'کرم‌ها',
                                                'tags'     => json_encode(['کرم‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1317',
                                                'name'     => 'نرم تنان',
                                                'tags'     => json_encode(['نرم_تنان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1318',
                                                'name'     => 'بند‌پایان',
                                                'tags'     => json_encode(['بند‌پایان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1319',
                                                'name'     => 'خارپوستان',
                                                'tags'     => json_encode(['خارپوستان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1327',
                                        'name'     => 'فصل چهاردهم: جانوران مهره‌دار',
                                        'tags'     => json_encode(['فصل_چهاردهم:_جانوران_مهره‌دار'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1321',
                                                'name'     => 'جانورانی با ستون مهره',
                                                'tags'     => json_encode(['جانورانی_با_ستون_مهره'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1322',
                                                'name'     => 'ماهی‌ها',
                                                'tags'     => json_encode(['ماهی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1323',
                                                'name'     => 'دوزیستان',
                                                'tags'     => json_encode(['دوزیستان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1324',
                                                'name'     => 'خزندگان',
                                                'tags'     => json_encode(['خزندگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1325',
                                                'name'     => 'پرندگان',
                                                'tags'     => json_encode(['پرندگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1326',
                                                'name'     => 'پستانداران',
                                                'tags'     => json_encode(['پستانداران'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1332',
                                        'name'     => 'فصل پانزدهم: با هم زیستن',
                                        'tags'     => json_encode(['فصل_پانزدهم:_با_هم_زیستن'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1328',
                                                'name'     => 'بوم سازگان',
                                                'tags'     => json_encode(['بوم_سازگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1329',
                                                'name'     => 'هرم ماده و انرژی',
                                                'tags'     => json_encode(['هرم_ماده_و_انرژی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1330',
                                                'name'     => 'روابط بین جانداران',
                                                'tags'     => json_encode(['روابط_بین_جانداران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1331',
                                                'name'     => 'تنوع زیستی و اهمیت آن',
                                                'tags'     => json_encode(['تنوع_زیستی_و_اهمیت_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1463',
                                'name'     => 'فارسی',
                                'tags'     => json_encode(['فارسی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1340',
                                        'name'     => 'درس اول: آفرینش همه تنبیه خداوند دل است',
                                        'tags'     => json_encode(['درس_اول:_آفرینش_همه_تنبیه_خداوند_دل_است'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1334',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1335',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1336',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1337',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1338',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1339',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1348',
                                        'name'     => 'درس دوم: عجایبِ صنعِ حق‌تعالی',
                                        'tags'     => json_encode(['درس_دوم:_عجایبِ_صنعِ_حق‌تعالی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1341',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1342',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1343',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1344',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1345',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1346',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1347',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1355',
                                        'name'     => 'درس سوم: مثل آیینه، کار و شایستگی',
                                        'tags'     => json_encode(['درس_سوم:_مثل_آیینه،_کار_و_شایستگی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1349',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1350',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1351',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1352',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1353',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1354',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1362',
                                        'name'     => 'درس چهارم: همنشین',
                                        'tags'     => json_encode(['درس_چهارم:_همنشین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1356',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1357',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1358',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1359',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1360',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1361',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1369',
                                        'name'     => 'درس ششم: آداب زندگانی',
                                        'tags'     => json_encode(['درس_ششم:_آداب_زندگانی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1363',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1364',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1365',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1366',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1367',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1368',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1376',
                                        'name'     => 'درس هفتم: پرتو امید',
                                        'tags'     => json_encode(['درس_هفتم:_پرتو_امید'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1370',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1371',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1372',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1373',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1374',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1375',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1384',
                                        'name'     => 'درس هشتم: همزیستی با مامِ میهن',
                                        'tags'     => json_encode(['درس_هشتم:_همزیستی_با_مامِ_میهن'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1377',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1378',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1379',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1380',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1381',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1382',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1383',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1391',
                                        'name'     => 'درس نهم: راز موفقیت',
                                        'tags'     => json_encode(['درس_نهم:_راز_موفقیت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1385',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1386',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1387',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1388',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1389',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1390',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1398',
                                        'name'     => 'درس دهم: آرشی دیگر',
                                        'tags'     => json_encode(['درس_دهم:_آرشی_دیگر'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1392',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1393',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1394',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1395',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1396',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1397',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1405',
                                        'name'     => 'درس یازدهم: زنِ پارسا',
                                        'tags'     => json_encode(['درس_یازدهم:_زنِ_پارسا'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1399',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1400',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1401',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1402',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1403',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1404',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1412',
                                        'name'     => 'درس دوازدهم: پیام‌آور رحمت',
                                        'tags'     => json_encode(['درس_دوازدهم:_پیام‌آور_رحمت'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1406',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1407',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1408',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1409',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1410',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1411',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1419',
                                        'name'     => 'درس سیزدهم: آشنای غریبان، میلاد گل',
                                        'tags'     => json_encode(['درس_سیزدهم:_آشنای_غریبان،_میلاد_گل'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1413',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1414',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1415',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1416',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1417',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1418',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1427',
                                        'name'     => 'درس چهاردهم: پیدای پنهان',
                                        'tags'     => json_encode(['درس_چهاردهم:_پیدای_پنهان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1420',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1421',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1422',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1423',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1424',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1425',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1426',
                                                'name'     => 'حفظ شعر',
                                                'tags'     => json_encode(['حفظ_شعر'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1434',
                                        'name'     => 'درس شانزدهم: آرزو',
                                        'tags'     => json_encode(['درس_شانزدهم:_آرزو'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1428',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1429',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1430',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1431',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1432',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1433',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1441',
                                        'name'     => 'درس هفدهم: شازده کوچولو',
                                        'tags'     => json_encode(['درس_هفدهم:_شازده_کوچولو'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1435',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1436',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1437',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1438',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1439',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1440',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1448',
                                        'name'     => 'ستایش: به نام خداوند جان و خرد',
                                        'tags'     => json_encode(['ستایش:_به_نام_خداوند_جان_و_خرد'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1442',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1443',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1444',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1445',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1446',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1447',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1455',
                                        'name'     => 'نیایش: بیا تا برآریم، دستی ز دل',
                                        'tags'     => json_encode(['نیایش:_بیا_تا_برآریم،_دستی_ز_دل'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1449',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1450',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1451',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1452',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1453',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1454',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1462',
                                        'name'     => 'محتوای ترکیبی',
                                        'tags'     => json_encode(['محتوای_ترکیبی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1456',
                                                'name'     => 'واژگان',
                                                'tags'     => json_encode(['واژگان'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1457',
                                                'name'     => 'املا',
                                                'tags'     => json_encode(['املا'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1458',
                                                'name'     => 'تاریخ ادبیات',
                                                'tags'     => json_encode(['تاریخ_ادبیات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1459',
                                                'name'     => 'دانش ادبی',
                                                'tags'     => json_encode(['دانش_ادبی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1460',
                                                'name'     => 'دانش زبانی',
                                                'tags'     => json_encode(['دانش_زبانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1461',
                                                'name'     => 'معنی و مفهوم',
                                                'tags'     => json_encode(['معنی_و_مفهوم'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1574',
                                'name'     => 'مطالعات اجتماعی',
                                'tags'     => json_encode(['مطالعات_اجتماعی'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1467',
                                        'name'     => 'درس 1: گوی آبی زیبا',
                                        'tags'     => json_encode(['درس_1:_گوی_آبی_زیبا'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1464',
                                                'name'     => 'جایگاه زمین در کیهان',
                                                'tags'     => json_encode(['جایگاه_زمین_در_کیهان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1465',
                                                'name'     => 'موقعیت مکانی',
                                                'tags'     => json_encode(['موقعیت_مکانی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1466',
                                                'name'     => 'طول و عرض جغرافیایی (مختصات جغرافیایی)',
                                                'tags'     => json_encode(['طول_و_عرض_جغرافیایی_(مختصات_جغرافیایی)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1470',
                                        'name'     => 'درس 2: حرکات زمین',
                                        'tags'     => json_encode(['درس_2:_حرکات_زمین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1468',
                                                'name'     => 'حرکت وضعی',
                                                'tags'     => json_encode(['حرکت_وضعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1469',
                                                'name'     => 'حرکت انتقالی',
                                                'tags'     => json_encode(['حرکت_انتقالی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1476',
                                        'name'     => 'درس 3: چهرۀ زمین',
                                        'tags'     => json_encode(['درس_3:_چهرۀ_زمین'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1471',
                                                'name'     => 'محیط‌های زمین',
                                                'tags'     => json_encode(['محیط‌های_زمین'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1472',
                                                'name'     => 'خشکی‌ها',
                                                'tags'     => json_encode(['خشکی‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1475',
                                                'name'     => 'ناهمواری‌ها',
                                                'tags'     => json_encode(['ناهمواری‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [
                                                    [
                                                        'id'       => '1473',
                                                        'name'     => 'عوامل درونی',
                                                        'tags'     => json_encode(['عوامل_درونی'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],
                                                    [
                                                        'id'       => '1474',
                                                        'name'     => 'عوامل بیرونی',
                                                        'tags'     => json_encode(['عوامل_بیرونی'],
                                                            JSON_UNESCAPED_UNICODE),
                                                        'children' => [

                                                        ],
                                                    ],

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1483',
                                        'name'     => 'درس 4: آب فراوان، هوای پاک',
                                        'tags'     => json_encode(['درس_4:_آب_فراوان،_هوای_پاک'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1477',
                                                'name'     => 'پنج مجموعۀ آبی بزرگ',
                                                'tags'     => json_encode(['پنج_مجموعۀ_آبی_بزرگ'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1478',
                                                'name'     => 'ناهمواری‌های کف اقیانوس‌ها',
                                                'tags'     => json_encode(['ناهمواری‌های_کف_اقیانوس‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1479',
                                                'name'     => 'انسان و اقیانوس‌ها',
                                                'tags'     => json_encode(['انسان_و_اقیانوس‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1480',
                                                'name'     => 'هواکره (اتمسفر)',
                                                'tags'     => json_encode(['هواکره_(اتمسفر)'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1481',
                                                'name'     => 'تنوع آب‌و‌هوا در جهان',
                                                'tags'     => json_encode(['تنوع_آب‌و‌هوا_در_جهان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1482',
                                                'name'     => 'عوامل مؤثر بر آب‌وهوای جهان',
                                                'tags'     => json_encode(['عوامل_مؤثر_بر_آب‌وهوای_جهان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1487',
                                        'name'     => 'درس 5: پراکندگی زیست‌بوم‌های جهان',
                                        'tags'     => json_encode(['درس_5:_پراکندگی_زیست‌بوم‌های_جهان'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1484',
                                                'name'     => 'زیست‌بوم (بیوم)',
                                                'tags'     => json_encode(['زیست‌بوم_(بیوم)'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1485',
                                                'name'     => 'تنوع زیست‌بوم‌ها به چه عواملی بستگی دارد؟',
                                                'tags'     => json_encode(['تنوع_زیست‌بوم‌ها_به_چه_عواملی_بستگی_دارد؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1486',
                                                'name'     => 'پراکندگی زیست‌بوم‌های جهان',
                                                'tags'     => json_encode(['پراکندگی_زیست‌بوم‌های_جهان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1491',
                                        'name'     => 'درس 6: زیست‌بوم‌ها در خطرند',
                                        'tags'     => json_encode(['درس_6:_زیست‌بوم‌ها_در_خطرند'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1488',
                                                'name'     => 'انقراض گونه‌ها',
                                                'tags'     => json_encode(['انقراض_گونه‌ها'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1489',
                                                'name'     => 'زیست‌گاه‌ها چرا و چگونه تخریب می‌شوند؟',
                                                'tags'     => json_encode(['زیست‌گاه‌ها_چرا_و_چگونه_تخریب_می‌شوند؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1490',
                                                'name'     => 'چه باید کرد؟',
                                                'tags'     => json_encode(['چه_باید_کرد؟'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1497',
                                        'name'     => 'درس 7: جمعیت جهان',
                                        'tags'     => json_encode(['درس_7:_جمعیت_جهان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1492',
                                                'name'     => 'تغییر رشد جمعیت در جهان',
                                                'tags'     => json_encode(['تغییر_رشد_جمعیت_در_جهان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1493',
                                                'name'     => 'رشد جمعیت در کشورهای جهان',
                                                'tags'     => json_encode(['رشد_جمعیت_در_کشورهای_جهان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1494',
                                                'name'     => 'پراکندگی جمعیت',
                                                'tags'     => json_encode(['پراکندگی_جمعیت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1495',
                                                'name'     => 'جا‌به‌جایی جمعیت (مهاجرت)',
                                                'tags'     => json_encode(['جا‌به‌جایی_جمعیت_(مهاجرت)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1496',
                                                'name'     => 'افزایش شهر‌نشینی',
                                                'tags'     => json_encode(['افزایش_شهر‌نشینی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1501',
                                        'name'     => 'درس 8: جهان نا‌برابر',
                                        'tags'     => json_encode(['درس_8:_جهان_نا‌برابر'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1498',
                                                'name'     => 'نابرابری جهانی یا بین‌المللی و معیارهای آن',
                                                'tags'     => json_encode(['نابرابری_جهانی_یا_بین‌المللی_و_معیارهای_آن'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1499',
                                                'name'     => 'شاخص توسعۀ انسانی چیست؟',
                                                'tags'     => json_encode(['شاخص_توسعۀ_انسانی_چیست؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1500',
                                                'name'     => 'علل و عوامل نابرابری',
                                                'tags'     => json_encode(['علل_و_عوامل_نابرابری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1507',
                                        'name'     => 'درس 9: ایرانی متحد و یکپارچه',
                                        'tags'     => json_encode(['درس_9:_ایرانی_متحد_و_یکپارچه'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1502',
                                                'name'     => 'اوضاع سیاسی ایران هنگام تأسیس صفوی',
                                                'tags'     => json_encode(['اوضاع_سیاسی_ایران_هنگام_تأسیس_صفوی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1503',
                                                'name'     => 'شکل‌گیری حکومت صفویه',
                                                'tags'     => json_encode(['شکل‌گیری_حکومت_صفویه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1504',
                                                'name'     => 'قدرت و سقوط صفویان',
                                                'tags'     => json_encode(['قدرت_و_سقوط_صفویان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1505',
                                                'name'     => 'صفویان چگونه کشور را اداره می‌کردند؟',
                                                'tags'     => json_encode(['صفویان_چگونه_کشور_را_اداره_می‌کردند؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1506',
                                                'name'     => 'اروپاییان در راه ایران',
                                                'tags'     => json_encode(['اروپاییان_در_راه_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1512',
                                        'name'     => 'درس 10: اوضاع اجتماعی، اقتصادی، علمی و فرهنگی ایران در عصر صفوی',
                                        'tags'     => json_encode(['درس_10:_اوضاع_اجتماعی،_اقتصادی،_علمی_و_فرهنگی_ایران_در_عصر_صفوی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1508',
                                                'name'     => 'زندگی اجتماعی',
                                                'tags'     => json_encode(['زندگی_اجتماعی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1509',
                                                'name'     => 'شکوفایی صنعت',
                                                'tags'     => json_encode(['شکوفایی_صنعت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1510',
                                                'name'     => 'رونق تجارت',
                                                'tags'     => json_encode(['رونق_تجارت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1511',
                                                'name'     => 'شکوفایی علمی و فرهنگی',
                                                'tags'     => json_encode(['شکوفایی_علمی_و_فرهنگی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1516',
                                        'name'     => 'درس 11: تلاش برای حفظ استقلال و اتحاد سیاسی ایران',
                                        'tags'     => json_encode(['درس_11:_تلاش_برای_حفظ_استقلال_و_اتحاد_سیاسی_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1513',
                                                'name'     => 'افشاریه',
                                                'tags'     => json_encode(['افشاریه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1514',
                                                'name'     => 'زندیه',
                                                'tags'     => json_encode(['زندیه'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1515',
                                                'name'     => 'قاجاریه: گسترش نفوذ و دخالت کشورهای استعمارگر',
                                                'tags'     => json_encode(['قاجاریه:_گسترش_نفوذ_و_دخالت_کشورهای_استعمارگر'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1519',
                                        'name'     => 'درس 12: در جست‌و‌جوی پیشرفت و رهایی از سلطۀ خارجی',
                                        'tags'     => json_encode(['درس_12:_در_جست‌و‌جوی_پیشرفت_و_رهایی_از_سلطۀ_خارجی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1517',
                                                'name'     => 'تلاش برای نوسازی و اصلاح امور کشور',
                                                'tags'     => json_encode(['تلاش_برای_نوسازی_و_اصلاح_امور_کشور'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1518',
                                                'name'     => 'مبارزه با نفوذ و سلطۀ اقتصادی بیگانگان',
                                                'tags'     => json_encode(['مبارزه_با_نفوذ_و_سلطۀ_اقتصادی_بیگانگان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1524',
                                        'name'     => 'درس 13: انقلاب مشروطیت؛ موانع و مشکلات',
                                        'tags'     => json_encode(['درس_13:_انقلاب_مشروطیت؛_موانع_و_مشکلات'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1520',
                                                'name'     => 'مشروطه چیست؟',
                                                'tags'     => json_encode(['مشروطه_چیست؟'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1521',
                                                'name'     => 'زمینه‌های انقلاب مشروطه',
                                                'tags'     => json_encode(['زمینه‌های_انقلاب_مشروطه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1522',
                                                'name'     => 'انقلاب مشروطه چگونه رخ داد؟',
                                                'tags'     => json_encode(['انقلاب_مشروطه_چگونه_رخ_داد؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1523',
                                                'name'     => 'موانع و مشکلات حکومت مشروطه',
                                                'tags'     => json_encode(['موانع_و_مشکلات_حکومت_مشروطه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1530',
                                        'name'     => 'درس 14: ایران در دوران حکومت پهلوی',
                                        'tags'     => json_encode(['درس_14:_ایران_در_دوران_حکومت_پهلوی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1525',
                                                'name'     => 'زمینه‌های تغییر حکومت از قاجاریه به پهلوی',
                                                'tags'     => json_encode(['زمینه‌های_تغییر_حکومت_از_قاجاریه_به_پهلوی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1526',
                                                'name'     => 'شیوۀ حکومت و اقدامات رضاشاه',
                                                'tags'     => json_encode(['شیوۀ_حکومت_و_اقدامات_رضاشاه'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1527',
                                                'name'     => 'آثار جنگ‌ جهانی دوم بر ایران',
                                                'tags'     => json_encode(['آثار_جنگ‌_جهانی_دوم_بر_ایران'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1528',
                                                'name'     => 'نهضت ملی شدن نفت',
                                                'tags'     => json_encode(['نهضت_ملی_شدن_نفت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1529',
                                                'name'     => 'کودتای 28 مرداد 1332',
                                                'tags'     => json_encode(['کودتای_28_مرداد_1332'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1534',
                                        'name'     => 'درس 15: انقلاب اسلامی ایران',
                                        'tags'     => json_encode(['درس_15:_انقلاب_اسلامی_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1531',
                                                'name'     => 'نهضت اسلامی به رهبری امام خمینی (ره)',
                                                'tags'     => json_encode(['نهضت_اسلامی_به_رهبری_امام_خمینی_(ره)'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1532',
                                                'name'     => 'اوضاع ایران در آستانۀ انقلاب اسلامی',
                                                'tags'     => json_encode(['اوضاع_ایران_در_آستانۀ_انقلاب_اسلامی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1533',
                                                'name'     => 'انقلاب اسلامی از آغاز تا پیروزی',
                                                'tags'     => json_encode(['انقلاب_اسلامی_از_آغاز_تا_پیروزی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1538',
                                        'name'     => 'درس 16: ایران در دوران پس از پیروزی انقلاب اسلامی',
                                        'tags'     => json_encode(['درس_16:_ایران_در_دوران_پس_از_پیروزی_انقلاب_اسلامی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1535',
                                                'name'     => 'برپایی نظام جمهوری اسلامی',
                                                'tags'     => json_encode(['برپایی_نظام_جمهوری_اسلامی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1536',
                                                'name'     => 'توطئه‌ها و دسیسه‌های دشمنان',
                                                'tags'     => json_encode(['توطئه‌ها_و_دسیسه‌های_دشمنان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1537',
                                                'name'     => 'رحلت امام‌خمینی (ره) و انتخاب حضرت آیت‌الله خامنه‌ای به رهبری',
                                                'tags'     => json_encode(['رحلت_امام‌خمینی_(ره)_و_انتخاب_حضرت_آیت‌الله_خامنه‌ای_به_رهبری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1542',
                                        'name'     => 'درس 17: فرهنگ',
                                        'tags'     => json_encode(['درس_17:_فرهنگ'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1539',
                                                'name'     => 'فرهنگ، شیوۀ زندگی',
                                                'tags'     => json_encode(['فرهنگ،_شیوۀ_زندگی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1540',
                                                'name'     => 'فرهنگ آموختنی است',
                                                'tags'     => json_encode(['فرهنگ_آموختنی_است'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1541',
                                                'name'     => 'لایه‌های فرهنگ',
                                                'tags'     => json_encode(['لایه‌های_فرهنگ'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1547',
                                        'name'     => 'درس 18: هویت',
                                        'tags'     => json_encode(['درس_18:_هویت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1543',
                                                'name'     => 'منظور از هویت چیست؟',
                                                'tags'     => json_encode(['منظور_از_هویت_چیست؟'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1544',
                                                'name'     => 'ابعاد فردی و اجتماعی هویت',
                                                'tags'     => json_encode(['ابعاد_فردی_و_اجتماعی_هویت'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1545',
                                                'name'     => 'ویژگی‌های هویتی ما (انتسابی و اکتسابی) و تغییر آن‌ها',
                                                'tags'     => json_encode(['ویژگی‌های_هویتی_ما_(انتسابی_و_اکتسابی)_و_تغییر_آن‌ها'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1546',
                                                'name'     => 'هویت ملی و هویت ایرانی',
                                                'tags'     => json_encode(['هویت_ملی_و_هویت_ایرانی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1548',
                                        'name'     => 'درس 19: کارکرد‌های خانواده',
                                        'tags'     => json_encode(['درس_19:_کارکرد‌های_خانواده'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [

                                        ],
                                    ],
                                    [
                                        'id'       => '1553',
                                        'name'     => 'درس 20: آرامش در خانواده',
                                        'tags'     => json_encode(['درس_20:_آرامش_در_خانواده'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1549',
                                                'name'     => 'همسر گزینی',
                                                'tags'     => json_encode(['همسر_گزینی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1550',
                                                'name'     => 'سازگاری زن و شوهر در خانواده',
                                                'tags'     => json_encode(['سازگاری_زن_و_شوهر_در_خانواده'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1551',
                                                'name'     => 'سازگاری والدین و فرزندان',
                                                'tags'     => json_encode(['سازگاری_والدین_و_فرزندان'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1552',
                                                'name'     => 'مدیریت مشکلات و حوادث در خانواده',
                                                'tags'     => json_encode(['مدیریت_مشکلات_و_حوادث_در_خانواده'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1558',
                                        'name'     => 'درس 21: نهاد حکومت',
                                        'tags'     => json_encode(['درس_21:_نهاد_حکومت'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1554',
                                                'name'     => 'نیاز به حکومت',
                                                'tags'     => json_encode(['نیاز_به_حکومت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1555',
                                                'name'     => 'وظایف حکومت',
                                                'tags'     => json_encode(['وظایف_حکومت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1556',
                                                'name'     => 'اسلام و حکومت',
                                                'tags'     => json_encode(['اسلام_و_حکومت'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1557',
                                                'name'     => 'حکومت در کشور ما',
                                                'tags'     => json_encode(['حکومت_در_کشور_ما'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1562',
                                        'name'     => 'درس 22: حقوق و تکالیف شهروندی',
                                        'tags'     => json_encode(['درس_22:_حقوق_و_تکالیف_شهروندی'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1559',
                                                'name'     => 'شهروندی',
                                                'tags'     => json_encode(['شهروندی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1560',
                                                'name'     => 'حقوق شهروندی',
                                                'tags'     => json_encode(['حقوق_شهروندی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1561',
                                                'name'     => 'تکالیف شهروندی',
                                                'tags'     => json_encode(['تکالیف_شهروندی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1567',
                                        'name'     => 'درس 23: بهره‌وری چیست؟',
                                        'tags'     => json_encode(['درس_23:_بهره‌وری_چیست؟'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1563',
                                                'name'     => 'بررسی موقعیت‌هایی درباره بهره‌وری',
                                                'tags'     => json_encode(['بررسی_موقعیت‌هایی_درباره_بهره‌وری'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1564',
                                                'name'     => 'بهره‌وری چیست؟',
                                                'tags'     => json_encode(['بهره‌وری_چیست؟'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1565',
                                                'name'     => 'فرهنگ بهره‌وری',
                                                'tags'     => json_encode(['فرهنگ_بهره‌وری'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1566',
                                                'name'     => 'بهره‌وری در زندگی فردی و خانوادگی',
                                                'tags'     => json_encode(['بهره‌وری_در_زندگی_فردی_و_خانوادگی'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1573',
                                        'name'     => 'درس 24: اقتصاد و بهره‌وری',
                                        'tags'     => json_encode(['درس_24:_اقتصاد_و_بهره‌وری'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1568',
                                                'name'     => 'نهاد اقتصاد',
                                                'tags'     => json_encode(['نهاد_اقتصاد'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1569',
                                                'name'     => 'بهره‌وری در تولید، توزیع و مصرف',
                                                'tags'     => json_encode(['بهره‌وری_در_تولید،_توزیع_و_مصرف'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1570',
                                                'name'     => 'بهره‌وری سبز',
                                                'tags'     => json_encode(['بهره‌وری_سبز'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1571',
                                                'name'     => 'بهره‌وری در کشور ما',
                                                'tags'     => json_encode(['بهره‌وری_در_کشور_ما'],
                                                    JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1572',
                                                'name'     => 'اقتصاد مقاومتی',
                                                'tags'     => json_encode(['اقتصاد_مقاومتی'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],
                            [
                                'id'       => '1611',
                                'name'     => 'پیام‌های آسمان',
                                'tags'     => json_encode(['پیام‌های_آسمان'], JSON_UNESCAPED_UNICODE),
                                'children' => [
                                    [
                                        'id'       => '1577',
                                        'name'     => 'درس اول: تو را چگونه بشناسم؟',
                                        'tags'     => json_encode(['درس_اول:_تو_را_چگونه_بشناسم؟'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1575',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1576',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1580',
                                        'name'     => 'درس دوم: در پناه ایمان',
                                        'tags'     => json_encode(['درس_دوم:_در_پناه_ایمان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1578',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1579',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1583',
                                        'name'     => 'درس سوم: راهنمایان الهی',
                                        'tags'     => json_encode(['درس_سوم:_راهنمایان_الهی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1581',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1582',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1586',
                                        'name'     => 'درس چهارم: خورشید پنهان',
                                        'tags'     => json_encode(['درس_چهارم:_خورشید_پنهان'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1584',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1585',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1589',
                                        'name'     => 'درس پنجم: رهبری در دوران غیبت',
                                        'tags'     => json_encode(['درس_پنجم:_رهبری_در_دوران_غیبت'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1587',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1588',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1592',
                                        'name'     => 'درس ششم: وضو، غسل و تیمم',
                                        'tags'     => json_encode(['درس_ششم:_وضو،_غسل_و_تیمم'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1590',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1591',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1595',
                                        'name'     => 'درس هفتم: احکام نماز',
                                        'tags'     => json_encode(['درس_هفتم:_احکام_نماز'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1593',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1594',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1598',
                                        'name'     => 'درس هشتم: همدلی و همراهی',
                                        'tags'     => json_encode(['درس_هشتم:_همدلی_و_همراهی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1596',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1597',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1601',
                                        'name'     => 'درس نهم: انقلاب اسلامی ایران',
                                        'tags'     => json_encode(['درس_نهم:_انقلاب_اسلامی_ایران'],
                                            JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1599',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1600',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1604',
                                        'name'     => 'درس دهم: مسئولیت همگانی',
                                        'tags'     => json_encode(['درس_دهم:_مسئولیت_همگانی'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1602',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1603',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1607',
                                        'name'     => 'درس یازدهم: انفاق',
                                        'tags'     => json_encode(['درس_یازدهم:_انفاق'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1605',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1606',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],
                                    [
                                        'id'       => '1610',
                                        'name'     => 'درس دوازدهم: جهاد',
                                        'tags'     => json_encode(['درس_دوازدهم:_جهاد'], JSON_UNESCAPED_UNICODE),
                                        'children' => [
                                            [
                                                'id'       => '1608',
                                                'name'     => 'آیات و روایات',
                                                'tags'     => json_encode(['آیات_و_روایات'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],
                                            [
                                                'id'       => '1609',
                                                'name'     => 'متن',
                                                'tags'     => json_encode(['متن'], JSON_UNESCAPED_UNICODE),
                                                'children' => [

                                                ],
                                            ],

                                        ],
                                    ],

                                ],
                            ],

                        ],
                    ],
                ],
            ],
            [
                'name'     => 'متوسطه2',
                'tags'     => json_encode(["متوسطه2"], JSON_UNESCAPED_UNICODE),
                'children' => $reshteh,
            ],
            [
                'name'     => 'مهارتی',
                'tags'     => json_encode(["مهارتی"], JSON_UNESCAPED_UNICODE),
                'enable'   => false,
                'children' => [],
            ],

        ];
        $alaa    = [
            'name'     => 'آلاء',
            'children' => $paye,
        ];

        return $alaa;
    }
}
