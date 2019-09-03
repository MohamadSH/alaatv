<?php

namespace App\Http\Controllers\Web;


use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{DB, Input};
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
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
    };
use Zarinpal\Zarinpal;

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

    protected $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->middleware('role:admin');
        $this->setting  = $setting->setting;
    }

    public function bot(Request $request)
    {
        try {
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
                $orders = Order::whereIn('paymentstatus_id', [config('constants.PAYMENT_STATUS_INDEBTED') ,config('constants.PAYMENT_STATUS_UNPAID') ])
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
        } catch (\Exception    $e) {
            $message = "unexpected error";

            return response()->json( [
                "message" => $message,
                "error"   => $e->getMessage(),
                "line"    => $e->getLine(),
                "file"    => $e->getFile(),
            ] , Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function walletBot(Request $request)
    {
        if (!$request->has("userGroup")) {
            session()->put("error", "لطفا گروه کاربران را تعیین کنید");

            return redirect()->back();
        } else {
            $userGroup = $request->get("userGroup");
        }

        $hamayeshTalai      = [];
        $ordooHozoori       = [];
        $ordooGheireHozoori = [];
        $hamayesh5Plus1     = [];
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
        $successCounter = 0;
        $failedCounter  = 0;
        $warningCounter = 0;
        $users          = collect();

        if($request->has('summer98')){
            $transactions = Transaction::whereHas("order", function ($q) {
                $q->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                    ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID") , config('constants.PAYMENT_STATUS_VERIFIED_INDEBTED')])
                    ->whereHas('orderproducts' , function ($q2){
                        $q2->whereNotIn('product_id' , [Product::CUSTOM_DONATE_PRODUCT , Product::DONATE_PRODUCT_5_HEZAR , Product::ASIATECH_PRODUCT]) ;
                    });
            })
            ->where("created_at" , '>=', "2019-08-11 19:30:00") // 20 mordad 98 saat 12 shab tehran
            ->where('created_at' , '<=', "2019-09-01 19:30:00") // 2 shahrivar 98 saat 12 shab
            ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
            ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
            ->where("cost", ">", 0)
            ->get();

            $pointMultiply = 1;
            $amountUnit     = 50000;
            foreach ($transactions as $transaction) {
                $user = $transaction->order->user;
                if (isset($user)) {
                    $userRecord = $users->where("user_id", $user->id)->first();

                    if (isset($userRecord)) {
                        $userRecord["totalAmount"] += $transaction->cost;
                        $point                     = (int) ($userRecord["totalAmount"] / $amountUnit);
                        $userRecord["point"]       += $point ;
//                        $userRecord["point"]       = $point * $pointMultiply;
                    } else {
                        $point = (int) ($transaction->cost / $amountUnit);
                        $users->push([
                            "user_id"     => $user->id,
                            "totalAmount" => $transaction->cost,
                            "point"       => $point,
//                            "point"       => $point * $pointMultiply,
                        ]);
                    }
                } else {
                    dump("Warning: User was not found for transaction ".$transaction->id);
                    $warningCounter++;
                }
            }
        }
        elseif($request->has('riyazi')){
            // riyazi [318]
            $riyaziComplete = User::whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                    ->whereHas('transactions' , function ($q3){
                        $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                            ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                            ->where("cost", ">", 0);
                    });
                })->where('product_id' , 298);
            })->whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                        ->whereHas('transactions' , function ($q3){
                            $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                ->where("cost", ">", 0);
                        });
                })
                    ->where('product_id' , 312);
            })->whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                        ->whereHas('transactions' , function ($q3){
                            $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                ->where("cost", ">", 0);
                        });
                })
                    ->where('product_id' , 308);
            })->whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                        ->whereHas('transactions' , function ($q3){
                            $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                ->where("cost", ">", 0);
                        });
                })
                    ->where('product_id' , 306);
            })->whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                        ->whereHas('transactions' , function ($q3){
                            $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                ->where("cost", ">", 0);
                        });
                })
                    ->where('product_id' , 302);
            })->whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                        ->whereHas('transactions' , function ($q3){
                            $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                ->where("cost", ">", 0);
                        });
                })
                    ->where('product_id' , 342);
            })->whereHas('orderproducts' , function ($q){
                $q->whereHas('order' , function ($q2){
                    $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                        ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                        ->whereHas('transactions' , function ($q3){
                            $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                ->where("cost", ">", 0);
                        });
                })
                    ->where('product_id' , 318);
            })->get();

            foreach ($riyaziComplete as $user) {
                $users->push([
                    "user_id"     => $user->id,
                    "totalAmount" => 0,
                    "point"       => 1,
                ]);
            }
        }
        elseif($request->has('tajrobi')){
            // tajrobi [328 ,322,316] zist[326]
            $tajrobiComplete = User::whereHas('orderproducts' , function ($q){
                $q->where('product_id' , 298)
                    ->whereHas('order' , function ($q2){
                        $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                            ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                            ->whereHas('transactions' , function ($q3){
                                $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                    ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                    ->where("cost", ">", 0);
                            });
                    });
            })->whereHas('orderproducts' , function ($q){
                $q->where('product_id' , 312)
                    ->whereHas('order' , function ($q2){
                        $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                            ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                            ->whereHas('transactions' , function ($q3){
                                $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                    ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                    ->where("cost", ">", 0);
                            });
                    });
            })->whereHas('orderproducts' , function ($q){
                $q->where('product_id' , 308)
                    ->whereHas('order' , function ($q2){
                        $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                            ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                            ->whereHas('transactions' , function ($q3){
                                $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                    ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                    ->where("cost", ">", 0);
                            });
                    });
            })->whereHas('orderproducts' , function ($q){
                $q->where('product_id' , 306)
                    ->whereHas('order' , function ($q2){
                        $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                            ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                            ->whereHas('transactions' , function ($q3){
                                $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                    ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                    ->where("cost", ">", 0);
                            });
                    });
            })->whereHas('orderproducts' , function ($q){
                $q->where('product_id' , 302)
                    ->whereHas('order' , function ($q2){
                        $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                            ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                            ->whereHas('transactions' , function ($q3){
                                $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                    ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                    ->where("cost", ">", 0);
                            });
                    });
            })->whereHas('orderproducts' , function ($q){
                $q->whereIn('product_id' , [322,316,328])
                    ->whereHas('order' , function ($q2){
                        $q2->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED") , config('constants.ORDER_STATUS_POSTED')])
                            ->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID")])
                            ->whereHas('transactions' , function ($q3){
                                $q3->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                    ->where('paymentmethod_id' , '<>' , config('constants.PAYMENT_METHOD_WALLET'))
                                    ->where("cost", ">", 0);
                            });
                    });
            })->get();


            foreach ($tajrobiComplete as $user) {
                $users->push([
                    "user_id"     => $user->id,
                    "totalAmount" => 0,
                    "point"       => 1,
                ]);
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
                                if ($response->getStatusCode() == Response::HTTP_OK) {
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

    public function tagBot()
    {
        $counter = 0;
        try {
            dump("start time:".Carbon::now("asia/tehran"));
            if (!Input::has("t")) {
                return response()->json(["message" => "Wrong inputs: Please pass parameter t. Available values: v , p , cs , pr , e , b ,a"], Response::HTTP_UNPROCESSABLE_ENTITY);
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
                    return response()->json(["message" => "Unprocessable input t."], Response::HTTP_UNPROCESSABLE_ENTITY);
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

                    if ($response["statusCode"] == Response::HTTP_OK) {
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

            return response()->json(["message" => "Done! number of processed items : $counter"] , Response::HTTP_OK);
        } catch (\Exception $e) {
            $message = "unexpected error";
            dump($successCounter." items successfully done");
            dump($failedCounter." items failed");
            dump($warningCounter." warnings");

            return response()->json([
                "message"                                => $message,
                "number of successfully processed items" => $counter,
                "error"                                  => $e->getMessage(),
                "line"                                   => $e->getLine(),
            ] , Response::HTTP_SERVICE_UNAVAILABLE );
        }
    }

    public function ZarinpalVerifyPaymentBot(Request $request){
        $authority = $request->get('authority');
        $cost = $request->get('cost');

        if(is_null($authority) || is_null($cost))
            dd('Please provide authority and cost');

        $zarinpal = new Zarinpal(config('Zarinpal.merchantID'));
        $result = $zarinpal->verify($cost, $authority);
        return response()->json([
            'result'  => $result
        ]);
    }

    public function fixthumbnail(Request $request){
        $setId = $request->get('set');
        $set = Contentset::Find($setId);
        if(!isset($set))
            return response()->json(['message'=>'Bad request. set has not been set'] , Response::HTTP_BAD_REQUEST);

        $contents = $set->contents()->where('contenttype_id' , 8)->whereNull('thumbnail')->get();

        foreach ($contents as $content) {
            $baseUrl = "https://cdn.sanatisharif.ir/media/";
            $videoFileName = basename($content->file_for_admin->get('video')->first()->fileName);
            $thumbnailFileName = pathinfo($videoFileName, PATHINFO_FILENAME).".jpg";
            $thumbnailUrl      = $baseUrl."thumbnails/".$setId."/".$thumbnailFileName;

            $size = null;
            $type = 'thumbnail';

            $content->thumbnail = [
                'uuid'     => Str::uuid()->toString(),
                'disk'     => 'alaaCdnSFTP',
                'url'      => $thumbnailUrl,
                'fileName' => parse_url($thumbnailUrl)['path'],
                'size'     => $size,
                'caption'  => null,
                'res'      => null,
                'type'     => $type,
                'ext'      => 'jpg',
            ];

            $content->update();
        }

        return response()->json([
            'message'  => 'thumbnails fixed successfully'
        ]);
    }

    public function introContentTags(Request $request){
        $product = Product::find($request->get('product'));
        $contents = Content::whereIn('id' , convertTagStringToArray($request->get('contents' , [])))->get();
        if(!isset($product) || $contents->isEmpty()){
            return response()->json([
                'error'=>[
                    'code'  => Response::HTTP_BAD_REQUEST,
                    'message'   => 'please set product and contents argument'
                ]
            ]);
        }

        $tags = [];
        foreach ($contents as $content) {
            array_push($tags , 'c-'.$content->id);
        }

        $params = [
            "tags" => json_encode($tags, JSON_UNESCAPED_UNICODE),
        ];

        if (isset($product->created_at) && strlen($product->created_at) > 0) {
            $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $product->created_at)->timestamp;
        }

        $response = $this->sendRequest(config("constants.TAG_API_URL")."id/relatedproduct/".$product->id, "PUT", $params);

        return response()->json([
           'result'=> $response
        ]);
    }
}
