<?php

namespace App\Http\Controllers;

use App\{Assignmentstatus,
    Attribute,
    Attributecontrol,
    Attributeset,
    Block,
    Bon,
    Checkoutstatus,
    Classes\Format\BlockCollectionFormatter,
    Classes\Format\webBlockCollectionFormatter,
    Classes\Format\webSetCollectionFormatter,
    Consultationstatus,
    Content,
    Contentset,
    Contenttype,
    Coupon,
    Coupontype,
    Event,
    Eventresult,
    Events\FreeInternetAccept,
    Gender,
    Http\Requests\ContactUsFormRequest,
    Http\Requests\InsertUserRequest,
    Http\Requests\Request,
    Lottery,
    Major,
    Notifications\GeneralNotice,
    Notifications\GiftGiven,
    Notifications\UserRegisterd,
    Order,
    Orderproduct,
    Orderstatus,
    Paymentmethod,
    Paymentstatus,
    Permission,
    Product,
    Productfile,
    Producttype,
    Productvoucher,
    Question,
    Role,
    Slideshow,
    Traits\APIRequestCommon,
    Traits\CharacterCommon,
    Traits\DateTrait,
    Traits\Helper,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Traits\UserCommon,
    Transaction,
    Transactionstatus,
    User,
    Userbon,
    Userbonstatus,
    Userstatus,
    Usersurveyanswer,
    Userupload,
    Useruploadstatus,
    Websitepage,
    Websitesetting};
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Config, File, Input, Route, Storage};
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Maatwebsite\ExcelLight\Excel;
use Maatwebsite\ExcelLight\Spout\{Reader, Row, Sheet, Writer};
use SEO;
use SSH;

//use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    use Helper;
    use APIRequestCommon;
    use ProductCommon;
    use DateTrait;
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
        //        $agent = new Agent();
        //        if ($agent->isRobot())
        //        {
        //            $authException = ['index' , 'getImage' , 'error404' , 'error403' , 'error500' , 'errorPage' , 'siteMapXML', 'download' ];
        //        }else{
        $authException = [
            'debug',
            'download',
            'telgramAgent',
            'index',
            'getImage',
            'error404',
            'error403',
            'error500',
            'errorPage',
            'aboutUs',
            'contactUs',
            'sendMail',
            'rules',
            'siteMapXML',
            'uploadFile',
            'search',
            'schoolRegisterLanding',
        ];
        //        }
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('ability:' . Config::get("constants.ROLE_ADMIN") . ',' . Config::get("constants.USER_ADMIN_PANEL_ACCESS"), ['only' => 'admin']);
        $this->middleware('permission:' . Config::get('constants.CONSULTANT_PANEL_ACCESS'), ['only' => 'consultantAdmin']);
        $this->middleware('permission:' . Config::get("constants.PRODUCT_ADMIN_PANEL_ACCESS"), ['only' => 'adminProduct']);
        $this->middleware('permission:' . Config::get("constants.CONTENT_ADMIN_PANEL_ACCESS"), ['only' => 'adminContent']);
        $this->middleware('permission:' . Config::get("constants.LIST_ORDER_ACCESS"), ['only' => 'adminOrder']);
        $this->middleware('permission:' . Config::get("constants.SMS_ADMIN_PANEL_ACCESS"), ['only' => 'adminSMS']);
        $this->middleware('permission:' . Config::get("constants.REPORT_ADMIN_PANEL_ACCESS"), ['only' => 'adminReport']);
        $this->middleware('permission:' . Config::get("constants.LIST_EDUCATIONAL_CONTENT_ACCESS"), ['only' => 'contentSetListTest']);
        $this->middleware('ability:' . Config::get("constants.ROLE_ADMIN") . ',' . Config::get("constants.TELEMARKETING_PANEL_ACCESS"), ['only' => 'adminTeleMarketing']);
        $this->middleware('permission:' . Config::get('constants.INSERT_COUPON_ACCESS'), ['only' => 'adminGenerateRandomCoupon']);
        $this->middleware('role:admin', [
            'only' => [
                'bot',
                'smsBot',
                'checkDisableContentTagBot',
                'tagBot',
                'pointBot',
                'adminLottery',
                'registerUserAndGiveOrderproduct',
                'specialAddUser',
            ],
        ]);
        $this->response = $response;
        $this->setting = $setting->setting;

    }

    public function contentSetListTest(Request $request, Contentset $set)
    {
        $contents = $set->contents()
                        ->get();
        return view('listTest', compact('set', 'contents'));
    }

    /*private function slug($title, $separator = '-')
    {
        $title = str_replace("‌",' ',$title);
        $title = mb_strtolower($title, "utf-8");
        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';

        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

        // Replace @ with the word 'at'
        $title = str_replace('@', $separator.'at'.$separator, $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        $title = trim($title, $separator);
        $title = preg_replace("/[^a-z0-9_\s-ء-يپچژکگیۃۂۀہ]/u", '', $title);
        $title = preg_replace("/[^a-z0-9_\s-ءاآؤئبپتثجچحخدذرزژسشصضطظعغفقكکگلمنوهی]/u", '', $title);

        $title = preg_replace("/[\s-_]+/", ' ', $title);
        $title = preg_replace("/[\s_]/", $separator, $title);
        return $title;
    }*/

    public function telgramAgent(Request $request)
    {
        //        Log::debug($request->headers->all());

    }

    public function debug(Request $request, BlockCollectionFormatter $formatter)
    {
        try{

//            $set = Contentset::findOrFail(1);
//            dd($set->contents_count);
            //
            $sections = (new webBlockCollectionFormatter(new webSetCollectionFormatter()))->format(Block::getBlocks());
            dd($sections);

            $users = User::whereIn("id" , [1,2,3])->get();
            foreach ($users as $user)
            {
                $user->firstName .= "3";
                $user->update();
            }

            dd($users);

            /*$orderproduct = Orderproduct::FindOrFail(108196);
            dd($orderproduct->obtainOrderproductCost(false));*/

            $order = Order::FindOrFail(248131);
//            $orderCost = $order->obtainOrderCost(false,false , "REOBTAIN");
//            $orderCost = $order->obtainOrderCost(true,false,"REOBTAIN");
//            $orderCost = $order->obtainOrderCost(false,true,"REOBTAIN");
//            $orderCost = $order->obtainOrderCost(true,true,"REOBTAIN");
//            $orderCost = $order->obtainOrderCost(false,false );
//            $orderCost = $order->obtainOrderCost(true,false);
//            $orderCost = $order->obtainOrderCost(false,true);
            $orderCost = $order->obtainOrderCost(true,true);
            dd($orderCost);

            $calculateOrderCost = true;
            $calculateOrderproductCost = true;

            if($calculateOrderCost) {
                $orderproductsToCalculateFromBaseIds = [];
                if($calculateOrderproductCost)
                {
                    $orderproductsToCalculateFromBaseIds = $order->normalOrderproducts->pluck("id")->toArray();
                }

                $alaaCashierFacade = new \App\Classes\Checkout\Alaa\OrderCheckout($order , $orderproductsToCalculateFromBaseIds);
            }
            else{
                $alaaCashierFacade = new \App\Classes\Checkout\Alaa\ReObtainOrderFromRecords($order);
            }

            $priceInfo = json_decode($alaaCashierFacade->checkout());

            dd($priceInfo);
        }
        catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response
                ->setStatusCode(503)
                ->setContent([
                                 "message" => $message,
                                 "error"   => $e->getMessage(),
                                 "line"    => $e->getLine(),
                                 "file"    => $e->getFile(),
                             ]);
        }
    }

    public function search(Request $request)
    {
        return redirect(action("ContentController@index"), Response::HTTP_REDIRECT_PERM);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $url = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
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

        //        $consultationstatus_active = Consultationstatus::all()->where("name", "active")->first();
        //        $consultingQuestionCount = Userupload::all()->count();
        //        $consultations = Consultation::all()->sortByDesc("created_at")->where("consultationstatus_id", $consultationstatus_active->id);
        //        $consultationCount = $consultations->count();
        //        $userCount = User::count();

        //        $todayDate = $this->convertDate(Carbon::now()->toDateTimeString(), "toJalali");
        //        $todayDate = explode("/", $todayDate);
        //        $currentDay = $todayDate[2];
        //        $currentMonth = $todayDate[1];
        //        $currentYear = $todayDate[0];
        //        $contents = Content::enable()
        //            ->valid()
        //            ->orderBy("validSince", "DESC")
        //            ->take(10)
        //            ->get();
        //        $contentCollection = collect();
        //        foreach ($contents as $content) {
        //            $contentCollection
        //                ->push([
        //                    "id" => $content->id,
        //                    "displayName" => $content->display_name,
        //                    "validSince_Jalali" => explode(" ", $content->validSince_Jalali())[0]
        //                ]);
        //        }

        $slides = Slideshow::getMainBanner();
        $slideCounter = 1;
        $slideDisk = 9;

        if (Config::has("constants.HOME_EXCLUDED_PRODUCTS"))
            $excludedProducts = Config::get("constants.HOME_EXCLUDED_PRODUCTS");
        else
            $excludedProducts = [];

        if (Config::has("constants.HOME_PRODUCTS_OFFER")) {
            $productIds = Config::get("constants.HOME_PRODUCTS_OFFER");
            $products = Product::getProducts(0, 1)
                               ->orderBy('order')
                               ->whereIn("id", $productIds)
                               ->whereNotIn("id", $excludedProducts)
                               ->take(3)
                               ->get();
        } else {
            //            $products = Product::recentProducts(2)
            //                ->whereNotIn("id", $excludedProducts)
            //                ->get();
            $products = collect();
        }

        //        $costCollection = $this->makeCostCollection($products);
        $costCollection = collect();
        /**
         * Ordroo registration statistics
         *
         * //   BOYS SECTION
         * $boysBlocks = collect([["displayName"=>"سالن ۱" , "capacity"=>"30"] ,["displayName"=>"سالن ۲" , "capacity"=>"30"] ]);
         * $boysOrdooRegisteredCount = Order::whereHas('orderproducts', function($q)
         * {
         * $q->whereIn("product_id",  Product::whereHas('parents', function($q)
         * {
         * $q->whereIn("parent_id",  [1] );
         * })->pluck("id") );
         * })->whereIn("orderstatus_id" , [2])->count();
         *
         * // GIRLS SECTION
         * $girlsBlocks = collect([["displayName"=>"سالن ۱" , "capacity"=>"30"] ,["displayName"=>"سالن ۲" , "capacity"=>"30"] ]);
         * $girlsOrdooRegisteredCount = Order::whereHas('orderproducts', function($q)
         * {
         * $q->whereIn("product_id",  Product::whereHas('parents', function($q)
         * {
         * $q->whereIn("parent_id",  [13] );
         * })->pluck("id") );
         * })->whereIn("orderstatus_id" , [2])->count();
         * /**
         *  end of code
         */


        $pageName = "dashboard";
        return view('pages.dashboard1', compact(
            'pageName',
            'slides',
            'slideCounter',
            'products',
            'costCollection',
            'slideDisk'
        ));
    }

    public function home()
    {
        return redirect('/', 301);
    }

    /**
     * Show the not found page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error404()
    {
        return abort(404);
    }

    /**
     * Show forbidden page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error403()
    {
        return abort(403);
    }

    /**
     * Show general error page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error500()
    {
        return abort(500);
    }

    /**
     * Show admin panel main page
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $gendersWithUnknown = clone $genders;
        $gendersWithUnknown->prepend("نامشخص");
        $permissions = Permission::pluck('display_name', 'id');
        $roles = Role::pluck('display_name', 'id');
        //        $roles = array_add($roles , 0 , "همه نقش ها");
        //        $roles = array_sort_recursive($roles);
        $limitStatus = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];
        $enableStatus = [
            0 => 'غیرفعال',
            1 => 'فعال',
        ];

        $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])
                                    ->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $hasOrder = [
            0 => 'همه کاربران',
            1 => 'کسانی که سفارش ثبت کرده اند',
            2 => 'کسانی که سفارش ثبت نکرده اند',
        ];

        $products = $this->makeProductCollection();

        $lockProfileStatus = [
            0 => "پروفایل باز",
            1 => "پروفایل قفل شده",
        ];
        $mobileNumberVerification = [
            0 => "تایید نشده",
            1 => "تایید شده",
        ];

        $tableDefaultColumns = [
            "نام خانوادگی",
            "نام کوچک",
            "رشته",
            "کد ملی",
            "موبایل",
            "ایمیل",
            "شهر",
            "استان",
            "وضعیت شماره موبایل",
            "کد پستی",
            "آدرس",
            "مدرسه",
            "وضعیت",
            "زمان ثبت نام",
            "زمان اصلاح",
            "نقش های کاربر",
            "تعداد بن",
            "عملیات",
        ];

        $sortBy = [
            "updated_at" => "تاریخ اصلاح",
            "created_at" => "تاریخ ثبت نام",
            "firstName"  => "نام",
            "lastName"   => "نام خانوادگی",
        ];
        $sortType = [
            "desc" => "نزولی",
            "asc"  => "صعودی",
        ];
        $addressSpecialFilter = [
            "بدون فیلتر خاص",
            "بدون آدرس ها",
            "آدرس دارها",
        ];

        $coupons = Coupon::pluck('name', 'id')
                         ->toArray();
        $coupons = array_sort_recursive($coupons);

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')
                                          ->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        $pageName = "admin";

        return view("admin.index", compact("pageName", "majors", "userStatuses", "permissions", "roles", "limitStatus", "orderstatuses", "paymentstatuses", "enableStatus", "genders", "gendersWithUnknown", "hasOrder", "products",
                                           "lockProfileStatus", "mobileNumberVerification", "tableDefaultColumns", "sortBy", "sortType", "coupons", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Show product admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProduct()
    {
        $attributecontrols = Attributecontrol::pluck('name', 'id')
                                             ->toArray();
        $enableStatus = [
            0 => 'غیرفعال',
            1 => 'فعال',
        ];
        $attributesets = Attributeset::pluck('name', 'id')
                                     ->toArray();
        $limitStatus = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];

        $products = Product::pluck('name', 'id')
                           ->toArray();
        $coupontype = Coupontype::pluck('displayName', 'id');

        $productTypes = Producttype::pluck("displayName", "id");

        $lastProduct = Product::getProducts(0, 1)
                              ->get()
                              ->sortByDesc("order")
                              ->first();
        if (isset($lastProduct)) {
            $lastOrderNumber = $lastProduct->order + 1;
            $defaultProductOrder = $lastOrderNumber;
        } else {
            $defaultProductOrder = 1;
        }

        $pageName = "admin";
        return view("admin.indexProduct", compact("pageName", "attributecontrols", "enableStatus", "attributesets", "limitStatus", "products", "coupontype", "productTypes", "defaultProductOrder"));
    }

    /**
     * Show order admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminOrder()
    {
        $pageName = "admin";
        $user = Auth::user();
        if ($user->can(Config::get('constants.SHOW_OPENBYADMIN_ORDER')))
            $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])
                                        ->pluck('displayName', 'id');
        else
            $orderstatuses = Orderstatus::whereNotIn('id', [
                Config::get("constants.ORDER_STATUS_OPEN"),
                Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN"),
            ])
                                        ->pluck('displayName', 'id')
                                        ->toArray();
        //        $orderstatuses= array_sort_recursive(array_add($orderstatuses , 0 , "دارای هر وضعیت سفارش")->toArray());

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id')
                                        ->toArray();
        $majors = Major::pluck('name', 'id');
        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')
                                          ->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        if ($user->hasRole("onlineNoroozMarketing")) {
            $products = [Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT")];
            $products = $this->makeProductCollection($products);
        } else {
            $products = $this->makeProductCollection();
        }


        $paymentMethods = Paymentmethod::pluck('displayName', 'id')
                                       ->toArray();

        $attributevalueCollection = collect();
        $extraAttributes = Attribute::whereHas("attributegroups", function ($q) {
            $q->where("attributetype_id", 2);
        })
                                    ->get();
        foreach ($extraAttributes as $attribute) {
            $values = [];
            $values = array_merge($values, $attribute->attributevalues->pluck("id", "name")
                                                                      ->toArray());
            if (!empty($values))
                $attributevalueCollection->put($attribute->displayName, $values);
        }

        $sortBy = [
            "updated_at"    => "تاریخ اصلاح مدیریتی",
            "completed_at"  => "تاریخ ثبت نهایی",
            "created_at"    => "تاریخ ثبت اولیه",
            "userFirstName" => "نام مشتری",
            "userLastName"  => "نام خانوادگی مشتری"
            /* , "productName" => "نام محصول"*/
        ];
        $sortType = [
            "desc" => "نزولی",
            "asc"  => "صعودی",
        ];

        $transactionTypes = [
            0 => "واریز شده",
            1 => "بازگشت داده شده",
        ];

        $coupons = Coupon::pluck('name', 'id')
                         ->toArray();
        $coupons = array_sort_recursive($coupons);

        $transactionStatuses = Transactionstatus::orderBy("order")
                                                ->pluck("displayName", "id")
                                                ->toArray();

        $userBonStatuses = Userbonstatus::pluck("displayName", "id");

        $orderTableDefaultColumns = [
            "محصولات",
            "نام خانوادگی",
            "نام کوچک",
            "رشته",
            "استان",
            "شهر",
            "آدرس",
            "کد پستی",
            "موبایل",
            "مبلغ(تومان)",
            "عملیات",
            "ایمیل",
            "پرداخت شده(تومان)",
            "مبلغ برگشتی(تومان)",
            "بدهکار/بستانکار(تومان)",
            "توضیحات مسئول",
            "کد مرسوله پستی",
            "توضیحات مشتری",
            "وضعیت سفارش",
            "وضعیت پرداخت",
            "کدهای تراکنش",
            "تاریخ اصلاح مدیریتی",
            "تاریخ ثبت نهایی",
            "ویژگی ها",
            "تعداد بن استفاده شده",
            "تعداد بن اضافه شده به شما از این سفارش",
            "کپن استفاده شده",
            "تاریخ ایجاد اولیه",
        ];
        $transactionTableDefaultColumns = [
            "نام مشتری",
            "تراکنش پدر",
            "موبایل",
            "مبلغ سفارش",
            "مبلغ تراکنش",
            "کد تراکنش",
            "نحوه پرداخت",
            "تاریخ ثبت",
            "عملیات",
            "توضیح مدیریتی",
            "مبلغ فیلتر شده",
            "مبلغ آیتم افزوده",
        ];
        $userBonTableDefaultColumns = [
            "نام کاربر",
            "تعداد بن تخصیص داده شده",
            "وضعیت بن",
            "نام کالایی که از خرید آن بن دریافت کرده است",
            "تاریخ درج",
            "عملیات",
        ];
        $addressSpecialFilter = [
            "بدون فیلتر خاص",
            "بدون آدرس ها",
            "آدرس دارها",
        ];


        return view("admin.indexOrder", compact("pageName", "orderstatuses", "products", "paymentMethods", "majors", "paymentstatuses", "sortBy", "sortType", "transactionTypes", "orderTableDefaultColumns", "coupons", "transactionStatuses", "transactionTableDefaultColumns", "userBonTableDefaultColumns", "userBonStatuses", "attributevalueCollection", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Show content admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminContent()
    {
        $majors = Major::pluck('name', 'id');
        $assignmentStatuses = Assignmentstatus::pluck('name', 'id');
        $assignmentStatuses->prepend("انتخاب وضعیت");
        $consultationStatuses = Consultationstatus::pluck('name', 'id');
        $consultationStatuses->prepend("انتخاب وضعیت");

        $pageName = "admin";
        return view("admin.indexContent", compact("pageName", "assignmentStatuses", "consultationStatuses", "majors"));
    }

    /**
     * Show consultant admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantAdmin()
    {
        $questions = Userupload::all()
                               ->sortByDesc('created_at');
        $questionStatusDone = Useruploadstatus::all()
                                              ->where("name", "done")
                                              ->first();
        $questionStatusPending = Useruploadstatus::all()
                                                 ->where("name", "pending")
                                                 ->first();
        $newQuestionsCount = Userupload::all()
                                       ->where("useruploadstatus_id", $questionStatusPending->id)
                                       ->count();
        $answeredQuestionsCount = Userupload::all()
                                            ->where("useruploadstatus_id", $questionStatusDone->id)
                                            ->count();
        $counter = 0;


        $pageName = "consultantAdmin";
        return view("admin.consultant.consultantAdmin", compact("questions", "counter", "pageName", "newQuestionsCount", "answeredQuestionsCount"));
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function consultantEntekhabReshte()
    {
        $user = User::FindOrFail(Input::get("user"));
        if (Storage::disk('entekhabReshte')
                   ->exists($user->id . "-" . $user->major->id . ".txt")) {
            $storedMajors = json_decode(Storage::disk('entekhabReshte')
                                               ->get($user->id . "-" . $user->major->id . ".txt"));
            $parentMajorId = $user->major->id;
            $storedMajorsInfo = Major::whereHas("parents", function ($q) use ($storedMajors, $parentMajorId) {
                $q->where("major1_id", $parentMajorId)
                  ->whereIn("majorCode", $storedMajors);
            })
                                     ->get();

            $selectedMajors = [];
            foreach ($storedMajorsInfo as $storedMajorInfo) {
                $storedMajor = $storedMajorInfo->parents->where("id", $parentMajorId)
                                                        ->first();
                $majorCode = $storedMajor->pivot->majorCode;
                $majorName = $storedMajorInfo->name;
                $selectedMajors = array_add($selectedMajors, $majorCode, $majorName);
            }
        }
        $eventId = 1;
        $surveyId = 1;
        $requestUrl = action("UserSurveyAnswerController@index");
        $requestUrl .= "?event_id[]=" . $eventId . "&survey_id[]=" . $surveyId . "&user_id[]=" . $user->id;
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $userSurveyAnswers = collect();
        foreach ($answersCollection as $answerCollection) {
            $answerArray = $answerCollection->userAnswer->answer;
            $question = Question::FindOrFail($answerCollection->userAnswer->question_id);
            $requestBaseUrl = $question->dataSourceUrl;
            $requestUrl = url("/") . $requestBaseUrl . "?ids=$answerArray";
            $originalInput = \Illuminate\Support\Facades\Request::input();
            $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            $userSurveyAnswers->push([
                                         "questionStatement" => $question->statement,
                                         "questionAnswer"    => $dataJson,
                                     ]);
        }


        //        Meta::set('title', substr("آلاء|پنل انتخاب رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view("admin.consultant.consultantEntekhabReshte", compact("user", "storedMajors", "selectedMajors", "userSurveyAnswers"));
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantEntekhabReshteList()
    {
        $eventId = 1;
        $surveyId = 1;
        $usersurveyanswers = Usersurveyanswer::where("event_id", $eventId)
                                             ->where("survey_id", $surveyId)
                                             ->get()
                                             ->groupBy("user_id");


        //        Meta::set('title', substr("آلاء|لیست انتخاب رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view("admin.consultant.consultantEntekhabReshteList", compact("usersurveyanswers"));
    }

    /**
     * Storing consultant entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantStoreEntekhabReshte(\Illuminate\Http\Request $request)
    {
        $userId = $request->get("user");
        $user = User::FindOrFail($userId);
        $parentMajor = $request->get("parentMajor");
        $majorCodes = json_encode($request->get("majorCodes"), JSON_UNESCAPED_UNICODE);

        Storage::disk('entekhabReshte')
               ->delete($userId . '-' . $parentMajor . '.txt');
        Storage::disk('entekhabReshte')
               ->put($userId . "-" . $parentMajor . ".txt", $majorCodes);
        session()->put("success", "رشته های انتخاب شده با موفقیت درج شدند");
        return redirect(action("HomeController@consultantEntekhabReshte", ["user" => $user]));
    }

    /**
     * Show adminSMS panel main page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSMS()
    {
        $pageName = "admin";

        $userStatuses = Userstatus::pluck('name', 'id');
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $gendersWithUnknown = clone $genders;
        $gendersWithUnknown->prepend("نامشخص");
        $roles = Role::pluck('display_name', 'id');

        $orderstatuses = Orderstatus::whereNotIn('name', ['open'])
                                    ->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $products = $this->makeProductCollection();

        $lockProfileStatus = [
            0 => "پروفایل باز",
            1 => "پروفایل قفل شده",
        ];
        $mobileNumberVerification = [
            0 => "تایید نشده",
            1 => "تایید شده",
        ];

        $relatives = ["فرد"];
//        $relatives = Relative::pluck('displayName', 'id');
//        $relatives->prepend('فرد');

        $sortBy = [
            "updated_at" => "تاریخ اصلاح",
            "created_at" => "تاریخ ثبت نام",
            "firstName"  => "نام",
            "lastName"   => "نام خانوادگی",
        ];
        $sortType = [
            "desc" => "نزولی",
            "asc"  => "صعودی",
        ];
        $addressSpecialFilter = [
            "بدون فیلتر خاص",
            "بدون آدرس ها",
            "آدرس دارها",
        ];

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')
                                          ->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        $pageName = "admin";

        $smsCredit = (int)$this->medianaGetCredit();

        $smsProviderNumber = Config::get('constants.SMS_PROVIDER_NUMBER');

        $coupons = Coupon::pluck('name', 'id')
                         ->toArray();
        $coupons = array_sort_recursive($coupons);


        //        Meta::set('title', substr("آلاء|پنل پیامک", 0, Config::get("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view("admin.indexSMS", compact("pageName", "majors", "userStatuses",
                                              "roles", "relatives", "orderstatuses", "paymentstatuses", "genders", "gendersWithUnknown", "products", "allRootProducts", "lockProfileStatus",
                                              "mobileNumberVerification", "sortBy", "sortType", "smsCredit", "smsProviderNumber",
                                              "numberOfFatherPhones", "numberOfMotherPhones", "coupons", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSlideShow()
    {

        $slideController = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()
                                                          ->where('url', "/home")
                                                          ->first()->id;
        $slides = $slideController->index()
                                  ->where("websitepage_id", $slideWebsitepageId);
        $slideDisk = 9;
        $slideContentName = "عکس اسلاید صفحه اصلی";
        $sideBarMode = "closed";
        $section = "slideShow";


        return view("admin.siteConfiguration.slideShow", compact("slides", "sideBarMode", "section", "slideDisk", "slideContentName", "slideWebsitepageId"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminArticleSlideShow()
    {

        $slideController = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()
                                                          ->where('url', "/لیست-مقالات")
                                                          ->first()->id;
        $slides = $slideController->index()
                                  ->where("websitepage_id", $slideWebsitepageId);
        $slideDisk = 13;
        $slideContentName = "عکس اسلاید صفحه مقالات";
        $sideBarMode = "closed";
        $section = "articleSlideShow";
        return view("admin.siteConfiguration.articleSlideShow", compact("slides", "sideBarMode", "slideWebsitepageId", "section", "slideDisk", "slideContentName"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSiteConfig()
    {
        $this->setting = Websitesetting::where("version", 1)
                                       ->get()
                                       ->first();

        return redirect(action('WebsiteSettingController@show', $this->setting));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminMajor()
    {
        $parentName = Input::get("parent");
        $parentMajor = Major::all()
                            ->where("name", $parentName)
                            ->where("majortype_id", 1)
                            ->first();

        $majors = Major::where("majortype_id", 2)
                       ->orderBy("name")
                       ->whereHas("parents", function ($q) use ($parentMajor) {
                           $q->where("major1_id", $parentMajor->id);
                       })
                       ->get();


        return view("admin.indexMajor", compact("parentMajor", "majors"));
    }

    /**
     * Admin panel for getting a special report
     */
    public function adminReport()
    {
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $gendersWithUnknown = clone $genders;
        $gendersWithUnknown->prepend("نامشخص");
        $permissions = Permission::pluck('display_name', 'id');
        $roles = Role::pluck('display_name', 'id');
        //        $roles = array_add($roles , 0 , "همه نقش ها");
        //        $roles = array_sort_recursive($roles);
        $limitStatus = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];
        $enableStatus = [
            0 => 'غیرفعال',
            1 => 'فعال',
        ];

        $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])
                                    ->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $hasOrder = [
            0 => 'همه کاربران',
            1 => 'کسانی که سفارش ثبت کرده اند',
            2 => 'کسانی که سفارش ثبت نکرده اند',
        ];

        $bookProductsId = [
            176,
            167,
        ];
        $bookProducts = $this->makeProductCollection($bookProductsId);

        $products = $this->makeProductCollection();


        $lockProfileStatus = [
            0 => "پروفایل باز",
            1 => "پروفایل قفل شده",
        ];
        $mobileNumberVerification = [
            0 => "تایید نشده",
            1 => "تایید شده",
        ];

        //        $tableDefaultColumns = ["نام" , "رشته"  , "موبایل"  ,"شهر" , "استان" , "وضعیت شماره موبایل" , "کد پستی" , "آدرس" , "مدرسه" , "وضعیت" , "زمان ثبت نام" , "زمان اصلاح" , "نقش های کاربر" , "تعداد بن" , "عملیات"];

        $sortBy = [
            "updated_at" => "تاریخ اصلاح",
            "created_at" => "تاریخ ثبت نام",
            "firstName"  => "نام",
            "lastName"   => "نام خانوادگی",
        ];
        $sortType = [
            "desc" => "نزولی",
            "asc"  => "صعودی",
        ];
        $addressSpecialFilter = [
            "بدون فیلتر خاص",
            "بدون آدرس ها",
            "آدرس دارها",
        ];

        $coupons = Coupon::pluck('name', 'id')
                         ->toArray();
        $coupons = array_sort_recursive($coupons);

        $lotteries = Lottery::pluck("displayName", 'id')
                            ->toArray();

        $pageName = "admin";


        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')
                                          ->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        return view("admin.indexGetReport", compact("pageName", "majors", "userStatuses", "permissions", "roles", "limitStatus", "orderstatuses", "paymentstatuses", "enableStatus", "genders", "gendersWithUnknown", "hasOrder", "products",
                                                    "bookProducts", "lockProfileStatus", "mobileNumberVerification", "sortBy", "sortType", "coupons", "addressSpecialFilter", "lotteries", "checkoutStatuses"));
    }

    /**
     * Admin panel for lotteries
     */
    public function adminLottery(Request $request)
    {
        $userlotteries = collect();
        if ($request->has("lottery")) {
            $lotteryName = $request->get("lottery");
            $lottery = Lottery::where("name", $lotteryName)
                              ->get()
                              ->first();
            $lotteryDisplayName = $lottery->displayName;
            $userlotteries = $lottery->users->where("pivot.rank", ">", 0)
                                            ->sortBy("pivot.rank");
        }

        $bonName = config("constants.BON2");
        $bon = Bon::where("name", $bonName)
                  ->first();
        $pointsGiven = Userbon::where("bon_id", $bon->id)
                              ->where("userbonstatus_id", 1)
                              ->get()
                              ->isNotEmpty();

        $pageName = "admin";
        return view("admin.indexLottery", compact("userlotteries", "pageName", "lotteryName", "lotteryDisplayName", "pointsGiven"));
    }

    /**
     * Admin panel for tele marketing
     */
    public function adminTeleMarketing(Request $request)
    {
        if ($request->has("group-mobile")) {
            $marketingProducts = [
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
            $mobiles = $request->get("group-mobile");
            $mobileArray = [];
            foreach ($mobiles as $mobile) {
                array_push($mobileArray, $mobile["mobile"]);
            }
            $baseDataTime = Carbon::createFromTimeString("2018-05-03 00:00:00");
            $orders = Order::whereHas("user", function ($q) use ($mobileArray, $baseDataTime) {
                $q->whereIn("mobile", $mobileArray);
            })
                           ->whereHas("orderproducts", function ($q2) use ($marketingProducts) {
                               $q2->whereIn("product_id", $marketingProducts);
                           })
                           ->where("orderstatus_id", Config::get("constants.ORDER_STATUS_CLOSED"))
                           ->where("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_PAID"))
                           ->where("completed_at", ">=", $baseDataTime)
                           ->get();
            $orders->load("orderproducts");
        }
        return view("admin.indexTeleMarketing", compact("orders", "marketingProducts"));
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function newDownload($data)
    {
        if (isset($data)) {
            try {
                $data = (array)decrypt($data);
            }
            catch (DecryptException $e) {
                abort(403);
            }
            $url = $data["url"];
            $contentId = $data["data"]["content_id"];
            if (Auth::check()) {
                $user = auth()->user();
                $user->hasContent($contentId);
                return redirect($url);
            }
        }
        abort(403);
    }

    function download(Request $request)
    {
        $fileName = $request->get("fileName");
        $contentType = $request->get("content");
        $user = Auth::user();

        switch ($contentType) {
            case "عکس پروفایل":
                $diskName = Config::get('constants.DISK1');
                break;
            case "عکس محصول":
                $diskName = Config::get('constants.DISK4');
                break;
            case "تمرین":
                // check if he has permission for downloading the assignment :

                //if(!Auth::user()->permissions->contains(Permission::all()->where("name", Config::get('constants.DOWNLOAD_ASSIGNMENT_ACCESS'))->first()->id)) return redirect(action(("HomeController@error403"))) ;
                //  checking permission through the user's role
                //$user->hasRole('goldenUser');
                $diskName = Config::get('constants.DISK2');
                break;
            case "پاسخ تمرین":
                $diskName = Config::get('constants.DISK3');
                break;
            case "کاتالوگ محصول":
                $diskName = Config::get('constants.DISK5');
                break;
            case "سؤال مشاوره ای":
                $diskName = Config::get('constants.DISK6');
                break;
            case "تامبنیل مشاوره":
                $diskName = Config::get('constants.DISK7');
                break;
            case "عکس مقاله" :
                $diskName = Config::get('constants.DISK8');
                break;
            case "عکس اسلاید صفحه اصلی" :
                $diskName = Config::get('constants.DISK9');
                break;
            case "فایل سفارش" :
                $diskName = Config::get('constants.DISK10');
                break;
            case "فایل محصول" :
                $productId = Input::get("pId");
                if (!$user->can(Config::get("constants.DOWNLOAD_PRODUCT_FILE"))) {
                    $products = Product::whereIn('id',
                                                 Product::whereHas('validProductfiles', function ($q) use ($fileName) {
                                                     $q->where("file", $fileName);
                                                 })
                                                        ->pluck("id")
                    )
                                       ->OrwhereIn('id', Product::whereHas('parents', function ($q) use ($fileName) {
                                           $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                                               $q->where("file", $fileName);
                                           });
                                       })
                                                                ->pluck("id")
                                       )
                                       ->OrwhereIn('id', Product::whereHas('complimentaryproducts', function ($q) use ($fileName) {
                                           $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                                               $q->where("file", $fileName);
                                           });
                                       })
                                                                ->pluck("id")
                                       )
                                       ->OrwhereIn('id', Product::whereHas('gifts', function ($q) use ($fileName) {
                                           $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                                               $q->where("file", $fileName);
                                           });
                                       })
                                                                ->pluck("id")
                                       )
                                       ->OrwhereIn('id', Product::whereHas('parents', function ($q) use ($fileName) {
                                           $q->whereHas('complimentaryproducts', function ($q) use ($fileName) {
                                               $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                                                   $q->where("file", $fileName);
                                               });
                                           });
                                       })
                                                                ->pluck("id")
                                       )
                                       ->get();
                    $validOrders = $user->orders()
                                        ->whereHas('orderproducts', function ($q) use ($products) {
                                            $q->whereIn("product_id", $products->pluck("id"));
                                        })
                                        ->whereIn("orderstatus_id", [
                                            Config::get("constants.ORDER_STATUS_CLOSED"),
                                            Config::get("constants.ORDER_STATUS_POSTED"),
                                            Config::get("constants.ORDER_STATUS_READY_TO_POST"),
                                        ])
                                        ->whereIn("paymentstatus_id", [Config::get("constants.PAYMENT_STATUS_PAID")])
                                        ->get();

                    if ($products->isEmpty()) {
                        $message = "چنین فایلی وجود ندارد ویا غیر فعال شده است";
                    } else if ($validOrders->isEmpty()) {

                        $message = "شما ابتدا باید یکی از این محصولات را سفارش دهید و یا اگر سفارش داده اید مبلغ را تسویه نمایید: " . "<br>";
                        $productIds = [];
                        foreach ($products as $product) {
                            $myParents = $this->makeParentArray($product);
                            if (!empty($myParents)) {
                                $rootParent = end($myParents);
                                if (!in_array($rootParent->id, $productIds)) {
                                    $message .= "<a href='" . action('ProductController@show', $rootParent->id) . "'>" . $rootParent->name . "</a><br>";
                                    array_push($productIds, $rootParent->id);
                                }
                            } else {
                                if (!in_array($product->id, $productIds)) {
                                    $message .= "<a  href='" . action('ProductController@show', $product->id) . "'>" . $product->name . "</a><br>";
                                    array_push($productIds, $product->id);
                                }
                            }
                        }
                    }
                    //
                    if (isset($message) && strlen($message) > 0) {
                        return $this->errorPage($message);
                    }
                }
                $productId = [$productId];
                if (isset($products))
                    $productId = array_merge($productId, $products->pluck("id")
                                                                  ->toArray());
                $diskName = Config::get('constants.DISK13');
                $cloudFile = Productfile::where("file", $fileName)
                                        ->whereIn("product_id", $productId)
                                        ->get()
                                        ->first()->cloudFile;
                //TODO: verify "$productFileLink = "http://".env("SFTP_HOST" , "").":8090/". $cloudFile;"
                $productFileLink = config("constants.DOWNLOAD_HOST_PROTOCOL", "https://") . config('constants.DOWNLOAD_HOST_NAME') . $cloudFile;
                $unixTime = Carbon::today()
                                  ->addDays(2)->timestamp;
                $userIP = request()->ip();
                //TODO: fix diffrent Ip
                $ipArray = explode(".", $userIP);
                $ipArray[3] = 0;
                $userIP = implode(".", $ipArray);

                $linkHash = $this->generateSecurePathHash($unixTime, $userIP, "TakhteKhak", $cloudFile);
                $externalLink = $productFileLink . "?md5=" . $linkHash . "&expires=" . $unixTime;
                //                dd($temp."+".$userIP);
                break;
            case "فایل کارنامه" :
                $diskName = Config::get('constants.DISK14');
                break;
            case Config::get('constants.DISK18') :
                if (Storage::disk(Config::get('constants.DISK18_CLOUD'))
                           ->exists($fileName))
                    $diskName = Config::get('constants.DISK18_CLOUD');
                else
                    $diskName = Config::get('constants.DISK18');
                break;
            case Config::get('constants.DISK19'):
                if (Storage::disk(Config::get('constants.DISK19_CLOUD'))
                           ->exists($fileName))
                    $diskName = Config::  get('constants.DISK19_CLOUD');
                else
                    $diskName = Config::get('constants.DISK19');
                break;
            case Config::get('constants.DISK20'):
                if (Storage::disk(Config::get('constants.DISK20_CLOUD'))
                           ->exists($fileName))
                    $diskName = Config::  get('constants.DISK20_CLOUD');
                else
                    $diskName = Config::get('constants.DISK20');
                break;
            default :
                $file = \App\File::where("uuid", $fileName)
                                 ->get();
                if ($file->isNotEmpty() && $file->count() == 1) {
                    $file = $file->first();
                    if ($file->disks->isNotEmpty()) {
                        $diskName = $file->disks->first()->name;
                        $fileName = $file->name;
                    } else {
                        $externalLink = $file->name;
                    }
                } else {
                    abort("404");
                }
        }
        if (isset($downloadPriority) && strcmp($downloadPriority, "cloudFirst") == 0) {
            if (isset($externalLink)) {
                return redirect($externalLink);
            } else if (Storage::disk($diskName)
                              ->exists($fileName)) {
                //            Other download method :  problem => it changes the file name to download
                //            $file = Storage::disk($diskName)->get($fileName);
                //            return (new Response($file, 200))
                //                ->header('Content-Type', $contentMime)
                //                ->header('Content-Disposition'  , 'attachment')
                //                ->header('filename',$fileName);

                //                $filePrefixPath =Storage::drive($diskName)->getAdapter()->getPathPrefix() ;
                //                if(isset($filePrefixPath))
                //                    return response()->download(Storage::drive($diskName)->path($fileName));
                //                else
                //                    return response()->download(Storage::drive($diskName)->getAdapter()->getRoot() . $fileName);

                $filePrefixPath = Storage::drive($diskName)
                                         ->getAdapter()
                                         ->getPathPrefix();
                if (isset($filePrefixPath)) {
                    $fs = Storage::disk($diskName)
                                 ->getDriver();
                    $stream = $fs->readStream($fileName);
                    return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, 200, [
                        "Content-Type"        => $fs->getMimetype($fileName),
                        "Content-Length"      => $fs->getSize($fileName),
                        "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                    ]);
                } else {
                    $fileHost = Storage::drive($diskName)
                                       ->getAdapter()
                                       ->getHost();
                    if (isset($fileHost)) {
                        $fileRoot = Storage::drive($diskName)
                                           ->getAdapter()
                                           ->getRoot();
                        //TODO: verify "$fileRemotePath = "http://" . $fileHost . ":8090" . "/public" . explode("public", $fileRoot)[1];"

                        $fileRemotePath = config("constants.DOWNLOAD_HOST_PROTOCOL") . config("constants.DOWNLOAD_HOST_NAME") . "/public" . explode("public", $fileRoot)[1];
                        return response()->redirectTo($fileRemotePath . $fileName);
                    } else {
                        $fs = Storage::disk($diskName)
                                     ->getDriver();
                        $stream = $fs->readStream($fileName);
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            "Content-Type"        => $fs->getMimetype($fileName),
                            "Content-Length"      => $fs->getSize($fileName),
                            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                        ]);
                    }
                }

                //
            }
        } else {
            if (isset($diskName) && Storage::disk($diskName)
                                           ->exists($fileName)) {
                $diskAdapter = Storage::disk($diskName)
                                      ->getAdapter();
                $diskType = class_basename($diskAdapter);
                switch ($diskType) {
                    case "SftpAdapter" :
                        if (isset($file)) {
                            $url = $file->getUrl();
                            if (isset($url[0])) {
                                return response()->redirectTo($url);
                            } else {
                                $fs = Storage::disk($diskName)
                                             ->getDriver();
                                $stream = $fs->readStream($fileName);

                                return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                                    fpassthru($stream);
                                }, 200, [
                                    "Content-Type"        => $fs->getMimetype($fileName),
                                    "Content-Length"      => $fs->getSize($fileName),
                                    "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                                ]);
                            }
                        }

                        break;
                    case "Local" :
                        $fs = Storage::disk($diskName)
                                     ->getDriver();
                        $stream = $fs->readStream($fileName);
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            "Content-Type"        => $fs->getMimetype($fileName),
                            "Content-Length"      => $fs->getSize($fileName),
                            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                        ]);
                        break;
                    default:
                        break;
                }
            } else if (isset($externalLink)) {
                return redirect($externalLink);
            }
        }
        abort(404);
    }

    /**
     * Show the general error page.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function errorPage($message)
    {
        //        $message = Input::get("message");
        if (strlen($message) <= 0)
            $message = "";
        return view("errors.errorPage", compact("message"));
    }

    public function getImage($category, $w, $h, $fileName)
    {
        switch ($category) {
            case "1";
                $diskName = Config::get('constants.DISK1');
                break;
            case "4":
                $diskName = Config::get('constants.DISK4');
                break;
            case "7":
                $diskName = Config::get('constants.DISK7');
                break;
            case "8":
                $diskName = Config::get('constants.DISK8');
                break;
            case "9":
                $diskName = Config::get('constants.DISK9');
                break;
            case "11":
                $diskName = Config::get('constants.DISK11');
                break;
            default:
                break;
        }
        if (Storage::disk($diskName)
                   ->exists($fileName)) {
            $file = Storage::disk($diskName)
                           ->get($fileName);
            $type = Storage::disk($diskName)
                           ->mimeType($fileName);
            $etag = md5($file);
            $lastModified = Storage::disk($diskName)
                                   ->lastModified($fileName);
            $size = strlen($file);
            return response($file, 200)
                ->header('Content-Type', $type)
                ->header('Content-Length', $size)
                ->setMaxAge(3600)
                ->setPublic()
                ->setEtag($etag)
                ->setLastModified(Carbon::createFromTimestamp($lastModified));
        }
        return redirect(action("HomeController@error404"));
    }

    function aboutUs(Request $request)
    {
        $url = $request->url();
        $title = "آلاء|درباره ما";
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

        return view("pages.aboutUs");
    }

    function contactUs(Request $request)
    {
        $url = $request->url();
        $title = "آلاء|تماس با ما";
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

        $emergencyContacts = collect();
        foreach ($this->setting->branches->main->emergencyContacts as $emergencyContact) {
            $number = "";
            if (isset($emergencyContact->number) && strlen($emergencyContact->number) > 0)
                $number = $emergencyContact->number;

            $description = "";
            if (isset($emergencyContact->description) && strlen($emergencyContact->description) > 0)
                $description = $emergencyContact->description;

            if (strlen($number) > 0 || strlen($description) > 0)
                $emergencyContacts->push([
                                             "number"      => $number,
                                             "description" => $description,
                                         ]);
        }
        return view("pages.contactUs", compact("emergencyContacts"));
    }

    function rules(Request $request)
    {
        $url = $request->url();
        $title = "آلاء|قوانین";
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

        return view("pages.rules");
    }

    function donate(Request $request)
    {
        $url = $request->url();
        $title = "آلاء|کمک مالی";
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

        $donateProductArray = Product::DONATE_PRODUCT;
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

            $donateAmount = $donate->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
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
                                      $q->where("orderproducttype_id", Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
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

                    $amount = $donate->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
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
                            $amount = $donate->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
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
            $contentPath = str_replace($baseUrl, "", action("HomeController@donate"));
        }


        return view("pages.donate", compact("latestDonors", "maxDonors", "months"
            , "chartData", "totalSpend", "totalIncome", "currentJalaliDateString", "currentJalaliMonthString"));
    }

    function siteMap(Request $request)
    {

        $url = $request->url();
        $title = 'آلاء|نقشه سایت';
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

        $products = Product::getProducts(0, 1)
                           ->orderBy("order")
                           ->get();
        //        $articlecategories = Articlecategory::where('enable', 1)->orderBy('order')->get();
        //        $articlesWithoutCategory = Article::where('articlecategory_id', null)->get();
        return view("pages.siteMap", compact('products', 'articlecategories', 'articlesWithoutCategory'));
    }

    function siteMapXML()
    {
        return redirect(action('SitemapController@index'), 301);
    }

    /**
     * Sends an email to the website's own email
     *
     * @param \app\Http\Requests\ContactUsFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail(ContactUsFormRequest $request)
    {

        $this->setting = Websitesetting::where("version", 1)
                                       ->get()
                                       ->first();
        $wSetting = json_decode($this->setting->setting);

        //        try {
        //            $sent = Mail::send('emailLayouts.contactUs',
        //                array(
        //                    'name' =>  $request->get('fullName'),
        //                    'email' => $request->get('email'),
        //                    'phone' =>  $request->get('phone'),
        //                    'comment' => $request->get('message')
        //                ), function($message) use ($request , $wSetting)
        //                {
        //                    if(isset($wSetting->branches->main->emails[0]->address)) $to = $wSetting->branches->main->emails[0]->address;
        //                    else $to = "";
        ////                    $to = "mohamad.shahrokhi@gmail.com";
        //                    $message->from('info@itecsgroup.com');
        //                    $message->to($to, 'itecsgroup.com')->subject('تماس با ما');
        //                    $email =$request->get("email");
        //                    if(strlen($email)>0)  $message->replyTo($request->get('email'), $request->get('fullName'));
        //                });
        //
        //            if($sent)
        //            {
        //                session()->flash('success', 'پیام با موفقیت ارسال شد');
        //                return redirect()->back();
        //            }else
        //            {
        //                session()->flash('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
        //                return redirect()->back();
        //            }
        //        } catch ( \Exception    $error) {
        //            $message = "با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید";
        //            return $this->errorPage($message) ;
        //        }


        $email = $request->get('email');
        $name = $request->get('fullName');
        $phone = $request->get('phone');
        $comment = $request->get('message');

        //create a boundary for the email. This
        $boundary = uniqid('sh');

        // multiple recipients
        //    $to  = 'info@sanatisharif.ir' . ', '; // note the comma
        //    $to .= 'foratmail@gmail.com';

        if (isset($wSetting->branches->main->emails[0]->address))
            $to = $wSetting->branches->main->emails[0]->address;
        else $to = "";
        // To send HTML mail, the Content-type header must be set
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"\r\n";//';charset=UTF-8' .
        $headers .= "From: " . strip_tags(config('constants.MAIL_USERNAME')) . "\r\n" .
            "Reply-To: " . strip_tags($email) . "\r\n" .
            "X-Mailer: PHP/" . phpversion();


        $orginaltext = $request->get('message');

        $orginaltext = str_replace('\"', '"', $orginaltext);
        $orginaltext = str_replace('\\\\', '\\', $orginaltext);

        $sender = '<p dir="rtl"> نام فرستنده: ' . $name . '</p>';
        if (strlen($email) > 0)
            $sender .= '<p dir="rtl"> ایمیل فرستنده: ' . $email . '</p>';
        if (strlen($phone) > 0)
            $sender .= '<p dir="rtl">  شماره تماس فرستنده: ' . $phone . '</p>';

        //plainText version
        $text = "\r\n\r\n--" . $boundary . "\r\n"; //header
        $text .= "Content-type: text/plain; charset=utf-8 \r\n\r\n"; //header

        $text .= strip_tags($orginaltext) . "\r\n" . strip_tags($sender);

        //htmlText version

        $text .= "\r\n\r\n--" . $boundary . "\r\n"; //header
        $text .= "Content-type: text/html; charset=utf-8 \r\n\r\n"; //header

        //            $text .= $sender.str_replace('\"','\'','<p dir="rtl" style="text-align: right">'.$orginaltext.'</p>') ;
        $text .= view("emailLayouts.contactUs", compact("email", "phone", "comment", "name"));


        /*$text .='
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><h1>'.$subject.'</h1></title>
            </head>
            <body dir="rtl">
                '.$orginaltext.'\r\n'.$sender.'
            </body>
        </html>
            ';*/

        $text .= "\r\n\r\n--" . $boundary . "--";

        $subject = "آلاء - تماس با ما";

        try {
            $numSent = mail($to, $subject, $text, $headers);
            if ($numSent) {
                session()->put('success', 'پیام با موفقیت ارسال شد');
                return redirect()->back();
            } else {
                session()->put('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
                return redirect()->back();
            }
        }
        catch (\Exception    $error) {
            $message = "با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید";
            return $this->errorPage($message);
        }


    }

    /**
     * Send a custom SMS to the user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(Request $request)
    {
        $from = $request->get("smsProviderNumber");
        $message = $request->get("message");
        $usersId = $request->get("users");
        $usersId = explode(',', $usersId);
        $relatives = $request->get("relatives");
        $relatives = explode(',', $relatives);

        $smsNumber = config('constants.SMS_PROVIDER_DEFAULT_NUMBER');
        $users = User::whereIn("id", $usersId)->get();
        if ($users->isEmpty())
            return $this->response->setStatusCode(451);

        if (!isset($from) || strlen($from) == 0)
            $from = $smsNumber;

        $mobiles = [];
        $finalUsers = collect();
        foreach ($users as $user) {
            if (in_array(0, $relatives))
                array_push($mobiles, ltrim($user->mobile, '0'));
            if (in_array(1, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $fatherMobiles = $user->contacts->where("relative_id", 1)->first()->phones->where("phonetype_id", 1)->sortBy("priority");
                    if (!$fatherMobiles->isEmpty())
                        foreach ($fatherMobiles as $fatherMobile) {
                            array_push($mobiles, ltrim($fatherMobile->phoneNumber, '0'));
                        }

                }
            }
            if (in_array(2, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $motherMobiles = $user->contacts->where("relative_id", 2)->first()->phones->where("phonetype_id", 1)->sortBy("priority");
                    if (!$motherMobiles->isEmpty())
                        foreach ($motherMobiles as $motherMobile) {
                            array_push($mobiles, ltrim($motherMobile->phoneNumber, '0'));
                        }
                }
            }
        }
        $smsInfo = array();
        $smsInfo["message"] = $message;
        $smsInfo["to"] = $mobiles;
        $smsInfo["from"] = $from;
        $response = $this->medianaSendSMS($smsInfo);
    //Sending notification to user collection
//        Notification::send($users, new GeneralNotice($message));
        if (!$response["error"]) {
            $smsCredit = $this->medianaGetCredit();
            return $this->response->setContent($smsCredit)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Sends an email to the website's own email
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(\Illuminate\Http\Request $request)
    {

        $filePath = $request->header("X-File-Name");
        $originalFileName = $request->header("X-Dataname");
        $filePrefix = "";
        $contentSetId = $request->header("X-Dataid");
        $disk = $request->header("X-Datatype");
        $done = false;

        //        dd($request->headers->all());
        try {
            $dirname = pathinfo($filePath, PATHINFO_DIRNAME);
            $ext = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $fileName = basename($originalFileName, "." . $ext) . "_" . date("YmdHis") . '.' . $ext;

            $newFileNameDir = $dirname . '/' . $fileName;

            //            dd([
            //                "filePath"=>$filePath,
            //                "newFileNameDir"=>$newFileNameDir
            //            ]);
            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);


            if (strcmp($disk, "product") == 0) {
                if ($ext == "mp4")
                    $directory = "video";
                else if ($ext == "pdf")
                    $directory = "pamphlet";

                $adapter = new SftpAdapter([
                                               'host'          => config('constants.SFTP_HOST'),
                                               'port'          => config('constants.SFTP_PORT'),
                                               'username'      => config('constants.SFTP_USERNAME'),
                                               'password'      => config('constants.SFTP_PASSSWORD'),
                                               'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                                               'root'          => config('constants.SFTP_ROOT') . '/private/' . $contentSetId . '/',
                                               'timeout'       => config('constants.SFTP_TIMEOUT'),
                                               'directoryPerm' => 0755,
                                           ]);
                $filesystem = new Filesystem($adapter);
                if (isset($directory)) {
                    if (!$filesystem->has($directory)) {
                        $filesystem->createDir($directory);
                    }

                    $filePrefix = $directory . "/";
                    $filesystem = $filesystem->get($directory);
                    $path = $filesystem->getPath();
                    $filesystem->setPath($path . "/" . $fileName);
                    if ($filesystem->put(fopen($newFileNameDir, 'r+')))
                        $done = true;
                } else {
                    if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+')))
                        $done = true;
                }

            } else if (strcmp($disk, "video") == 0) {
                $adapter = new SftpAdapter([
                                               'host'          => config('constants.SFTP_HOST'),
                                               'port'          => config('constants.SFTP_PORT'),
                                               'username'      => config('constants.SFTP_USERNAME'),
                                               'password'      => config('constants.SFTP_PASSSWORD'),
                                               'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                                               // example:  /alaa_media/cdn/media/203/HD_720p , /alaa_media/cdn/media/thumbnails/203/
                                               'root'          => config("constants.DOWNLOAD_SERVER_ROOT") .
                                                   config("constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH") .
                                                   $contentSetId,
                                               'timeout'       => config('constants.SFTP_TIMEOUT'),
                                               'directoryPerm' => 0755,
                                           ]);
                $filesystem = new Filesystem($adapter);
                if ($filesystem->put($originalFileName, fopen($newFileNameDir, 'r+'))) {
                    $done = true;
                    // example:  https://cdn.sanatisharif.ir/media/203/hq/203001dtgr.mp4
                    $fileName = config("constants.DOWNLOAD_SERVER_PROTOCOL") .
                        config("constants.DOWNLOAD_SERVER_NAME") .
                        config("constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH") .
                        $contentSetId .
                        $originalFileName;
                }
            } else {
                $filesystem = Storage::disk($disk . "Sftp");
                //                Storage::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
                if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                    $done = true;
                }

            }
            if ($done)
                return $this->response->setStatusCode(Response::HTTP_OK)
                                      ->setContent([
                                                       "fileName" => $fileName,
                                                       "prefix"   => $filePrefix,
                                                   ]);
            else
                return $this->response->setStatusCode(503);
        }
        catch (\Exception $e) {
            //            return $this->TAG.' '.$e->getMessage();
            $message = "unexpected error";
            return $this->response
                ->setStatusCode(503)
                ->setContent([
                                 "message" => $message,
                                 "error"   => $e->getMessage(),
                                 "line"    => $e->getLine(),
                                 "file"    => $e->getFile(),
                             ]);
        }
    }

    public function adminBot()
    {
        if (!Input::has("bot"))
            dd("Please pass bot as input");

        $bot = Input::get("bot");
        $view = "";
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
        if (strlen($view) > 0)
            return view($view, compact('pageName', 'params'));
        else
            abort(404);

    }

    public function smsBot()
    {
        abort("403");
    }
    //    public function certificates()
    //    {
    //        return view("pages.certificates");
    //    }

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
                                   $q->whereNull("orderproducttype_id")
                                     ->orWhere("orderproducttype_id", config("constants.ORDER_PRODUCT_TYPE_DEFAULT"));
                               })
                               ->get();
                dd($orders->pluck("id")
                          ->toArray());

            }

            if ($request->has("voucherbot")) {
                $asiatechProduct = config("constants.ASIATECH_FREE_ADSL");
                $voucherPendingOrders = Order::where("orderstatus_id", config("constants.ORDER_STATUS_PENDING"))
                                             ->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"))
                                             ->whereHas("orderproducts", function ($q) use ($asiatechProduct) {
                                                 $q->where("product_id", $asiatechProduct);
                                             })
                                             ->orderBy("completed_at")
                                             ->get();
                echo "<span style='color:blue'>Number of orders: " . $voucherPendingOrders->count() . "</span>";
                echo "<br>";
                $counter = 0;
                $nowDateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                                     ->timezone('Asia/Tehran');
                foreach ($voucherPendingOrders as $voucherOrder) {
                    $orderUser = $voucherOrder->user;
                    $unusedVoucher = Productvoucher::whereNull("user_id")
                                                   ->where("enable", 1)
                                                   ->where("expirationdatetime", ">", $nowDateTime)
                                                   ->where("product_id", $asiatechProduct)
                                                   ->get()
                                                   ->first();
                    if (isset($unusedVoucher)) {
                        $voucherOrder->orderstatus_id = config("constants.ORDER_STATUS_CLOSED");
                        if ($voucherOrder->update()) {
                            $userVoucher = $orderUser->productvouchers()
                                                     ->where("enable", 1)
                                                     ->where("expirationdatetime", ">", $nowDateTime)
                                                     ->where("product_id", $asiatechProduct)
                                                     ->get();

                            if ($userVoucher->isEmpty()) {

                                $unusedVoucher->user_id = $orderUser->id;
                                if ($unusedVoucher->update()) {

                                    event(new FreeInternetAccept($orderUser));
                                    $counter++;
                                } else {
                                    echo "<span style='color:red'>Error on giving voucher to user #" . $orderUser->id . "</span>";
                                    echo "<br>";
                                }
                            } else {
                                echo "<span style='color:orangered'>User  #" . $orderUser->id . " already has a voucher code</span>";
                                echo "<br>";
                            }
                        } else {
                            echo "<span style='color:red'>Error on updating order #" . $voucherOrder->id . " for user #" . $orderUser->id . "</span>";
                            echo "<br>";
                        }
                    } else {
                        echo "<span style='color:orangered'>Could not find voucher for user  #" . $orderUser->id . "</span>";
                        echo "<br>";
                    }
                }
                echo "<span style='color:green'>Number of processed orders: " . $counter . "</span>";
                echo "<br>";
                dd("DONE!");
            }

            if ($request->has("smsarabi")) {
                $hamayeshTalai = [
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
                $users = User::whereHas("orderproducts", function ($q) use ($hamayeshTalai) {
                    $q->whereHas("order", function ($q) use ($hamayeshTalai) {
                        $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                          ->whereIn("paymentstatus_id", [
                              config("constants.PAYMENT_STATUS_PAID"),
                          ]);
                    })
                      ->whereIn("product_id", [214]);
                    //                        ->havingRaw('COUNT(*) > 0');
                })
                             ->whereDoesntHave("orderproducts", function ($q) use ($hamayeshTalai) {
                                 $q->whereHas("order", function ($q) use ($hamayeshTalai) {
                                     $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                                       ->whereIn("paymentstatus_id", [
                                           config("constants.PAYMENT_STATUS_PAID"),
                                       ]);
                                 })
                                   ->where("product_id", 223);
                             })
                             ->get();

                echo "Number of users:" . $users->count();
                dd("stop");

                foreach ($users as $user) {
                    $message = "آلایی عزیز تا جمعه ظهر فرصت دارید تا حضور خود در همایش  حضوری عربی را اعلام کنید";
                    $message .= "\n";
                    $message .= "sanatisharif.ir/user/" . $user->id;
                    $user->notify(new GeneralNotice($message));
                }

                dd("Done");
            }

            if ($request->has("coupon")) {
                $hamayeshTalai = [
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
                $notIncludedUsers_Shimi = [
                    2
                    ,
                    111
                    ,
                    117
                    ,
                    203
                    ,
                    347
                    ,
                    417
                    ,
                    806
                    ,
                    923
                    ,
                    963
                    ,
                    1132
                    ,
                    1680
                    ,
                    2150
                    ,
                    2439
                    ,
                    2501
                    ,
                    3176
                    ,
                    3194
                    ,
                    3350
                    ,
                    3778
                    ,
                    3854
                    ,
                    4058
                    ,
                    4134
                    ,
                    4273
                    ,
                    4598
                    ,
                    4994
                    ,
                    5443
                    ,
                    5543
                    ,
                    5949
                    ,
                    6159
                    ,
                    6655
                    ,
                    6712
                    ,
                    7109
                    ,
                    7200
                    ,
                    7325
                    ,
                    7467
                    ,
                    7772
                    ,
                    8151
                    ,
                    8568
                    ,
                    8934
                    ,
                    9247
                    ,
                    9895
                    ,
                    9926
                    ,
                    10127
                    ,
                    10577
                    ,
                    10690
                    ,
                    11017
                    ,
                    11412
                    ,
                    11428
                    ,
                    11513
                    ,
                    11517
                    ,
                    11569
                    ,
                    11619
                    ,
                    11688
                    ,
                    11854
                    ,
                    12173
                    ,
                    12196
                    ,
                    12347
                    ,
                    12443
                    ,
                    12492
                    ,
                    12621
                    ,
                    12672
                    ,
                    12720
                    ,
                    12907
                    ,
                    12959
                    ,
                    13004
                    ,
                    13557
                    ,
                    13583
                    ,
                    13742
                    ,
                    13928
                    ,
                    14046
                    ,
                    14371
                    ,
                    14680
                    ,
                    14870
                    ,
                    15020
                    ,
                    15028
                    ,
                    15079
                    ,
                    15136
                    ,
                    15195
                    ,
                    15330
                    ,
                    15722
                    ,
                    15774
                    ,
                    15893
                    ,
                    16667
                    ,
                    16698
                    ,
                    17671
                    ,
                    18250
                    ,
                    19010
                    ,
                    19169
                    ,
                    19384
                    ,
                    19394
                    ,
                    19588
                    ,
                    20123
                    ,
                    20191
                    ,
                    20285
                    ,
                    20403
                    ,
                    20460
                    ,
                    20534
                    ,
                    20641
                    ,
                    20643
                    ,
                    20669
                    ,
                    20865
                    ,
                    21261
                    ,
                    21292
                    ,
                    21442
                    ,
                    21468
                    ,
                    21471
                    ,
                    21513
                    ,
                    21536
                    ,
                    21663
                    ,
                    21681
                    ,
                    21792
                    ,
                    21922
                    ,
                    22126
                    ,
                    22397
                    ,
                    22419
                    ,
                    22560
                    ,
                    22597
                    ,
                    22733
                    ,
                    23281
                    ,
                    23410
                    ,
                    24019
                    ,
                    24373
                    ,
                    24463
                    ,
                    24683
                    ,
                    24902
                    ,
                    25243
                    ,
                    25276
                    ,
                    25375
                    ,
                    25436
                    ,
                    26289
                    ,
                    26860
                    ,
                    27276
                    ,
                    27387
                    ,
                    27519
                    ,
                    27588
                    ,
                    27590
                    ,
                    27757
                    ,
                    27864
                    ,
                    27886
                    ,
                    27902
                    ,
                    28038
                    ,
                    28117
                    ,
                    28143
                    ,
                    28280
                    ,
                    28340
                    ,
                    28631
                    ,
                    28898
                    ,
                    28907
                    ,
                    29041
                    ,
                    29503
                    ,
                    29740
                    ,
                    29787
                    ,
                    29972
                    ,
                    30087
                    ,
                    30093
                    ,
                    30255
                    ,
                    30367
                    ,
                    30554
                    ,
                    31028
                    ,
                    31033
                    ,
                    31334
                    ,
                    31863
                    ,
                    32573
                    ,
                    32707
                    ,
                    32819
                    ,
                    33189
                    ,
                    33198
                    ,
                    33386
                    ,
                    33666
                    ,
                    33785
                    ,
                    34617
                    ,
                    34851
                    ,
                    34913
                    ,
                    34939
                    ,
                    35468
                    ,
                    35564
                    ,
                    35800
                    ,
                    36119
                    ,
                    36235
                    ,
                    36256
                    ,
                    36753
                    ,
                    36841
                    ,
                    36921
                    ,
                    36950
                    ,
                    37789
                    ,
                    38224
                    ,
                    38368
                    ,
                    38530
                    ,
                    38584
                    ,
                    38604
                    ,
                    38683
                    ,
                    39527
                    ,
                    40743
                    ,
                    42260
                    ,
                    42491
                    ,
                    42676
                    ,
                    42747
                    ,
                    42878
                    ,
                    43381
                    ,
                    44086
                    ,
                    44328
                    ,
                    44399
                    ,
                    44872
                    ,
                    46301
                    ,
                    46357
                    ,
                    46511
                    ,
                    46567
                    ,
                    46641
                    ,
                    46736
                    ,
                    47586
                    ,
                    47612
                    ,
                    47624
                    ,
                    48050
                    ,
                    48417
                    ,
                    48693
                    ,
                    49249
                    ,
                    49543
                    ,
                    50084
                    ,
                    50883
                    ,
                    51899
                    ,
                    51969
                    ,
                    52058
                    ,
                    53232
                    ,
                    54116
                    ,
                    56841
                    ,
                    57559
                    ,
                    61798
                    ,
                    62314
                    ,
                    62449
                    ,
                    63522
                    ,
                    64092
                    ,
                    64235
                    ,
                    66573
                    ,
                    67570
                    ,
                    68263
                    ,
                    68482
                    ,
                    69806
                    ,
                    70904
                    ,
                    71801
                    ,
                    73465
                    ,
                    76536
                    ,
                    78080
                    ,
                    78813
                    ,
                    80023
                    ,
                    80349
                    ,
                    81118
                    ,
                    81753
                    ,
                    82728
                    ,
                    83913
                    ,
                    85670
                    ,
                    87430
                    ,
                    88302
                    ,
                    92617
                    ,
                    94553
                    ,
                    94766
                    ,
                    95339
                    ,
                    95588
                    ,
                    96011
                    ,
                    97934
                    ,
                    98640
                    ,
                    103379
                    ,
                    103875
                    ,
                    103961
                    ,
                    105811
                    ,
                    106239
                    ,
                    106313
                    ,
                    107562
                    ,
                    107751
                    ,
                    108011
                    ,
                    108113
                    ,
                    109148
                    ,
                    109770
                    ,
                    109952
                    ,
                    112128
                    ,
                    112816
                    ,
                    113664
                    ,
                    114751
                    ,
                    116219
                    ,
                    116809,
                ];
                $notIncludedUsers_Vafadaran = [
                    100
                    ,
                    272
                    ,
                    282
                    ,
                    502
                    ,
                    589
                    ,
                    751
                    ,
                    1031
                    ,
                    1281
                    ,
                    1421
                    ,
                    1565
                    ,
                    1572
                    ,
                    1695
                    ,
                    1846
                    ,
                    2143
                    ,
                    2385
                    ,
                    2661
                    ,
                    3396
                    ,
                    3538
                    ,
                    3646
                    ,
                    3738
                    ,
                    3788
                    ,
                    4051
                    ,
                    4117
                    ,
                    4197
                    ,
                    4517
                    ,
                    5009
                    ,
                    5385
                    ,
                    5877
                    ,
                    6452
                    ,
                    6767
                    ,
                    6895
                    ,
                    6896
                    ,
                    7020
                    ,
                    7037
                    ,
                    7056
                    ,
                    7192
                    ,
                    7291
                    ,
                    7442
                    ,
                    7527
                    ,
                    7942
                    ,
                    8199
                    ,
                    8681
                    ,
                    9363
                    ,
                    10244
                    ,
                    10263
                    ,
                    10343
                    ,
                    11088
                    ,
                    11133
                    ,
                    11339
                    ,
                    11440
                    ,
                    11594
                    ,
                    11623
                    ,
                    11742
                    ,
                    11797
                    ,
                    11804
                    ,
                    12155
                    ,
                    12788
                    ,
                    13313
                    ,
                    13410
                    ,
                    13436
                    ,
                    13442
                    ,
                    13448
                    ,
                    13541
                    ,
                    13724
                    ,
                    13746
                    ,
                    13752
                    ,
                    14084
                    ,
                    14807
                    ,
                    14937
                    ,
                    15603
                    ,
                    15914
                    ,
                    16114
                    ,
                    16141
                    ,
                    16291
                    ,
                    16491
                    ,
                    16779
                    ,
                    17275
                    ,
                    17500
                    ,
                    17527
                    ,
                    18344
                    ,
                    18377
                    ,
                    18663
                    ,
                    18759
                    ,
                    19481
                    ,
                    19714
                    ,
                    19736
                    ,
                    20016
                    ,
                    20150
                    ,
                    20172
                    ,
                    20381
                    ,
                    20442
                    ,
                    20501
                    ,
                    20652
                    ,
                    20666
                    ,
                    20732
                    ,
                    20753
                    ,
                    20937
                    ,
                    20953
                    ,
                    21412
                    ,
                    21431
                    ,
                    21522
                    ,
                    22275
                    ,
                    22290
                    ,
                    22391
                    ,
                    22495
                    ,
                    23130
                    ,
                    23438
                    ,
                    23600
                    ,
                    23986
                    ,
                    24223
                    ,
                    24472
                    ,
                    25457
                    ,
                    25557
                    ,
                    25572
                    ,
                    25776
                    ,
                    25806
                    ,
                    26355
                    ,
                    26621
                    ,
                    27764
                    ,
                    28269
                    ,
                    28288
                    ,
                    28371
                    ,
                    28385
                    ,
                    28397
                    ,
                    28405
                    ,
                    28488
                    ,
                    28719
                    ,
                    28865
                    ,
                    29021
                    ,
                    29050
                    ,
                    29054
                    ,
                    29194
                    ,
                    29230
                    ,
                    29334
                    ,
                    29589
                    ,
                    29737
                    ,
                    30038
                    ,
                    30129
                    ,
                    30158
                    ,
                    30318
                    ,
                    30652
                    ,
                    30857
                    ,
                    30958
                    ,
                    31508
                    ,
                    32131
                    ,
                    32274
                    ,
                    32894
                    ,
                    32906
                    ,
                    32959
                    ,
                    32987
                    ,
                    33187
                    ,
                    33255
                    ,
                    33616
                    ,
                    33680
                    ,
                    33803
                    ,
                    33817
                    ,
                    33949
                    ,
                    34018
                    ,
                    34062
                    ,
                    34188
                    ,
                    34966
                    ,
                    35004
                    ,
                    35327
                    ,
                    35652
                    ,
                    35911
                    ,
                    35929
                    ,
                    35936
                    ,
                    36264
                    ,
                    36364
                    ,
                    36444
                    ,
                    36460
                    ,
                    36524
                    ,
                    36788
                    ,
                    36793
                    ,
                    36883
                    ,
                    37006
                    ,
                    37021
                    ,
                    37058
                    ,
                    37156
                    ,
                    38868
                    ,
                    38893
                    ,
                    39022
                    ,
                    39062
                    ,
                    39075
                    ,
                    40088
                    ,
                    40189
                    ,
                    40503
                    ,
                    40958
                    ,
                    41389
                    ,
                    41448
                    ,
                    41858
                    ,
                    42848
                    ,
                    43322
                    ,
                    44436
                    ,
                    46322
                    ,
                    48191
                    ,
                    49032
                    ,
                    49314
                    ,
                    50637
                    ,
                    50671
                    ,
                    51091
                    ,
                    54884
                    ,
                    56547
                    ,
                    57493
                    ,
                    57649
                    ,
                    58317
                    ,
                    59178
                    ,
                    62602
                    ,
                    62713
                    ,
                    62903
                    ,
                    62987
                    ,
                    63530
                    ,
                    66143
                    ,
                    66485
                    ,
                    68472
                    ,
                    69136
                    ,
                    71817
                    ,
                    72386
                    ,
                    72458
                    ,
                    73399
                    ,
                    75119
                    ,
                    76888
                    ,
                    77855
                    ,
                    78596
                    ,
                    78897
                    ,
                    80328
                    ,
                    80408
                    ,
                    80973
                    ,
                    82093
                    ,
                    82744
                    ,
                    82785
                    ,
                    83048
                    ,
                    83991
                    ,
                    85557
                    ,
                    86966
                    ,
                    87086
                    ,
                    87791
                    ,
                    88977
                    ,
                    90447
                    ,
                    92857
                    ,
                    92951
                    ,
                    93432
                    ,
                    93701
                    ,
                    99623
                    ,
                    99686
                    ,
                    101628
                    ,
                    107960
                    ,
                    108174
                    ,
                    110145
                    ,
                    115132
                    ,
                    118902
                    ,
                    119386
                    ,
                    125351,
                ];
                $smsNumber = config("constants.SMS_PROVIDER_DEFAULT_NUMBER");
                $users = User::whereHas("orderproducts", function ($q) use ($hamayeshTalai) {
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

                echo "number of users:" . $users->count();
                echo "<br>";
                dd("stop");
                $couponController = new CouponController();
                $failedCounter = 0;
                $proccessed = 0;
                dump($users->pluck("id")
                           ->toArray());

                foreach ($users as $user) {
                    do {
                        $couponCode = str_random(5);
                    }
                    while (\App\Coupon::where("code", $couponCode)
                                      ->get()
                                      ->isNotEmpty());

                    /** Coupon Settings */
                    $couponName = "قرعه کشی وفاداران آلاء برای " . $user->getFullName();
                    $couponDescription = "قرعه کشی وفاداران آلاء برای " . $user->getFullName();
                    $validSinceDate = "2018-06-11";
                    $validUntilDate = " 00:00:00";
                    $validSinceTime = "2018-06-15";
                    $validUntilTime = "12:00:00";
                    $couponProducts = \App\Product::whereNotIn("id", [
                        179,
                        180,
                        182,
                    ])
                                                  ->get()
                                                  ->pluck('id')
                                                  ->toArray();
                    $discount = 55;
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
                        echo "user " . $user->id . " notfied";
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

                dump("processed: " . $proccessed);
                dump("failed: " . $failedCounter);
                dd("coupons done");

            }

            if ($request->has("tagfix")) {
                $contentsetId = 159;
                $contentset = Contentset::where("id", $contentsetId)
                                        ->first();

                $tags = $contentset->tags->tags;
                array_push($tags, "نادریان");
                $bucket = "contentset";
                $tagsJson = [
                    "bucket" => $bucket,
                    "tags"   => $tags,
                ];
                $contentset->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);

                if ($contentset->update()) {
                    $params = [
                        "tags" => json_encode($contentset->tags->tags, JSON_UNESCAPED_UNICODE),
                    ];
                    if (isset($contentset->created_at) && strlen($contentset->created_at) > 0)
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $contentset->created_at)->timestamp;

                    $response = $this->sendRequest(
                        config("constants.TAG_API_URL") . "id/$bucket/" . $contentset->id,
                        "PUT",
                        $params
                    );
                } else {
                    dump("Error on updating #" . $contentset->id);
                }

                $contents = $contentset->contents;

                foreach ($contents as $content) {
                    $tags = $content->tags->tags;
                    array_push($tags, "نادریان");
                    $bucket = "content";
                    $tagsJson = [
                        "bucket" => $bucket,
                        "tags"   => $tags,
                    ];
                    $content->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                    if ($content->update()) {
                        $params = [
                            "tags" => json_encode($content->tags->tags, JSON_UNESCAPED_UNICODE),
                        ];
                        if (isset($content->created_at) && strlen($content->created_at) > 0)
                            $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $content->created_at)->timestamp;

                        $response = $this->sendRequest(
                            config("constants.TAG_API_URL") . "id/$bucket/" . $content->id,
                            "PUT",
                            $params
                        );
                    } else {
                        dump("Error on updating #" . $content->id);
                    }
                }
                dd("Tags DONE!");
            }
        }
        catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response
                ->setStatusCode(503)
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
         * $q2->where("product_id" , $product->id)->whereNull("orderproducttype_id");
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

    public function convertArray(array $input)
    {
        foreach ($input as $key => $value) {
            $input[$key] = $this->convert($value);
        }
        return $input;
    }

    /**
     * @param $result
     *
     * @return string
     */
    public function convert($result): string
    {
        return iconv(mb_detect_encoding($result, mb_detect_order(), true), "UTF-8", $result);
        //         return iconv('windows-1250', 'utf-8', $result) ;
        //        return chr(255) . chr(254).mb_convert_encoding($result, 'UTF-16LE', 'UTF-8');
        //        return utf8_encode($result);
    }

    public function walletBot(Request $request)
    {
        if (!$request->has("userGroup")) {
            session()->put("error", "لطفا گروه کاربران را تعیین کنید");
            return redirect()->back();
        } else {
            $userGroup = $request->get("userGroup");
        }

        $hamayeshTalai = [
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
        $ordooHozoori = [
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
        $hamayesh5Plus1 = [
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
                    if (isset($products["filter"]))
                        $filterType = $products["filter"];
                    else
                        $filterType = "";

                    if (isset($products["id"]))
                        $idArray = $products["id"];
                    else
                        $idArray = [];

                    $q->whereHas("orderproducts", function ($q2) use ($idArray, $filterType) {
                        if (!empty($idArray) && strlen($filterType) > 0) {
                            foreach ($idArray as $key => $ids) {
                                if ($key > 0)
                                    $myFilterType = "or" . $filterType;
                                else
                                    $myFilterType = $filterType;

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
        dump("Total number of users:" . $users->count());

        if (!$request->has("giveGift"))
            dd("Done!");

        $successCounter = 0;
        $failedCounter = 0;
        foreach ($users as $user) {
            $result = $user->deposit($giftCredit, 2);
            if (isset($result["wallet"]))
                $wallet = $result["wallet"];
            else
                $wallet = "unknown";
            if ($result["result"]) {
                $user->notify(new GiftGiven($giftCredit));
                $successCounter++;
            } else {
                $failedCounter++;
                dump("Credit for user: " . $user->id . " was not given!" . "wallet: " . $wallet . " ,response: " . $result["responseText"]);
            }

        }
        dump("Number of successfully processed users: ", $successCounter);
        dump("Number of failed users: ", $failedCounter);
        dd("Done!");
    }

    public function pointBot(Request $request)
    {
        abort(404);
        /** Points for Hamayesh Talai lottery */
        //        $hamayeshTalai = [ 210 , 211 ,212 ,213 , 214,216,217,218,219,220,221, 222 ];
        //
        //        $orderproducts = Orderproduct::whereHas("order" , function ($q) use ($hamayeshTalai){
        //                                $q->whereIn("orderstatus_id" , [2,5,7])
        //                                  ->whereIn("paymentstatus_id" , [3]);
        //                            })->whereIn("product_id" , $hamayeshTalai)
        //                              ->get();
        //        $users = [];
        //        $successCounter = 0;
        //        $failedCounter = 0 ;
        //        $warningCounter = 0 ;
        //        foreach ($orderproducts as $orderproduct)
        //        {
        //            if(isset($orderproduct->order->user->id))
        //            {
        //                $user = $orderproduct->order->user ;
        //                if(isset($users[$user->id]))
        //                {
        //                    $users[$user->id]++;
        //                }
        //                else
        //                {
        //                    $users[$user->id] = 1 ;
        //                }
        //            }
        //            else
        //            {
        //                dump("User was not found for orderproduct ".$orderproduct->id);
        //                $warningCounter++;
        //            }
        //        }
        //
        //        // USERS WITH PLUS POINTS
        //        $orders = Order::where("completed_at" , "<" , "2018-05-18")
        //                        ->whereIn("orderstatus_id" , [2,5,7])
        //                        ->whereIn("paymentstatus_id" , [3])
        //                        ->whereHas("orderproducts" , function ($q) use ($hamayeshTalai){
        //                            $q->whereIn("product_id" , $hamayeshTalai);
        //                        })
        //                        ->pluck("user_id")
        //                        ->toArray();
        //
        //        $usersPlus = [];
        //        foreach ($orders as $userId)
        //        {
        //            if(in_array($userId , $usersPlus))
        //                continue;
        //            else
        //                array_push($usersPlus , $userId) ;
        //
        //            if(isset($users[$userId]))
        //            {
        //                $users[$userId]++ ;
        //            }
        //            else
        //            {
        //                $users[$userId] = 1 ;
        //            }
        //
        //        }
        /** Points for Hamayesh Talai lottery */


        /** Points for Eide Fetr lottery */
        $transactions = Transaction::whereHas("order", function ($q) {
            $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
              ->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"));
        })
                                   ->whereBetween("completed_at", [
                                       "2018-06-14 21:30:00",
                                       "2018-06-30 19:30:00",
                                   ])
                                   ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
                                   ->where("cost", ">", 0)
                                   ->get();

        $users = collect();
        $amountUnit = 40000;
        $successCounter = 0;
        $failedCounter = 0;
        $warningCounter = 0;
        foreach ($transactions as $transaction) {
            $user = $transaction->order->user;
            if (isset($user)) {
                $userRecord = $users->where("user_id", $user->id)
                                    ->first();
                if (isset($userRecord)) {
                    $userRecord["totalAmount"] += $transaction->cost;
                    $point = (int)($userRecord["totalAmount"] / $amountUnit);
                    $userRecord["point"] = $point;
                } else {
                    $point = (int)($transaction->cost / $amountUnit);
                    $users->push([
                                     "user_id"     => $user->id,
                                     "totalAmount" => $transaction->cost,
                                     "point"       => $point,
                                 ]);
                }
            } else {
                dump("User was not found for transaction " . $transaction->id);
                $warningCounter++;
            }
        }

        //        $users = $users->where("point"  , ">" , 0);

        dd("STOP");
        //        $userbons = Userbon::where("bon_id" , 2)
        //                            ->where("created_at" , ">" , "2018-05-24 00:00:00")
        //                            ->where("totalNumber" , ">=" , "3")
        //                            ->get();
        //
        //        foreach ($userbons as $userbon)
        //        {
        //            $user = $userbon->user;
        //            $successfulTransactions = $user->orderTransactions
        //                                        ->where("completed_at" , ">" , "2018-05-24 20:00:00")
        //                                        ->where("transactionstatus_id" , config("constants.TRANSACTION_STATUS_SUCCESSFUL"))
        //                                        ->whereIn("paymentmethod_id" , [
        //                                            config("constants.PAYMENT_METHOD_ONLINE") ,
        //                                            config("constants.PAYMENT_METHOD_ATM")
        //                                        ])
        //                                        ->where("cost" , ">" , 0);
        //            if($successfulTransactions->isNotEmpty())
        //            {
        //                $userRecord = $users->where("user_id" , $user->id)->first();
        //                if(!isset($userRecord))
        //                {
        //                    $users->push([
        //                        "user_id" => $user->id,
        //                        "totalAmount" => -1 ,
        //                        "point" => 1 ,
        //                    ]);
        //                }
        //            }
        //        }
        $bonName = config("constants.BON2");
        $bon = Bon::where("name", $bonName)
                  ->first();
        if (!isset($bon))
            dd("Bon not found");

        dump("Number of available users: " . $users->count());
        foreach ($users as $userPoint) {
            $userId = $userPoint["user_id"];
            $points = $userPoint["point"];

            echo "User Id: " . $userId . " , Points: " . $points;
            echo "<br>";

            if ($points == 0)
                continue;

            $userBon = new Userbon();
            $userBon->bon_id = $bon->id;
            $userBon->user_id = $userId;
            $userBon->totalNumber = $points;
            $userBon->userbonstatus_id = 1;
            $bonResult = $userBon->save();
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
                echo "User " . $userId . " notified , " . $user->mobile;
                echo "</span>";
                echo "<br>";
                $successCounter++;
            } else {
                $failedCounter++;
                dump("Userbon for user " . $userId . " was not created");
            }
        }
        dump("number of successfully processed users: " . $successCounter);
        dump("number of failed users: " . $failedCounter);
        dd("Done!");
    }

    public function excelBot(Request $request)
    {
        $fileName = "list_arabi_hozouri.xlsx";
        $myReader = new Reader();
        $myWriter = new Writer();
        $excel = new Excel($myReader, $myWriter);
        $counter = 0;
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
                    $mobile = $row["mobile"];
                    $nationalCode = $row["nationalcode"];
                    $firstName = $row["firstname"];
                    $lastName = $row["lastname"];
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
                            $mobileValidation = (strlen($mobile) == 11);
                            if ($nationalCodeValidation && $mobileValidation) {
                                $request = new Request();
                                $request->offsetSet("mobile", $mobile);
                                $request->offsetSet("nationalCode", $nationalCode);
                                if (strlen($firstName) > 0)
                                    $request->offsetSet("firstName", $firstName);

                                if (strlen($lastName) > 0)
                                    $request->offsetSet("lastName", $lastName);

                                if (isset($row["major"])) {
                                    if ($row["major"] == "r") {
                                        $request->offsetSet("major_id", 1);
                                    } else if ($row["major"] == "t") {
                                        $request->offsetSet("major_id", 2);
                                    }
                                }
                                if (isset($row["gender"])) {
                                    if ($row["gender"] == "پسر") {
                                        $request->offsetSet("gender_id", 1);
                                    } else if ($row["gender"] == "دختر") {
                                        $request->offsetSet("gender_id", 2);
                                    }
                                }
                                RequestCommon::convertRequestToAjax($request);
                                $response = $this->registerUserAndGiveOrderproduct($request);
                                if ($response->getStatusCode() == 200) {
                                    $counter++;
                                    echo "User inserted: " . $lastName . " " . $mobile;
                                    echo "<br>";
                                } else {
                                    echo "<span style='color:red'>";
                                    echo "Error on inserting user: " . $lastName . " " . $mobile;
                                    echo "</span>";
                                    echo "<br>";
                                }
                            } else {
                                $fault = "";
                                if (!$nationalCodeValidation)
                                    $fault .= " wrong nationalCode ";

                                if (!$mobile)
                                    $fault .= " wrong mobile ";

                                echo "<span style='color:orange'>";
                                echo "Warning! user wrong information: " . $lastName . $fault . " ,in sheet : " . $sheetName;
                                echo "</span>";
                                echo "<br>";
                            }
                        } else {
                            echo "<span style='color:orange'>";
                            echo "Warning! user incomplete information: " . $lastName . " ,in sheet : " . $sheetName;
                            echo "</span>";
                            echo "<br>";
                        }
                    }

                });
            });
        });
        echo "<span style='color:green'>";
        echo "Inserted users: " . $counter;
        echo "</span>";
        echo "<br>";
        dd("Done!");
        //        $rows = Excel::load('storage\\exports\\'. $fileName)->get();
    }

    public function registerUserAndGiveOrderproduct(Request $request)
    {
        try {
            $mobile = $request->get("mobile");
            $nationalCode = $request->get("nationalCode");
            $firstName = $request->get("firstName");
            $lastName = $request->get("lastName");
            $major_id = $request->get("major_id");
            $gender_id = $request->get("gender_id");
            $user = User::where("mobile", $mobile)
                        ->where("nationalCode", $nationalCode)
                        ->first();
            if (isset($user)) {
                $flag = false;
                if (!isset($user->firstName) && isset($firstName)) {
                    $user->firstName = $firstName;
                    $flag = true;
                }
                if (!isset($user->lastName) && isset($lastName)) {
                    $user->lastName = $lastName;
                    $flag = true;
                }
                if (!isset($user->major_id) && isset($major_id)) {
                    $user->major_id = $major_id;
                    $flag = true;
                }
                if (!isset($user->gender_id) && isset($gender_id)) {
                    $user->gender_id = $gender_id;
                    $flag = true;
                }

                if ($flag)
                    $user->update();
            } else {
                $registerRequest = new InsertUserRequest();
                $registerRequest->offsetSet("mobile", $mobile);
                $registerRequest->offsetSet("nationalCode", $nationalCode);
                $registerRequest->offsetSet("firstName", $firstName);
                $registerRequest->offsetSet("lastName", $lastName);
                $registerRequest->offsetSet("password", $nationalCode);
                //                $registerRequest->offsetSet("mobileNumberVerification" , 1);
                $registerRequest->offsetSet("major_id", $major_id);
                $registerRequest->offsetSet("gender_id", $gender_id);
                $registerRequest->offsetSet("userstatus_id", 1);
                $userController = new \App\Http\Controllers\UserController();
                $response = $userController->store($registerRequest);
                $result = json_decode($response->getContent());
                if ($response->getStatusCode() == 200) {
                    $userId = $result->userId;
                    if ($userId > 0) {
                        $user = User::where("id", $userId)
                                    ->first();
                        $user->notify(new UserRegisterd());
                    }
                }
            }

            if (isset($user)) {
                $orderProductIds = [];

                $arabiProduct = 214;
                $hasArabiOrder = $user->orderproducts()
                                      ->where("product_id", $arabiProduct)
                                      ->whereHas("order", function ($q) {
                                          $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"));
                                          $q->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"));
                                      })
                                      ->get();
                if ($hasArabiOrder->isEmpty()) {
                    array_push($orderProductIds, $arabiProduct);
                }

                $shimiProduct = 100;
                $hasShimiOrder = $user->orderproducts()
                                      ->where("product_id", $shimiProduct)
                                      ->whereHas("order", function ($q) {
                                          $q->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"));
                                          $q->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"));
                                      })
                                      ->get();

                if ($hasShimiOrder->isEmpty()) {
                    array_push($orderProductIds, $shimiProduct);
                }

                $giftOrderDone = true;
                if (!empty($orderProductIds)) {
                    $orderController = new OrderController();
                    $storeOrderRequest = new Request();
                    $storeOrderRequest->offsetSet("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"));
                    $storeOrderRequest->offsetSet("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"));
                    $storeOrderRequest->offsetSet("cost", 0);
                    $storeOrderRequest->offsetSet("costwithoutcoupon", 0);
                    $storeOrderRequest->offsetSet("user_id", $user->id);
                    $giftOrderCompletedAt = Carbon::now()
                                                  ->setTimezone("Asia/Tehran");
                    $storeOrderRequest->offsetSet("completed_at", $giftOrderCompletedAt);
                    $giftOrder = $orderController->store($storeOrderRequest);

                    $giftOrderMessage = "ثبت سفارش با موفیت انجام شد";
                    if ($giftOrder !== false) {
                        foreach ($orderProductIds as $productId) {
                            $request->offsetSet("cost", 0);
                            $request->offsetSet("orderId_bhrk", $giftOrder->id);
                            $request->offsetSet("userId_bhrk", $user->id);
                            $product = Product::where("id", $productId)
                                              ->first();
                            if (isset($product)) {
                                $response = $orderController->addOrderproduct($request, $product);
                                $responseStatus = $response->getStatusCode();
                                $result = json_decode($response->getContent());
                                if ($responseStatus == 200) {

                                } else {
                                    $giftOrderDone = false;
                                    $giftOrderMessage = "خطا در ثبت آیتم سفارش";
                                    foreach ($result as $value) {
                                        $giftOrderMessage .= "<br>";
                                        $giftOrderMessage .= $value;
                                    }
                                }
                            } else {
                                $giftOrderDone = false;
                                $giftOrderMessage = "خطا در ثبت آیتم سفارش. محصول یافت نشد.";
                            }
                        }

                    } else {
                        $giftOrderDone = false;
                        $giftOrderMessage = "خطا در ثبت سفارش";
                    }

                } else {
                    $giftOrderMessage = "کاربر مورد نظر محصولات را از قبل داشت";
                }
            } else {
                $giftOrderMessage = "خطا در یافتن کاربر";
            }

            if ($giftOrderDone) {
                if (isset($user->gender_id)) {
                    if ($user->gender->name == "خانم")
                        $gender = "خانم ";
                    else if ($user->gender->name == "آقا")
                        $gender = "آقای ";
                    else
                        $gender = "";
                } else {
                    $gender = "";
                }
                $message = $gender . $user->full_name . "\n";
                $message .= "همایش طلایی عربی و همایش حل مسائل شیمی به فایل های شما افزوده شد . دانلود در:";
                $message .= "\n";
                $message .= "sanatisharif.ir/asset/";
                $user->notify(new GeneralNotice($message));
                session()->put("success", $giftOrderMessage);
            } else
                session()->put("error", $giftOrderMessage);

            if ($request->ajax()) {
                if ($giftOrderDone) {
                    return $this->response
                        ->setStatusCode(200);
                } else {
                    return $this->response
                        ->setStatusCode(503);
                }
            } else {
                return redirect()->back();
            }
        }
        catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response
                ->setStatusCode(500)
                ->setContent([
                                 "message" => $message,
                                 "error"   => $e->getMessage(),
                                 "line"    => $e->getLine(),
                                 "file"    => $e->getFile(),
                             ]);
        }


    }

    public function checkDisableContentTagBot()
    {
        $disableContents = Content::where("enable", 0)
                                  ->get();
        $counter = 0;
        foreach ($disableContents as $content) {
            $tags = $content->retrievingTags();
            if (!empty($tags)) {
                $author = "";
                if (isset($content->author_id))
                    $author = $content->user->lastName;
                dump($content->id . " has tags! type: " . $content->contenttype_id . " author: " . $author);
                $counter++;
            }
        }
        dump("count: " . $counter);
        dd("finish");
    }

    public function tagBot()
    {
        $counter = 0;
        try {
            dump("start time:" . Carbon::now("asia/tehran"));
            if (!Input::has("t"))
                return $this->response->setStatusCode(422)
                                      ->setContent(["message" => "Wrong inputs: Please pass parameter t. Available values: v , p , cs , pr , e , b ,a"]);
            $type = Input::get("t");
            switch ($type) {
                case "v": //Video
                    $bucket = "content";
                    $items = Content::where("contenttype_id", 8)
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
                        if (!empty($majors))
                            $myTags = array_merge($myTags, $majors);
                        $grades = $item->grades->where("name", "graduated")
                                               ->pluck("description")
                                               ->toArray();
                        if (!empty($grades))
                            $myTags = array_merge($myTags, $grades);
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
                        $myTags = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "p": //Pamphlet
                    $bucket = "content";
                    $items = Content::where("contenttype_id", 1)
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
                        if (!empty($majors))
                            $myTags = array_merge($myTags, $majors);
                        $grades = $item->grades->where("name", "graduated")
                                               ->pluck("description")
                                               ->toArray();
                        if (!empty($grades))
                            $myTags = array_merge($myTags, $grades);
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
                        $myTags = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "b": //Book
                    $bucket = "content";
                    $items = Content::where("contenttype_id", 7)
                                    ->where("enable", 1);
                    $items = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "کتاب_درسی",
                            "PDF",
                            "پایه",
                            "نظام_آموزشی_جدید",
                        ];
                        $majors = $item->majors->pluck("description")
                                               ->toArray();
                        if (!empty($majors))
                            $myTags = array_merge($myTags, $majors);
                        $grades = $item->grades->where("name", "graduated")
                                               ->pluck("description")
                                               ->toArray();
                        if (!empty($grades))
                            $myTags = array_merge($myTags, $grades);
                        $myTags = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "e": //Exam
                    $bucket = "content";
                    $items = Content::where("contenttype_id", 2)
                                    ->where("enable", 1);
                    $items = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "آزمون",
                            "PDF",
                        ];
                        $childContentTypes = Contenttype::whereHas("parents", function ($q) {
                            $q->where("name", "exam");
                        })
                                                        ->pluck("description")
                                                        ->toArray();
                        $myTags = array_merge($myTags, $childContentTypes);

                        $majors = $item->majors->pluck("description")
                                               ->toArray();
                        if (!empty($majors))
                            $myTags = array_merge($myTags, $majors);
                        $grades = $item->grades->where("name", "graduated")
                                               ->pluck("description")
                                               ->toArray();
                        if (!empty($grades))
                            $myTags = array_merge($myTags, $grades);

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

                        $myTags = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "a": //Article
                    $bucket = "content";
                    $items = Content::where("contenttype_id", 9)
                                    ->where("enable", 1);
                    $items = $items->get();
                    foreach ($items->where("tags", null) as $item) {
                        $myTags = [
                            "مقاله",
                        ];
                        $majors = $item->majors->pluck("description")
                                               ->toArray();
                        if (!empty($majors))
                            $myTags = array_merge($myTags, $majors);
                        $grades = $item->grades->where("name", "graduated")
                                               ->pluck("description")
                                               ->toArray();
                        if (!empty($grades))
                            $myTags = array_merge($myTags, $grades);
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

                        $myTags = array_merge($myTags, ["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags"   => $myTags,
                        ];
                        $item->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    break;
                case "cs": //Contentset
                    $bucket = "contentset";
                    $items = Contentset::orderBy("id")
                                       ->where("enable", 1);
                    if (Input::has("id")) {
                        $id = Input::get("id");
                        $items = $items->where("id", $id);
                    }
                    $items = $items->get();

                    break;
                case "pr": //Product
                    $bucket = "product";
                    if (Input::has("id")) {
                        $id = Input::get("id");
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
                            183
                            ,
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

                        $tagsJson = [
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
            dump("available items: " . $items->count());
            $successCounter = 0;
            $failedCounter = 0;
            $warningCounter = 0;
            foreach ($items as $item) {
                if (!isset($item)) {
                    $warningCounter++;
                    dump("invalid item at counter" . $counter);
                    continue;
                } else {
                    if (!isset($item->tags)) {
                        $warningCounter++;
                        dump("no tags found for" . $item->id);
                        continue;
                    } else {
                        $itemTagsArray = $item->tags->tags;
                    }
                }

                if (is_array($itemTagsArray) && !empty($itemTagsArray) && isset($item["id"])) {
                    $params = [
                        "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
                    ];
                    if (isset($item->created_at) && strlen($item->created_at) > 0)
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $item->created_at)->timestamp;

                    $response = $this->sendRequest(
                        config("constants.TAG_API_URL") . "id/$bucket/" . $item->id,
                        "PUT",
                        $params
                    );

                    if ($response["statusCode"] == 200) {
                        $successCounter++;
                    } else {
                        dump("item #" . $item["id"] . " failed. response : " . $response["statusCode"]);
                        $failedCounter++;
                    }
                    $counter++;
                } else if (is_array($itemTagsArray) && empty($itemTagsArray)) {
                    $warningCounter++;
                    dump("warning no tags found for item #" . $item->id);
                }
            }
            dump($successCounter . " items successfully done");
            dump($failedCounter . " items failed");
            dump($warningCounter . " warnings");
            dump("finish time:" . Carbon::now("asia/tehran"));
            return $this->response->setStatusCode(200)
                                  ->setContent(["message" => "Done! number of processed items : " . $counter]);
        }
        catch (\Exception $e) {
            $message = "unexpected error";
            dump($successCounter . " items successfully done");
            dump($failedCounter . " items failed");
            dump($warningCounter . " warnings");
            return $this->response->setStatusCode(503)
                                  ->setContent([
                                                   "message"                                => $message,
                                                   "number of successfully processed items" => $counter,
                                                   "error"                                  => $e->getMessage(),
                                                   "line"                                   => $e->getLine(),
                                               ]);
        }
    }

    /**
     * Showing create form for user's kunkoor result
     *
     * @return \Illuminate\Http\Response
     */
    public function submitKonkurResult(Request $request)
    {

        $majors = Major::where("majortype_id", 1)
                       ->get()
                       ->pluck("name", "id")
                       ->toArray();
        $majors = array_add($majors, 0, "انتخاب رشته");
        $majors = array_sort_recursive($majors);
        $event = Event::where("name", "konkur97")
                      ->first();
        $sideBarMode = "closed";

        $userEventReport = Eventresult::where("user_id", Auth::user()->id)
                                      ->where("event_id", $event->id)
                                      ->get()
                                      ->first();

        $pageName = "submitKonkurResult";
        $user = Auth::user();
        $userCompletion = (int)$user->completion();
        $url = $request->url();
        $title = "آلاء|کارنامه سراسری 97";
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

        return view("user.submitEventResultReport", compact("majors",
                                                            "event",
                                                            "sideBarMode",
                                                            "userEventReport",
                                                            "pageName",
                                                            "user",
                                                            "userCompletion"
        ));
    }

    public function schoolRegisterLanding(Request $request)
    {
        abort(404);
        $eventRegistered = false;
        if (Auth::check()) {
            $user = Auth::user();
            $event = Event::where("name", "sabtename_sharif_97")
                          ->get();
            if ($event->isEmpty()) {
                dd("ثبت نام آغاز نشده است");
            } else {
                $event = $event->first();
                $events = $user->eventresults->where("user_id", $user->id)
                                             ->where("event_id", $event->id);
                $eventRegistered = $events->isNotEmpty();
                if ($eventRegistered) {
                    $score = $events->first()->participationCodeHash;
                }
                if (isset($user->firstName) && strlen(preg_replace('/\s+/', '', $user->firstName)) > 0)
                    $firstName = $user->firstName;
                if (isset($user->lastName) && strlen(preg_replace('/\s+/', '', $user->lastName)) > 0)
                    $lastName = $user->lastName;
                if (isset($user->mobile) && strlen(preg_replace('/\s+/', '', $user->mobile)) > 0)
                    $mobile = $user->mobile;
                if (isset($user->nationalCode) && strlen(preg_replace('/\s+/', '', $user->nationalCode)) > 0)
                    $nationalCode = $user->nationalCode;
                $major = $user->major_id;
                $grade = $user->grade_id;

            }

        }
        $url = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
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
        $pageName = "schoolRegisterLanding";
        return view("pages.schoolRegister", compact("pageName", "user", "major", "grade", "firstName", "lastName",
                                                    "mobile", "nationalCode", "score", "eventRegistered"));
    }

    public function specialAddUser(Request $request)
    {
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $pageName = "admin";
        return view("admin.insertUserAndOrderproduct", compact("majors", "genders", "pageName"));
    }

    /**
     * Temporary method for generating special couopns
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminGenerateRandomCoupon(Request $request)
    {
        $productCollection = $products = $this->makeProductCollection();
        return view("admin.generateSpecialCoupon" , compact("productCollection"));
    }
}
