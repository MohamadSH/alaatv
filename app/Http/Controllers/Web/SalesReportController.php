<?php

namespace App\Http\Controllers\Web;

use App\Orderproduct;
use App\Repositories\ContentRepository;
use App\Repositories\ProductRepository;
use App\Traits\DateTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

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
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $limitStatus = [1, 5, 10, 30, 50, 100, 200, 500, 1000];
        $coupontype = ['نوع یک', 'نوع دو'];
        $products = ['محصول یک', 'محصول دو'];
        $user = $request->user();

        $setIds = $this->getArray( $this->getContentsetsOfUser($user->id) , 'contentset_id') ;

        $talai98Ids = [306,316,322,318,302,326,312,298,308,328,342];
        $productIds = $this->getArray( $this->getProductsOfUser($setIds) , 'id') ;
        $intendedProductIds = array_intersect($talai98Ids, $productIds);

        $allTimeOrderproducts = $this->getPurchasedOrderproducts($intendedProductIds);
        $allTimeCount         = $this->countOrderproducts($allTimeOrderproducts);
        $allTimeSum           = $this->calculateTotalPrice($allTimeOrderproducts);

        /** Today */
        $todayOrderproducts   = $this->getTodayPurchases($allTimeOrderproducts);
        $todayCount           = $this->countOrderproducts($todayOrderproducts);
        $todaySum             = $this->calculateTotalPrice($todayOrderproducts);
        $todayOveralOrderproducts = $this->getTodayPurchasedOrderproducts();
        $todayOveralSum             = $this->calculateTotalPrice($todayOveralOrderproducts);
        $todayRate = 0;
        if($todayOveralSum != 0)
            $todayRate = $todaySum/$todayOveralSum;

        /** This week */
        $thisWeekOrderproducts  = $this->getThisWeekPurchases($allTimeOrderproducts);
        $thisWeekCount          = $this->countOrderproducts($thisWeekOrderproducts);
        $thisWeekSum            = $this->calculateTotalPrice($thisWeekOrderproducts);
        $thisWeekOveralOrderproducts   = $this->getThisWeekPurchasedOrderproducts();
        $thisWeekOveralSum             = $this->calculateTotalPrice($thisWeekOveralOrderproducts);
        $thisWeekRate = 0;
        if($thisWeekOveralSum != 0)
            $thisWeekRate = $thisWeekSum / $thisWeekOveralSum;

        /** This month */
        $thisMonthOrderproducts = $this->getThisMonthPurchases($allTimeOrderproducts);
        $thisMonthCount         =         $this->countOrderproducts($thisMonthOrderproducts);
        $thisMonthSum           = $this->calculateTotalPrice($thisMonthOrderproducts);
        $thisMonthOveralOrderproducts   = $this->getThisMonthPurchasedOrderproducts();
        $thisMonthOveralSum             = $this->calculateTotalPrice($thisMonthOveralOrderproducts);
        $thisMonthRate = 0;
        if($thisMonthOveralSum != 0)
            $thisMonthRate = $thisMonthSum / $thisMonthOveralSum;

        return view("user.salesReport", compact('limitStatus', 'coupontype', 'products' ,
            'allTimeCount' , 'allTimeSum' , 'thisMonthCount' , 'thisMonthSum' , 'thisWeekCount' , 'thisWeekSum' , 'todayCount' , 'todaySum',
            'todayRate' , 'thisWeekRate' , 'thisMonthRate'));

    }

    /**
     * @param int $userId
     * @return Collection
     */
    private function getContentsetsOfUser(int $userId): Collection
    {
        return  ContentRepository::getContentsetByUserId($userId)->get();
    }

    /**
     * @param array $setIds
     * @return Collection
     */
    private function getProductsOfUser(array $setIds): Collection
    {
        return ProductRepository::getProductsByUserId($setIds)->get();
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @return Collection
     */
    private function getTodayPurchases(Collection $allTimeOrderproducts): Collection
    {
        list($sinceDateTime, $tillDateTime) = $this->getTodayTimePeriod();
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @return Collection
     */
    private function getThisWeekPurchases(Collection $allTimeOrderproducts): Collection
    {
        list($sinceDateTime, $tillDateTime) = $this->getThisWeekTimePeriod();
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @return Collection
     */
    private function getThisMonthPurchases(Collection $allTimeOrderproducts): Collection
    {
        list($sinceDateTime, $tillDateTime) = $this->getThisMonthTimePeriod();
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }

    /**
     * @return array
     */
    private function getThisWeekDate(): array
    {
        $firstDayOfWeekDate = Carbon::now()->startOfWeek()->subDays(2)->format('Y-m-d');
        $endDayOfWeekDate = Carbon::now()->endOfWeek()->subDays(2)->format('Y-m-d');
        return array($firstDayOfWeekDate, $endDayOfWeekDate);
    }

    /**
     * @return array
     */
    private function getThisMonthDate(): array
    {
        $jalaliCalender = collect(config('constants.JALALI_CALENDER'));
        list($currentJalaliYear, $currentJalaliMonth, $currentJalaliDay) = $this->todayJalaliSplittedDate();
        $currentJalaliMonthString = $this->convertToJalaliMonth($currentJalaliMonth);
        $monthPeriod = $jalaliCalender->where("month", $currentJalaliMonthString)->first();
        $firstDayDate = $monthPeriod["periodBegin"];
        $lastDayDate = $monthPeriod["periodEnd"];
        return array($firstDayDate, $lastDayDate);
    }

    /**
     * @param array $products
     * @return Collection
     */
    private function getPurchasedOrderproducts(array $products):Collection
    {
        return  Orderproduct::whereIn('product_id', $products)
                                        ->where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                                        ->whereHas('order', function ($q) {
                                            $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                                                ->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                                        })->get()->load('order');
    }

    /**
     * @return Collection
     */
    private function getTodayPurchasedOrderproducts():Collection
    {
        list($sinceDateTime, $tillDateTime) = $this->getTodayTimePeriod();
        return $this->getOrderproductsByTimePeriod($sinceDateTime, $tillDateTime);
    }

    /**
     * @return Collection
     */
    private function getThisWeekPurchasedOrderproducts():Collection
    {
        list($sinceDateTime, $tillDateTime) = $this->getThisWeekTimePeriod();
        return $this->getOrderproductsByTimePeriod($sinceDateTime, $tillDateTime);
    }

    /**
     * @return Collection
     */
    private function getThisMonthPurchasedOrderproducts():Collection
    {
        list($sinceDateTime, $tillDateTime) = $this->getThisMonthTimePeriod();
        return $this->getOrderproductsByTimePeriod($sinceDateTime, $tillDateTime);
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @return int
     */
    private function countOrderproducts(Collection $allTimeOrderproducts): int
    {
        return  $allTimeOrderproducts->count();
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @param string $sinceDateTime
     * @param string $tillDateTime
     * @return Collection
     */
    private function filterOrderproductsByCompletionDate(Collection $allTimeOrderproducts, string $sinceDateTime, string $tillDateTime): Collection
    {
        return  $allTimeOrderproducts->where('order.completed_at', '>=', $sinceDateTime)
                                    ->where('order.completed_at', '<=', $tillDateTime);
    }

    /**
     * @param string $today
     * @return string
     */
    private function makeSinceDateTime(string $today): string
    {
        return $today . '00:00:00';
    }

    /**
     * @param string $today
     * @return string
     */
    private function makeTillDateTime(string $today): string
    {
        return $today . '23:59:59';
    }

    /**
     * @param Collection $collection
     * @param string $pluck
     * @return array
     */
    private function getArray(Collection $collection , string $pluck):array {
        return $collection->pluck($pluck)->toArray();
    }

    /**
     * @param Collection $orderproducts
     * @return int
     */
    private function calculateTotalPrice(Collection $orderproducts):int{
        $sum = 0;
        foreach ($orderproducts as $orderproduct) {
            $price = $orderproduct->obtainOrderproductCost(false);
            $sum += $price['final'];
        }
        return $sum;
    }

    /**
     * @return array
     */
    private function getTodayTimePeriod(): array
    {
        $today = Carbon::today()->format('Y-m-d');
        $sinceDateTime = $this->makeSinceDateTime($today);
        $tillDateTime = $this->makeTillDateTime($today);
        return array($sinceDateTime, $tillDateTime);
    }

    /**
     * @return array
     */
    private function getThisWeekTimePeriod(): array
    {
        list($firstDayOfWeekDate, $endDayOfWeekDate) = $this->getThisWeekDate();
        $sinceDateTime = $this->makeSinceDateTime($firstDayOfWeekDate);
        $tillDateTime = $this->makeTillDateTime($endDayOfWeekDate);
        return array($sinceDateTime, $tillDateTime);
    }

    /**
     * @return array
     */
    private function getThisMonthTimePeriod(): array
    {
        list($firstDayDate, $lastDayDate) = $this->getThisMonthDate();
        $sinceDateTime = $this->makeSinceDateTime($firstDayDate);
        $tillDateTime = $this->makeTillDateTime($lastDayDate);
        return array($sinceDateTime, $tillDateTime);
    }

    /**
     * @param $sinceDateTime
     * @param $tillDateTime
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getOrderproductsByTimePeriod($sinceDateTime, $tillDateTime)
    {
        return Orderproduct::where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->whereHas('order', function ($q) use ($sinceDateTime, $tillDateTime) {
                $q->where('completed_at', '>=', $sinceDateTime)
                    ->where('completed_at', '<=', $tillDateTime)
                    ->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                    ->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
            })->get();
    }
}
