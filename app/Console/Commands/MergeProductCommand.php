<?php

namespace App\Console\Commands;

use App\Http\Controllers\ProductController;
use App\Orderproduct;
use App\Product;
use App\Traits\APIRequestCommon;
use App\Traits\ProductCommon;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class MergeProductCommand extends Command
{
    use ProductCommon;
    use APIRequestCommon;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:merge:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merging old products';
    protected $productArray;

    /**
     * @return array
     */
    private function initializing()
    {
        $initialArray = [];
        if(Schema::hasTable("products"))
        {
            $parentShimiProductId = 231;
            $parentShimiProduct = Product::FindOrFail($parentShimiProductId); //All Shimi product
            $shimiChildren =
                [
                    [
                        "name" => "جمع بندی شیمی ۲ و۳ آقای صنیعی",
                        "id" => 91,
                        "description" => "شامل 16 ساعت و 17 دقیقه فیلم با حجم 1.7 گیگ",
                        "newCost" => 5000 ,
                        "discount" => 0,
                        "type" =>1,
                    ],
                    [
                        "name" => "همایش طلایی مسائل ترکیبی شیمی کنکور آقای صنیعی",
                        "id" => 217,
                        "description" => "شامل 5 ساعت 55 دقیقه فیلم با حجم 828 مگابایت",
                        "newCost" =>5000 ,
                        "discount" => 0,
                        "type" =>1,
                    ],
                    [
                        "name" => "همایش حل مسائل شیمی آقای صنیعی",
                        "id" => 100,
                        "description" => "شامل 10 ساعت و 40 دقیقه فیلم با حجم 1.2 گیگ",
                        "newCost" =>5000 ,
                        "discount" => 0,
                        "type" =>2,
                    ]
                    ,
                    [
                        "name" => "همایش 5+1 شیمی آقای صنیعی",
                        "id" => 145,
                        "description" => "شامل 8 ساعت و 58 دقیقه فیلم با حجم 956 مگ",
                        "newCost" => 5000,
                        "discount" => 0,
                        "type" =>2,
                    ]
                    ,
                ];

            $parentPhysicProductId = 233;
            $parentPhysicProduct = Product::FindOrFail($parentPhysicProductId); //All Physic product
            $physicChildren = [
                [
                    "name" => "جمع بندی فیزیک ۲ و ۳ آقای طلوعی",
                    "id" => 92,
                    "description" => "شامل 19 ساعت و 38 دقیقه فیلم با حجم 2.3 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>1,
                ],
                [
                    "name" => "همایش طلایی فیزیک کنکور طلوعی",
                    "id" => 216,
                    "description" => "شامل 21 ساعت و 8 دقیقه فیلم با حجم 2.7 گیگ",
                    "newCost" => 5000,
                    "discount" => 0,
                    "type" =>1,
                ]
                ,
                [
                    "name" => "همایش ۱+۵ فیزیک آقای طلوعی",
                    "id" => 157,
                    "description" => "شامل 10 ساعت و 5 دقیقه فیلم با حجم 986 مگابایت",
                    "newCost" =>5000 ,
                    "discount" => 0,
                    "type" =>2,
                ]
                ,
                [
                    "name" => "همایش 200 تست فیزیک آقای طلوعی",
                    "id" => 88,
                    "description" => "شامل 21 ساعت و 50 دقیقه فیلم با حجم 1.2 گیگ",
                    "newCost" => 5000,
                    "discount" => 0,
                    "type" =>2,
                ]
                ,
            ];

            $parentZistProductId = 235;
            $parentZistProduct = Product::FindOrFail($parentZistProductId); //All Zist product
            $zistChildren = [
                [
                    "name" => "همایش زیست شناسی آقای پازوکی",
                    "id" => 109,
                    "description" => "شامل 12 ساعت و 39 دقیقه فیلم با حجم 1.8 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ]
                ,
                [
                    "name" => "همایش ۱+۵ زیست آقای جعفری",
                    "id" => 141,
                    "description" => "شامل 8 ساعت و 42 دقیقه فیلم با حجم 919 گیگ",
                    "newCost" =>5000 ,
                    "discount" => 0,
                    "type" =>2,
                ]
                ,
                [
                    "name" => "همایش طلایی زیست کنکور آقای چلاجور",
                    "id" => 212,
                    "description" => "شامل 18 ساعت و 20 دقیقه فیلم با حجم 2.4 گیگ",
                    "newCost" => 5000,
                    "discount" => 0,
                    "type" =>1,
                ]
                ,
                [
                    "name" => "همایش طلایی ژنتیک کنکور آقای آل علی",
                    "id" => 221,
                    "description" => "شامل 6 ساعت و 8 دقیقه فیلم با حجم 940 مگابایت",
                    "newCost" => 5000,
                    "discount" => 0,
                    "type" =>1,
                ]
                ,
            ];

            $parentArabiProductId = 237;
            $parentArabiProduct = Product::FindOrFail($parentArabiProductId); //All Arabi product
            $ArabiChildren = [
                [
                    "name" => "همایش 200 تست طلایی کنکور عربی آقای ناصح زاده",
                    "id" => 214,
                    "description" => "شامل 7 ساعت و 1 دقیقه فیلم با حجم 1.2 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>1,
                ],
                [
                    "name" => "همایش 5+1 عربی آقای آهویی",
                    "id" => 149,
                    "description" => "شامل 5 ساعت و 36 دقیقه فیلم با حجم 677 مگابایت",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
            ];

            $parentDiniProductId = 239;
            $parentDiniProduct = Product::FindOrFail($parentDiniProductId); //All Dini product
            $DiniChildren = [
                [
                    "name" => "همایش طلایی دین و زندگی خانم کاغذی",
                    "id" => 211,
                    "description" => "شامل 18 ساعت و 9 دقیقه فیلم با حجم 2.1 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>1,
                ],
                [
                    "name" => "همایش دین و زندگی آقای رنجبرزاده",
                    "id" => 105,
                    "description" => "شامل 7 ساعت و 20 دقیقه فیلم با حجم 1 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
            ];

            $parentRiyaziTajrobiProductId = 241;
            $parentRiyaziTajrobiProduct = Product::FindOrFail($parentRiyaziTajrobiProductId); //All RiyaziTajrobi product
            $RiyaziTajrobiChildren = [
                [
                    "name" => "همایش طلایی ریاضی تجربی کنکور آقای نباخته",
                    "id" => 220,
                    "description" => "شامل 8 ساعت و 2 دقیقه فیلم با حجم 953 مگابایت",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>1,
                ],
                [
                    "name" => "همایش طلایی ریاضی تجربی کنکور آقای امینی",
                    "id" => 219,
                    "description" => "شامل 12 ساعت و 17 دقیقه فیلم با حجم 1.6 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>1,
                ],
                [
                    "name" => "همایش 1+5 ریاضی تجربی آقای نباخته",
                    "id" => 137,
                    "description" => "شامل 7 ساعت و 7 دقیقه فیلم با حجم 442 مگابایت",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
                [
                    "name" => "همایش 1+5 ریاضی تجربی آقای امینی",
                    "id" => 133,
                    "description" => "شامل 8 ساعت و 12 دقیقه فیلم با حجم 934 مگابایت",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
                [
                    "name" => "همایش ریاضی تجربی آقای شامیزاده",
                    "id" => 90,
                    "description" => "شامل 10 ساعت و 50 دقیقه فیلم با حجم 8 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
            ];

            $parentDifransielProductId = 243;
            $parentDifransielProduct = Product::FindOrFail($parentDifransielProductId); //All Difransiel product
            $DifransielChildren = [
                [
                    "name" => "همایش طلایی 48 تست کنکور ریاضی آقای ثابتی",
                    "id" => 218,
                    "description" => "شامل 21 ساعت و 54 دقیقه فیلم با حجم 3 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>1,
                ],
                [
                    "name" => "همایش 1+5 دیفرانسیل آقای ثابتی",
                    "id" => 125,
                    "description" => "شامل 5 ساعت و 12 دقیقه فیلم با حجم 630 مگابایت",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
                [
                    "name" => "همایش دیفرانسیل و ریاضی پایه کنکور آقای ثابتی",
                    "id" => 96,
                    "description" => "شامل 4 ساعت و 24 دقیقه فیلم با حجم 210 مگابایت",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],
                [
                    "name" => "همایش 1+5 تحلیلی آقای ثابتی",
                    "id" => 121,
                    "description" => "شامل 5 ساعت و 31 دقیقه فیلم با حجم 648 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ],[
                    "name" => "همایش 5+1 گسسته آقای مؤذنی پور",
                    "id" => 165,
                    "description" => "شامل 5 ساعت و 10 دقیقه فیلم با حجم 601 گیگ",
                    "newCost" => 5000 ,
                    "discount" => 0,
                    "type" =>2,
                ]
            ];


            $initialArray =  [
                [
                    "title" => "Shimi",
                    "parent" => $parentShimiProduct ,
                    "children" => $shimiChildren
                ],
                [
                    "title" => "Physics",
                    "parent" => $parentPhysicProduct ,
                    "children" => $physicChildren
                ],
                [
                    "title" => "Zist",
                    "parent" => $parentZistProduct ,
                    "children" => $zistChildren
                ],
                [
                    "title" => "Arabi",
                    "parent" => $parentArabiProduct ,
                    "children" => $ArabiChildren
                ],
                [
                    "title" => "Dini",
                    "parent" => $parentDiniProduct ,
                    "children" => $DiniChildren
                ],
                [
                    "title" => "RiyaziTajrobi",
                    "parent" => $parentRiyaziTajrobiProduct ,
                    "children" => $RiyaziTajrobiChildren
                ],
                [
                    "title" => "Difransiel",
                    "parent" => $parentDifransielProduct ,
                    "children" => $DifransielChildren
                ],
            ];
        }

        return $initialArray;

    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->productArray = $this->initializing();
    }

    /**
     * Execute the console command.
     *
     * @param ProductController $productController
     * @return mixed
     * @throws \Exception
     */
    public function handle(ProductController $productController)
    {
        $productCount = count($this->productArray);
        if ($this->confirm('Products will be merged into ' . $productCount . '. Do you wish to continue?', true))
        {
            $this->performMergingForAllProducts($productController, $productCount);

            if ($this->confirm('Do you want to clear cache ', true)) {
                Artisan::call('cache:clear');
            }

            $this->info("Merging Successfully Done!");
        }
        else
        {
            $this->info("Action Aborted");
        }


    }

    /**
     * @param ProductController $productController
     * @param $productCount
     * @return void
     */
    private function performMergingForAllProducts(ProductController $productController, $productCount): void
    {
        $bar = $this->output->createProgressBar($productCount);
        foreach ($this->productArray as $productElement) {
            $finalProduct = $productElement["parent"];
            if($finalProduct->hasChildren())
            {// It means it had been processed before
                $this->info("This product was skipped because had been processed before.");
                $this->info("\n Total Progress:");
                $bar->advance();
                $this->info("\n\n");
                continue;
            }

            $childrenCount = count($productElement["children"]);
            $this->info("Found ".$childrenCount." items for ".$productElement["title"]);
            $subBar = $this->output->createProgressBar($childrenCount);
            if($childrenCount >0)
                foreach ($productElement["children"] as $child) {
                $newProductId = $child["id"];

                $hasConfigurableParent = false;
                if ($child["type"] == config("constants.PRODUCT_TYPE_CONFIGURABLE"))
                    $hasConfigurableParent = true;

                if ($hasConfigurableParent)
                {
                    $originalProduct = Product::Find($child["id"]);
                    if (isset($originalProduct)) {
                        $response = $productController->copy($originalProduct);
                        $responseContent = json_decode($response->getContent());
                        if ($response->getStatusCode() == Response::HTTP_OK)
                            $newProductId = $responseContent->newProductId;

                    }
                }

                $newProduct = Product::Find($newProductId);

                if($hasConfigurableParent)
                {
                    $this->copyProductFiles($originalProduct, $newProduct);

                    $newProductPhotoInfo = [
                        "title" => "نمونه جزوه ".$child["name"] ,
                        "description" => ""
                    ];
                    $this->copyProductPhotos($originalProduct, $newProduct , $newProductPhotoInfo);

                    $originalProduct->disable();
                    $originalProduct->update();

                    if ($originalProduct->hasParents()) {
                        $originalProductParent = $originalProduct->parents->first();
                        $this->copyProductFiles($originalProductParent, $newProduct);

                        $newProductPhotoInfo = [
                            "title" => "نمونه جزوه ".$child["name"] ,
                            "description" => ""
                        ];
                        $this->copyProductPhotos($originalProductParent, $newProduct,$newProductPhotoInfo);

                        $originalProductParent->disable();
                        $originalProductParent->update();
                    }

                    $this->info("Deleting orderproducts");
                    Orderproduct::deleteOpenedTransactions([$originalProduct->id], [config("constants.ORDER_STATUS_OPEN")]);
                }

                $newProduct->name = $child["name"];
                $newProduct->basePrice = $child["newCost"];
                $newProduct->discount = $child["discount"];
                if($finalProduct->hasParents())
                {
                    $finalProductGrandParent =  $finalProduct->getGrandParent();
                    if(isset($finalProductGrandParent))
                    {
                        $finalProductGrandParent->enable();
                        $finalProductGrandParent->update();

                        $itemTagsArray = $finalProductGrandParent->tags->tags ;
                        $params = [
                            "tags"=> json_encode($itemTagsArray) ,
                        ];

                        if(isset($finalProductGrandParent->created_at) && strlen($finalProductGrandParent->created_at) > 0 )
                            $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $finalProductGrandParent->created_at )->timestamp;

                        $response =  $this->sendRequest(
                            config("constants.TAG_API_URL")."id/product/".$finalProductGrandParent->id ,
                            "PUT",
                            $params
                        );
                        if($response["statusCode"] != 200)
                            $this->info("Failed on setting tags for product #".$finalProductGrandParent->id ."\n");

                    }
                    else{
                        $this->info("Could not enable parent of #".$finalProduct->id ."\n");
                    }
                }
                $newProduct->redirectUrl = action("ProductController@show" , $finalProductGrandParent);
                $newProduct->update();
                $finalProduct->children()->attach($newProductId, ["control_id" => 2, "description" => $child["description"], "created_at" => Carbon::now(), "updated_at" => Carbon::now(),]);
                $finalProduct->enable();
                $finalProduct->update();
                $subBar->advance();
            }

            $subBar->finish();
            $this->info("\n Total Progress:");
            $bar->advance();
            $this->info("\n\n");
        }

        $bar->finish();
        $this->info("\n");
    }
}
