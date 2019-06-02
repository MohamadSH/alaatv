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

        $productIds = $this->getArray( $this->getProductsOfUser($setIds) , 'id') ;

        $allTimeOrderproducts = $this->getPurchasedOrderproducts($productIds);
        $allTimeCount         =         $this->countOrderproducts($allTimeOrderproducts);
        $allTimeSum           = $this->calculateTotalPrice($allTimeOrderproducts);

        /** Today */
        $todayOrderproducts = $this->getTodayPurchases($allTimeOrderproducts);
        $todayCount         =         $this->countOrderproducts($todayOrderproducts);
        $todaySum           = $this->calculateTotalPrice($todayOrderproducts);

        /** This week */
        $thisWeekOrderproducts  = $this->getThisWeekPurchases($allTimeOrderproducts);
        $thisWeekCount          =         $this->countOrderproducts($thisWeekOrderproducts);
        $thisWeekSum            = $this->calculateTotalPrice($thisWeekOrderproducts);

        /** This month */
        $thisMonthOrderproducts = $this->getThisMonthPurchases($allTimeOrderproducts);
        $thisMonthCount         =         $this->countOrderproducts($thisMonthOrderproducts);
        $thisMonthSum           = $this->calculateTotalPrice($thisMonthOrderproducts);

        return view("user.salesReport", compact('limitStatus', 'coupontype', 'products' ,
            'allTimeCount' , 'allTimeSum' , 'thisMonthCount' , 'thisMonthSum' , 'thisWeekCount' , 'thisWeekSum' , 'todayCount' , 'todaySum'));

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
        $today = Carbon::today()->format('Y-m-d');
        $sinceDateTime = $this->makeSinceDateTime($today);
        $tillDateTime = $this->makeTillDateTime($today);
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @return Collection
     */
    private function getThisWeekPurchases(Collection $allTimeOrderproducts): Collection
    {
        list($firstDayOfWeekDate, $endDayOfWeekDate) = $this->getThisWeekDate();
        $sinceDateTime = $this->makeSinceDateTime($firstDayOfWeekDate);
        $tillDateTime = $this->makeTillDateTime($endDayOfWeekDate);
        return $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
    }

    /**
     * @param Collection $allTimeOrderproducts
     * @return Collection
     */
    private function getThisMonthPurchases(Collection $allTimeOrderproducts): Collection
    {
        list($firstDayDate, $lastDayDate) = $this->getThisMonthDate();
        $sinceDateTime = $this->makeSinceDateTime($firstDayDate);
        $tillDateTime = $this->makeTillDateTime($lastDayDate);
        $thisMonthOrderproducts = $this->filterOrderproductsByCompletionDate($allTimeOrderproducts, $sinceDateTime, $tillDateTime);
        return $thisMonthOrderproducts;
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
}
