<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Order;
use Carbon\Carbon;
use App\Orderproduct;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SalesReportController extends Controller
{
    use DateTrait;
    
    /**
     * SalesReportController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:'.config('constants.SHOW_SALES_REPORT'));
    }
    
    
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $limitStatus = [1, 5, 10, 30, 50, 100, 200, 500, 1000];
        $coupontype  = ['نوع یک', 'نوع دو'];
        $products    = ['محصول یک', 'محصول دو'];
        $talai98Ids  = [306, 316, 322, 318, 302, 326, 312, 298, 308, 328, 342 , 328];
    
        /** @var User $user */
        $user = $request->user();

//        dump('start query allTime' , Carbon::now());
        $productIds = $this->getUserProducts($user);
    
        $allTimeOrderproducts = $this->getPurchasedOrderproducts($productIds);
        $allTimeCount         = $this->countOrderproducts($allTimeOrderproducts);
    
        $userRank = $this->calculateUserRank($allTimeCount, array_diff($talai98Ids, $productIds));

//        dump('start calculating allTime' , Carbon::now());
        $allTimeSum = $this->calculateTotalPrice($allTimeOrderproducts);
        
        $provinces = $this->setLocation($allTimeOrderproducts);

//        dump('start today', Carbon::now());
        /** Today */
        [$todayCount, $todaySum] = $this->todayPurchases($allTimeOrderproducts);

//        dump('start this week', Carbon::now());
        /** This week */
        [$thisWeekCount, $thisWeekSum] = $this->thisWeekPurchases($allTimeOrderproducts);

//        dump('start this moonth', Carbon::now());
        /** This month */
        [$thisMonthCount, $thisMonthSum] = $this->thisMonthPurchases($allTimeOrderproducts);

        $now = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
        return view('user.salesReport', compact('limitStatus', 'coupontype', 'products',
            'allTimeCount', 'allTimeSum', 'thisMonthCount', 'thisMonthSum', 'thisWeekCount', 'thisWeekSum',
            'todayCount', 'todaySum',
            'todayRate', 'thisWeekRate', 'thisMonthRate', 'provinces' , 'userRank' , 'now'));
    }
    
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return array
     */
    private function todayPurchases(Collection $allTimeOrderproducts): array
    {
        return Cache::remember('SR-todayPurchases-'.md5(implode(',', $allTimeOrderproducts->pluck('id')
                ->toArray())), config('constants.CACHE_3'), function () use ($allTimeOrderproducts) {
            $todayOrderproducts = $this->getTodayPurchases($allTimeOrderproducts);
            $todayCount         = $this->countOrderproducts($todayOrderproducts);
            $todaySum           = $this->calculateTotalPrice($todayOrderproducts);
            return [$todayCount, $todaySum];
        });
        
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return array
     */
    private function thisWeekPurchases(Collection $allTimeOrderproducts): array
    {
        return Cache::remember('SR-thisWeekPurchases-'.md5(implode(',', $allTimeOrderproducts->pluck('id')
                ->toArray())), config('constants.CACHE_3'), function () use ($allTimeOrderproducts) {
            $thisWeekOrderproducts = $this->getThisWeekPurchases($allTimeOrderproducts);
            $thisWeekCount         = $this->countOrderproducts($thisWeekOrderproducts);
            $thisWeekSum           = $this->calculateTotalPrice($thisWeekOrderproducts);
            return [$thisWeekCount, $thisWeekSum];
        });
        
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return array
     */
    private function thisMonthPurchases(Collection $allTimeOrderproducts): array
    {
        return Cache::remember('SR-thisMonthPurchases-'.md5(implode(',', $allTimeOrderproducts->pluck('id')
                ->toArray())), config('constants.CACHE_3'), function () use ($allTimeOrderproducts) {
            $thisMonthOrderproducts = $this->getThisMonthPurchases($allTimeOrderproducts);
            $thisMonthCount         = $this->countOrderproducts($thisMonthOrderproducts);
            $thisMonthSum           = $this->calculateTotalPrice($thisMonthOrderproducts);
            return [$thisMonthCount, $thisMonthSum];
        });
        
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return Collection
     */
    private function getTodayPurchases(Collection $allTimeOrderproducts): Collection
    {
        [$sinceDateTime, $tillDateTime] = $this->getTodayTimePeriod();
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return Collection
     */
    private function getThisWeekPurchases(Collection $allTimeOrderproducts): Collection
    {
        [$sinceDateTime, $tillDateTime] = $this->getThisWeekTimePeriod();
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return Collection
     */
    private function getThisMonthPurchases(Collection $allTimeOrderproducts): Collection
    {
        [$sinceDateTime, $tillDateTime] = $this->getThisMonthTimePeriod();
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }
    
    /**
     * @return array
     */
    private function getThisWeekDate(): array
    {
        return Cache::remember('Sr-getThisWeekDate', config('constants.CACHE_60'), function () {
            $firstDayOfWeekDate = Carbon::now()
                ->setTimezone('Asia/Tehran')
                ->startOfWeek(Carbon::SATURDAY)
                ->format('Y-m-d');
            $endDayOfWeekDate   = Carbon::now()
                ->setTimezone('Asia/Tehran')
                ->endOfWeek(Carbon::SATURDAY)
                ->format('Y-m-d');
            return [$firstDayOfWeekDate, $endDayOfWeekDate];
        });
    }
    
    /**
     * @return array
     */
    private function getThisMonthDate(): array
    {
        return Cache::remember('Sr-getThisMonthDate', config('constants.CACHE_60'), function () {
            $jalaliCalender = collect(config('constants.JALALI_CALENDER'));
            [$currentJalaliYear, $currentJalaliMonth, $currentJalaliDay] = $this->todayJalaliSplittedDate();
            $currentJalaliMonthString = $this->convertToJalaliMonth($currentJalaliMonth);
            $monthPeriod              = $jalaliCalender->where('month', $currentJalaliMonthString)
                ->first();
            $firstDayDate             = $monthPeriod['periodBegin'];
            $lastDayDate              = $monthPeriod['periodEnd'];
            return [$firstDayDate, $lastDayDate];
        });
    }
    
    /**
     * @param  array  $products
     *
     * @return Collection
     */
    private function getPurchasedOrderproducts(array $products): Collection
    {
        return Cache::remember('sr:getPurchasedOrderproducts:'.md5(implode(',', $products)),
            config('constants.CACHE_5'),
            static function () use ($products) {
    
                return Orderproduct::whereIn('product_id', $products)
                    ->where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                    ->whereHas('order', function ($q) {
                        $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                            ->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                    })
                    ->with(['order', 'order.transactions'])
                    ->get();
            });
    }
    
    /**
     * @param  array  $otherProducts
     *
     * @return mixed
     */
    private function getPurchasedGroupedOrderproducts(array $otherProducts)
    {
        return Cache::remember('sr:getPurchasedGroupedOrderproducts:'.md5(implode(',', $otherProducts)),
            config('constants.CACHE_5'),
            static function () use ($otherProducts) {
                return Orderproduct::select(DB::raw('COUNT("*") as count'))
                    ->whereIn('product_id', $otherProducts)
                    ->where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                    ->whereHas('order', function ($q) {
                        $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                            ->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                    })
                    ->groupBy('product_id')
                    ->get();
            });
    }
    
    /**
     * @param  User  $user
     *
     * @return mixed
     */
    private function getUserProducts(User $user)
    {
        return Cache::remember('sr-'.$user->cacheKey(), config('constants.CACHE_600'), function () use ($user) {
            return $user->contracts->pluck('product_id')
                ->toArray();
        });
    }
    
    /**
     * Calculates user rank
     *
     * @param  int    $userAllTimeCount
     * @param  array  $otherProducts
     *
     * @return int
     */
    private function calculateUserRank(int $userAllTimeCount, array $otherProducts): int
    {
        $saleRecords = $this->getOrderprodutsCount($otherProducts);
        return rankInArray($saleRecords, $userAllTimeCount);
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return int
     */
    private function countOrderproducts(Collection $allTimeOrderproducts): int
    {
        return $allTimeOrderproducts->count();
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     * @param  string      $sinceDateTime
     * @param  string      $tillDateTime
     *
     * @return Collection
     */
    private function filterOrderproductsByCompletionDate(Collection $allTimeOrderproducts, string $sinceDateTime, string $tillDateTime): Collection
    {
        $key = implode(',', $allTimeOrderproducts->pluck('id')
                ->toArray()).'-'.$sinceDateTime.'-'.$tillDateTime;
        $key = md5($key);
        return Cache::remember($key, config('constants.CACHE_5'),
            static function () use ($allTimeOrderproducts, $sinceDateTime, $tillDateTime) {
                return $allTimeOrderproducts->where('order.completed_at', '>=', $sinceDateTime)
                    ->where('order.completed_at', '<=', $tillDateTime);
            });
    }
    
    /**
     * @param  string  $today
     *
     * @return string
     */
    private function makeSinceDateTime(string $today): string
    {
        return $today.' 00:00:00';
    }
    
    /**
     * @param  string  $today
     *
     * @return string
     */
    private function makeTillDateTime(string $today): string
    {
        return $today.' 23:59:59';
    }
    
    /**
     * @param  Collection  $orderproducts
     *
     * @return int
     */
    private function calculateTotalPrice(Collection $orderproducts): int
    {
        $sum = 0;
        foreach ($orderproducts as $orderproduct) {
            /** @var Orderproduct $orderproduct */
            $key   = 'salesReport:calculateOrderproductPrice:'.$orderproduct->cacheKey();
            $toAdd = Cache::tags(['salesReport', 'order', 'orderproduct'])
                ->remember($key, config('constants.CACHE_600'), function () use ($orderproduct) {
                    $price = $orderproduct->obtainOrderproductCost(false);
                    
                    /** @var Order $myOrder */
                    $myOrder                = $orderproduct->order;
                    $orderWalletTransactins = $myOrder->transactions()
                        ->where('paymentmethod_id',
                            config('constants.PAYMENT_METHOD_WALLET'))
                        ->whereIn('transactionstatus_id', [
                            config('constants.TRANSACTION_STATUS_SUCCESSFUL'),
                            config('constants.TRANSACTION_STATUS_SUSPENDED'),
                        ])
                        ->where('cost', '>', 0)
                        ->get();
    
                    $orderWalletSum = $orderWalletTransactins->sum('cost');
                    if ($orderWalletSum == 0) {
                        $myValue = $price['final'];
                    } else {
                        $walletPerItem = $orderWalletSum / $myOrder->orderproducts_count;
                        $myValue       = ($price['final'] - $walletPerItem);
                    }
    
                    return $myValue;
                });
    
            $sum += $toAdd;
        }
        return $sum;
    }
    
    /**
     * @return array
     */
    private function getTodayTimePeriod(): array
    {
        return Cache::remember('SR-getTodayTimePeriod', config('constants.CACHE_3'), function () {
            $today = Carbon::now()
                ->setTimezone('Asia/Tehran')
                ->format('Y-m-d');
        
            $sinceDateTime = $this->makeSinceDateTime($today);
            $tillDateTime  = $this->makeTillDateTime($today);
            return [$sinceDateTime, $tillDateTime];
        });
    }
    
    /**
     * @return array
     */
    private function getThisWeekTimePeriod(): array
    {
        return Cache::remember('SR-getThisWeekTimePeriod', config('constants.CACHE_3'), function () {
            [$firstDayOfWeekDate, $endDayOfWeekDate] = $this->getThisWeekDate();
            $sinceDateTime = $this->makeSinceDateTime($firstDayOfWeekDate);
            $tillDateTime  = $this->makeTillDateTime($endDayOfWeekDate);
            return [$sinceDateTime, $tillDateTime];
        });
        
    }
    
    /**
     * @return array
     */
    private function getThisMonthTimePeriod(): array
    {
        return Cache::remember('SR-getThisMonthTimePeriod', config('constants.CACHE_3'), function () {
            [$firstDayDate, $lastDayDate] = $this->getThisMonthDate();
            $sinceDateTime = $this->makeSinceDateTime($firstDayDate);
            $tillDateTime  = $this->makeTillDateTime($lastDayDate);
            return [$sinceDateTime, $tillDateTime];
        });
        
    }
    
    /**
     * Returns a collection of provinces
     *
     * @return Collection
     */
    private function getProvinces(): Collection
    {
        return collect([
            [
                'name'        => 'ir-hg',
                'persianName' => 'هرمزگان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-bs',
                'persianName' => 'بوشهر',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-kb',
                'persianName' => 'کهگیلویه و بویراحمد',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-fa',
                'persianName' => 'فارس',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-es',
                'persianName' => 'اصفهان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-sm',
                'persianName' => 'سمنان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-go',
                'persianName' => 'گلستان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-mn',
                'persianName' => 'مازندران',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-th',
                'persianName' => 'تهران',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-mk',
                'persianName' => 'مرکزی',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-ya',
                'persianName' => 'یزد',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-cm',
                'persianName' => 'چهارمحال بختیاری',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-kz',
                'persianName' => 'خوزستان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-lo',
                'persianName' => 'لرستان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-il',
                'persianName' => 'ایلام',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-ar',
                'persianName' => 'اردبیل',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-qm',
                'persianName' => 'قم',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-hd',
                'persianName' => 'همدان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-za',
                'persianName' => 'زنجان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-qz',
                'persianName' => 'قزوین',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-wa',
                'persianName' => 'آذربایجان غربی',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-ea',
                'persianName' => 'آذربایجان شرقی',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-bk',
                'persianName' => 'کرمانشاه',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-gi',
                'persianName' => 'گیلان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-kd',
                'persianName' => 'کردستان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-kj',
                'persianName' => 'خراسان جنوبی',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-kv',
                'persianName' => 'خراسان رضوی',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-ks',
                'persianName' => 'خراسان شمالی',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-sb',
                'persianName' => 'سیستان و بلوچستان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-ke',
                'persianName' => 'کرمان',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-al',
                'persianName' => 'البرز',
                'count'       => 0,
            ],
            [
                'name'        => 'ir-un',
                'persianName' => 'بدون_استان',
                'count'       => 0,
            ],

        ]);
    }
    
    /**
     * @param  Collection  $allTimeOrderproducts
     *
     * @return Collection
     */
    private function setLocation(Collection $allTimeOrderproducts): Collection
    {
        $provinces = $this->getProvinces();
        foreach ($allTimeOrderproducts as $allTimeOrderproduct) {
            [$key, $foundProvince] = Cache::remember('sr-SetLocation-OP:'.$allTimeOrderproduct->id,
                config('constants.CACHE_600'), function () use ($allTimeOrderproduct, $provinces) {
                    $user         = $allTimeOrderproduct->order->user;
                    $userProvince = $user->province;
                    if (isset($userProvince)) {
                        $foundProvince = $provinces->filter(static function ($item) use ($userProvince) {
                            return false !== stripos($item['persianName'], $userProvince);
                        });
                        if ($foundProvince->isEmpty()) {
                            $foundProvince = $provinces->where('name', 'ir-un');
                        }
                    } else {
                        $foundProvince = $provinces->where('name', 'ir-un');
                    }
                    $key           = key($foundProvince->toArray());
                    $foundProvince = $foundProvince->first();
                    $foundProvince['count']++;
                    return [
                        $key,
                        $foundProvince,
                    ];
                });
            
            
            $provinces->put($key, $foundProvince);
        }
        return $provinces;
    }
    
    /**
     * @param  array  $otherProducts
     *
     * @return mixed
     */
    private function getOrderprodutsCount(array $otherProducts): array
    {
        return Cache::remember('sr-getOrderprodutsCount'.md5(implode(',', $otherProducts)),
            config('constants.CACHE_5'), function () use ($otherProducts) {
                $orderproducts = $this->getPurchasedGroupedOrderproducts($otherProducts);
                return $orderproducts->pluck('count')
                    ->toArray();
            });
        
    }
}
