<?php

namespace App\Http\Controllers\Web;


use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{DB, Input};
use Maatwebsite\ExcelLight\Excel;
use App\Http\Controllers\Controller;
use App\Console\Commands\CategoryTree\Riazi;
use App\Console\Commands\CategoryTree\Tajrobi;
use Maatwebsite\ExcelLight\Spout\{Row, Sheet, Reader, Writer};
use App\{Bon,
    Orderproduct,
    User,
    Order,
    Content,
    Product,
    Userbon,
    Contentset,
    Contenttype,
    Transaction,
    Traits\Helper,
    Productvoucher,
    Websitesetting,
    Traits\UserCommon,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Http\Requests\Request,
    Traits\CharacterCommon,
    Notifications\GiftGiven,
    Traits\APIRequestCommon,
    Events\FreeInternetAccept,
    Notifications\GeneralNotice};
use Zarinpal\Zarinpal;

//use Jenssegers\Agent\Agent;

class BotsController extends Controller
{
    use Helper;
    use APIRequestCommon;
    use ProductCommon;
    use CharacterCommon;
    use UserCommon;
    use RequestCommon;
    
    private static $TAG = HomeController::class;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $response;
    
    protected $sideBarAdmin;
    
    protected $setting;
    
    public function __construct(Response $response, Websitesetting $setting)
    {
        $this->middleware('role:admin', [
            'only' => ['bot', 'smsBot', 'checkDisableContentTagBot', 'tagBot', 'pointBot',],
        ]);
        $this->response = $response;
        $this->setting  = $setting->setting;
    }
    
    public function adminBot()
    {
        if (!Input::has("bot")) {
            dd("Please pass bot as input");
        }
        
        $bot    = Input::get("bot");
        $view   = "";
        $params = [];
        switch ($bot) {
            case "wallet":
                $view = "admin.bot.wallet";
                break;
            case "excel":
                $view = "admin.bot.excel";
                break;
            default:
                break;
        }
        $pageName = "adminBot";
        if (strlen($view) > 0) {
            return view($view, compact('pageName', 'params'));
        } else {
            abort(404);
        }
    }
    
    public function smsBot()
    {
        abort("403");
    }
    
    public function bot(Request $request)
    {
        try {
            if ($request->has("emptyorder")) {
                $orders = Order::whereIn("orderstatus_id", [
                    config("constants.ORDER_STATUS_CLOSED"),
                    config("constants.ORDER_STATUS_POSTED"),
                    config("constants.ORDER_STATUS_READY_TO_POST"),
                ])
                    ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                    ->whereDoesntHave("orderproducts", function ($q) {
                        $q->Where("orderproducttype_id", config("constants.ORDER_PRODUCT_TYPE_DEFAULT"));
                    })
                    ->get();
                dd($orders->pluck("id")
                    ->toArray());
            }
            
            if ($request->has("voucherbot")) {
                $asiatechProduct      = config("constants.ASIATECH_FREE_ADSL");
                $voucherPendingOrders = Order::where("orderstatus_id", config("constants.ORDER_STATUS_PENDING"))
                    ->where("paymentstatus_id",
                        config("constants.PAYMENT_STATUS_PAID"))
                    ->whereHas("orderproducts", function (
                        $q
                    ) use ($asiatechProduct) {
                        $q->where("product_id", $asiatechProduct);
                    })
                    ->orderBy("completed_at")
                    ->get();
                echo "<span style='color:blue'>Number of orders: ".$voucherPendingOrders->count()."</span>";
                echo "<br>";
                $counter     = 0;
                $nowDateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                    ->timezone('Asia/Tehran');
                foreach ($voucherPendingOrders as $voucherOrder) {
                    $orderUser     = $voucherOrder->user;
                    $unusedVoucher = Productvoucher::whereNull("user_id")
                        ->where("enable", 1)
                        ->where("expirationdatetime", ">",
                            $nowDateTime)
                        ->where("product_id", $asiatechProduct)
                        ->get()
                        ->first();
                    if (isset($unusedVoucher)) {
                        $voucherOrder->orderstatus_id = config("constants.ORDER_STATUS_CLOSED");
                        if ($voucherOrder->update()) {
                            $userVoucher = $orderUser->productvouchers()
                                ->where("enable", 1)
                                ->where("expirationdatetime", ">",
                                    $nowDateTime)
                                ->where("product_id", $asiatechProduct)
                                ->get();
                            
                            if ($userVoucher->isEmpty()) {
                                
                                $unusedVoucher->user_id = $orderUser->id;
                                if ($unusedVoucher->update()) {
                                    
                                    event(new FreeInternetAccept($orderUser));
                                    $counter++;
                                } else {
                                    echo "<span style='color:red'>Error on giving voucher to user #".$orderUser->id."</span>";
                                    echo "<br>";
                                }
                            } else {
                                echo "<span style='color:orangered'>User  #".$orderUser->id." already has a voucher code</span>";
                                echo "<br>";
                            }
                        } else {
                            echo "<span style='color:red'>Error on updating order #".$voucherOrder->id." for user #".$orderUser->id."</span>";
                            echo "<br>";
                        }
                    } else {
                        echo "<span style='color:orangered'>Could not find voucher for user  #".$orderUser->id."</span>";
                        echo "<br>";
                    }
                }
                echo "<span style='color:green'>Number of processed orders: ".$counter."</span>";
                echo "<br>";
                dd("DONE!");
            }
            
            if ($request->has("coupon")) {
                $hamayeshTalai              = [
                    210,
                    211,
                    212,
                    213,
                    214,
                    215,
                    216,
                    217,
                    218,
                    219,
                    220,
                    221,
                    222,
                ];
                $notIncludedUsers_Shimi     = [
                    2,
                    111,
                    117,
                    203,
                    347,
                    417,
                    806,
                    923,
                    963,
                    1132,
                    1680,
                    2150,
                    2439,
                    2501,
                    3176,
                    3194,
                    3350,
                    3778,
                    3854,
                    4058,
                    4134,
                    4273,
                    4598,
                    4994,
                    5443,
                    5543,
                    5949,
                    6159,
                    6655,
                    6712,
                    7109,
                    7200,
                    7325,
                    7467,
                    7772,
                    8151,
                    8568,
                    8934,
                    9247,
                    9895,
                    9926,
                    10127,
                    10577,
                    10690,
                    11017,
                    11412,
                    11428,
                    11513,
                    11517,
                    11569,
                    11619,
                    11688,
                    11854,
                    12173,
                    12196,
                    12347,
                    12443,
                    12492,
                    12621,
                    12672,
                    12720,
                    12907,
                    12959,
                    13004,
                    13557,
                    13583,
                    13742,
                    13928,
                    14046,
                    14371,
                    14680,
                    14870,
                    15020,
                    15028,
                    15079,
                    15136,
                    15195,
                    15330,
                    15722,
                    15774,
                    15893,
                    16667,
                    16698,
                    17671,
                    18250,
                    19010,
                    19169,
                    19384,
                    19394,
                    19588,
                    20123,
                    20191,
                    20285,
                    20403,
                    20460,
                    20534,
                    20641,
                    20643,
                    20669,
                    20865,
                    21261,
                    21292,
                    21442,
                    21468,
                    21471,
                    21513,
                    21536,
                    21663,
                    21681,
                    21792,
                    21922,
                    22126,
                    22397,
                    22419,
                    22560,
                    22597,
                    22733,
                    23281,
                    23410,
                    24019,
                    24373,
                    24463,
                    24683,
                    24902,
                    25243,
                    25276,
                    25375,
                    25436,
                    26289,
                    26860,
                    27276,
                    27387,
                    27519,
                    27588,
                    27590,
                    27757,
                    27864,
                    27886,
                    27902,
                    28038,
                    28117,
                    28143,
                    28280,
                    28340,
                    28631,
                    28898,
                    28907,
                    29041,
                    29503,
                    29740,
                    29787,
                    29972,
                    30087,
                    30093,
                    30255,
                    30367,
                    30554,
                    31028,
                    31033,
                    31334,
                    31863,
                    32573,
                    32707,
                    32819,
                    33189,
                    33198,
                    33386,
                    33666,
                    33785,
                    34617,
                    34851,
                    34913,
                    34939,
                    35468,
                    35564,
                    35800,
                    36119,
                    36235,
                    36256,
                    36753,
                    36841,
                    36921,
                    36950,
                    37789,
                    38224,
                    38368,
                    38530,
                    38584,
                    38604,
                    38683,
                    39527,
                    40743,
                    42260,
                    42491,
                    42676,
                    42747,
                    42878,
                    43381,
                    44086,
                    44328,
                    44399,
                    44872,
                    46301,
                    46357,
                    46511,
                    46567,
                    46641,
                    46736,
                    47586,
                    47612,
                    47624,
                    48050,
                    48417,
                    48693,
                    49249,
                    49543,
                    50084,
                    50883,
                    51899,
                    51969,
                    52058,
                    53232,
                    54116,
                    56841,
                    57559,
                    61798,
                    62314,
                    62449,
                    63522,
                    64092,
                    64235,
                    66573,
                    67570,
                    68263,
                    68482,
                    69806,
                    70904,
                    71801,
                    73465,
                    76536,
                    78080,
                    78813,
                    80023,
                    80349,
                    81118,
                    81753,
                    82728,
                    83913,
                    85670,
                    87430,
                    88302,
                    92617,
                    94553,
                    94766,
                    95339,
                    95588,
                    96011,
                    97934,
                    98640,
                    103379,
                    103875,
                    103961,
                    105811,
                    106239,
                    106313,
                    107562,
                    107751,
                    108011,
                    108113,
                    109148,
                    109770,
                    109952,
                    112128,
                    112816,
                    113664,
                    114751,
                    116219,
                    116809,
                ];
                $notIncludedUsers_Vafadaran = [
                    100,
                    272,
                    282,
                    502,
                    589,
                    751,
                    1031,
                    1281,
                    1421,
                    1565,
                    1572,
                    1695,
                    1846,
                    2143,
                    2385,
                    2661,
                    3396,
                    3538,
                    3646,
                    3738,
                    3788,
                    4051,
                    4117,
                    4197,
                    4517,
                    5009,
                    5385,
                    5877,
                    6452,
                    6767,
                    6895,
                    6896,
                    7020,
                    7037,
                    7056,
                    7192,
                    7291,
                    7442,
                    7527,
                    7942,
                    8199,
                    8681,
                    9363,
                    10244,
                    10263,
                    10343,
                    11088,
                    11133,
                    11339,
                    11440,
                    11594,
                    11623,
                    11742,
                    11797,
                    11804,
                    12155,
                    12788,
                    13313,
                    13410,
                    13436,
                    13442,
                    13448,
                    13541,
                    13724,
                    13746,
                    13752,
                    14084,
                    14807,
                    14937,
                    15603,
                    15914,
                    16114,
                    16141,
                    16291,
                    16491,
                    16779,
                    17275,
                    17500,
                    17527,
                    18344,
                    18377,
                    18663,
                    18759,
                    19481,
                    19714,
                    19736,
                    20016,
                    20150,
                    20172,
                    20381,
                    20442,
                    20501,
                    20652,
                    20666,
                    20732,
                    20753,
                    20937,
                    20953,
                    21412,
                    21431,
                    21522,
                    22275,
                    22290,
                    22391,
                    22495,
                    23130,
                    23438,
                    23600,
                    23986,
                    24223,
                    24472,
                    25457,
                    25557,
                    25572,
                    25776,
                    25806,
                    26355,
                    26621,
                    27764,
                    28269,
                    28288,
                    28371,
                    28385,
                    28397,
                    28405,
                    28488,
                    28719,
                    28865,
                    29021,
                    29050,
                    29054,
                    29194,
                    29230,
                    29334,
                    29589,
                    29737,
                    30038,
                    30129,
                    30158,
                    30318,
                    30652,
                    30857,
                    30958,
                    31508,
                    32131,
                    32274,
                    32894,
                    32906,
                    32959,
                    32987,
                    33187,
                    33255,
                    33616,
                    33680,
                    33803,
                    33817,
                    33949,
                    34018,
                    34062,
                    34188,
                    34966,
                    35004,
                    35327,
                    35652,
                    35911,
                    35929,
                    35936,
                    36264,
                    36364,
                    36444,
                    36460,
                    36524,
                    36788,
                    36793,
                    36883,
                    37006,
                    37021,
                    37058,
                    37156,
                    38868,
                    38893,
                    39022,
                    39062,
                    39075,
                    40088,
                    40189,
                    40503,
                    40958,
                    41389,
                    41448,
                    41858,
                    42848,
                    43322,
                    44436,
                    46322,
                    48191,
                    49032,
                    49314,
                    50637,
                    50671,
                    51091,
                    54884,
                    56547,
                    57493,
                    57649,
                    58317,
                    59178,
                    62602,
                    62713,
                    62903,
                    62987,
                    63530,
                    66143,
                    66485,
                    68472,
                    69136,
                    71817,
                    72386,
                    72458,
                    73399,
                    75119,
                    76888,
                    77855,
                    78596,
                    78897,
                    80328,
                    80408,
                    80973,
                    82093,
                    82744,
                    82785,
                    83048,
                    83991,
                    85557,
                    86966,
                    87086,
                    87791,
                    88977,
                    90447,
                    92857,
                    92951,
                    93432,
                    93701,
                    99623,
                    99686,
                    101628,
                    107960,
                    108174,
                    110145,
                    115132,
                    118902,
                    119386,
                    125351,
                ];
                $smsNumber                  = config("constants.SMS_PROVIDER_DEFAULT_NUMBER");
                $users                      = User::whereHas("orderproducts", function ($q) use ($hamayeshTalai) {
                    $q->whereHas("order", function ($q) use ($hamayeshTalai) {
                        $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                            ->whereIn("paymentstatus_id", [
                                config("constants.PAYMENT_STATUS_PAID"),
                            ]);
                    })
                        ->whereIn("product_id", $hamayeshTalai);
                    //                        ->havingRaw('COUNT(*) > 0');
                })
                    ->whereDoesntHave("orderproducts", function ($q) use ($hamayeshTalai) {
                        $q->whereHas("order", function ($q) use ($hamayeshTalai) {
                            $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                                ->whereIn("paymentstatus_id", [
                                    config("constants.PAYMENT_STATUS_PAID"),
                                ]);
                        })
                            ->where("product_id", 210);
                    })
                    ->whereNotIn("id", $notIncludedUsers_Shimi)
                    ->whereNotIn("id", $notIncludedUsers_Vafadaran)
                    ->get();
                
                echo "number of users:".$users->count();
                echo "<br>";
                dd("stop");
                $couponController = new CouponController();
                $failedCounter    = 0;
                $proccessed       = 0;
                dump($users->pluck("id")
                    ->toArray());
                
                foreach ($users as $user) {
                    do {
                        $couponCode = str_random(5);
                    } while (\App\Coupon::where("code", $couponCode)
                        ->get()
                        ->isNotEmpty());
                    
                    /** Coupon Settings */
                    $couponName        = "قرعه کشی وفاداران آلاء برای ".$user->getFullName();
                    $couponDescription = "قرعه کشی وفاداران آلاء برای ".$user->getFullName();
                    $validSinceDate    = "2018-06-11";
                    $validUntilDate    = " 00:00:00";
                    $validSinceTime    = "2018-06-15";
                    $validUntilTime    = "12:00:00";
                    $couponProducts    = \App\Product::whereNotIn("id", [
                        179,
                        180,
                        182,
                    ])
                        ->get()
                        ->pluck('id')
                        ->toArray();
                    $discount          = 55;
                    /** Coupon Settings */
                    
                    $insertCouponRequest = new \App\Http\Requests\InsertCouponRequest();
                    $insertCouponRequest->offsetSet("enable", 1);
                    $insertCouponRequest->offsetSet("usageNumber", 0);
                    $insertCouponRequest->offsetSet("limitStatus", 0);
                    $insertCouponRequest->offsetSet("coupontype_id", 2);
                    $insertCouponRequest->offsetSet("discounttype_id", 1);
                    $insertCouponRequest->offsetSet("name", $couponName);
                    $insertCouponRequest->offsetSet("description", $couponDescription);
                    $insertCouponRequest->offsetSet("code", $couponCode);
                    $insertCouponRequest->offsetSet("products", $couponProducts);
                    $insertCouponRequest->offsetSet("discount", $discount);
                    $insertCouponRequest->offsetSet("validSince", $validSinceDate);
                    $insertCouponRequest->offsetSet("sinceTime", $validSinceTime);
                    $insertCouponRequest->offsetSet("validSinceEnable", 1);
                    $insertCouponRequest->offsetSet("validUntil", $validUntilDate);
                    $insertCouponRequest->offsetSet("untilTime", $validUntilTime);
                    $insertCouponRequest->offsetSet("validUntilEnable", 1);
                    
                    $storeCoupon = $couponController->store($insertCouponRequest);
                    
                    if ($storeCoupon->status() == 200) {
                        
                        $message = "شما در قرعه کشی وفاداران آلاء برنده یک کد تخفیف شدید.";
                        $message .= "\n";
                        $message .= "کد شما:";
                        $message .= "\n";
                        $message .= $couponCode;
                        $message .= "\n";
                        $message .= "مهلت استفاده از کد: تا پنجشنبه ساعت 11 شب";
                        $message .= "\n";
                        $message .= "به امید اینکه با کمک دیگر همایش های آلاء در کنکور بدرخشید و برنده iphonex در قرعه کشی عید فطر آلاء باشید.";
                        $user->notify(new GeneralNotice($message));
                        echo "<span style='color:green'>";
                        echo "user ".$user->id." notfied";
                        echo "</span>";
                        echo "<br>";
                        
                        $proccessed++;
                        
                        //                    $openOrder = $userlottery->openOrders()->get()->first();
                        //                    if (isset($openOrder)) {
                        //                        session()->forget("order_id");
                        //                        session()->put("order_id", $openOrder->id);
                        //                        $attachCouponRequest = new \App\Http\Requests\SubmitCouponRequest();
                        //                        $attachCouponRequest->offsetSet("coupon", $couponCode);
                        //                        $orderController = new \App\Http\Controllers\OrderController();
                        //                        $orderController->submitCoupon($attachCouponRequest);
                        //                        session()->forget('couponMessageError');
                        //                        session()->forget('couponMessageSuccess');
                        //                    }
                    } else {
                        $failedCounter++;
                    }
                }
                
                dump("processed: ".$proccessed);
                dump("failed: ".$failedCounter);
                dd("coupons done");
            }
            
            if ($request->has("tagfix")) {
                $contentsetId = 159;
                $contentset   = Contentset::where("id", $contentsetId)
                    ->first();
                
                $tags = $contentset->tags->tags;
                array_push($tags, "نادریان");
                $bucket           = "contentset";
                $tagsJson         = [
                    "bucket" => $bucket,
                    "tags"   => $tags,
                ];
                $contentset->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                
                if ($contentset->update()) {
                    $params = [
                        "tags" => json_encode($contentset->tags->tags, JSON_UNESCAPED_UNICODE),
                    ];
                    if (isset($contentset->created_at) && strlen($contentset->created_at) > 0) {
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $contentset->created_at)->timestamp;
                    }
                    
                    $response = $this->sendRequest(config("constants.TAG_API_URL")."id/$bucket/".$contentset->id, "PUT",
                        $params);
                } else {
                    dump("Error on updating #".$contentset->id);
                }
                
                $contents = $contentset->contents;
                
                foreach ($contents as $content) {
                    $tags = $content->tags->tags;
                    array_push($tags, "نادریان");
                    $bucket        = "content";
                    $tagsJson      = [
                        "bucket" => $bucket,
                        "tags"   => $tags,
                    ];
                    $content->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                    if ($content->update()) {
                        $params = [
                            "tags" => json_encode($content->tags->tags, JSON_UNESCAPED_UNICODE),
                        ];
                        if (isset($content->created_at) && strlen($content->created_at) > 0) {
                            $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $content->created_at)->timestamp;
                        }
                        
                        $response = $this->sendRequest(config("constants.TAG_API_URL")."id/$bucket/".$content->id,
                            "PUT", $params);
                    } else {
                        dump("Error on updating #".$content->id);
                    }
                }
                dd("Tags DONE!");
            }

            if($request->has('checkghesdi')){
                $orders = Order::where('paymentstatus_id', config('constants.PAYMENT_STATUS_INDEBTED'))
                                ->whereDoesntHave('orderproducts' , function ($q){
                                    $q->where('product_id' , Product::CUSTOM_DONATE_PRODUCT);
                                });

                $since = $request->get('since');
                if(isset($since))
                    $orders->where('completed_at' , '>=' , $since.' 00:00:00');

                $till = $request->get('till');
                if(isset($till))
                    $orders->where('completed_at' , '<=' , $till.' 23:59:59');

                $orders = $orders->get();
                dump('Found total '.$orders->count().' indebted orders');
                $counter = 0;
                foreach ($orders as $order){
                    if($order->totalCost() == $order->totalPaidCost())
                    {
                        $counter++;
                        $orderLink = action('Web\OrderController@edit' , $order);
                        echo $counter.' - ';
                        echo('<a target="_blank" href="'.$orderLink.'">'.$order->id.'</a>');
                        echo('<br>');
                    }
                }
                if($counter == 0 )
                {
                    dump('No corrupted orders found');
                }
                dd('Done!');

            }

            if($request->has('fakedonates')){
                $orders = Order::where('paymentstatus_id' , config('constants.PAYMENT_STATUS_INDEBTED'))
                                ->where('orderstatus_id' , config('constants.ORDER_STATUS_CLOSED'))
                                ->where('costWithoutcoupon' , 0)
                                ->whereHas('orderproducts' , function ($q){
                                    $q->where('product_id' , Product::CUSTOM_DONATE_PRODUCT);
                                })
                                ->get();

                dump('Found total '.$orders->count().' fake donate orders');
                $counter = 0;
                foreach ($orders as $order) {
                    if($order->totalPaidCost() == 0)
                    {
                        $counter++;
                        $orderLink = action('Web\OrderController@edit' , $order);
                        echo $counter.' - ';
                        echo('<a target="_blank" href="'.$orderLink.'">'.$order->id.'</a>');
                        echo('<br>');
                    }
                }
                dd('Done!');
            }

            if($request->has('checkorderproducts')){
                $mode = 'paid_more';
                if($request->has('notpaid')){
                    $mode = 'not_paid';
                }
                $orders = Order::where('paymentstatus_id' , config('constants.PAYMENT_STATUS_PAID'))
                                ->where('orderstatus_id' , config('constants.ORDER_STATUS_CLOSED'));

                $since = $request->get('since');
                if(isset($since))
                    $orders->where('completed_at' , '>=' , $since.' 00:00:00');

                $till = $request->get('till');
                if(isset($till))
                    $orders->where('completed_at' , '<=' , $till.' 23:59:59');

                $orders = $orders->get();
                dump('Found total '.$orders->count().' orders');
                $counter = 0;
                foreach ($orders as $order){
                    $orderTotalCost = (int)$order->obtainOrderCost(true , false)['totalCost'];
                    if($mode == 'paid_more'){
                        $condition = (( $order->totalPaidCost() - $orderTotalCost ) > 5)?true:false ;
                    }else{
                        $condition = ( $orderTotalCost > $order->totalPaidCost() )?true:false ;
                    }
                    if($condition)
                    {
                        $counter++;
                        $orderLink = action('Web\OrderController@edit' , $order);
                        echo $counter.' - ';
                        echo('<a target="_blank" href="'.$orderLink.'">'.$order->id.'</a>');
                        echo('<br>');
                    }
                }
                if($counter == 0 )
                {
                    dump('No corrupted orders found');
                }
                dd('Done!');

            }

            if($request->has('checktransactions')){
                $transactions = Transaction::whereNotNull('transactionID')
                                            ->where('transactionstatus_id' , config('constants.TRANSACTION_STATUS_UNSUCCESSFUL'));

                $transactions = $transactions->get();
                $totalCount = $transactions->count();
                if($totalCount == 0 )
                {
                    dd('No corrupted transactions found');
                }

                dump('Found total '.$totalCount.' transactions');
                $counter = 0;
                foreach ($transactions as $transaction) {
                    $counter++;
                    $transactionLink = action('Web\TransactionController@edit' , $transaction);
                    echo $counter.' - ';
                    echo('<a target="_blank" href="'.$transactionLink.'">'.$transaction->id.'</a>');
                    echo('<br>');
                }
                dd('Done!');
            }

            if($request->has('checkmellat')){
                $transactionId = $request->get('id');
                if(!isset($transactionId)) {
                    dd('Please provide transaction id');
                }

                $transaction = Transaction::find($transactionId);
                if(!isset($transaction)){
                    dd('Transaction not found');
                }

                $client = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

                $parameters = [
                    'terminalId'      => config('behpardakht.terminalId'),
                    'userName'        => config('behpardakht.username'),
                    'userPassword'    => config('behpardakht.password'),
                    'orderId'         => $transaction->order_id,
                    'saleOrderId'     => $transaction->order_id,
                    'saleReferenceId' => $transaction->transactionID,
                ];


                try {
                    dd($client->bpInquiryRequest($parameters));
                } catch (\SoapFault $e) {
                    throw $e;
                }
            }

            if($request->has('refundwallet')){
                $walletTransactions = Transaction::where('paymentmethod_id' , config('constants.PAYMENT_METHOD_WALLET'))
                                                    ->where('transactionstatus_id' , config('constants.TRANSACTION_STATUS_SUSPENDED'))
                                                    ->get();

                dump('total transactions: '.$walletTransactions->count() );
                dump('total transactions cost: '.number_format($walletTransactions->sum('cost')));
                /** @var Transaction $walletTransaction */
                $totalRefund = 0;

                $depositFlag = false;
                if($request->has('dorefund')){
                    $depositFlag = true;
                }


                foreach ($walletTransactions as $walletTransaction) {
                    /** @var Order $order */
                    $order = $walletTransaction->order;
                    /** @var \App\Wallet $wallet */
                    $wallet = $walletTransaction->wallet;
                    if(!isset($order)) {
                        echo('Transaction does not have order: '.$walletTransaction->id);
                        echo('</br>');
                        continue;
                    }

                    if(!isset($wallet)) {
                        echo('Transaction does not have wallet: '.$walletTransaction->id);
                        echo('</br>');
                        continue;
                    }

                    if($walletTransaction->cost < 0){
                        echo('Transaction cost is minus: '.$walletTransaction->id);
                        echo('</br>');
                        continue;
                    }

                    if($walletTransaction->cost == 0){
                        echo('Transaction cost is zero: '.$walletTransaction->id);
                        echo('</br>');
                        continue;
                    }

                    if($order->paymentstatus_id == config('constants.PAYMENT_STATUS_PAID')){
                        echo('Order status is paid: '.$walletTransaction->id);
                        echo('</br>');
                        continue;
                    }

                    if($order->orderstatus_id != config('constants.ORDER_STATUS_CLOSED') && $order->orderstatus_id != config('constants.ORDER_STATUS_CANCELED')){
                        echo('Order status is not closed: '.$order->orderstatus_id.' '.$walletTransaction->id);
                        echo('</br>');
                        continue;
                    }


                    if($depositFlag){
                        $result = $walletTransaction->depositThisWalletTransaction();
                        if($result['result'])
                        {
                            $totalRefund += $walletTransaction->cost;
                            $walletTransaction->delete();
                        }else{
                            echo('Could not update wallet '.$wallet->id.' : '.$walletTransaction->id);
                            echo('</br>');
                        }
                    }
                }

                dd('total refunded : '.number_format($totalRefund));
            }

            if($request->has('walletquery')){
                $query = User::whereHas('transactions' , function ($q) {
                    $q->where('paymentmethod_id', config('constants.PAYMENT_METHOD_WALLET'))
                        ->where('transactionstatus_id', config('constants.TRANSACTION_STATUS_SUSPENDED'))
                        ->where('cost', '>', 0)
                        ->whereHas('order', function ($q2) {
                            $q2->whereNotIn('paymentstatus_id', [config('constants.PAYMENT_STATUS_PAID')])
                                ->whereIn('orderstatus_id', [config('constants.ORDER_STATUS_CLOSED'), config('constants.ORDER_STATUS_CANCELED')]);
                        });
                })->toSql();

                dd($query);
            }

            if($request->has('teacherrank')){
                $otherProducts = [306, 316, 322, 318, 302, 326, 312, 298, 308, 328, 342];
                    $orderproducts = Orderproduct::select(DB::raw('COUNT("*") as count , product_id'))
                        ->whereIn('product_id', $otherProducts)
                        ->where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                        ->whereHas('order', function ($q) {
                            $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                                ->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                        })
                        ->groupBy('product_id')
                        ->get()
                        ->pluck('count' , 'product_id')
                        ->toArray();

                    dd($orderproducts);
            }

            if($request->has('query')){
                $users = User::whereHas('orders' , function ($q){
                    $q->whereIn('orderstatus_id' , [2,5])
                        ->whereIn('paymentstatus_id' , [3,4])
                        ->whereHas('orderproducts' , function ($q2){
                            $q2->whereIn('product_id' , [312]);
                        });
                });

                dd($users->toSql());



                $users = User::whereHas('orders' , function ($q){
                    $q->whereIn('orderstatus_id' , [2,5])
                        ->whereIn('paymentstatus_id' , [3,4])
                        ->whereHas('orderproducts' , function ($q2){
                            $q2->whereIn('product_id' , [281,282,283,284,292,287,293,285,286,288,289,290,291]);
                        });
                })->whereHas('orders', function ($q3) {
                    $q3->whereIn('orderstatus_id' , [2,5])
                        ->whereIn('paymentstatus_id' , [3,4])
                        ->whereHas('orderproducts' , function ($q2){
                            $q2->whereIn('product_id' , [306, 316, 322, 318, 302, 326, 312, 298, 308, 328, 342]);
                        });
                });

                $orderproducts = Orderproduct::select(DB::raw('COUNT("*") as count'))
                            ->whereIn('product_id' , [306, 316, 322, 318, 302, 326, 312, 298, 308, 328, 342 ])
                            ->where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                            ->whereHas('order', function ($q3) {
                                $q3->whereIn('orderstatus_id' , [2,5])
                                    ->whereIn('paymentstatus_id' , [3,4]);
                            });

                dd($orderproducts->get()->first()->count);
            }

        } catch (\Exception    $e) {
            $message = "unexpected error";
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    "message" => $message,
                    "error"   => $e->getMessage(),
                    "line"    => $e->getLine(),
                    "file"    => $e->getFile(),
                ]);
        }
        
        /**
         * Fixing contentset tags
         *
         * if(Input::has("id"))
         * $contentsetId = Input::get("id");
         * else
         * dd("Wring inputs, Please pass id as input");
         *
         * if(!is_array($contentsetId))
         * dd("The id input must be an array!");
         * $contentsets = Contentset::whereIn("id" , $contentsetId)->get();
         * dump("number of contentsets:".$contentsets->count());
         * $contentCounter = 0;
         * foreach ($contentsets as $contentset)
         * {
         * $baseTime = Carbon::createFromDate("2017" , "06" , "01" , "Asia/Tehran");
         * $contents = $contentset->contents->sortBy("pivot.order");
         * $contentCounter += $contents->count();
         * foreach ($contents as $content)
         * {
         * $content->created_at = $baseTime;
         * if($content->update())
         * {
         * if(isset($content->tags))
         * {
         * $params = [
         * "tags"=> json_encode($content->tags->tags,JSON_UNESCAPED_UNICODE ) ,
         * ];
         * if(isset($content->created_at) && strlen($content->created_at) > 0 )
         * $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $content->created_at )->timestamp;
         *
         * $response =  $this->sendRequest(
         * config("constants.AG_API_URL")."id/content/".$content->id ,
         * "PUT",
         * $params
         * );
         *
         * if($response["statusCode"] == 200)
         * {
         * }
         * else
         * {
         * dump("tag request for content id ".$content->id." failed. response : ".$response["statusCode"]);
         * }
         * }
         * else
         * {
         * dump("content id ".$content->id."did not have ant tags!");
         * }
         * }
         * else
         * {
         * dump("content id ".$content->id." was not updated");
         * }
         * $baseTime = $baseTime->addDay();
         * }
         *
         * }
         * dump("number of total processed contents: ".$contentCounter);
         * dd("done!");
         */
        
        /***
         * $contents = Content::where("contenttype_id" , 8);
         * $contentArray = $contents->pluck("id")->toArray();
         * $sanatishRecords = Sanatisharifmerge::whereIn("content_id" , $contentArray)->get();
         * $contents = $contents->get();
         * $successCounter = 0 ;
         * $failedCounter = 0 ;
         * dump("number of contents: ".$contents->count());
         * foreach ($contents as $content)
         * {
         * $myRecord =  $sanatishRecords->where("content_id" , $content->id)->first();
         * if(isset($myRecord))
         * if(isset($myRecord->videoEnable))
         * {
         * if($myRecord->isEnable)
         * $content->enable = 1;
         * else
         * $content->enable = 0 ;
         * if($content->update())
         * $successCounter++;
         * else
         * $failedCounter++;
         * }
         *
         *
         * }
         * dump("success counter: ".$successCounter);
         * dump("fail counter: ".$failedCounter);
         *
         * dd("finish");
         */
        
        /**
         * $contents =  Content::where("id" , "<" , 158)->get();
         * dump("number of contents: ".$contents->count());
         * $successCounter= 0 ;
         * $failedCounter = 0;
         * foreach ($contents as $content)
         * {
         * $contenttype = $content->contenttypes()->whereDoesntHave("parents")->get()->first();
         * $content->contenttype_id = $contenttype->id ;
         * if($content->update())
         * {
         * $successCounter++;
         * }
         * else
         * {
         * $failedCounter++;
         * dump("content for ".$content->id." was not saved.") ;
         * }
         * }
         * dump("successful : ".$successCounter);
         * dump("failed: ".$failedCounter) ;
         * dd("finish");
         **/
        /**
         * Giving gift to users
         *
         * $carbon = new Carbon("2018-02-20 00:00:00");
         * $orderproducts = Orderproduct::whereIn("product_id" ,[ 100] )->whereHas("order" , function ($q) use ($carbon)
         * {
         * //           $q->where("orderstatus_id" , 1)->where("created_at" ,">" , $carbon);
         * $q->where("orderstatus_id" , 2)->whereIn("paymentstatus_id" , [2,3])->where("completed_at" ,">" , $carbon);
         * })->get();
         * dump("تعداد سفارش ها" . $orderproducts->count());
         * $users = array();
         * $counter = 0;
         * foreach ($orderproducts as $orderproduct)
         * {
         * $order = $orderproduct->order;
         * if($order->orderproducts->where("product_id" , 107)->isNotEmpty()) continue ;
         *
         * $giftOrderproduct = new Orderproduct();
         * $giftOrderproduct->orderproducttype_id = Config::get("constants.ORDER_PRODUCT_GIFT");
         * $giftOrderproduct->order_id = $order->id ;
         * $giftOrderproduct->product_id = 107 ;
         * $giftOrderproduct->cost = 24000 ;
         * $giftOrderproduct->discountPercentage = 100 ;
         * $giftOrderproduct->save() ;
         *
         * $giftOrderproduct->parents()->attach($orderproduct->id , ["relationtype_id"=>Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);
         * $counter++;
         * if(isset($order->user->id))
         * array_push($users , $order->user->id);
         * else
         * array_push($users , 0);
         * }
         * dump($counter." done");
         * dd($users);
         */
        /**
         *  Converting Hamayesh with Poshtibani to without poshtibani
         * if (!Auth::user()->hasRole("admin")) abort(404);
         *
         * $productsArray = [164, 160, 156, 152, 148, 144, 140, 136, 132, 128, 124, 120];
         * $orders = Order::whereHas("orderproducts", function ($q) use ($productsArray) {
         * $q->whereIn("product_id", $productsArray);
         * })->whereIn("orderstatus_id", [Config::get("constants.ORDER_STATUS_CLOSED"), Config::set("constants.ORDER_STATUS_POSTED")])->whereIn("paymentstatus_id", [Config::get("constants.PAYMENT_STATUS_PAID"), Config::get("constants.PAYMENT_STATUS_INDEBTED")])->get();
         *
         *
         * dump("Number of orders: ".$orders->count());
         * $counter = 0;
         * foreach ($orders as $order)
         * {
         * if($order->successfulTransactions->isEmpty()) continue ;
         * $totalRefund = 0;
         * foreach ($order->orderproducts->whereIn("product_id", $productsArray) as $orderproduct)
         * {
         * $orderproductTotalRefund = 0 ;
         * $orderproductRefund = (int)((($orderproduct->cost / 88000) * 9000))  ;
         * $orderproductRefundWithBon = $orderproductRefund * (1 - ($orderproduct->getTotalBonNumber() / 100)) ;
         * if($order->couponDiscount>0 && $orderproduct->includedInCoupon)
         * $orderproductTotalRefund += $orderproductRefundWithBon * (1 - ($order->couponDiscount / 100)) ;
         * else
         * $orderproductTotalRefund += $orderproductRefundWithBon ;
         *
         * $totalRefund += $orderproductTotalRefund ;
         * $orderproduct->cost = $orderproduct->cost - $orderproductRefund ;
         * switch ($orderproduct->product_id)
         * {
         * case 164:
         * $orderproduct->product_id = 165 ;
         * break;
         * case 160:
         * $orderproduct->product_id = 161 ;
         * break;
         * case 156:
         * $orderproduct->product_id = 157 ;
         * break;
         * case 152:
         * $orderproduct->product_id = 153 ;
         * break;
         * case 148:
         * $orderproduct->product_id = 149 ;
         * break;
         * case 144:
         * $orderproduct->product_id = 145 ;
         * break;
         * case 140:
         * $orderproduct->product_id = 141 ;
         * break;
         * case 136:
         * $orderproduct->product_id = 137 ;
         * break;
         * case 132:
         * $orderproduct->product_id = 133 ;
         * break;
         * case 128:
         * $orderproduct->product_id = 129 ;
         * break;
         * case 124:
         * $orderproduct->product_id = 125 ;
         * break;
         * case 120:
         * $orderproduct->product_id = 121 ;
         * break;
         * default:
         * break;
         * }
         * if(!$orderproduct->update()) dump("orderproduct ".$orderproduct->id." wasn't saved");
         * }
         * $newOrder = Order::where("id" , $order->id)->get()->first();
         * $orderCostArray = $newOrder->obtainOrderCost(true , false , "REOBTAIN");
         * $newOrder->cost = $orderCostArray["rawCostWithDiscount"] ;
         * $newOrder->costwithoutcoupon = $orderCostArray["rawCostWithoutDiscount"];
         * $newOrder->update();
         *
         * if($totalRefund > 0 )
         * {
         * $transactionRequest =  new \App\Http\Requests\InsertTransactionRequest();
         * $transactionRequest->offsetSet("comesFromAdmin" , true);
         * $transactionRequest->offsetSet("order_id" , $order->id);
         * $transactionRequest->offsetSet("cost" , -$totalRefund);
         * $transactionRequest->offsetSet("managerComment" , "ثبت سیستمی بازگشت هزینه پشتیبانی همایش 1+5");
         * $transactionRequest->offsetSet("destinationBankAccount_id" , 1);
         * $transactionRequest->offsetSet("paymentmethod_id" , Config::get("constants.PAYMENT_METHOD_ATM"));
         * $transactionRequest->offsetSet("transactionstatus_id" ,  Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL"));
         * $transactionController = new TransactionController();
         * $transactionController->store($transactionRequest);
         *
         * if(session()->has("success")) {
         * session()->forget("success");
         * }elseif(session()->has("error")){
         * dump("Transaction wasn't saved ,Order: ".$order->id);
         * session()->forget("error");
         * }
         * $counter++;
         * }
         * }
         * dump("Processed: ".$counter) ;
         */
        /**
         *  Fixing complementary products
         *
         * $products = \App\Product::all();
         * $counter = 0 ;
         * foreach ($products as $product)
         * {
         * $orders = \App\Order::whereHas("orderproducts" , function ($q2) use ($product){
         * $q2->where("product_id" , $product->id)->where("orderproducttype_id", config('constants.ORDER_PRODUCT_TYPE_DEFAULT'));
         * })->whereIn("orderstatus_id" , [Config::get("constants.ORDER_STATUS_CLOSED") , Config::get("constants.ORDER_STATUS_POSTED") , Config::get("constants.ORDER_STATUS_READY_TO_POST")])
         * ->whereIn("paymentstatus_id" , [Config::get("constants.PAYMENT_STATUS_INDEBTED") , Config::get("constants.PAYMENT_STATUS_PAID")])->get();
         *
         * dump("Number of orders: ".$orders->count());
         * foreach ($orders as $order)
         * {
         * if ($product->hasGifts())
         * {
         * foreach ($product->gifts as $gift)
         * {
         * if($order->orderproducts->where("product_id" , $gift->id)->isEmpty())
         * {
         * $orderproduct = new \App\Orderproduct();
         * $orderproduct->orderproducttype_id = 2;
         * $orderproduct->order_id = $order->id;
         * $orderproduct->product_id = $gift->id;
         * $orderproduct->cost = $gift->basePrice;
         * $orderproduct->discountPercentage = 100;
         * if ($orderproduct->save()) $counter++;
         * else dump("orderproduct was not saved! order: " . $order->id . " ,product: " . $gift->id);
         * }
         * }
         * }
         * //$parentsArray = $product->parents;
         * $parentsArray = $this->makeParentArray($product);
         * if (!empty($parentsArray)) {
         * foreach ($parentsArray as $parent) {
         * foreach ($parent->gifts as $gift) {
         * if($order->orderproducts->where("product_id" , $gift->id)->isEmpty())
         * {
         * $orderproduct = new \App\Orderproduct();
         * $orderproduct->orderproducttype_id = 2;
         * $orderproduct->order_id = $order->id;
         * $orderproduct->product_id = $gift->id;
         * $orderproduct->cost = $gift->basePrice;
         * $orderproduct->discountPercentage = 100;
         * if ($orderproduct->save()) $counter++;
         * else dump("orderproduct was not saved! order: " . $order->id . " ,product: " . $gift->id);
         * }
         * }
         * }
         * }
         * }
         * }
         * dump("Number of processed : ".$counter);
         * dd("finish");
         * */
    }
    
    public function walletBot(Request $request)
    {
        if (!$request->has("userGroup")) {
            session()->put("error", "لطفا گروه کاربران را تعیین کنید");
            
            return redirect()->back();
        } else {
            $userGroup = $request->get("userGroup");
        }
        
        $hamayeshTalai      = [
            210,
            211,
            212,
            213,
            214,
            215,
            216,
            217,
            218,
            219,
            220,
            221,
            222,
        ];
        $ordooHozoori       = [
            195,
            184,
            185,
            186,
        ];
        $ordooGheireHozoori = [
            196,
            199,
            206,
            202,
            200,
            201,
            203,
            204,
            205,
        ];
        $hamayesh5Plus1     = [
            123,
            124,
            125,
            119,
            120,
            121,
            163,
            164,
            165,
            159,
            160,
            161,
            155,
            156,
            157,
            151,
            152,
            153,
            147,
            148,
            149,
            143,
            144,
            145,
            139,
            140,
            141,
            135,
            136,
            137,
            131,
            132,
            133,
            127,
            128,
            129,
        ];
        if ($request->has("giftCost")) {
            $giftCredit = $request->get("giftCost");
        } else {
            session()->put("error", "لطفا مبلغ هدیه را تعیین کنید");
            
            return redirect()->back();
        }
        
        switch ($userGroup) {
            case "1":
                $productSet = [
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [$hamayesh5Plus1]
                        // products id
                    ],
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [$hamayeshTalai]
                        // products id
                    ],
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $ordooGheireHozoori,
                            $ordooHozoori,
                        ],
                        // products id
                    ],
                ];
                break;
            case "2":
                $productSet = [
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [$hamayesh5Plus1]
                        // products id
                    ],
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $ordooGheireHozoori,
                            $ordooHozoori,
                        ],
                        // products id
                    ],
                    [
                        "query"  => "whereDoesntHave",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [$hamayeshTalai]
                        // products id
                    ],
                ];
                break;
            case "3":
                $productSet = [
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [$hamayesh5Plus1]
                        // products id
                    ],
                    [
                        "query"  => "whereDoesntHave",
                        //whereHas / whereDoesntHave
                        "filter" => "whereNotIn",
                        //whereIn / whereNotIn / all
                        "id"     => [$hamayesh5Plus1]
                        // products id
                    ],
                ];
                break;
            case "4":
                $productSet = [
                    [
                        "query"  => "whereDoesntHave",
                        //whereHas / whereDoesntHave
                        "filter" => "all",
                        //whereIn / whereNotIn / all
                        "id"     => []
                        // products id
                    ],
                ];
                break;
            case "5":
                $productSet = [
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "all",
                        //whereIn / whereNotIn / all
                        "id"     => []
                        // products id
                    ],
                    [
                        "query"  => "whereDoesntHave",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $hamayeshTalai,
                            $ordooHozoori,
                            $ordooGheireHozoori,
                            $hamayesh5Plus1,
                        ]
                        // products id
                    ],
                ];
                break;
            case "6":
                $productSet = [
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $hamayeshTalai,
                        ]
                        // products id
                    ],
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $hamayesh5Plus1,
                        ]
                        // products id
                    ],
                    [
                        "query"  => "whereDoesntHave",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $ordooGheireHozoori,
                            $ordooHozoori,
                        ]
                        // products id
                    ],
                ];
                break;
            case "7":
                $productSet = [
                    [
                        "query"  => "whereHas",
                        //whereHas / whereDoesntHave
                        "filter" => "whereIn",
                        //whereIn / whereNotIn / all
                        "id"     => [
                            $hamayeshTalai,
                        ]
                        // products id
                    ],
                
                ];
                break;
            default:
                session()->put("error", "گروه کاربران معتبر نمی باشد");
                
                return redirect()->back();
                break;
        }
        
        $users = User::query();
        foreach ($productSet as $products) {
            $query = $products["query"];
            $users->$query("orders", function ($q) use ($products) {
                if ($products["filter"] != "all") {
                    if (isset($products["filter"])) {
                        $filterType = $products["filter"];
                    } else {
                        $filterType = "";
                    }
                    
                    if (isset($products["id"])) {
                        $idArray = $products["id"];
                    } else {
                        $idArray = [];
                    }
                    
                    $q->whereHas("orderproducts", function ($q2) use ($idArray, $filterType) {
                        if (!empty($idArray) && strlen($filterType) > 0) {
                            foreach ($idArray as $key => $ids) {
                                if ($key > 0) {
                                    $myFilterType = "or".$filterType;
                                } else {
                                    $myFilterType = $filterType;
                                }
                                
                                $q2->$myFilterType("product_id", $ids);
                            }
                        }
                    });
                }
                
                $q->whereIn("orderstatus_id", [
                    2,
                    5,
                    7,
                ])
                    ->whereIn("paymentstatus_id", [
                        2,
                        3,
                    ]);
            });
        }
        
        $users = $users->get();
        dump("Total number of users:".$users->count());
        
        if (!$request->has("giveGift")) {
            dd("Done!");
        }
        
        $successCounter = 0;
        $failedCounter  = 0;
        foreach ($users as $user) {
            $result = $user->deposit($giftCredit, 2);
            if (isset($result["wallet"])) {
                $wallet = $result["wallet"];
            } else {
                $wallet = "unknown";
            }
            if ($result["result"]) {
                $user->notify(new GiftGiven($giftCredit));
                $successCounter++;
            } else {
                $failedCounter++;
                dump("Credit for user: ".$user->id." was not given!"."wallet: ".$wallet." ,response: ".$result["responseText"]);
            }
        }
        dump("Number of successfully processed users: ", $successCounter);
        dump("Number of failed users: ", $failedCounter);
        dd("Done!");
    }
    
    public function pointBot(Request $request)
    {
        /** Points for Hamayesh Talai lottery */
                /*$hamayeshTalai = [306, 316, 322, 318, 302, 326, 312, 298, 308, 328, 342];

                $orderproducts = Orderproduct::whereHas("order" , function ($q) use ($hamayeshTalai){
                                        $q->whereIn("orderstatus_id" , [config('constants.ORDER_STATUS_CLOSED'),config('constants.ORDER_STATUS_POSTED'),config('constants.ORDER_STATUS_READY_TO_POST')])
                                          ->whereIn("paymentstatus_id" , [config('constants.PAYMENT_STATUS_PAID')]);
                                    })->whereIn("product_id" , $hamayeshTalai)
                                      ->get();
                $users = [];
                $successCounter = 0;
                $failedCounter = 0 ;
                $warningCounter = 0 ;
                foreach ($orderproducts as $orderproduct)
                {
                    if(isset($orderproduct->order->user->id))
                    {
                        $user = $orderproduct->order->user ;
                        if(isset($users[$user->id]))
                        {
                            $users[$user->id]++;
                        }
                        else
                        {
                            $users[$user->id] = 1 ;
                        }
                    }
                    else
                    {
                        dump("User was not found for orderproduct ".$orderproduct->id);
                        $warningCounter++;
                    }
                }

                // USERS WITH PLUS POINTS
                $orders = Order::where("completed_at" , "<" , "2018-05-18")
                                ->whereIn("orderstatus_id" , [config('constants.ORDER_STATUS_CLOSED'),config('constants.ORDER_STATUS_POSTED'),config('constants.ORDER_STATUS_READY_TO_POST')])
                                ->whereIn("paymentstatus_id" , [config('constants.PAYMENT_STATUS_PAID')])
                                ->whereHas("orderproducts" , function ($q) use ($hamayeshTalai){
                                    $q->whereIn("product_id" , $hamayeshTalai);
                                })
                                ->pluck("user_id")
                                ->toArray();

                $usersPlus = [];
                foreach ($orders as $userId)
                {
                    if(in_array($userId , $usersPlus))
                        continue;
                    else
                        array_push($usersPlus , $userId) ;

                    if(isset($users[$userId]))
                    {
                        $users[$userId]++ ;
                    }
                    else
                    {
                        $users[$userId] = 1 ;
                    }

                }*/
        // /** Points for Hamayesh Talai lottery */

        if($request->has('5khordad'))
        {
            /** Points for Eide Fetr lottery */
            $transactions = Transaction::whereHas("order", function ($q) {
                $q->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                    ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID") , config('constants.PAYMENT_STATUS_VERIFIED_INDEBTED')])
                    ->whereHas('orderproducts' , function ($q2){
                        $q2->whereNotIn('product_id' , [Product::CUSTOM_DONATE_PRODUCT , Product::DONATE_PRODUCT_5_HEZAR , Product::ASIATECH_PRODUCT]) ;
                    });
            })
                ->where("created_at" , '>=', "2019-05-15 19:30:00") // 16 ordibehesht 98 saat 12 tehran
                ->where('created_at' , '<=', "2019-05-26 19:29:59") // 5 khordad 98 saat 23:59
                ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                ->where("cost", ">", 0)
                ->get();
            $pointMultiply = 3;// 5 khordad 98
        }elseif($request->has('10khordad')){

            $transactions = Transaction::whereHas("order", function ($q) {
                $q->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                    ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID") , config('constants.PAYMENT_STATUS_VERIFIED_INDEBTED')])
                    ->whereHas('orderproducts' , function ($q2){
                        $q2->whereNotIn('product_id' , [Product::CUSTOM_DONATE_PRODUCT , Product::DONATE_PRODUCT_5_HEZAR , Product::ASIATECH_PRODUCT]) ;
                    });
            })
                ->where("created_at" , '>=', "2019-05-26 19:30:00") // 5 khordad 98 saat 12 tehran
                ->where('created_at' , '<=', "2019-05-31 19:29:59") // 10 khordad 98 saat 23:59
                ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                ->where("cost", ">", 0)
                ->get();
            $pointMultiply = 2;// 10 khordad 98
        }elseif($request->has('19khordad')){
            $transactions = Transaction::whereHas("order", function ($q) {
                $q->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                    ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID") , config('constants.PAYMENT_STATUS_VERIFIED_INDEBTED')])
                    ->whereHas('orderproducts' , function ($q2){
                        $q2->whereNotIn('product_id' , [Product::CUSTOM_DONATE_PRODUCT , Product::DONATE_PRODUCT_5_HEZAR , Product::ASIATECH_PRODUCT]) ;
                    });
            })
                ->where("created_at" , '>=', "2019-05-31 19:30:00") // 10 khordad 98 saat 12 tehran
                ->where('created_at' , '<=', "2019-06-09 07:00:00") // 19 khordad 98 saat 11:30
                ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                ->where("cost", ">", 0)
                ->get();
            $pointMultiply = 1;// 19 khordad 98
        }else{
            dd('Bad Request');
        }


        $users          = collect();
        $amountUnit     = 50000;
        $successCounter = 0;
        $failedCounter  = 0;
        $warningCounter = 0;

        foreach ($transactions as $transaction) {
            $user = $transaction->order->user;
            if (isset($user)) {
                $userRecord = $users->where("user_id", $user->id)->first();

                if (isset($userRecord)) {
                    $userRecord["totalAmount"] += $transaction->cost;
                    $point                     = (int) ($userRecord["totalAmount"] / $amountUnit);
                    $userRecord["point"]       = $point * $pointMultiply;
                } else {
                    $point = (int) ($transaction->cost / $amountUnit);
                    $users->push([
                        "user_id"     => $user->id,
                        "totalAmount" => $transaction->cost,
                        "point"       => $point * $pointMultiply,
                    ]);
                }
            } else {
                dump("Warning: User was not found for transaction ".$transaction->id);
                $warningCounter++;
            }
        }
        
        $users = $users->where("point"  , ">" , 0);
//        dump($users->count());
//        dd("STOP points");
        /** Extra point */
        /*$userbons = Userbon::where("bon_id" , 2)
                            ->where("created_at" , ">" , "2018-05-24 00:00:00")
                            ->where("totalNumber" , ">=" , "3")
                            ->get();

        foreach ($userbons as $userbon)
        {
            $user = $userbon->user;
            $successfulTransactions = $user->orderTransactions
                                        ->where("completed_at" , ">" , "2018-05-24 20:00:00")
                                        ->where("transactionstatus_id" , config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                        ->whereIn("paymentmethod_id" , [
                                            config("constants.PAYMENT_METHOD_ONLINE") ,
                                            config("constants.PAYMENT_METHOD_ATM")
                                        ])
                                        ->where("cost" , ">" , 0);
            if($successfulTransactions->isNotEmpty())
            {
                $userRecord = $users->where("user_id" , $user->id)->first();
                if(!isset($userRecord))
                {
                    $users->push([
                        "user_id" => $user->id,
                        "totalAmount" => -1 ,
                        "point" => 1 ,
                    ]);
                }
            }
        }*/
        $bonName = config("constants.BON2");
        $bon     = Bon::where("name", $bonName)->first();
        if (!isset($bon)) {
            dd("Bon not found");
        }
        
        dump("Number of available users: ".$users->count());
        foreach ($users as $userPoint) {
            $userId = $userPoint["user_id"];
            $points = $userPoint["point"];
            
            echo "User Id: ".$userId." , Points: ".$points;
            echo "<br>";
            
            if ($points == 0) {
                continue;
            }
            
            $userBon                   = new Userbon();
            $userBon->bon_id           = $bon->id;
            $userBon->user_id          = $userId;
            $userBon->totalNumber      = $points;
            $userBon->userbonstatus_id = 1;
            $bonResult                 = $userBon->save();
            if ($bonResult) {
//                $message = "شما در قرعه کشی 10 تیر شرکت داده خواهید شد.";
//                $message .= "\n";
//                $message .= "امتیاز شما:";
//                $message .= $points;
//                $message .= "\n";
//                $message .= "آلاء";
                $user = $userBon->user;
//                $user->notify(new GeneralNotice($message));
                echo "<span style='color:green'>";
                echo "User ".$userId." get $points points , ".$user->mobile;
                echo "</span>";
                echo "<br>";
                $successCounter++;
            } else {
                $failedCounter++;
                dump("Error: Userbon for user ".$userId." was not created");
            }
        }
        dump("number of successfully processed users: ".$successCounter);
        dump("number of failed users: ".$failedCounter);
        dd("Done!");
    }
    
    public function excelBot(Request $request)
    {
        dd('This method is not working . Please check it out.');
        $fileName = "list_arabi_hozouri.xlsx";
        $myReader = new Reader();
        $myWriter = new Writer();
        $excel    = new Excel($myReader, $myWriter);
        $counter  = 0;
        $excel->load(storage_path($fileName), function (Reader $reader) use (&$counter) {
            $reader->sheets(function (Sheet $sheet) use (&$counter) {
                $sheetName = $sheet->name();
                $sheet->rows(function (Row $row) use (&$counter, $sheetName) {
                    // Get a column
                    //                    $row->column('نام');
                    
                    // Magic get
                    //                    $row->heading_key;
                    
                    // Array access
                    //                    $row['heading_key'];
                    $mobile       = $row["mobile"];
                    $nationalCode = $row["nationalcode"];
                    $firstName    = $row["firstname"];
                    $lastName     = $row["lastname"];
                    if (strlen($lastName) > 0 && $lastName != "lastname") {
                        //                        if(strlen($row["شماره موبایل"]) == 0 || strlen($row["شماره ملی"]) == 0)
                        //                        {
                        //                            $counter++ ;
                        //                            dump($counter);
                        //                            dump($row["نام خانوادگی"]);
                        //                            if(strlen($row["شماره موبایل"]) > 0 && strlen($row["شماره ملی"]) == 0)
                        //                            {
                        //                                dump("OK!") ;
                        //                            }
                        //                        }
                        
                        if (strlen($mobile) > 0 && strlen($nationalCode) > 0) {
                            $nationalCodeValidation = $this->validateNationalCode($nationalCode);
                            $mobileValidation       = (strlen($mobile) == 11);
                            if ($nationalCodeValidation && $mobileValidation) {
                                $request = new Request();
                                $request->offsetSet("mobile", $mobile);
                                $request->offsetSet("nationalCode", $nationalCode);
                                if (strlen($firstName) > 0) {
                                    $request->offsetSet("firstName", $firstName);
                                }
                                
                                if (strlen($lastName) > 0) {
                                    $request->offsetSet("lastName", $lastName);
                                }
                                
                                if (isset($row["major"])) {
                                    if ($row["major"] == "r") {
                                        $request->offsetSet("major_id", 1);
                                    } else {
                                        if ($row["major"] == "t") {
                                            $request->offsetSet("major_id", 2);
                                        }
                                    }
                                }
                                if (isset($row["gender"])) {
                                    if ($row["gender"] == "پسر") {
                                        $request->offsetSet("gender_id", 1);
                                    } else {
                                        if ($row["gender"] == "دختر") {
                                            $request->offsetSet("gender_id", 2);
                                        }
                                    }
                                }
                                RequestCommon::convertRequestToAjax($request);
                                $response = $this->registerUserAndGiveOrderproduct($request);
                                if ($response->getStatusCode() == 200) {
                                    $counter++;
                                    echo "User inserted: ".$lastName." ".$mobile;
                                    echo "<br>";
                                } else {
                                    echo "<span style='color:red'>";
                                    echo "Error on inserting user: ".$lastName." ".$mobile;
                                    echo "</span>";
                                    echo "<br>";
                                }
                            } else {
                                $fault = "";
                                if (!$nationalCodeValidation) {
                                    $fault .= " wrong nationalCode ";
                                }
                                
                                if (!$mobile) {
                                    $fault .= " wrong mobile ";
                                }
                                
                                echo "<span style='color:orange'>";
                                echo "Warning! user wrong information: ".$lastName.$fault." ,in sheet : ".$sheetName;
                                echo "</span>";
                                echo "<br>";
                            }
                        } else {
                            echo "<span style='color:orange'>";
                            echo "Warning! user incomplete information: ".$lastName." ,in sheet : ".$sheetName;
                            echo "</span>";
                            echo "<br>";
                        }
                    }
                });
            });
        });
        echo "<span style='color:green'>";
        echo "Inserted users: ".$counter;
        echo "</span>";
        echo "<br>";
        dd("Done!");
        //        $rows = Excel::load('storage\\exports\\'. $fileName)->get();
    }
    
    public function checkDisableContentTagBot()
    {
        $disableContents = Content::where("enable", 0)
            ->get();
        $counter         = 0;
        foreach ($disableContents as $content) {
            $tags = $content->retrievingTags();
            if (!empty($tags)) {
                $author = "";
                if (isset($content->author_id)) {
                    $author = $content->user->lastName;
                }
                dump($content->id." has tags! type: ".$content->contenttype_id." author: ".$author);
                $counter++;
            }
        }
        dump("count: ".$counter);
        dd("finish");
    }
    
    public function tagBot()
    {
        $counter = 0;
        try {
            dump("start time:".Carbon::now("asia/tehran"));
            if (!Input::has("t")) {
                return $this->response->setStatusCode(422)
                    ->setContent(["message" => "Wrong inputs: Please pass parameter t. Available values: v , p , cs , pr , e , b ,a"]);
            }
            $type = Input::get("t");
            switch ($type) {
                case "v": //Video
                    $bucket = "content";
                    $items  = Content::where("contenttype_id", 8)
                        ->where("enable", 1);
                    if (Input::has("id")) {
                        $contentId = Input::get("id");
                        $items->where("id", $contentId);
                    }
                    $items = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "فیلم",
                        ];
                        $majors = $item->majors->pluck("description")
                            ->toArray();
                        if (!empty($majors)) {
                            $myTags = array_merge($myTags, $majors);
                        }
                        $grades = $item->grades->where("name", "graduated")
                            ->pluck("description")
                            ->toArray();
                        if (!empty($grades)) {
                            $myTags = array_merge($myTags, $grades);
                        }
                        switch ($item->id) {
                            case 130:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                    "میلاد_ناصح_زاده",
                                ]);
                                break;
                            case 131:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 144:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 145:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 156:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 157:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 158:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 159:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 160:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 161:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 162:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 163:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 164:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 165:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            default :
                                break;
                        }
                        $myTags     = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson   = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "p": //Pamphlet
                    $bucket = "content";
                    $items  = Content::where("contenttype_id", 1)
                        ->where("enable", 1);
                    if (Input::has("id")) {
                        $contentId = Input::get("id");
                        $items->where("id", $contentId);
                    }
                    $items = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "جزوه",
                            "PDF",
                        ];
                        $majors = $item->majors->pluck("description")
                            ->toArray();
                        if (!empty($majors)) {
                            $myTags = array_merge($myTags, $majors);
                        }
                        $grades = $item->grades->where("name", "graduated")
                            ->pluck("description")
                            ->toArray();
                        if (!empty($grades)) {
                            $myTags = array_merge($myTags, $grades);
                        }
                        switch ($item->id) {
                            case 115:
                                $myTags = array_merge($myTags, [
                                    "گسسته",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 112:
                                $myTags = array_merge($myTags, [
                                    "تحلیلی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 126:
                            case 114:
                            case 127:
                                $myTags = array_merge($myTags, [
                                    "آمار_و_مدلسازی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 133:
                                $myTags = array_merge($myTags, [
                                    "پیش",
                                ]);
                                break;
                            case 136:
                                $myTags = array_merge($myTags, [
                                    "فیزیک",
                                    "پیش",
                                    "همایش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 119:
                            case 128:
                            case 129:
                            case 143:
                            case 146:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 120:
                                $myTags = array_merge($myTags, [
                                    "زیست_شناسی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 121:
                                $myTags = array_merge($myTags, [
                                    "زیست_شناسی",
                                    "پایه",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            case 122:
                                $myTags = array_merge($myTags, [
                                    "زبان_و_ادبیات_فارسی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 123:
                            case 124:
                            case 125:
                            case 2:
                            case 3:
                            case 55:
                            case 56:
                            case 57:
                            case 58:
                            case 59:
                            case 60:
                            case 61:
                            case 62:
                            case 63:
                            case 64:
                            case 65:
                            case 66:
                            case 67:
                            case 137:
                            case 147:
                            case 148:
                            case 149:
                            case 150:
                            case 151:
                            case 152:
                            case 153:
                            case 154:
                            case 155:
                                $myTags = array_merge($myTags, [
                                    "شیمی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            default :
                                break;
                        }
                        $myTags     = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson   = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "b": //Book
                    $bucket = "content";
                    $items  = Content::where("contenttype_id", 7)
                        ->where("enable", 1);
                    $items  = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "کتاب_درسی",
                            "PDF",
                            "پایه",
                            "نظام_آموزشی_جدید",
                        ];
                        $majors = $item->majors->pluck("description")
                            ->toArray();
                        if (!empty($majors)) {
                            $myTags = array_merge($myTags, $majors);
                        }
                        $grades = $item->grades->where("name", "graduated")
                            ->pluck("description")
                            ->toArray();
                        if (!empty($grades)) {
                            $myTags = array_merge($myTags, $grades);
                        }
                        $myTags     = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson   = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "e": //Exam
                    $bucket = "content";
                    $items  = Content::where("contenttype_id", 2)
                        ->where("enable", 1);
                    $items  = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags            = [
                            "آزمون",
                            "PDF",
                        ];
                        $childContentTypes = Contenttype::whereHas("parents", function ($q) {
                            $q->where("name", "exam");
                        })
                            ->pluck("description")
                            ->toArray();
                        $myTags            = array_merge($myTags, $childContentTypes);
                        
                        $majors = $item->majors->pluck("description")
                            ->toArray();
                        if (!empty($majors)) {
                            $myTags = array_merge($myTags, $majors);
                        }
                        $grades = $item->grades->where("name", "graduated")
                            ->pluck("description")
                            ->toArray();
                        if (!empty($grades)) {
                            $myTags = array_merge($myTags, $grades);
                        }
                        
                        switch ($item->id) {
                            case 141:
                            case 142:
                                $myTags = array_merge($myTags, [
                                    "عربی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                            case 116:
                            case 16:
                            case 17:
                            case 18:
                            case 13:
                            case 14:
                            case 15:
                                $myTags = array_merge($myTags, [
                                    "پایه",
                                    "نظام_آموزشی_جدید",
                                ]);
                                break;
                            default:
                                $myTags = array_merge($myTags, [
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                ]);
                                break;
                        }
                        
                        $myTags     = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson   = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "a": //Article
                    $bucket = "content";
                    $items  = Content::where("contenttype_id", 9)
                        ->where("enable", 1);
                    $items  = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "مقاله",
                        ];
                        $majors = $item->majors->pluck("description")
                            ->toArray();
                        if (!empty($majors)) {
                            $myTags = array_merge($myTags, $majors);
                        }
                        $grades = $item->grades->where("name", "graduated")
                            ->pluck("description")
                            ->toArray();
                        if (!empty($grades)) {
                            $myTags = array_merge($myTags, $grades);
                        }
                        switch ($item->id) {
                            case 132:
                                $myTags = array_merge($myTags, [
                                    "پیش",
                                    "نظام_آموزشی_قدیم",
                                    "مشاوره",
                                    "مهدی_ناصر_شریعت",
                                ]);
                                break;
                            default :
                                break;
                        }
                        
                        $myTags     = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson   = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "cs": //Contentset
                    $bucket = "contentset";
                    $items  = Contentset::orderBy("id")
                        ->where("enable", 1);
                    if (Input::has("id")) {
                        $id    = Input::get("id");
                        $items = $items->where("id", $id);
                    }
                    $items = $items->get();
                    
                    break;
                case "pr": //Product
                    $bucket = "product";
                    if (Input::has("id")) {
                        $id         = Input::get("id");
                        $productIds = [$id];
                    } else {
                        $productIds = [
                            99,
                            104,
                            92,
                            91,
                            181,
                            107,
                            69,
                            65,
                            61,
                            163,
                            135,
                            131,
                            139,
                            143,
                            147,
                            155,
                            119,
                            123,
                            183,
                            210,
                            211,
                            212,
                            213,
                            214,
                            215,
                            216,
                            217,
                            218,
                            219,
                            220,
                            221,
                        ];
                    }
                    $items = Product::whereIn("id", $productIds);
                    $items = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "محصول",
                            "نظام_آموزشی_قدیم",
                            "پیش",
                        ];
                        switch ($item->id) {
                            case 99:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "کنکور",
                                    "شیمی",
                                    'مهدی_صنیعی_طهرانی',
                                ]);
                                break;
                            case 104:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "دین_و_زندگی",
                                    'جعفر_رنجبرزاده',
                                ]);
                                break;
                            case 92:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "کنکور",
                                    "فیزیک",
                                    'پیمان_طلوعی',
                                ]);
                                break;
                            case 91:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "کنکور",
                                    "شیمی",
                                    'مهدی_صنیعی_طهرانی',
                                ]);
                                break;
                            case 181:
                                $myTags = [
                                    "محصول",
                                    "رشته_تجربی",
                                    "دهم",
                                    "نظام_آموزشی_جدید",
                                    "پایه",
                                    "زیست_شناسی",
                                    'جلال_موقاری',
                                ];
                                break;
                            case 107:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "کنکور",
                                    "شیمی",
                                    'مهدی_صنیعی_طهرانی',
                                ]);
                                break;
                            case 69:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "زیست_شناسی",
                                    'محمد_پازوکی',
                                ]);
                                break;
                            case 65:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "ریاضی_تجربی",
                                    'رضا_شامیزاده',
                                ]);
                                break;
                            case 61:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "کنکور",
                                    "دیفرانسیل",
                                    'محمد_صادق_ثابتی',
                                ]);
                                break;
                            case 163:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "کنکور",
                                    "گسسته",
                                    'بهمن_مؤذنی_پور',
                                ]);
                                break;
                            case 135:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "ریاضی_تجربی",
                                    'محمدامین_نباخته',
                                ]);
                                break;
                            case 131:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "ریاضی_تجربی",
                                    'مهدی_امینی_راد',
                                ]);
                                break;
                            case 139:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "زیست_شناسی",
                                    'ابوالفضل_جعفری',
                                ]);
                                break;
                            case 143:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "کنکور",
                                    "شیمی",
                                    'مهدی_صنیعی_طهرانی',
                                ]);
                                break;
                            case 147:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "عربی",
                                    'محسن_آهویی',
                                ]);
                                break;
                            case 155:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "کنکور",
                                    "فیزیک",
                                    'پیمان_طلوعی',
                                ]);
                                break;
                            case 119:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "کنکور",
                                    "تحلیلی",
                                    'محمد_صادق_ثابتی',
                                ]);
                                break;
                            case 123:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "کنکور",
                                    "دیفرانسیل",
                                    'محمد_صادق_ثابتی',
                                ]);
                                break;
                            case 183:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "عربی",
                                    'میلاد_ناصح_زاده',
                                ]);
                                break;
                            case 210:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "ادبیات_و_زبان_فارسی",
                                    'هامون_سبطی',
                                ]);
                                break;
                            case 211:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "دین_و_زندگی",
                                    'وحیده_کاعذی',
                                ]);
                                break;
                            case 212:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "زیست_شناسی",
                                    'محمد_چلاجور',
                                ]);
                                break;
                            case 213:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "زمین_شناسی",
                                    'محمد_چلاجور',
                                ]);
                                break;
                            case 214:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "عربی",
                                    'میلاد_ناصح_زاده',
                                ]);
                                break;
                            case 215:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "عربی",
                                    'محسن_آهویی',
                                ]);
                                break;
                            case 216:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "فیزیک",
                                    'پیمان_طلوعی',
                                ]);
                                break;
                            case 217:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "رشته_تجربی",
                                    "رشته_انسانی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "شیمی",
                                    'مهدی_صنیعی_طهرانی',
                                ]);
                                break;
                            case 218:
                                $myTags = array_merge($myTags, [
                                    "رشته_ریاضی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "دیفرانسیل",
                                    'محمد_صادق_ثابتی',
                                ]);
                                break;
                            case 219:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "ریاضی_تجربی",
                                    'مهدی_امینی_راد',
                                ]);
                                break;
                            case 220:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "ریاضی_تجربی",
                                    'محمد_امین_نباخته',
                                ]);
                                break;
                            case 221:
                                $myTags = array_merge($myTags, [
                                    "رشته_تجربی",
                                    "کنکور",
                                    "همایش_طلایی",
                                    "زیست_شناسی",
                                    'آل_علی',
                                ]);
                                break;
                            default:
                                break;
                        }
                        $myTags = array_merge($myTags, ["متوسطه2"]);
                        
                        $tagsJson   = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                default:
                    return $this->response->setStatusCode(422)
                        ->setContent(["message" => "Unprocessable input t."]);
                    break;
            }
            dump("available items: ".$items->count());
            $successCounter = 0;
            $failedCounter  = 0;
            $warningCounter = 0;
            foreach ($items as $item) {
                if (!isset($item)) {
                    $warningCounter++;
                    dump("invalid item at counter".$counter);
                    continue;
                } else {
                    if (!isset($item->tags)) {
                        $warningCounter++;
                        dump("no tags found for".$item->id);
                        continue;
                    } else {
                        $itemTagsArray = $item->tags->tags;
                    }
                }
                
                if (is_array($itemTagsArray) && !empty($itemTagsArray) && isset($item["id"])) {
                    $params = [
                        "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
                    ];
                    if (isset($item->created_at) && strlen($item->created_at) > 0) {
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $item->created_at)->timestamp;
                    }
                    
                    $response = $this->sendRequest(config("constants.TAG_API_URL")."id/$bucket/".$item->id, "PUT",
                        $params);
                    
                    if ($response["statusCode"] == 200) {
                        $successCounter++;
                    } else {
                        dump("item #".$item["id"]." failed. response : ".$response["statusCode"]);
                        $failedCounter++;
                    }
                    $counter++;
                } else {
                    if (is_array($itemTagsArray) && empty($itemTagsArray)) {
                        $warningCounter++;
                        dump("warning no tags found for item #".$item->id);
                    }
                }
            }
            dump($successCounter." items successfully done");
            dump($failedCounter." items failed");
            dump($warningCounter." warnings");
            dump("finish time:".Carbon::now("asia/tehran"));
            
            return $this->response->setStatusCode(200)
                ->setContent(["message" => "Done! number of processed items : ".$counter]);
        } catch (\Exception $e) {
            $message = "unexpected error";
            dump($successCounter." items successfully done");
            dump($failedCounter." items failed");
            dump($warningCounter." warnings");
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    "message"                                => $message,
                    "number of successfully processed items" => $counter,
                    "error"                                  => $e->getMessage(),
                    "line"                                   => $e->getLine(),
                ]);
        }
    }

    public function ZarinpalVerifyPaymentBot(Request $request){
        $authority = $request->get('authority');
        $cost = $request->get('cost');

        if(is_null($authority) || is_null($cost))
            dd('Please provide authority and cost');

        $zarinpal = new Zarinpal(config('Zarinpal.merchantID'));
        $result = $zarinpal->verify($cost, $authority);
        dd($result);
    }
}
