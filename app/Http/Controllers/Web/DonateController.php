<?php

namespace App\Http\Controllers\Web;

use App\Order;
use App\Product;
use Carbon\Carbon;
use App\Orderproduct;
use App\Websitesetting;
use App\Traits\DateTrait;
use App\Traits\MetaCommon;
use Illuminate\Http\Request;
use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DonateController extends Controller
{
    use MetaCommon;
    use DateTrait;
    
    private $setting;
    
    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;
    }

    public function __invoke(Request $request)
    {
        $url   = $request->url();
        $title = "آلاء|کمک مالی";
        $this->generateSeoMetaTags(new SeoDummyTags($title, $this->setting->site->seo->homepage->metaDescription, $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));
        
        return $this->makeDonatePage();
    }

    private function makeDonatePage()
    {
        /** INITIAL VALUES    */
        
        $monthToPeriodConvert = collect(config('constants.JALALI_CALENDER'));
        $firstMonth           = $monthToPeriodConvert->first()["month"];
        $MONTH_SPEND          = 25000000;
        $LATEST_WEEK_NUMBER   = 3;
        $LATEST_MAX_NUMBER    = 3;
        
        /** END OF INITIALIZING   */
        
        $donateProductArray = [
            Product::CUSTOM_DONATE_PRODUCT,
            Product::DONATE_PRODUCT_5_HEZAR,
        ];
        array_push($donateProductArray, Product::CUSTOM_DONATE_PRODUCT);
        $orders = $this->repo_getOrders($donateProductArray);

        list($currentJalaliYear, $currentJalaliMonth, $currentJalaliDay) = $this->todayJalaliSplittedDate();
        $currentJalaliMonthString = $this->convertToJalaliMonth($currentJalaliMonth);
        $currentJalaliMonthDays   = $this->getJalaliMonthDays($currentJalaliMonthString);
        
        $currentJalaliDateString = $currentJalaliDay." ".$currentJalaliMonthString;
        
        /** THIS WEEK/TODAY LATEST DONATES **/
        $latestDonors = collect();
        $donates      = $orders->take($LATEST_WEEK_NUMBER);
        foreach ($donates as $donate) {
            if (isset($donate->user->id)) {
                $firstName = $donate->user->firstName;
                $lastName  = $donate->user->lastName;
                $avatar    = $donate->user->getCustomSizePhoto(150,150);
            }
            
            $donateAmount = $donate->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                ->whereIn("product_id",
                    $donateProductArray)
                ->get()
                ->sum("cost");
            
            $latestDonors->push([
                "firstName"    => (isset($firstName)) ? $firstName : "",
                "lastName"     => (isset($lastName)) ? $lastName : "",
                "donateAmount" => $donateAmount,
                "avatar"       => (isset($avatar)) ? $avatar : "",
            ]);
        }
        /** END **/
        
        /** CURRENT MONTH MAXIMUM DONATES **/
        $today            = $monthToPeriodConvert->where("month", $currentJalaliMonthString)->first();
        $today            = $today["periodBegin"];
        $today            = explode("-", $today);
        $todayYear        = $today[0];
        $todayMonth       = $today[1];
        $todayDay         = $today[2];
        $date             = Carbon::createMidnightDate($todayYear, $todayMonth, $todayDay);
        $thisMonthDonates = $this->repo_getThisMonthDonates($orders, $date);
        $maxDonates       = $this->repo_MaxDonates($thisMonthDonates, $donateProductArray, $LATEST_MAX_NUMBER);
        $maxDonors        = collect();
        foreach ($maxDonates as $maxDonate) {
            if (isset($maxDonate->order->user->id)) {
                $firstName = $maxDonate->order->user->firstName;
                $lastName  = $maxDonate->order->user->lastName;
                $avatar    = $donate->user->getCustomSizePhoto(150,150);
            }
            
            $donateAmount = $maxDonate->cost;
            
            $maxDonors->push([
                "firstName"    => (isset($firstName)) ? $firstName : "",
                "lastName"     => (isset($lastName)) ? $lastName : "",
                "donateAmount" => $donateAmount,
                "avatar"       => (isset($avatar)) ? $avatar : "",
            ]);
        }
        /** END **/
        
        /** DONATES CHART **/
        $allMonths = config('constants.JALALI_ALL_MONTHS');
        $allDays   = config('constants.ALL_DAYS_OF_MONTH');
        
        $chartData   = collect();
        $totalSpend  = 0;
        $totalIncome = 0;
        
        if ($currentJalaliMonthString == $firstMonth) {
            $currentDayKey = array_search($currentJalaliDay, $allDays);
            $days          = array_splice($allDays, 0, $currentDayKey + 1);
            $date          = $monthToPeriodConvert->where("month", $currentJalaliMonthString)->first();
            foreach ($days as $day) {
                $mehrGregorianMonth = Carbon::createFromFormat("Y-m-d", $date["periodBegin"])
                    ->setTimezone("Asia/Tehran")->month;
                
                $mehrGregorianEndDay = Carbon::createFromFormat("Y-m-d", $date["periodEnd"])
                        ->setTimezone("Asia/Tehran")->day + ($day - 1);
                
                if ($mehrGregorianEndDay > 30) {
                    $mehrGregorianMonth++;
                    $mehrGregorianEndDay = $mehrGregorianEndDay - 30;
                    if ($mehrGregorianEndDay < 10) {
                        $mehrGregorianEndDay = "0".$mehrGregorianEndDay;
                    }
                }
                if ($mehrGregorianMonth < 10) {
                    $mehrGregorianMonth = "0".$mehrGregorianMonth;
                }
                
                $donates = $orders->where("completed_at", ">=",
                    "2018-$mehrGregorianMonth-$mehrGregorianEndDay 00:00:00")
                    ->where("completed_at", "<=",
                        "2018-$mehrGregorianMonth-$mehrGregorianEndDay 23:59:59");
                
                $totalMonthIncome = 0;
                foreach ($donates as $donate) {
    
                    $amount = $this->repo_getTotal($donate, $donateProductArray);

                    $totalMonthIncome += $amount;
                }
                $dayRatio        = 1 / $currentJalaliMonthDays;
                $totalMonthSpend = (int) round($MONTH_SPEND * $dayRatio);
                
                $totalIncome += $totalMonthIncome;
                $totalSpend  += $totalMonthSpend;
                
                $monthData = $day." ".$currentJalaliMonthString;
                $chartData->push([
                    "month"       => $monthData,
                    "totalIncome" => $totalMonthIncome,
                    "totalSpend"  => $totalMonthSpend,
                ]);
            }
        }
        else {
            $currentMonthKey = array_search($currentJalaliMonthString, $allMonths);
            $months          = array_splice($allMonths, 0, $currentMonthKey + 1);
            
            foreach ($months as $month) {
                switch ($month) {
                    // Example for static data
                    //                case "مهر" :
                    //                    $totalMonthIncome = 2491700;
                    //                    $totalMonthSpend = $MONTH_SPEND;
                    //                    break;
                    default:
                        $date    = $monthToPeriodConvert->where("month", $month)
                            ->first();
                        $donates = $orders->where("completed_at", ">=", $date["periodBegin"])
                            ->where("completed_at", "<=", $date["periodEnd"]);
                        
                        $totalMonthIncome = 0;
                        foreach ($donates as $donate) {
                            $amount = $this->repo_getTotal($donate, $donateProductArray);
                            
                            $totalMonthIncome += $amount;
                        }
                        if ($month == $currentJalaliMonthString) {
                            $dayRatio        = $currentJalaliDay / $currentJalaliMonthDays;
                            $totalMonthSpend = (int) round($MONTH_SPEND * $dayRatio);
                        }
                        else {
                            $totalMonthSpend = $MONTH_SPEND;
                        }
                        break;
                }
                $totalIncome += $totalMonthIncome;
                $totalSpend  += $totalMonthSpend;
                if ($month == $currentJalaliMonthString) {
                    $monthData = $currentJalaliDay." ".$month;
                } else {
                    $monthData = $month;
                }
                
                $chartData->push([
                    "month"       => $monthData,
                    "totalIncome" => $totalMonthIncome,
                    "totalSpend"  => $totalMonthSpend,
                ]);
            }
        }
        /** END **/
        
        if (Auth::check()) {
            $baseUrl     = url("/");
            $contentPath = str_replace($baseUrl, "", action("Web\DonateController"));
        }
        
        return view("pages.donate",
            compact("latestDonors", "maxDonors", "months", "chartData", "totalSpend", "totalIncome",
                "currentJalaliDateString", "currentJalaliMonthString"));
    }
    
    /**
     * @param  array  $donateProductArray
     *
     * @return \App\Order[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function repo_getOrders(array $donateProductArray)
    {
        return Order::whereHas("orderproducts", function ($q) use ($donateProductArray) {
            $q->whereIn("product_id", $donateProductArray);
        })
            ->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
            ->where("paymentstatus_id",
                config("constants.PAYMENT_STATUS_PAID"))
            ->orderBy("completed_at", "DESC")
            ->get();
    }
    
    /**
     * @param  array  $thisMonthDonates
     * @param  array  $donateProductArray
     * @param  int    $LATEST_MAX_NUMBER
     *
     * @return \Illuminate\Support\Collection
     */
    private function repo_MaxDonates(array $thisMonthDonates, array $donateProductArray, int $LATEST_MAX_NUMBER): \Illuminate\Support\Collection
    {
        $maxDonates = Orderproduct::whereIn("order_id", $thisMonthDonates)
            ->where(function ($q) {
                $q->where("orderproducttype_id", config('constants.ORDER_PRODUCT_TYPE_DEFAULT'));
            })
            ->whereIn("product_id", $donateProductArray)
            ->orderBy("cost", "DESC")
            ->orderBy("created_at", "DESC")
            ->take($LATEST_MAX_NUMBER)
            ->get();
        
        return $maxDonates;
    }
    
    /**
     * @param $orders
     * @param $date
     *
     * @return mixed
     */
    private function repo_getThisMonthDonates($orders, $date)
    {
        $thisMonthDonates = $orders->where("completed_at", ">=", $date)
            ->pluck("id")
            ->toArray();
        
        return $thisMonthDonates;
    }
    
    /**
     * @param         $donate
     * @param  array  $donateProductArray
     *
     * @return mixed
     */
    private function repo_getTotal($donate, array $donateProductArray)
    {
        $amount = $donate->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->whereIn("product_id", $donateProductArray)
            ->get()
            ->sum("cost");
        
        return $amount;
    }
}
