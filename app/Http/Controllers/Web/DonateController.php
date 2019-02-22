<?php

namespace App\Http\Controllers\Web;
use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Order;
use App\Orderproduct;
use App\Product;
use App\Traits\DateTrait;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $url = $request->url();
        $title = "آلاء|کمک مالی";
        $this->generateSeoMetaTags(new SeoDummyTags($title, $this->setting->site->seo->homepage->metaDescription, $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));
        return $this->makeDonatePage();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    private function makeDonatePage()
    {
        /** INITIAL VALUES    */

        $monthToPeriodConvert = collect([
            [
                "month"       => "مهر",
                "periodBegin" => "2018-09-23",
                "periodEnd"   => "2018-10-23",
            ],
            [
                "month"       => "آبان",
                "periodBegin" => "2018-10-23",
                "periodEnd"   => "2018-11-22",
            ],
            [
                "month"       => "آذر",
                "periodBegin" => "2018-11-22",
                "periodEnd"   => "2018-12-22",
            ],
            [
                "month"       => "دی",
                "periodBegin" => "2018-12-22",
                "periodEnd"   => "2019-01-21",
            ],
            [
                "month"       => "بهمن",
                "periodBegin" => "2019-01-21",
                "periodEnd"   => "2019-02-20",
            ],
            [
                "month"       => "اسفند",
                "periodBegin" => "2019-02-20",
                "periodEnd"   => "2019-03-21",
            ],
            [
                "month"       => "فروردین",
                "periodBegin" => "2019-03-21",
                "periodEnd"   => "2019-04-21",
            ],
            [
                "month"       => "اردیبهشت",
                "periodBegin" => "2019-04-21",
                "periodEnd"   => "2019-05-22",
            ],
            [
                "month"       => "خرداد",
                "periodBegin" => "2019-05-22",
                "periodEnd"   => "2019-06-22",
            ],
            [
                "month"       => "تیر",
                "periodBegin" => "2019-06-22",
                "periodEnd"   => "2019-07-23",
            ],
            [
                "month"       => "مرداد",
                "periodBegin" => "2019-07-23",
                "periodEnd"   => "2019-08-23",
            ],
            [
                "month"       => "شهریور",
                "periodBegin" => "2019-08-23",
                "periodEnd"   => "2019-09-23",
            ],
        ]);
        $firstMonth = $monthToPeriodConvert->first()["month"];
        $MONTH_SPEND = 25000000;
        $LATEST_WEEK_NUMBER = 3;
        $LATEST_MAX_NUMBER = 3;

        /** END OF INITIALIZING   */

        $donateProductArray = [
            Product::CUSTOM_DONATE_PRODUCT,
            Product::DONATE_PRODUCT_5_HEZAR,
        ];
        array_push($donateProductArray, Product::CUSTOM_DONATE_PRODUCT);
        $orders = Order::whereHas("orderproducts", function ($q) use ($donateProductArray) {
            $q->whereIn("product_id", $donateProductArray);
        })
                       ->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                       ->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"))
                       ->orderBy("completed_at", "DESC")
                       ->get();

        $currentGregorianDate = Carbon::now()
                                      ->timezone('Asia/Tehran');
        $delimiter = "/";
        $currentJalaliDate = $this->gregorian_to_jalali($currentGregorianDate->year, $currentGregorianDate->month, $currentGregorianDate->day, $delimiter);
        $currentJalaliDateSplit = explode($delimiter, $currentJalaliDate);
        $currentJalaliYear = $currentJalaliDateSplit[0];
        $currentJalaliMonth = $currentJalaliDateSplit[1];
        $currentJalaliDay = $currentJalaliDateSplit[2];
        $currentJalaliMonthString = $this->convertToJalaliMonth($currentJalaliMonth);
        $currentJalaliMonthDays = $this->getJalaliMonthDays($currentJalaliMonthString);

        $currentJalaliDateString = $currentJalaliDay . " " . $currentJalaliMonthString;


        /** THIS WEEK/TODAY LATEST DONATES **/
        $latestDonors = collect();
        $donates = $orders->take($LATEST_WEEK_NUMBER);
        foreach ($donates as $donate) {
            if (isset($donate->user->id)) {
                $firstName = $donate->user->firstName;
                $lastName = $donate->user->lastName;
                $avatar = $donate->user->photo;
            }

            $donateAmount = $donate->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                                   ->whereIn("product_id", $donateProductArray)
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
        $today = $monthToPeriodConvert->where("month", $currentJalaliMonthString)
                                      ->first();
        $today = $today["periodBegin"];
        $today = explode("-", $today);
        $todayYear = $today[0];
        $todayMonth = $today[1];
        $todayDay = $today[2];
        $date = Carbon::createMidnightDate($todayYear, $todayMonth, $todayDay);
        $thisMonthDonates = $orders->where("completed_at", ">=", $date)
                                   ->pluck("id")
                                   ->toArray();
        $maxDonates = Orderproduct::whereIn("order_id", $thisMonthDonates)
                                  ->where(function ($q) {
                                      $q->where("orderproducttype_id", config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                                        ->orWhereNull("orderproducttype_id");
                                  })
                                  ->whereIn("product_id", $donateProductArray)
                                  ->orderBy("cost", "DESC")
                                  ->orderBy("created_at", "DESC")
                                  ->take($LATEST_MAX_NUMBER)
                                  ->get();
        $maxDonors = collect();
        foreach ($maxDonates as $maxDonate) {
            if (isset($maxDonate->order->user->id)) {
                $firstName = $maxDonate->order->user->firstName;
                $lastName = $maxDonate->order->user->lastName;
                $avatar = $maxDonate->order->user->photo;
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
        $allMonths = [
            "مهر",
            "آبان",
            "آذر",
            "دی",
            "بهمن",
            "اسفند",
            "فروردین",
            "اردیبهشت",
            "خرداد",
            "تیر",
            "مرداد",
            "شهریور",
        ];
        $allDays = [
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "28",
            "29",
            "30",
        ];

        $chartData = collect();
        $totalSpend = 0;
        $totalIncome = 0;

        if ($currentJalaliMonthString == $firstMonth) {
            $currentDayKey = array_search($currentJalaliDay, $allDays);
            $days = array_splice($allDays, 0, $currentDayKey + 1);
            $date = $monthToPeriodConvert->where("month", $currentJalaliMonthString)
                                         ->first();
            foreach ($days as $day) {
                $mehrGregorianMonth = Carbon::createFromFormat("Y-m-d", $date["periodBegin"])
                                            ->setTimezone("Asia/Tehran")
                    ->month;

                $mehrGregorianEndDay = Carbon::createFromFormat("Y-m-d", $date["periodEnd"])
                                             ->setTimezone("Asia/Tehran")
                        ->day + ($day - 1);

                if ($mehrGregorianEndDay > 30) {
                    $mehrGregorianMonth++;
                    $mehrGregorianEndDay = $mehrGregorianEndDay - 30;
                    if ($mehrGregorianEndDay < 10)
                        $mehrGregorianEndDay = "0" . $mehrGregorianEndDay;
                }
                if ($mehrGregorianMonth < 10) {
                    $mehrGregorianMonth = "0" . $mehrGregorianMonth;
                }

                $donates = $orders->where("completed_at", ">=", "2018-$mehrGregorianMonth-$mehrGregorianEndDay 00:00:00")
                                  ->where("completed_at", "<=", "2018-$mehrGregorianMonth-$mehrGregorianEndDay 23:59:59");

                $totalMonthIncome = 0;
                foreach ($donates as $donate) {

                    $amount = $donate->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                                     ->whereIn("product_id", $donateProductArray)
                                     ->get()
                                     ->sum("cost");

                    $totalMonthIncome += $amount;
                }
                $dayRatio = 1 / $currentJalaliMonthDays;
                $totalMonthSpend = (int)round($MONTH_SPEND * $dayRatio);

                $totalIncome += $totalMonthIncome;
                $totalSpend += $totalMonthSpend;

                $monthData = $day . " " . $currentJalaliMonthString;
                $chartData->push([
                    "month"       => $monthData,
                    "totalIncome" => $totalMonthIncome,
                    "totalSpend"  => $totalMonthSpend,
                ]);
            }
        } else {
            $currentMonthKey = array_search($currentJalaliMonthString, $allMonths);
            $months = array_splice($allMonths, 0, $currentMonthKey + 1);

            foreach ($months as $month) {
                switch ($month) {
                    // Example for static data
                    //                case "مهر" :
                    //                    $totalMonthIncome = 2491700;
                    //                    $totalMonthSpend = $MONTH_SPEND;
                    //                    break;
                    default:
                        $date = $monthToPeriodConvert->where("month", $month)
                                                     ->first();
                        $donates = $orders->where("completed_at", ">=", $date["periodBegin"])
                                          ->where("completed_at", "<=", $date["periodEnd"]);

                        $totalMonthIncome = 0;
                        foreach ($donates as $donate) {
                            $amount = $donate->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                                             ->whereIn("product_id", $donateProductArray)
                                             ->get()
                                             ->sum("cost");

                            $totalMonthIncome += $amount;
                        }
                        if ($month == $currentJalaliMonthString) {
                            $dayRatio = $currentJalaliDay / $currentJalaliMonthDays;
                            $totalMonthSpend = (int)round($MONTH_SPEND * $dayRatio);
                        } else {
                            $totalMonthSpend = $MONTH_SPEND;
                        }
                        break;
                }
                $totalIncome += $totalMonthIncome;
                $totalSpend += $totalMonthSpend;
                if ($month == $currentJalaliMonthString)
                    $monthData = $currentJalaliDay . " " . $month;
                else
                    $monthData = $month;

                $chartData->push([
                    "month"       => $monthData,
                    "totalIncome" => $totalMonthIncome,
                    "totalSpend"  => $totalMonthSpend,
                ]);

            }
        }
        /** END **/

        if (Auth::check()) {
            $baseUrl = url("/");
            $contentPath = str_replace($baseUrl, "", action("Web\DonateController"));
        }


        return view("pages.donate", compact("latestDonors", "maxDonors", "months"
            , "chartData", "totalSpend", "totalIncome", "currentJalaliDateString", "currentJalaliMonthString"));
    }
}
