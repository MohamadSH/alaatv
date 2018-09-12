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


        $dahom = [
            [
                'name' => 'ادبیات',
                'tags' => json_encode(["ادبیات"], JSON_UNESCAPED_UNICODE),
                'children' =>[]
            ],
        ];
        $yazdahom = [
            [
                'name' => 'ادبیات',
                'tags' => json_encode(["ادبیات"], JSON_UNESCAPED_UNICODE),
                'children' =>[]
            ],
        ];
        $davazdahom = [
            [
                'name' => 'ادبیات',
                'tags' => json_encode(["ادبیات"], JSON_UNESCAPED_UNICODE),
                'children' =>[]
            ],
        ];
        $ghadim = [
            [
                'name' => 'ادبیات',
                'tags' => json_encode(["ادبیات"], JSON_UNESCAPED_UNICODE),
                'children' =>[]
            ],
        ];
        $riazi = [
            [
                'name' => 'نظام قدیم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $ghadim ,
            ],
            [
                'name' => 'دهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $dahom ,
            ],
            [
                'name' => 'یازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $dahom ,
            ],
            [
                'name' => 'دوازدهم',
                'tags' => json_encode(["دهم"], JSON_UNESCAPED_UNICODE),

                'children' => $dahom ,
            ],
        ];
        $reshteh = [
            [
                'name' => 'ریاضی',
                'tags' => json_encode(["ریاضی"], JSON_UNESCAPED_UNICODE),

                'children' => $riazi,
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
        $node = Category::create($alaa);
        $this->info("Finish!");

    }
}
