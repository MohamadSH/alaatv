<?php

namespace App\Http\Controllers\Web;

use SEO;
use Auth;
use stdClass;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use PHPUnit\Framework\Exception;
use Kalnoy\Nestedset\QueryBuilder;
use App\Http\Controllers\Controller;
use Illuminate\{Contracts\Routing\ResponseFactory,
    Contracts\View\Factory,
    Http\RedirectResponse,
    Http\Request,
    Http\Response,
    Support\Arr,
    Support\Collection,
    Support\Facades\DB,
    Support\Facades\View,
    Support\Facades\Input,
    Support\Facades\Route,
    Support\Facades\Cache,
    Contracts\Filesystem\FileNotFoundException,
    Validation\ValidationException};
use App\{Bon,
    Contacttype,
    Http\Requests\EditOrderRequest,
    Http\Requests\InsertContactRequest,
    Http\Requests\InsertEmployeeTimeSheet,
    Http\Requests\InsertEventResultRequest,
    Http\Requests\InsertPhoneRequest,
    Phonetype,
    Relative,
    Role,
    Survey,
    User,
    Event,
    Grade,
    Major,
    Order,
    Phone,
    Gender,
    Contact,
    Lottery,
    Product,
    Province,
    Bloodtype,
    Userstatus,
    Bankaccount,
    Traits\Helper,
    Websitesetting,
    Employeeschedule,
    Traits\DateTrait,
    Employeetimesheet,
    Traits\MetaCommon,
    Traits\UserCommon,
    Traits\OrderCommon,
    Transactiongateway,
    Traits\SearchCommon,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Afterloginformcontrol,
    Traits\CharacterCommon,
    Classes\SEO\SeoDummyTags,
    Classes\Search\UserSearch,
    Collection\ProductCollection,
    Http\Requests\EditUserRequest,
    Http\Requests\UserIndexRequest,
    Http\Requests\InsertUserRequest,
    Http\Requests\InsertVoucherRequest,
    Http\Requests\PasswordRecoveryRequest,
    Http\Controllers\Auth\RegisterController,
    Http\Requests\RegisterForSanatiSharifHighSchoolRequest};

class UserController extends Controller
{
    use ProductCommon;
    use DateTrait;
    use RequestCommon;
    use CharacterCommon;
    use Helper;
    use UserCommon;
    use SearchCommon;
    use MetaCommon;
    use OrderCommon;
    
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */
    
    const PARTIAL_MAIN_INDEX_TEMPLATE = "user.index";
    
    const PARTIAL_SMS_INDEX_TEMPLATE = "user.index2";
    
    const PARTIAL_REPORT_INDEX_TEMPLATE = "admin.partials.getReportIndex";
    
    protected $setting;
    

    
    public function __construct(Agent $agent, Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }
    
    /**
     * @param  Agent  $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        $authException = ['show'];
        
        return $authException;
    }
    
    /**
     * @param  array  $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:'.config('constants.LIST_USER_ACCESS')."|".config('constants.GET_BOOK_SELL_REPORT')."|".config('constants.GET_USER_REPORT'),
            ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_USER_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.REMOVE_USER_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_USER_ACCESS'), ['only' => 'edit']);
        $this->middleware('completeInfo', ['only' => ['uploadConsultingQuestion']]);
    }
    
    /**
     * Finding tech person based on his tech code
     *
     * @param  Request  $request
     *
     * @return int|string
     */
    public function findTech(Request $request)
    {
        $user = User::where('techCode', $request->techCode)
            ->first();
        if (isset($user)) {
            return action('Web\UserController@show', $user);
        }
        
        return 0;
    }

    public function index(UserIndexRequest $request)
    {
        //======================================================================
        //=============================OLD CODE=================================
        //======================================================================
        
        $createdTimeEnable = Input::get('createdTimeEnable');
        $createdSinceDate  = Input::get('createdSinceDate');
        $createdTillDate   = Input::get('createdTillDate');
        if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
            $createdSinceDate = Carbon::parse($createdSinceDate)
                    ->format('Y-m-d')." 00:00:00";
            $createdTillDate  = Carbon::parse($createdTillDate)
                    ->format('Y-m-d')." 23:59:59";
            $users            = User::whereBetween('created_at', [$createdSinceDate, $createdTillDate])
                ->orderBy('created_at', 'Desc');
        }
        else {
            $users = User::orderBy('created_at', 'Desc');
        }
        
        $updatedSinceDate  = Input::get('updatedSinceDate');
        $updatedTillDate   = Input::get('updatedTillDate');
        $updatedTimeEnable = Input::get('updatedTimeEnable');
        if (strlen($updatedSinceDate) > 0 && strlen($updatedTillDate) > 0 && isset($updatedTimeEnable)) {
            $users = $this->timeFilterQuery($users, $updatedSinceDate, $updatedTillDate, 'updated_at');
        }
        
        //filter by firstName, lastName, nationalCode, mobile
        $firstName = trim(Input::get('firstName'));
        if (isset($firstName) && strlen($firstName) > 0) {
            $users = $users->where('firstName', 'like', '%'.$firstName.'%');
        }
        
        $lastName = trim(Input::get('lastName'));
        if (isset($lastName) && strlen($lastName) > 0) {
            $users = $users->where('lastName', 'like', '%'.$lastName.'%');
        }
        
        $nationalCode = trim(Input::get('nationalCode'));
        if (isset($nationalCode) && strlen($nationalCode) > 0) {
            $users = $users->where('nationalCode', 'like', '%'.$nationalCode.'%');
        }
        
        $mobile = trim(Input::get('mobile'));
        if (isset($mobile) && strlen($mobile) > 0) {
            $users = $users->where('mobile', 'like', '%'.$mobile.'%');
        }
        
        //filter by role, major , coupon
        $roleEnable = Input::get('roleEnable');
        $rolesId    = Input::get('roles');
        if (isset($roleEnable) && isset($rolesId)) {
            $users = User::roleFilter($users, $rolesId);
        }
        
        $majorEnable = Input::get('majorEnable');
        $majorsId    = Input::get('majors');
        if (isset($majorEnable) && isset($majorsId)) {
            $users = User::majorFilter($users, $majorsId);
        }
        
        $couponEnable = Input::get('couponEnable');
        $couponsId    = Input::get('coupons');
        if (isset($couponEnable) && isset($couponsId)) {
            if (in_array(0, $couponsId)) {
                $users = $users->whereHas("orders", function ($q) use ($couponsId) {
                    $q->whereDoesntHave("coupon")
                        ->whereNotIn('orderstatus_id',
                            [
                                config("constants.ORDER_STATUS_OPEN"), config("constants.ORDER_STATUS_CANCELED"),
                                config("constants.ORDER_STATUS_OPEN_BY_ADMIN"),
                            ]);
                });
            }
            else {
                $users = $users->whereHas("orders", function ($q) use ($couponsId) {
                    $q->whereIn("coupon_id", $couponsId)
                        ->whereNotIn('orderstatus_id',
                            [
                                config("constants.ORDER_STATUS_OPEN"), config("constants.ORDER_STATUS_CANCELED"),
                                config("constants.ORDER_STATUS_OPEN_BY_ADMIN"),
                            ]);
                });
            }
        }
        
        //filter by product
        $seenProductEnable = Input::get('productEnable');
        $productsId        = Input::get('products');
        if (isset($seenProductEnable) && isset($productsId)) {
            $productUrls = [];
            $baseUrl     = url("/");
            foreach ($productsId as $productId) {
                array_push($productUrls, str_replace($baseUrl, "", action("Web\ProductController@show", $productId)));
            }
            $users = $users->whereHas('seensitepages', function ($q) use ($productUrls) {
                $q->whereIn("url", $productUrls);
            });
        }
        
        $orderProductEnable = Input::get("orderProductEnable");
        $productsId         = Input::get('orderProducts');
        if (isset($orderProductEnable) && isset($productsId)) {
            if (in_array(-1, $productsId)) {
                $users = $users->whereDoesntHave("orders", function ($q) {
                    $q->whereNotIn('orderstatus_id', [
                        config("constants.ORDER_STATUS_OPEN"),
                        config("constants.ORDER_STATUS_CANCELED"),
                        config("constants.ORDER_STATUS_OPEN_BY_ADMIN"),
                        config("constants.ORDER_STATUS_OPEN_DONATE"),
                        config("constants.ORDER_STATUS_PENDING"),
                    ]);
                });
            }
            elseif (in_array(0, $productsId)) {
                $users = $users->whereHas("orders", function ($query) {
                    $query->whereNotIn('orderstatus_id', [
                        config("constants.ORDER_STATUS_OPEN"),
                        config("constants.ORDER_STATUS_CANCELED"),
                        config("constants.ORDER_STATUS_OPEN_BY_ADMIN"),
                        config("constants.ORDER_STATUS_OPEN_DONATE"),
                        config("constants.ORDER_STATUS_PENDING"),
                    ]);
                });
            }
            elseif (isset($productsId)) {
                $products = Product::whereIn('id', $productsId)
                    ->get();
                foreach ($products as $product) {
                    if ($product->producttype_id == config("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                        if ($product->hasChildren()) {
                            $productsId = array_merge($productsId,
                                Product::whereHas('parents', function ($q) use ($productsId) {
                                    $q->whereIn("parent_id", $productsId);
                                })
                                    ->pluck("id")
                                    ->toArray());
                        }
                    }
                }
                
                if (Input::has("checkoutStatusEnable")) {
                    $checkoutStatuses = Input::get("checkoutStatuses");
                    if (in_array(0, $checkoutStatuses)) {
                        $orders = Order::whereHas("orderproducts", function ($q) use ($productsId) {
                            $q->whereIn("product_id", $productsId)
                                ->whereNull("checkoutstatus_id");
                        })
                            ->whereNotIn('orderstatus_id', [config("constants.ORDER_STATUS_OPEN")]);
                    }
                    else {
                        $orders = Order::whereHas("orderproducts", function ($q) use ($productsId, $checkoutStatuses) {
                            $q->whereIn("product_id", $productsId)
                                ->whereIn("checkoutstatus_id", $checkoutStatuses);
                        })
                            ->whereNotIn('orderstatus_id', [config("constants.ORDER_STATUS_OPEN")]);
                    }
                }
                else {
                    $orders = Order::whereHas("orderproducts", function ($q) use ($productsId) {
                        $q->whereIn("product_id", $productsId);
                    })
                        ->whereNotIn('orderstatus_id', [config("constants.ORDER_STATUS_OPEN")]);
                }
                
                $createdSinceDate  = Input::get('completedSinceDate');
                $createdTillDate   = Input::get('completedTillDate');
                $createdTimeEnable = Input::get('completedTimeEnable');
                if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
                    $orders = $this->timeFilterQuery($orders, $createdSinceDate, $createdTillDate, 'created_at');
                }
                $orders = $orders->get();
                $users  = $users->whereIn("id", $orders->pluck("user_id")
                    ->toArray());
            }
        }
        elseif (Input::has("checkoutStatusEnable")) {
            $checkoutStatuses = Input::get("checkoutStatuses");
            if (in_array(0, $checkoutStatuses)) {
                $orders = Order::whereHas("orderproducts", function ($q) use ($productsId) {
                    $q->whereNull("checkoutstatus_id");
                })
                    ->whereNotIn('orderstatus_id', [config("constants.ORDER_STATUS_OPEN")]);
            }
            else {
                $orders = Order::whereHas("orderproducts", function ($q) use ($productsId, $checkoutStatuses) {
                    $q->whereIn("checkoutstatus_id", $checkoutStatuses);
                })
                    ->whereNotIn('orderstatus_id', [config("constants.ORDER_STATUS_OPEN")]);
            }
            $orders = $orders->get();
            $users  = $users->whereIn("id", $orders->pluck("user_id")
                ->toArray());
        }
        
        $paymentStatusesId = Input::get('paymentStatuses');
        if (isset($paymentStatusesId)) {
            //Muhammad Shahrokhi : kar nemikone!
//            $users = $users->whereHas("orders" , function ($q) use ($paymentStatusesId) {
//                $q->whereIn("paymentstatus_id", $paymentStatusesId)->whereNotIn('orderstatus_id', [1]);
//            }
            
            if (!isset($orders)) {
                $orders = Order::all();
            }
            else {
                $orders = Order::paymentStatusFilter($orders, $paymentStatusesId);
            }
            $users = $users->whereIn("id", $orders->pluck("user_id")
                ->toArray());
        }
        
        $orderStatusesId = Input::get('orderStatuses');
        if (isset($orderStatusesId)) {
            //Muhammad Shahrokhi : kar nemikone!
//            $users = $users->whereHas("orders" , function ($q) use ($orderStatusesId) {
//                $q->whereIn("orderstatus_id", $orderStatusesId)->whereNotIn('orderstatus_id', [1]);
//            });
            if (!isset($orders)) {
                $orders = Order::all();
            }
            else {
                $orders = Order::orderStatusFilter($orders, $orderStatusesId);
            }
            $users = $users->whereIn("id", $orders->pluck("user_id")
                ->toArray());
        }
        //filter by gender ,lockProfile , mobileVerification
        $genderId = Input::get("gender_id");
        if (isset($genderId) && strlen($genderId) > 0) {
            if ($genderId == 0) {
                $users = $users->whereDoesntHave("gender");
            }
            else {
                $users = $users->where("gender_id", $genderId);
            }
        }
        
        $userstatusId = Input::get("userstatus_id");
        if (isset($userstatusId) && strlen($userstatusId) > 0 && $userstatusId != 0) {
            $users = $users->where("userstatus_id", $userstatusId);
        }
        
        $lockProfileStatus = Input::get("lockProfileStatus");
        if (isset($lockProfileStatus) && strlen($lockProfileStatus) > 0) {
            $users = $users->where("lockProfile", $lockProfileStatus);
        }
        
        $mobileNumberVerification = Input::get("mobileNumberVerification");
        if (isset($mobileNumberVerification) && strlen($mobileNumberVerification) > 0) {
            $users = $users->where("mobileNumberVerification", $mobileNumberVerification);
        }
        
        //filter by postalCode, province , city, address, school , email
        $withoutPostalCode = Input::get("withoutPostalCode");
        if (isset($withoutPostalCode)) {
            $users = $users->where(function ($q) {
                $q->whereNull("postalCode")
                    ->orWhere("postalCode", "");
            });
        }
        else {
            $postalCode = Input::get("postalCode");
            if (isset($postalCode) && strlen($postalCode) > 0) {
                $users = $users->where('postalCode', 'like', '%'.$postalCode.'%');
            }
        }
        
        $withoutProvince = Input::get("withoutProvince");
        if (isset($withoutProvince)) {
            $users = $users->where(function ($q) {
                $q->whereNull("province")
                    ->orWhere("province", "");
            });
        }
        else {
            $province = Input::get("province");
            if (isset($province) && strlen($province) > 0) {
                $users = $users->where('province', 'like', '%'.$province.'%');
            }
        }
        
        $withoutCity = Input::get("withoutCity");
        if (isset($withoutCity)) {
            $users = $users->where(function ($q) {
                $q->whereNull("city")
                    ->orWhere("city", "");
            });
        }
        else {
            $city = Input::get("city");
            if (isset($city) && strlen($city) > 0) {
                $users = $users->where('city', 'like', '%'.$city.'%');
            }
        }

//        $withoutAddress = Input::get("withoutAddress");
//        if(isset($withoutAddress)) {
//            $users = $users->where(function ($q){
//                $q->whereNull("address")->orWhere("address" , "");
//            });
//        }
//        else{
//            $address = Input::get("address");
//            if (isset($address) && strlen($address) > 0)
//                $users = $users->where('address', 'like', '%' . $address . '%');
//        }
        
        $addressSpecialFilter = Input::get("addressSpecialFilter");
        if (isset($addressSpecialFilter)) {
            switch ($addressSpecialFilter) {
                case "0":
                    $address = Input::get("address");
                    if (isset($address) && strlen($address) > 0) {
                        $users = $users->where('address', 'like', '%'.$address.'%');
                    }
                    break;
                case "1":
                    $users = $users->where(function ($q) {
                        $q->whereNull("address")
                            ->orWhere("address", "");
                    });
                    break;
                case  "2":
                    $users = $users->where(function ($q) {
                        $q->whereNotNull("address")
                            ->Where("address", "<>", "");
                    });
                    break;
                default:
                    break;
            }
        }
        else {
            $address = Input::get("address");
            if (isset($address) && strlen($address) > 0) {
                $users = $users->where('address', 'like', '%'.$address.'%');
            }
        }
        
        $withoutSchool = Input::get("withoutSchool");
        if (isset($withoutSchool)) {
            $users = $users->where(function ($q) {
                $q->whereNull("school")
                    ->orWhere("school", "");
            });
        }
        else {
            $school = Input::get("school");
            if (isset($school) && strlen($school) > 0) {
                $users = $users->where('school', 'like', '%'.$school.'%');
            }
        }
        
        $withoutEmail = Input::get("withoutEmail");
        if (isset($withoutEmail)) {
            $users = $users->where(function ($q) {
                $q->whereNull("email")
                    ->orWhere("email", "");
            });
        }
        else {
            $email = Input::get("email");
            if (isset($email) && strlen($email) > 0) {
                $users = $users->where('email', 'like', '%'.$email.'%');
            }
        }


        $previousPath         = url()->previous();
        if (strcmp($previousPath, action("Web\AdminController@adminSMS")) == 0 || $request->has('smsAdmin')) {
            $index                = "user.index2";

            $items = $users->get();

            /**
             * end
             */

            $sortBy   = Input::get("sortBy");
            $sortType = Input::get("sortType");
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, "desc") == 0) {
                    $items = $items->sortByDesc($sortBy);
                }
                else {
                    $items = $items->sortBy($sortBy);
                }
            }

            $uniqueUsers = $items->groupBy("nationalCode");
            $uniqueItems       = collect();
            foreach ($uniqueUsers as $user) {
                if ($user->where("mobileNumberVerification", 1)->isNotEmpty())
                    $uniqueItems->push($user->where("mobileNumberVerification", 1)->first());
                else
                    $uniqueItems->push($user->first());
            }

            $uniqueItemsId              = $uniqueItems->pluck("id");
            $uniqueItemsIdCount         = $uniqueItemsId->count();
            $numberOfFatherPhones = Phone::whereIn('contact_id',
                Contact::whereIn('user_id', $uniqueItemsId)
                    ->where('relative_id', 1)
                    ->pluck('id'))
                ->where("phonetype_id", 1)
                ->count();
            $numberOfMotherPhones = Phone::whereIn('contact_id',
                Contact::whereIn('user_id', $uniqueItemsId)
                    ->where('relative_id', 2)
                    ->pluck('id'))
                ->where("phonetype_id", 1)
                ->count();
        }
        elseif (strcmp($previousPath, action("Web\AdminController@admin")) == 0 || $request->has('userAdmin')) {
            $items = $users->paginate(10, ['*'], 'orders');

            $sortBy   = Input::get("sortBy");
            $sortType = Input::get("sortType");
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, "desc") == 0) {
                    $items = $items->sortByDesc($sortBy);
                }
                else {
                    $items = $items->sortBy($sortBy);
                }
            }

            return $items;
        }
        elseif (strcmp($previousPath, action("Web\AdminController@adminReport")) == 0 || $request->has('reportAdmin')) {
            $reportType           = "";
            $index = "admin.partials.getReportIndex";

            $items = $users->get();

            $sortBy   = Input::get("sortBy");
            $sortType = Input::get("sortType");
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, "desc") == 0) {
                    $items = $items->sortByDesc($sortBy);
                }
                else {
                    $items = $items->sortBy($sortBy);
                }
            }



            /** For selling books */
            $hasPishtaz = [];
            if (isset($orders)) {
                foreach ($items as $user) {
                    if ($user->orders()
                        ->whereIn("id", $orders->pluck("id")
                            ->toArray())
                        ->whereHas("orderproducts", function ($q) {
                            $q->whereHas("attributevalues", function ($q2) {
                                $q2->where("id", 48);
                            });
                        })
                        ->get()
                        ->isNotEmpty()) {
                        array_push($hasPishtaz, $user->id);
                    }
                }
            }
            /** end */

            $minCost = Input::get("minCost");
            if (isset($minCost[0])) {
                foreach ($items as $key => $user) {
                    $userOrders     = $user->orders;
                    $transactionSum = 0;
                    foreach ($userOrders as $order) {
                        $successfullTransactions = $order->successfulTransactions()
                            ->where("created_at", ">", "2017-09-22")
                            ->get();
                        foreach ($successfullTransactions as $transaction) {
                            $transactionSum += $transaction->cost;
                        }
                    }
                    if ($transactionSum < (int) $minCost) {
                        $items->forget($key);
                    }
                }
            }
            
            if (Input::has("lotteries")) {
                $lotteryId = Input::get("lotteries");
                $lotteries = Lottery::where("id", $lotteryId)
                    ->get();
            }
            
            if (Input::has("reportType")) {
                $reportType = Input::get("reportType");
            }
            
            if (Input::has("seePaidCost")) {
                $seePaidCost = true;
            }
        }
        else {
            $items = $users->get();

            $sortBy   = Input::get("sortBy");
            $sortType = Input::get("sortType");
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, "desc") == 0) {
                    $items = $items->sortByDesc($sortBy);
                }
                else {
                    $items = $items->sortBy($sortBy);
                }
            }
            return response([
                "data" => [
                    "users" => $items,
                ],
            ], Response::HTTP_OK);
        }

        $result = [
            'index'                => View::make($index,
                compact('items', 'products', 'paymentStatusesId', 'reportType', 'hasPishtaz', 'orders', 'seePaidCost',
                    'lotteries'))->render(),
            'products'             => (isset($products)) ? $products : [],
            'lotteries'            => (isset($lotteries)) ? $lotteries : [],
            "allUsers"             => $uniqueItemsId??[],
            "allUsersNumber"       => $uniqueItemsIdCount??0,
            "numberOfFatherPhones" => $numberOfFatherPhones??0,
            "numberOfMotherPhones" => $numberOfMotherPhones??0,
        ];
        
        return response(json_encode($result), 200)->header('Content-Type', 'application/json');
        
        //======================================================================
        //=============================REFACTOR=================================
        //======================================================================
        
        /*$tags = $request->get('tags');*/
        $filters    = array_filter($request->all()); //Removes null fields
        $isApp      = $this->isRequestFromApp($request);
        $items      = collect();
        $pageName   = 'userPage';
        $userResult = (new UserSearch)->setPageName($pageName)
            ->get($filters);
        if ($isApp) {
            $items->push($userResult->getCollection());
        }
        else {
            if ($userResult->total() > 0) {
                $mainIndex = $this->getPartialSearchFromIds($userResult, self::PARTIAL_MAIN_INDEX_TEMPLATE);
                $smsIndex  = $this->getPartialSearchFromIds($userResult, self::PARTIAL_SMS_INDEX_TEMPLATE);
//                $reportIndex = $this->getPartialSearchFromIds($userResult, self::PARTIAL_REPORT_INDEX_TEMPLATE);
            }
            else {
                $mainIndex   = null;
                $smsIndex    = null;
                $reportIndex = null;
            }
            
            $uniqueUsers = $userResult->getCollection()
                ->getUniqueUsers();
            
            $items->push([
                "totalitems"       => $userResult->total(),
                "totalUniqueItems" => $uniqueUsers->count(),
                "itemIds"          => $userResult->pluck("id"),
                "uniqueItemsIds"   => $uniqueUsers->pluck("id"),
                "mainIndex"        => $mainIndex,
                "smsIndex"         => $smsIndex,
                //                "reportIndex"  => $reportIndex,
            ]);
        }
        if ($isApp) {
            $response = $this->makeJsonForAndroidApp($items);
            
            return response()->json($response, Response::HTTP_OK);
        }
        if (request()->expectsJson()) {
            return response([
                "items" => $items,
            ], Response::HTTP_OK);
        }
        
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("مدیریت کاربران", "مدیریت کاربران سایت", $url, $url,
            route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));
        
        return redirect()->back();
    }
    
    /**
     * @param  Collection  $items
     *
     * @return Response
     */
    private function makeJsonForAndroidApp(Collection $items)
    {
        $items    = $items->pop();
        $key      = md5($items->pluck("id")
            ->implode(","));
        $response = Cache::remember($key, config("constants.CACHE_60"), function () use ($items) {
            $response = collect();
        });
        
        return $response;
    }

    public function store(InsertUserRequest $request)
    {
        try {
            $result = $this->new($request->all(), $request->user());
    
            if (isset($result['error'])) {
                $resultMessage = 'خطا در ذخیره کاربر';
                $resultCode    = Response::HTTP_INTERNAL_SERVER_ERROR;
            }
            else {
                $resultMessage = 'درج کاربر با موفقیت انجام شد';
                $resultCode    = Response::HTTP_OK;
                $savedUser     = $result['user'];
            }
            
            if ($resultCode == Response::HTTP_OK) {
                $responseContent = [
                    'user' => $savedUser ?? $savedUser,
                ];
            }
            else {
                $responseContent = [
                    'error' => [
                        'message' => $resultMessage,
                    ],
                ];
            }
            
            return response($responseContent, Response::HTTP_OK);
        } catch (\Exception    $e) {
            $message = 'unexpected error';
            
            return response([
                'message' => $message,
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * @param  array      $data
     * @param  User|null  $authenticatedUser
     *
     * @return array
     */
    public function new(array $data, User $authenticatedUser): array
    {
        $softDeletedUsers = User::onlyTrashed()
            ->where("mobile", $data["mobile"])
            ->where("nationalCode", $data["nationalCode"])
            ->get();
        
        if ($softDeletedUsers->isNotEmpty()) {
            $softDeletedUsers->first()
                ->restore();
            
            return response([], Response::HTTP_OK);
        }
        
        $user = new User();
        try {
            $this->fillUserFromRequest($data, $authenticatedUser, config('constants.INSERT_USER_ACCESS'), $user);
        } catch (FileNotFoundException $e) {
            return [
                "error" => true,
                "data"  => [
                    "resultCode" => Response::HTTP_INTERNAL_SERVER_ERROR,
                    "text"       => $e->getMessage(),
                    "line"       => $e->getLine(),
                    "file"       => $e->getFile(),
                ],
            ];
        }
        
        if (!$user->save()) {
            $resultText = 'Datebase error';
            $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
            $response   = [
                'error' => [
                    'code'    => $resultCode,
                    'message' => $resultText,
                ],
            ];
            
            return $response;
        }
        
        if ($user->checkUserProfileForLocking()) {
            $user->lockHisProfile();
        }

        if (in_array("roles", $data) && isset($data["roles"]) && $authenticatedUser->can(config('constants.INSET_USER_ROLE')))
        {
            $roles = $data['roles'];
            if(is_null($roles))
                $roles = [];

            $this->syncRoles($data["roles"], $user);
        }
        
        $resultText = 'User save successfully';
        $resultCode = Response::HTTP_OK;
        $response   = [
            'user' => $user,
        ];
        
        return $response;
    }
    
    /**
     * @param  array   $inputData
     * @param  User    $authenticatedUser
     *
     * @param  string  $moderatorPermission
     * @param  User    $user
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function fillUserFromRequest(array $inputData, User $authenticatedUser, string $moderatorPermission, User &$user): void
    {
        if ($authenticatedUser->can($moderatorPermission)) {
            // Checks both if $inputData has password index and it is not null
            $hasPassword = isset($inputData['password']);

            if ($hasPassword) {
                $user->password = bcrypt($inputData['password']);
            }

            Arr::pull($inputData , 'password') ;
            $user->fill($inputData);
            $hasMobileVerifiedAt = in_array('mobileNumberVerification', $inputData);

            if ($hasMobileVerifiedAt) {
                $user->mobile_verified_at = ($inputData['mobileNumberVerification'] == '1') ? Carbon::now()
                    ->setTimezone('Asia/Tehran') : null;
            }

            $user->lockProfile = array_get($inputData, 'lockProfile',
                (isset($user->lockProfile) ? $user->lockProfile : 0));
        }
        else {
            $user->fillByPublic($inputData);
        }
        
        $file = $this->getRequestFile($inputData, 'photo');
        if ($file !== false) {
            $this->storePhotoOfUser($user, $file);
        }
    }
    
    public function show(Request $request, User $user = null)
    {

        if ($user === null) {
            $user = $request->user();
        }
        
        
        /** @var User $autheiticatedUser */
        $autheiticatedUser = $request->user();
        if ($this->authenticatedUserCantSeeThisUser($autheiticatedUser, $user)) {
            abort(Response::HTTP_FORBIDDEN);
        }
        
        if ($request->expectsJson()) {
            return response($user, Response::HTTP_OK);
        }
        
        $genders     = Gender::pluck('name', 'id')
            ->prepend("نامشخص");
        $majors      = Major::pluck('name', 'id')
            ->prepend("نامشخص");
        $sideBarMode = "closed";

//        /** LOTTERY */
//        [
//            $exchangeAmount,
//            $userPoints,
//            $userLottery,
//            $prizeCollection,
//            $lotteryRank,
//            $lottery,
//            $lotteryMessage,
//            $lotteryName,
//        ] = $user->getLottery();
        
        $event            = Event::name('konkur97')
            ->first();
        $userKonkurResult = $user->eventresults->where("event_id", $event->id)
            ->first();
        
        $userCompletion = $user->info['completion'];

        
        return view("user.profile.profile",
            compact("user", 'event', 'userKonkurResult', 'genders', 'majors', 'sideBarMode',
                /*'exchangeAmount', 'userPoints', 'userLottery', 'prizeCollection', 'lotteryRank', 'lottery', 'lotteryMessage', 'lotteryName' , */
                'userKonkurResult', 'userCompletion'));
    }
    
    /**
     * @param  User  $authenticaedUser
     * @param  User  $user
     *
     * @return bool
     */
    private function authenticatedUserCantSeeThisUser(User $authenticaedUser, User $user): bool
    {
        return ($user->id !== $authenticaedUser->id) && !($authenticaedUser->can(config('constants.SHOW_USER_ACCESS')));
    }
    
    /**
     * Display a listing user's orders.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function userOrders(Request $request)
    {
//        $debitCard = Bankaccount::all()
//            ->where("user_id", 2)
//            ->first();

        /** @var User $user */
        $user = $request->user();
        
        $key    = "user:orders:".$user->cacheKey();
        $orders = Cache::tags('user')->remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->closedOrders()
                ->get()
//                ->append('created_at')
                ->sortByDesc("completed_at");
        });
        
        $key          = "user:transactions:".$user->cacheKey();
        $transactions = Cache::tags('user')->remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getShowableTransactions()
                ->get()
                ->groupBy("order_id");
        });
        
        $key         = "user:instalments:".$user->cacheKey();
        $instalments = Cache::tags('user')->remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getInstalments()
                ->get()
                ->sortBy("deadline_at");
        });
        
        $gatewaysCollection = Transactiongateway::enable()
            ->get()
            ->sortBy("order");

        $gateways = [];
        foreach ($gatewaysCollection as  $gateway){
            $gateways[route('redirectToBank', ['paymentMethod'=> $gateway->name, 'device'=>'web'])] = $gateway->displayName;
        }

        $key          = "user:orderCoupons:".$user->cacheKey().":Orders=".md5($orders->pluck("id")
                ->implode('-'));
        $orderCoupons = Cache::remember($key, config("constants.CACHE_60"), function () use ($orders) {
            return $orders->getCoupons();
        });

        return view("user.ordersList",
            compact("orders", "gateways", "debitCard", "transactions", "instalments", "orderCoupons"));
    }
    
    /**
     * Showing files to user which he has got for his orders
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function userProductFiles(Request $request)
    {
        return redirect()->route('web.user.dashboard', [$request->user()]);
    }
    
    /**
     * Filling product's pamphlets and videos collection ( called by reference )
     *
     * @param              $productArray
     * @param  Collection  $pamphlets
     * @param  Collection  $videos
     * @param  string      $mode
     */
    private function addVideoPamphlet($productArray, Collection &$pamphlets, Collection &$videos, $mode = "default")
    {
        if (empty($productArray)) {
            return false;
        }
        
        $videoArray    = [];
        $pamphletArray = [];
        foreach ($productArray as $product) {
            if ($this->productIsNeitherInArticlesNorInFilms($product, $pamphletArray, $videoArray)) {
                
                $pamphletArray = [];
                if (isset($pamphlets[$product->id])) {
                    $pamphletArray = $pamphlets[$product->id];
                }
                
                $videoArray = [];
                if (isset($videos[$product->id])) {
                    $videoArray = $videos[$product->id];
                }
                
                foreach ($product->validProductfiles as $productfile) {
                    if ($productfile->productfiletype_id == config("constants.PRODUCT_FILE_TYPE_PAMPHLET")) {
                        array_push($pamphletArray, [
                            "file"       => $productfile->file,
                            "name"       => $productfile->name,
                            "product_id" => $productfile->product_id,
                        ]);
                    }
                    else {
                        array_push($videoArray, [
                            "file"       => $productfile->file,
                            "name"       => $productfile->name,
                            "product_id" => $productfile->product_id,
                        ]);
                    }
                }
                
                if (!empty($pamphletArray)) {
                    $pamphlets->put($product->id, [
                        "productName" => $product->name,
                        "pamphlets"   => $pamphletArray,
                    ]);
                }
                
                if (!empty($videoArray)) {
                    $videos->put($product->id, [
                        "productName" => $product->name,
                        "videos"      => $videoArray,
                    ]);
                }
            }
            
            if ($mode == "digChildren") {
                $this->addVideoPamphlet($product->children, $pamphlets, $videos);
            }
            
            $this->addVideoPamphlet($product->complimentaryproducts, $pamphlets, $videos);
        }
    }
    
    /**
     * @param         $product
     * @param  array  $pamphletArray
     * @param  array  $videoArray
     *
     * @return bool
     */
    private function productIsNeitherInArticlesNorInFilms($product, array $pamphletArray, array $videoArray): bool
    {
        return !in_array($product->id, $pamphletArray) && !in_array($product->id, $videoArray);
    }
    
    /**
     * Show authenticated user belongings
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function showBelongings(Request $request)
    {
        $user        = $request->user();
        $belongings  = $user->belongings;
        $sideBarMode = "closed";
        
        return view("user.belongings", compact("belongings", "sideBarMode", "user"));
    }
    
    /**
     * Showing a survey to user to take part in
     *
     * @return Response
     */
    public function showSurvey()
    {
        // return redirect(action("Web\HomeController@error404"));
        $event   = Event::FindOrFail(1);
        $surveys = $event->surveys;
        foreach ($surveys as $survey) {
            $questions     = $survey->questions->sortBy("pivot.order");
            $questionsData = collect();
            $answersData   = collect();
            $this->getQuestionsAndAnswerData($questions, $event, $survey, $answersData, $questionsData);
        }
        $pageName = "showSurvey";
        
        return view("survey.show", compact("event", "survey", "questions", "questionsData", "answersData", "pageName"));
    }
    
    /**
     * @param                                  $questions
     * @param                                  $event
     * @param  Survey                     $survey
     * @param  Collection                      $answersData
     * @param  Collection                      $questionsData
     */
    private function getQuestionsAndAnswerData($questions, $event, Survey $survey, Collection &$answersData, Collection &$questionsData): void
    {
        foreach ($questions as $question) {
            $requestBaseUrl = $question->dataSourceUrl;
            /**
             * Getting raw answer
             */
            $this->getRawAnswer($event, $survey, $answersData, $question, $requestBaseUrl);
            /**
             *  Making questions
             */
            $this->makeQuestions($questionsData, $question, $requestBaseUrl);
        }
    }
    
    /**
     * @param                                  $event
     * @param  Survey                     $survey
     * @param  Collection                      $answersData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function getRawAnswer($event, Survey $survey, Collection &$answersData, $question, $requestBaseUrl): void
    {
        $requestUrl    = action("Web\UserSurveyAnswerController@index");
        $requestUrl    .= "?event_id[]=".$event->id."&survey_id[]=".$survey->id."&question_id[]=".$question->id;
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response          = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $questionAnswerArray = [];
        foreach ($answersCollection as $answerCollection) {
            /** Making answers */
            $answerArray   = $answerCollection->userAnswer->answer;
            $requestUrl    = url("/").$requestBaseUrl."?ids=$answerArray";
            $originalInput = \Illuminate\Support\Facades\Request::input();
            $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            foreach ($dataJson as $data) {
                $questionAnswerArray = array_add($questionAnswerArray, $data->id, $data->name);
            }
        }
        $answersData->put($question->id, $questionAnswerArray);
    }
    
    /**
     * @param  Collection                      $questionsData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function makeQuestions(Collection &$questionsData, $question, $requestBaseUrl): void
    {
        if (strpos($question->dataSourceUrl, "major") !== false) {
            $this->getQusetionDataInMajorStatus($questionsData, $question, $requestBaseUrl);
        }
        elseif (strpos($question->dataSourceUrl, "city") !== false) {
            $this->getQuestionDataInCityStatus($questionsData, $question, $requestBaseUrl);
        }
    }
    
    /**
     * @param  Collection                      $questionsData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function getQusetionDataInMajorStatus(Collection &$questionsData, $question, $requestBaseUrl): void
    {
        $userMajor  = Auth()->user()->major;
        $userMajors = $this->getUserMajors($userMajor);
        $requestUrl = url("/").$requestBaseUrl."?";
        foreach ($userMajors as $major) {
            $requestUrl .= "&parents[]=$major";
        }
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response = Route::dispatch($request);
        $dataJson = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $rootMajorArray = [];
        $majorsArray    = [];
        foreach ($dataJson as $item) {
            $majorsArray = array_add($majorsArray, $item->id, $item->name);
        }
        $rootMajorArray = array_add($rootMajorArray, $userMajor->name, $majorsArray);
        $questionsData->put($question->id, $rootMajorArray);
    }
    
    /**
     * @param $userMajor
     *
     * @return array|Collection
     */
    private function getUserMajors($userMajor)
    {
        $userMajors = collect();
        $userMajors->push($userMajor);
        foreach ($userMajors as $major) {
            $accessibleMajors = $major->accessibles;
            foreach ($accessibleMajors as $accessibleMajor) {
                $userMajors->push($accessibleMajor);
            }
        }
        $userMajors = $userMajors->pluck('id')
            ->toArray();
        
        return $userMajors;
    }
    
    /**
     * @param  Collection                      $questionsData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function getQuestionDataInCityStatus(Collection &$questionsData, $question, $requestBaseUrl): void
    {
        $provinces         = Province::orderBy("name")
            ->get();
        $provinceCityArray = [];
        foreach ($provinces as $province) {
            $requestUrl    = url("/").$requestBaseUrl."?provinces[]=$province->id";
            $originalInput = \Illuminate\Support\Facades\Request::input();
            $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            $citiesArray = [];
            foreach ($dataJson as $item) {
                $citiesArray = array_add($citiesArray, $item->id, $item->name);
            }
            $provinceCityArray = array_add($provinceCityArray, $province->name, $citiesArray);
            $questionsData->put($question->id, $provinceCityArray);
        }
    }

    public function edit($user)
    {
        $majors       = Major::pluck('name', 'id')
            ->toArray();
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $roles        = Role::pluck('display_name', 'id')
            ->toArray();
        $userRoles    = $user->roles()
            ->pluck('id')
            ->toArray();
        $genders      = Gender::pluck('name', 'id')
            ->toArray();
        
        return view("user.edit", compact("user", "majors", "userStatuses", "roles", "userRoles", "genders"));
    }

    public function destroy($user)
    {
        $user->delete();
        
        return redirect()->back();
    }
    
    /**
     * Show the form for completing information of the specified resource.(Created for orduatalaee 97)
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function informationPublicUrl(Request $request)
    {
        return redirect(action("Web\UserController@information", $request->user()), 301);
    }
    
    /**
     * Show the form for completing information of the specified resource.(Created for orduatalaee 97)
     *
     * @param  User  $user
     *
     * @return Factory|\Illuminate\View\View
     */
    public function information(User $user)
    {
        $validOrders = $user->orders()
            ->whereHas("orderproducts", function ($q) {
                /** @var QueryBuilder $q */
                $q->whereIn("product_id", config("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT"))
                    ->orwhereIn("product_id",
                        config("constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT"))
                    ->orwhereIn("product_id", [
                        199,
                        202,
                    ]);
            })
            ->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED")]);
        
        if ($validOrders->get()
            ->isEmpty()) {
            return redirect(action("Web\ProductController@landing2"));
        }
        $unPaidOrders = $validOrders->get();
        $paidOrder    = $validOrders->whereIn("paymentstatus_id", [
            config("constants.PAYMENT_STATUS_PAID"),
            config("constants.PAYMENT_STATUS_INDEBTED"),
        ])
            ->get();
        
        $order = $unPaidOrders->first();
        
        if (is_null($order)) {
            $order = $paidOrder->first();
        }
        
        if (!isset($order)) {
            abort(403);
        }
        
        $orderproduct = $order->orderproducts(config("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
            ->get()
            ->first();
        /** @var Product $product */
        $product                 = $orderproduct->product;
        $userHasMedicalQuestions = false;
        if (in_array($product->id, config("constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT"))) {
            $userHasMedicalQuestions = true;
        }
        $userProduct = $product->name;
        $grandParent = $product->grandParent;
        if (isset($grandParent)) {
            $userProduct = $grandParent->name;
        }
        
        $simpleContact   = Contacttype::where("name", "simple")
            ->get()
            ->first();
        $mobilePhoneType = Phonetype::where("name", "mobile")
            ->get()
            ->first();
        $parents         = Relative::whereIn("name", [
            "father",
            "mother",
        ])
            ->get();
        $parentsNumber   = collect();
        foreach ($parents as $parent) {
            /** @var Collection|Contact $parentContacts */
            $parentContacts = $user->contacts->where("relative_id", $parent->id)
                ->where("contacttype_id", $simpleContact->id);
            if ($parentContacts->isEmpty()) {
                continue;
            }
            
            $parentContact = $parentContacts->first();
            $parentMobiles = $parentContact->phones->where("phonetype_id", $mobilePhoneType->id)
                ->sortBy("priority");
            if ($parentMobiles->isEmpty()) {
                continue;
            }
            
            $parentMobile = $parentMobiles->first()->phoneNumber;
            $parentsNumber->put($parent->name, $parentMobile);
        }
        $majors    = Major::pluck('name', 'id')
            ->toArray();
        $majors[0] = "نامشخص";
        $majors    = array_sort_recursive($majors);
        /////////////////////////////////////////
        $genders    = Gender::pluck('name', 'id')
            ->toArray();
        $genders[0] = "نامشخص";
        $genders    = array_sort_recursive($genders);
        ///////////////////////
        $bloodTypes    = Bloodtype::pluck('name', 'id')
            ->toArray();
        $bloodTypes[0] = "نامشخص";
        $bloodTypes    = array_sort_recursive($bloodTypes);
        //////////////////////////
        $grades     = Grade::pluck('displayName', 'id')
            ->toArray();
        $grades[0]  = "نامشخص";
        $grades     = array_sort_recursive($grades);
        $orderFiles = $order->files;
        
        //////////Lock fields//////////
        $lockedFields = [];
        if ($user->lockProfile) {
            $lockedFields = $user->returnLockProfileItems();
        }
        if ($userHasMedicalQuestions) {
            $completionFields      = $user->returnCompletionItems();
            $completionFieldsCount = count($completionFields);
            $completionPercentage  = (int) $user->completion("completeInfo");
        }
        else {
            $completionFields      = array_diff($user->returnCompletionItems(), $user->returnMedicalItems());
            $completionFieldsCount = count($completionFields);
            $completionPercentage  = (int) $user->completion("custom", $completionFields);
        }
        
        $completedFieldsCount = (int) ceil(($completionPercentage * $completionFieldsCount) / 100);
        if ($orderFiles->isNotEmpty()) {
            $completedFieldsCount++;
        }
        $completionFieldsCount++;
        
        if (isset($order->customerExtraInfo)) {
            $customerExtraInfo = json_decode($order->customerExtraInfo);
            foreach ($customerExtraInfo as $item) {
                if (isset($item->info) && strlen(preg_replace('/\s+/', '', $item->info)) > 0) {
                    $completedFieldsCount++;
                }
                $completionFieldsCount++;
            }
        }
        
        if (isset($parentsNumber["father"])) {
            $completedFieldsCount++;
        }
        $completionFieldsCount++;
        
        if (isset($parentsNumber["mother"])) {
            $completedFieldsCount++;
        }
        $completionFieldsCount++;
        
        $completionPercentage = (int) (($completedFieldsCount / $completionFieldsCount) * 100);
        
        if ($completionPercentage == 100 && $user->completion("lockProfile") == 100) {
            $user->lockHisProfile();
            $user->updateWithoutTimestamp();
        }
        
        return view("user.completeInfo",
            compact("user", "parentsNumber", "majors", "genders", "bloodTypes", "grades", "userProduct", "order",
                "orderFiles", "userHasMedicalQuestions",
                "lockedFields", "completionPercentage", "customerExtraInfo"));
    }
    
    /**
     * Display a page where user can upaload his consulting questions
     *
     * @return Response
     */
    public function uploadConsultingQuestion()
    {
        return view("user.uploadConsultingQuestion");
    }
    
    /**
     * Display the list of uploaded files by user
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function uploads(Request $request)
    {
        $questions = $request->user()->useruploads->where("isEnable", "1");
        $counter   = 1;
        
        return view("user.consultingQuestions", compact("questions", "counter"));
    }
    
    /**
     * Send system generated password to the user that does not belong to anyone
     *
     * @param  PasswordRecoveryRequest  $request
     *
     * @return Response
     */
    public function sendGeneratedPassword(PasswordRecoveryRequest $request)
    {
        //uncomment and put permission to extend the code
        $mobile = $request->get("mobileNumber");
        if (isset($mobile)) {
            $users = User::all()
                ->where("mobile", $mobile);
            if ($users->isEmpty()) {
                session()->put("error", "شماره موبایل وارد شده اشتباه می باشد!");
                
                return redirect()->back();
            }
            $user = $users->first();
        }
        
        if (!isset($user)) {
            if (!Auth::check()) {
                return redirect(action("Web\HomeController@error403"));
            }
            $user = $request->user();
        }
        
        $now            = Carbon::now();
        $tooManyAttempt = $this->checkTooManyAttemptsMadeForRegeneratePassword($user, $now);
        if ($tooManyAttempt == 'min' || $tooManyAttempt == 'sec') {
            if ($tooManyAttempt == 'min') {
                $timeInterval = $now->diffInMinutes(Carbon::parse($user->passwordRegenerated_at))." دقیقه ";
            }
            elseif ($tooManyAttempt == 'sec') {
                $timeInterval = $now->diffInSeconds(Carbon::parse($user->passwordRegenerated_at))." ثانیه ";
            }
            session()->put("warning",
                "شما پس از گذشت ۵ دقیقه از آخرین درخواست خود می توانید دوباره درخواست ارسال رمز عبور نمایید .از زمان ارسال آخرین پیامک تایید برای شما ".$timeInterval."می گذرد.");
            
            return redirect()->back();
        }
        //        $password = $this->generateRandomPassword(4);
        $password       = [
            "rawPassword"  => $user->nationalCode,
            "hashPassword" => bcrypt($user->nationalCode),
        ];
        $user->password = $password["hashPassword"];
        
        /**
         * Sending auto generated password through SMS
         */
        throw new Exception("sendGeneratedPassword: implement sms Send!");
        //          $response = array("error"=>false , "message"=>"ارسال موفقیت آمیز بود");
        if (!$response["error"]) {
            $user->passwordRegenerated_at = Carbon::now();
            session()->put("success",
                "پیامک حاوی رمز عبور شما با موفقیت به شماره موبایلتان ارسال شد . در صورت عدم دریافت پیامک پس از ۵ دقیقه می توانید دوباره درخواست ارسال رمز عبور  نمایید");
        }
        else {
            $user->passwordRegenerated_at = null;
            session()->put("error",
                "ارسال پیامک حاوی رمز عبور با مشکل مواجه شد! لطفا دوباره درخواست ارسال پیامک نمایید.");
        }
        $user->update();
        
        return redirect()->back();
    }
    
    /**
     * @param $user
     * @param $now
     *
     * @return bool|string
     */
    private function checkTooManyAttemptsMadeForRegeneratePassword($user, $now)
    {
        if (isset($user->passwordRegenerated_at) && $now->diffInMinutes(Carbon::parse($user->passwordRegenerated_at)) < config('constants.GENERATE_PASSWORD_WAIT_TIME')) {
            if ($now->diffInMinutes(Carbon::parse($user->passwordRegenerated_at)) > 0) {
                return 'min';
            }
            
            return 'sec';
        }
        
        return false;
    }
    
    /**
     * Showing the form to the user for adding extra information after registeration
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function completeRegister(Request $request)
    {
        if ($request->has("redirectTo")) {
            $targetUrl = $request->get("redirectTo");
        }
        else {
            $targetUrl = action("Web\IndexPageController");
        }
        
        if ($request->user()
                ->completion("afterLoginForm") == 100) {
            return redirect($targetUrl);
        }
        
        $previousPath = url()->previous();
        if (strcmp($previousPath, route('login')) == 0) {
            $formByPass = false;
            $note       = "برای ورود به سایت لطفا اطلاعات زیر را تکمیل نمایید";
        }
        else {
            $formByPass = true;
            $note       = "برای استفاده از این خدمت سایت لطفا اطلاعات زیر را تکمیل نمایید";
        }
        
        $formFields = Afterloginformcontrol::getFormFields();
        $tables     = [];
        foreach ($formFields as $formField) {
            if (!strpos($formField->name, "_id")) {
                continue;
            }
            $tableName                = $formField->name;
            $tableName                = str_replace("_id", "s", $tableName);
            $tables[$formField->name] = DB::table($tableName)
                ->pluck('name', 'id');
        }
        
        return view("user.completeRegister", compact("formFields", "note", "formByPass", "tables"));
    }
    
    /**
     * Storing user's work time (for employees)
     *
     * @param  Request                      $request
     * @param  EmployeetimesheetController  $employeetimesheetController
     * @param  HomeController               $homeController
     *
     * @return Response
     */
    public function submitWorkTime(Request $request, EmployeetimesheetController $employeetimesheetController, HomeController $homeController)
    {
        $actionMap = [
            'action-clockIn'          => 'clockIn',
            'action-beginLunchBreak'  => 'beginLunchBreak',
            'action-finishLunchBreak' => 'finishLunchBreak',
            'action-clockOut'         => 'clockOut',
        ];
        if ($request->has('action') && isset($actionMap[$request->get('action')])) {
            $presentTime = Carbon::now('Asia/Tehran')
                ->format('H:i:s');
            $request->offsetSet($actionMap[$request->get('action')], $presentTime);
        }
        
        $userId = Auth::user()->id;
        $request->offsetSet('user_id', $userId);
        $request->offsetSet('date', Carbon::today('Asia/Tehran')
            ->format('Y-m-d'));
        
        $toDayJalali      = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
            ->format('l'));
        $employeeSchedule = Employeeschedule::where('user_id', $userId)
            ->where('day', $toDayJalali)
            ->get()
            ->first();
        if (isset($employeeSchedule)) {
            $request->offsetSet('userBeginTime', $employeeSchedule->getOriginal('beginTime'));
            $request->offsetSet('userFinishTime', $employeeSchedule->getOriginal('finishTime'));
            $request->offsetSet('allowedLunchBreakInSec',
                gmdate('H:i:s', $employeeSchedule->getOriginal('lunchBreakInSeconds')));
        }
        
        $request->offsetSet('modifier_id', $userId);
        $request->offsetSet('serverSide', true);
        $insertRequest  = new InsertEmployeeTimeSheet($request->all());
        $userTimeSheets = Employeetimesheet::where('date', Carbon::today('Asia/Tehran'))
            ->where('user_id', Auth::user()->id)
            ->get();
        if ($userTimeSheets->count() == 0) {
            $done = $employeetimesheetController->store($insertRequest);
        }
        elseif ($userTimeSheets->count() == 1) {
            $done = $employeetimesheetController->update($insertRequest, $userTimeSheets->first());
        }
        else {
            $message = 'شما بیش از یک ساعت کاری برای امروز ثبت نموده اید!';
            
            return $homeController->errorPage($message);
        }
        if ($done) {
            session()->flash('success', 'ساعت کاری با موفقیت ذخیره شد');
        }
        else {
            session()->flash('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }
    
    /**
     * Removes user from lottery
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function removeFromLottery(Request $request)
    {
        $user    = $request->user();
        $message = "";
        
        $bonName = config("constants.BON2");
        $bon     = Bon::where("name", $bonName)
            ->first();
        if (isset($bon)) {
            $userbons = $user->userValidBons($bon);
            list($usedUserBon, $userBonTaken, $done) = $this->checkUserBonsForLottery($user, $message, $userbons);
        }
        else {
            $done    = false;
            $message = "خطای غیر منتظره . لطفا بعدا اقدام فرمایید";
        }
        
        if ($done) {
            return $this->makeResponseForRemoveFromLotteryMethod(Response::HTTP_OK, "OK");
        }
        
        if (!isset($userBonTaken) || !$userBonTaken) {
            return $this->makeResponseForRemoveFromLotteryMethod(Response::HTTP_SERVICE_UNAVAILABLE, $message);
        }
        
        foreach ($userbons as $userbon) {
            if (isset($usedUserBon[$userbon->id])) {
                $usedNumber                = $usedUserBon[$userbon->id]["used"];
                $userbon->usedNumber       = max($userbon->usedNumber - $usedNumber, 0);
                $userbon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
            }
            else {
                $userbon->usedNumber       = 0;
                $userbon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
            }
            
            $userbon->update();
        }
        
        return $this->makeResponseForRemoveFromLotteryMethod(Response::HTTP_SERVICE_UNAVAILABLE, $message);
    }
    
    private function checkUserBonsForLottery($user, string &$message, $userbons): array
    {
        $done = false;
        if (!$userbons->isNotEmpty()) {
            $message = "شما در قرعه کشی نیستید";
            return [null, null, $done];
        }
        
        list($usedUserBon, $sumBonNumber) = $this->getUsedUserBon($userbons);
        $userBonTaken = true;
        [
            $result,
            $responseText,
            $prizeName,
            $walletId,
        ] = $this->exchangeLottery($user, $sumBonNumber);
        
        if (!$result) {
            $message = $responseText;
            return [$usedUserBon, $userBonTaken, $done];
        }
        $lottery = Lottery::where("name", config("constants.LOTTERY_NAME"))
            ->first();
        
        if (!isset($lottery)) {
            $message = "خطای غیر منتظره. لطفا بعدا دوباره اقدام نمایید";
            return [$usedUserBon, $userBonTaken, $done];
        }
        $prizes = '{
                      "items": [
                        {
                          "name": "'.$prizeName.'",
                          "objectType": "App\\\\Wallet",
                          "objectId": "'.$walletId.'"
                        }
                      ]
                    }';
        if ($user->lotteries()
            ->where("lottery_id", $lottery->id)
            ->get()
            ->isEmpty()) {
            $attachResult = $user->lotteries()
                ->attach($lottery->id, [
                    "rank"   => 0,
                    "prizes" => $prizes,
                ]);
            
            /**  clearing cache */
            Cache::tags('bon')
                ->flush();
            $done = true;
        }
        else {
            $message = "شما قبلا از قرعه کشی انصراف داده اید";
        }
        
        return [$usedUserBon, $userBonTaken, $done];
    }
    
    /**
     * @param $userbons
     *
     * @return array
     */
    private function getUsedUserBon($userbons): array
    {
        $usedUserBon  = collect();
        $sumBonNumber = 0;
        foreach ($userbons as $userbon) {
            $totalBonNumber = $userbon->totalNumber - $userbon->usedNumber;
            $usedUserBon->put($userbon->id, ["used" => $totalBonNumber]);
            $sumBonNumber              += $totalBonNumber;
            $userbon->usedNumber       = $userbon->usedNumber + $totalBonNumber;
            $userbon->userbonstatus_id = config("constants.USERBON_STATUS_USED");
            $userbon->update();
        }
        
        return [$usedUserBon, $sumBonNumber];
    }
    
    /**
     * @param  int     $httpStatus
     * @param  string  $message
     *
     * @return ResponseFactory|Response
     */
    private function makeResponseForRemoveFromLotteryMethod(int $httpStatus, string $message)
    {
        return response([
            ["message" => $message],
        ], $httpStatus);
    }
    
    /**
     * Store the complentary information of specified resource in storage.
     *
     * @param  User               $user
     *
     * @param  Request            $request
     * @param  UserController     $userController
     * @param  PhoneController    $phoneController
     * @param  ContactController  $contactController
     * @param  OrderController    $orderController
     *
     * @return Response
     * @throws FileNotFoundException
     * @throws ValidationException
     */
    public function completeInformation(
        User $user,
        Request $request,
        UserController $userController,
        PhoneController $phoneController,
        ContactController $contactController,
        OrderController $orderController
    )
    {
        
        $request->offsetSet("phone", $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("phone"))));
        $request->offsetSet("postalCode",
            $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("postalCode"))));
        $parentMobiles = [
            'father' => $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("parentMobiles")["father"])),
            'mother' => $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("parentMobiles")["mother"])),
        ];
        $request->offsetSet("parentMobiles", $parentMobiles);
        
        $mapConvertToEnglish = [
            'school',
            'allergy',
            'medicalCondition',
            'diet',
            'introducer',
        ];
        foreach ($mapConvertToEnglish as $item) {
            $request->offsetSet($item, $this->convertToEnglish($request->get($item)));
        }
        
        $this->validate($request, [
            'photo' => 'image|mimes:jpeg,jpg,png|max:200',
            'file'  => 'mimes:jpeg,jpg,png,zip,pdf,rar',
        ]);
        if ($request->user()->id != $user->id) {
            abort(403);
        }
        if ($request->has("order")) {
            $orderId = $request->get("order");
            $order   = Order::FindOrFail($orderId);
            if ($order->user_id != $request->user()->id) {
                abort(403);
            }
        }
        else {
            return response([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * User's basic info
         **/
        $editUserRequest = new EditUserRequest();
        if ($request->hasFile("photo")) {
            $editUserRequest->offsetSet("photo", $request->file("photo"));
        }
        $editUserRequestMap = [
            'province',
            'address',
            'postalCode',
            'city',
            'school',
            'major_id',
            'grade_id',
            'gender_id',
            'bloodtype_id',
            'phone',
            'allergy',
            'medicalCondition',
            'diet',
        ];
        foreach ($editUserRequestMap as $item) {
            if ($request->get($item) != 0) {
                $editUserRequest->offsetSet($item, $request->get($item));
            }
        }
        $userController->update($editUserRequest, $user);
        
        /**
         *
         */
        /**
         * Parent's basic info
         **/
        $simpleContact   = Contacttype::where("name", "simple")
            ->get()
            ->first();
        $mobilePhoneType = Phonetype::where("name", "mobile")
            ->get()
            ->first();
        $parentsNumber   = $request->get("parentMobiles");
        
        foreach ($parentsNumber as $relative => $mobile) {
            if (strlen(preg_replace('/\s+/', '', $mobile)) == 0) {
                continue;
            }
            $parent         = Relative::where("name", $relative)
                ->get()
                ->first();
            $parentContacts = $user->contacts->where("relative_id", $parent->id)
                ->where("contacttype_id", $simpleContact->id);
            if ($parentContacts->isEmpty()) {
                $storeContactRequest = new InsertContactRequest();
                $storeContactRequest->offsetSet("name", $relative);
                $storeContactRequest->offsetSet("user_id", $user->id);
                $storeContactRequest->offsetSet("contacttype_id", $simpleContact->id);
                $storeContactRequest->offsetSet("relative_id", $parent->id);
                $storeContactRequest->offsetSet("isServiceRequest", true);
                $response = $contactController->store($storeContactRequest);
                if ($response->getStatusCode() == 200) {
                    $responseContent = json_decode($response->getContent("contact"));
                    $parentContact   = $responseContent->contact;
                }
            }
            else {
                $parentContact = $parentContacts->first();
            }
            if (!isset($parentContact)) {
                continue;
            }
            $parentContact = Contact::where("id", $parentContact->id)
                ->get()
                ->first();
            $parentMobiles = $parentContact->phones->where("phonetype_id", $mobilePhoneType->id)
                ->sortBy("priority");
            if ($parentMobiles->isEmpty()) {
                $storePhoneRequest = new InsertPhoneRequest();
                $storePhoneRequest->offsetSet("phoneNumber", $mobile);
                $storePhoneRequest->offsetSet("contact_id", $parentContact->id);
                $storePhoneRequest->offsetSet("phonetype_id", $mobilePhoneType->id);
                $response = $phoneController->store($storePhoneRequest);
                $response->getStatusCode();
            }
            else {
                $parentMobile              = $parentMobiles->first();
                $parentMobile->phoneNumber = $mobile;
                $parentMobile->update();
            }
        }
        
        $updateOrderRequest = new EditOrderRequest();
        if ($request->hasFile("file")) {
            $updateOrderRequest->offsetSet("file", $request->file("file"));
        }
        /**
         * customerExtraInfo
         */
        $jsonConcats              = "";
        $extraInfoQuestions       = array_sort_recursive($request->get("customerExtraInfoQuestion"));
        $customerExtraInfoAnswers = $request->get("customerExtraInfoAnswer");
        foreach ($extraInfoQuestions as $key => $question) {
            $obj        = new stdClass();
            $obj->title = $question;
            $obj->info  = null;
            if (strlen(preg_replace('/\s+/', '', $customerExtraInfoAnswers[$key])) > 0) {
                $obj->info = $customerExtraInfoAnswers[$key];
            }
            if (strlen($jsonConcats) > 0) {
                $jsonConcats = $jsonConcats.','.json_encode($obj, JSON_UNESCAPED_UNICODE);
            }
            else {
                $jsonConcats = json_encode($obj, JSON_UNESCAPED_UNICODE);
            }
        }
        $customerExtraInfo = "[".$jsonConcats."]";
        $updateOrderRequest->offsetSet("customerExtraInfo", $customerExtraInfo);
        $orderController->update($updateOrderRequest, $order);
        
        session()->put("success", "اطلاعات با موفقیت ذخیره شد");
        
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * Note: Requests to this method must pass \App\Http\Middleware\trimUserRequest middle ware
     *
     * @param EditUserRequest $request
     * @param User $user
     *
     * @return array|Response
     */
    public function update(EditUserRequest $request, User $user = null)
    {
        $authenticatedUser = $request->user();
        if ($user === null) {
            $user = $authenticatedUser;
        }

        if($user->isUserProfileLocked() && !$authenticatedUser->can(config('constants.EDIT_USER_ACCESS')))
            return response(['message'=>'User profile is locked'] , Response::HTTP_LOCKED);
        
        try {
            $this->fillUserFromRequest($request->all(), $authenticatedUser, config('constants.EDIT_USER_ACCESS'),
                $user);
        } catch (FileNotFoundException $e) {
            return response([
                "error" => [
                    "text" => $e->getMessage(),
                    "line" => $e->getLine(),
                    "file" => $e->getFile(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //ToDo : place in UserObserver
        if ($user->checkUserProfileForLocking()) {
            $user->lockHisProfile();
        }
        
        if ($user->update()) {

            if ($request->has('roles') && $authenticatedUser->can(config('constants.INSET_USER_ROLE'))) {
                $roles = $request->get('roles');
                if(is_null($roles))
                    $roles=[];

                $this->syncRoles($roles, $user);
            }
            
            $message = 'اطلاعات با موفقیت اصلاح شد';
            $status  = Response::HTTP_OK;
        }
        else {
            $message = 'Database error on updating user';
            $status  = Response::HTTP_SERVICE_UNAVAILABLE;
        }

        Cache::tags('user')->flush();

        if ($request->expectsJson()) {
            if ($status == Response::HTTP_OK) {
                $response = [
                    'user'    => $user,
                    'message' => $message,
                ];
            }
            else {
                $response = [
                    'error' => [
                        'code'    => $status,
                        'message' => $message,
                    ],
                ];
            }
            
            return response($response, Response::HTTP_OK);
        }
        else {
            session()->flash('success' , $message);
            return redirect()->back();
        }
    }
    
    /**
     * Register student for sanati sharif highschool
     *
     * @param  RegisterForSanatiSharifHighSchoolRequest  $request
     * @param  EventresultController                     $eventResultController
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function registerForSanatiSharifHighSchool(RegisterForSanatiSharifHighSchoolRequest $request, EventresultController $eventResultController)
    {
        $event = Event::where("name", "sabtename_sharif_97")
            ->get();
        if ($event->isEmpty()) {
            session()->put("error", "رخداد یافت نشد");
            
            return redirect()->back();
        }
        else {
            $event = $event->first();
        }
        
        if (Auth::check()) {
            $user = $request->user();
        }
        else {
            $registeredUser = User::where("mobile", $request->get("mobile"))
                ->where("nationalCode", $request->get("nationalCode"))
                ->get();
        }
        
        if (!isset($user) && $registeredUser->isEmpty()) {
            $registerRequest = new Request();
            $registerRequest->offsetSet("firstName", $request->get("firstName"));
            $registerRequest->offsetSet("lastName", $request->get("lastName"));
            $registerRequest->offsetSet("mobile", $request->get("mobile"));
            $registerRequest->offsetSet("nationalCode", $request->get("nationalCode"));
            $registerRequest->offsetSet("major_id", $request->get("major_id"));
            $registerRequest->offsetSet("grade_id", $request->get("grade_id"));
            //            $registerRequest->offsetSet("gender_id", 1);
            $registerController = new RegisterController();
            $response           = $registerController->register($registerRequest);
            if ($response->getStatusCode() != 302) {
                session()->put("error", "خطایی در ثبت اطلاعات شما اتفاق افتاد . لطفا دوباره اقدام نمایید.");
                
                return redirect()->back();
            }
            $user = $request->user();
        }
        else {
            if (!isset($user)) {
                $user = $registeredUser->first();
            }
            $updateRequest = new EditUserRequest();
            if ($request->has("firstName") && (!isset($user->firstName) || strlen(preg_replace('/\s+/', '',
                        $user->firstName)) == 0)) {
                $updateRequest->offsetSet("firstName", $request->get("firstName"));
            }
            if ($request->has("lastName") && (!isset($user->lastName) || strlen(preg_replace('/\s+/', '',
                        $user->lastName)) == 0)) {
                $updateRequest->offsetSet("lastName", $request->get("lastName"));
            }
            $updateRequest->offsetSet("major_id", $request->get("major_id"));
            $updateRequest->offsetSet("grade_id", $request->get("grade_id"));
            RequestCommon::convertRequestToAjax($updateRequest);
            $response = $this->update($updateRequest, $user);
            if ($response->getStatusCode() == 503) {
                session()->put("error", "خطایی در ثبت اطلاعات شما رخ داد. لطفا مجددا اقدام نمایید");
                
                return redirect()->back();
            }
        }
        
        $eventRegistered = $user->eventresults->where("user_id", $user->id)
            ->where("event_id", $event->id);
        if ($eventRegistered->isNotEmpty()) {
            session()->put("error", "شما قبلا ثبت نام کرده اید");
            
            return redirect()->back();
        }
        else {
            $evenResultRequest = new InsertEventResultRequest();
            $evenResultRequest->offsetSet("user_id", $user->id);
            $evenResultRequest->offsetSet("event_id", $event->id);
            $evenResultRequest->offsetSet("participationCodeHash", $request->get("score"));
            RequestCommon::convertRequestToAjax($evenResultRequest);
            $response = $eventResultController->store($evenResultRequest);
            if ($response->getStatusCode() == 503) {
                session()->put("error", "خطایی در ثبت نام شما رخ داد. لطفا مجددا اقدام نمایید");
                
                return redirect()->back();
            }
            else {
                //                $result = json_decode($response->getContent());
                //                if(isset($result->participationCode))
                //                    $participationCode = $result->participationCode;
            }
        }
        
        $message = "پیش ثبت نام شما در دبیرستان دانشگاه صنعتی شریف با موفقیت انجام شد .";
        if (isset($participationCode)) {
            $message .= "کد داوطلبی شما: ".$participationCode;
        }
        session()->put("success", $message);
        
        return redirect()->back();
    }
    
    /**
     * Submit user request for voucher request
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function voucherRequest(Request $request)
    {
        $url   = $request->url();
        $title = "آلاء| درخواست اینترنت آسیاتک";
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()
            ->addImage(route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), [
                'height' => 100,
                'width'  => 100,
            ]);
        
        $user        = $request->user();
        $genders     = Gender::pluck('name', 'id')
            ->prepend("انتخاب کنید");
        $majors      = Major::pluck('name', 'id')
            ->prepend("انتخاب کنید");
        $sideBarMode = "closed";
        
        $asiatechProduct   = config("constants.ASIATECH_FREE_ADSL");
        $nowDateTime       = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
            ->timezone('Asia/Tehran');
        $userHasRegistered = false;
        
        $asitechPendingOrders     = Order::whereHas("orderproducts", function ($q) use ($asiatechProduct) {
            $q->where("product_id", $asiatechProduct);
        })
            ->where("orderstatus_id", config("constants.ORDER_STATUS_PENDING"))
            ->where("paymentstatus_id",
                config("constants.PAYMENT_STATUS_PAID"))
            ->orderBy("completed_at")
            ->get();
        $userAsitechPendingOrders = $asitechPendingOrders->where("user_id", $user->id);
        if ($userAsitechPendingOrders->isNotEmpty()) {
            $rank = $userAsitechPendingOrders->keys()
                    ->first() + 1;
            
            $userHasRegistered = true;
        }
        else {
            $asitechApprovedOrders = $user->orders()
                ->whereHas("orderproducts", function ($q) use ($asiatechProduct) {
                    $q->where("product_id", $asiatechProduct);
                })
                ->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                ->where("paymentstatus_id",
                    config("constants.PAYMENT_STATUS_PAID"))
                ->orderBy("completed_at")
                ->get();
            if ($asitechApprovedOrders->isNotEmpty()) {
                $userVoucher = $user->productvouchers->where("expirationdatetime", ">", $nowDateTime)
                    ->where("product_id", $asiatechProduct)
                    ->first();
                
                $userHasRegistered = true;
            }
        }
        $mobileVerificationCode = $user->getMobileVerificationCode();
        
        return view("user.submitVoucherRequest",
            compact("user", "genders", "majors", "sideBarMode", "userHasRegistered", "rank", "userVoucher",
                "mobileVerificationCode"));
    }
    
    /**
     * Submit user request for voucher request
     *
     * @param  InsertVoucherRequest InsertVoucherRequest
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function submitVoucherRequest(InsertVoucherRequest $request)
    {
        $asiatechProduct = config("constants.ASIATECH_FREE_ADSL");
        $user            = $request->user();
        $nowDateTime     = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
            ->timezone('Asia/Tehran');
        $vouchers        = $user->productvouchers->where("expirationdatetime", ">", $nowDateTime)
            ->where("product_id", $asiatechProduct);
        if ($vouchers->isNotEmpty()) {
            session()->put("error", "شما برای اینترنت رایگان ثبت نام کرده اید");
            
            return redirect()->back();
        }
        
        $updateRequest = new EditUserRequest();
        RequestCommon::convertRequestToAjax($updateRequest);
        $updateRequest->offsetSet("postalCode", $request->get("postalCode"));
        $updateRequest->offsetSet("email", $request->get("email"));
        $updateRequest->offsetSet("gender_id", $request->get("gender_id"));
        $updateRequest->offsetSet("province", $request->get("province"));
        $updateRequest->offsetSet("city", $request->get("city"));
        $updateRequest->offsetSet("address", $request->get("address"));
        if ($user->hasVerifiedMobile()) {
            $updateRequest->offsetSet("mobileNumberVerification", 1);
        }
        $birthdate = Carbon::parse($request->get("birthdate"))
            ->setTimezone("Asia/Tehran")
            ->format('Y-m-d');
        $updateRequest->offsetSet("birthdate", $birthdate);
        $updateRequest->offsetSet("school", $request->get("school"));
        $updateRequest->offsetSet("major_id", $request->get("major_id"));
        $updateRequest->offsetSet("introducedBy", $request->get("introducedBy"));
        $response          = $this->update($updateRequest, $user);
        $completionColumns = [
            "firstName",
            "lastName",
            "mobile",
            "nationalCode",
            "province",
            "city",
            "address",
            "postalCode",
            "gender_id",
            "birthdate",
            "school",
            "major_id",
            "introducedBy",
            "mobile_verified_at",
            "photo",
        ];
        if ($response->getStatusCode() != Response::HTTP_OK) {
            return $this->sessionPutAndRedirectBack("مشکل غیر منتظره ای در ذخیره اطلاعات شما پیش آمد . لطفا مجددا اقدام نمایید");
        }
        if ($user->completion("custom", $completionColumns) < 100) {
            return $this->sessionPutAndRedirectBack("اطلاعات شما ذخیره شد اما برای ثبت درخواست اینترنت رایگان آسیاتک کامل نمی باشند . لطفا اطلاعات خود را تکمیل نمایید.");
        }
        $asiatechOrder                    = new Order();
        $asiatechOrder->orderstatus_id    = config("constants.ORDER_STATUS_PENDING");
        $asiatechOrder->paymentstatus_id  = config("constants.PAYMENT_STATUS_PAID");
        $asiatechOrder->cost              = 0;
        $asiatechOrder->costwithoutcoupon = 0;
        $asiatechOrder->user_id           = $user->id;
        $asiatechOrder->completed_at      = Carbon::now()
            ->setTimezone("Asia/Tehran");
        
        if (!$asiatechOrder->save()) {
            return $this->sessionPutAndRedirectBack("خطا در ثبت سفارش اینترنت رایگان. لطفا بعدا اقدام نمایید");
        }
        
        $request->offsetSet("cost", 0);
        $request->offsetSet("orderId_bhrk", $asiatechOrder->id);
        $product = Product::where("id", $asiatechProduct)
            ->first();
        if (!isset($product)) {
            return $this->sessionPutAndRedirectBack("محصول اینترنت آسیاتک یافت نشد");
        }
        
        $orderController = new OrderController();
        $response        = $orderController->addOrderproduct($request, $product);
        $responseStatus  = $response->getStatusCode();
        $result          = json_decode($response->getContent());
        if ($responseStatus != 200) {
            return $this->sessionPutAndRedirectBack("خطا در ثبت محصول اینرنت رایگان آسیاتک");
        }
        $user->lockHisProfile();
        $user->update();
        
        return redirect()->back();
    }
    
    /**
     * @param $message
     *
     * @return RedirectResponse
     */
    private function sessionPutAndRedirectBack($message)
    {
        session()->put("error", $message);
        return redirect()->back();
    }
    
    /**
     * Checks whether user can give these roles or not
     *
     * @param  array  $newRoleIds
     * @param  User   $user
     */
    private function checkGivenRoles(array &$newRoleIds, User $user): void
    {
        foreach ($newRoleIds as $key => $newRoleId) {
            $newRole = Role::Find($newRoleId);
            if ($this->userCantGetRole($user, $newRole)) {
                unset($newRoleIds[$key]);
            }
        }
    }
    
    /**
     * @param  User       $user
     * @param             $newRole
     *
     * @return bool
     */
    private function userCantGetRole(User $user, $newRole): bool
    {
        return isset($newRole) && $newRole->isDefault && !$user->can(config('constants.GIVE_SYSTEM_ROLE'));
    }
}
