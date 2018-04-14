<?php

namespace App\Http\Controllers;

use App\Articlecategory;
use App\Assignmentstatus;
use App\Attribute;
use App\Attributecontrol;
use App\Attributegroup;
use App\Attributeset;
use App\Attributetype;
use App\Checkoutstatus;
use App\Consultation;
use App\Consultationstatus;
use App\Coupon;
use App\Coupontype;
use App\Educationalcontent;
use App\Gender;
use App\Http\Requests\ContactUsFormRequest;
use App\Http\Requests\SendSMSRequest;
use App\Lottery;
use App\Major;
use App\Orderstatus;
use App\Paymentmethod;
use App\Paymentstatus;
use App\Permission;
use App\Product;
use App\Productfile;
use App\Producttype;
use App\Question;
use App\Relative;
use App\Role;
use App\Slideshow;
use App\Traits\DateCommon;
use App\Traits\ProductCommon;
use App\Transactionstatus;
use App\User;
use App\Userbonstatus;
use App\Userstatus;
use App\Usersurveyanswer;
use App\Userupload;
use App\Useruploadstatus;
use App\Websitesetting;
use App\Websitepage;
use App\Http\Requests\Request;
use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Meta;
use Watson\Sitemap\Facades\Sitemap;
use SSH;
use Auth;

//use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $helper;
    protected $response;
    protected $sideBarAdmin;
    private static $TAG = HomeController::class;
    use ProductCommon;
    use DateCommon;

    public function debug(Request $request){

        $a = Attributegroup::find(1)->attributes;
//        dd($a);
//        return $a;
        $product = \App\Product::find( $request->get("p") );
        $product->getAllAttributes() ;
//        dd($product->children);
//        return $product->getAllAttributes();
        $attributeset = $product->attributeset;
        $attributes = $attributeset->attributes();
//        return $attributes;
//        dd($attributes);
        $productType = $product->producttype->id;
        if (!$product->relationLoaded('attributevalues'))
            $product->load('attributevalues');

        $attributes->load('attributetype','attributecontrol');

        foreach ( $attributes as $attribute) {
            $attributeType = $attribute->attributetype;
            $controlName = $attribute->attributecontrol->name;
            $attributevalues = $product->attributevalues->where("attribute_id", $attribute->id)->sortBy("pivot.order");
            dump($attributevalues);
        }
        return response()->make("Ok");

    }
    public function __construct()
    {
//        $agent = new Agent();
//        if ($agent->isRobot())
//        {
//            $authException = ['index' , 'getImage' , 'error404' , 'error403' , 'error500' , 'errorPage' , 'siteMapXML', 'download' ];
//        }else{
        $authException = ['index', 'getImage', 'error404', 'error403', 'error500', 'errorPage', 'aboutUs', 'contactUs', 'sendMail', 'rules', 'siteMapXML', 'uploadFile'];
//        }
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('ability:' . Config::get("constants.ROLE_ADMIN") . ',' . Config::get("constants.USER_ADMIN_PANEL_ACCESS"), ['only' => 'admin']);
        $this->middleware('permission:' . Config::get('constants.CONSULTANT_PANEL_ACCESS'), ['only' => 'consultantAdmin']);
        $this->middleware('permission:' . Config::get("constants.PRODUCT_ADMIN_PANEL_ACCESS"), ['only' => 'adminProduct']);
        $this->middleware('permission:' . Config::get("constants.CONTENT_ADMIN_PANEL_ACCESS"), ['only' => 'adminContent']);
        $this->middleware('permission:' . Config::get("constants.LIST_ORDER_ACCESS"), ['only' => 'adminOrder']);
        $this->middleware('permission:' . Config::get("constants.SMS_ADMIN_PANEL_ACCESS"), ['only' => 'adminSMS']);
        $this->middleware('permission:' . Config::get("constants.REPORT_ADMIN_PANEL_ACCESS"), ['only' => 'adminReport']);
        $this->helper = new Helper();
        $this->response = new Response();

    }

    public function search(Request $request)
    {
        $search = $request->get("search");

        try {
            $productSearch = Product::search($search)->where("enable", 1)->paginate(10);
            $articleSearch = Article::search($search)->paginate(10);
        } catch (\Exception    $error) {
            $message = "با عرض پوزش ، در حال حاضر دسترسی به این بخش مقدور نمی باشد";
            return $this->errorPage($message);
        }


        return view('pages.search', compact('productSearch', 'articleSearch'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr($setting->site->seo->homepage->metaTitle, 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('keywords', substr($setting->site->seo->homepage->metaKeywords, 0, Config::get("META_KEYWORDS_LIMIT.META_KEYWORDS_LIMIT")));
        Meta::set('description', substr($setting->site->seo->homepage->metaDescription, 0, Config::get("constants.META_DESCRIPTION_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
//        $assignmentstatus_active = Assignmentstatus::all()->where("name" , "active")->first();
//        $assignments = Assignment::all()->sortByDesc('created_at')->where("assignmentstatus_id" , $assignmentstatus_active->id);
        $consultationstatus_active = Consultationstatus::all()->where("name", "active")->first();
        $consultingQuestionCount = Userupload::all()->count();
        $consultations = Consultation::all()->sortByDesc("created_at")->where("consultationstatus_id", $consultationstatus_active->id);
        $consultationCount = $consultations->count();
        $userCount = User::count();
        $pageName = "dashboard";
        $helper = new Helper();
        $todayDate = $helper->convertDate(Carbon::now()->toDateTimeString(), "toJalali");
        $todayDate = explode("/", $todayDate);
        $currentDay = $todayDate[2];
        $currentMonth = $todayDate[1];
        $currentYear = $todayDate[0];
        $websitePageId = Websitepage::all()->where('url', "/home")->first()->id;
        $slides = Slideshow::all()->where("isEnable", 1)->where("websitepage_id", $websitePageId)->sortBy("order");
        $slideCounter = 1;
        $slideDisk = 9;
        $ordooRegisteredCount = 0;

        if (Config::has("constants.HOME_EXCLUDED_PRODUCTS"))
            $excludedProducts = Config::get("constants.HOME_EXCLUDED_PRODUCTS");
        else
            $excludedProducts = [];

        if (Config::has("constants.HOME_PRODUCTS_OFFER")) {
            $productIds = Config::get("constants.HOME_PRODUCTS_OFFER");
            $products = Product::getProducts(0, 1)->orderBy('created_at', 'Desc')->whereIn("id", $productIds)->whereNotIn("id", $excludedProducts)->take(3)->get();
        } else
            $products = Product::recentProducts(2)->whereNotIn("id", $excludedProducts)->get();

        $costCollection = $this->makeCostCollection($products);
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

        $educationalContents = Educationalcontent::enable()->valid()->orderBy("validSince", "DESC")->take(10)->get();
        $educationalContentCollection = collect();
        foreach ($educationalContents as $educationalContent) {
            $educationalContentCollection->push(["id" => $educationalContent->id, "displayName" => $educationalContent->getDisplayName(), "validSince_Jalali" => explode(" ", $educationalContent->validSince_Jalali())[0]]);
        }

        return view('pages.dashboard1', compact('consultations', 'consultationCount', 'consultingQuestionCount', 'pageName', 'userCount', 'currentDay', 'currentMonth', 'currentYear', 'ordooRegisteredCount', 'girlsOrdooRegisteredCount', 'boysOrdooRegisteredCount', 'boysBlocks', 'girlsBlocks', 'slides', 'slideCounter', 'products', 'costCollection', 'slideDisk', 'educationalContents', 'educationalContentCollection'));
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
     * Show the general error page.
     *
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function errorPage($message)
    {
//        $message = Input::get("message");
        if (strlen($message) <= 0) $message = "";
        return view("errors.errorPage", compact("message"));
    }

    /**
     * Show admin panel main page
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $userStatuses->prepend("انتخاب وضعیت");
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $permissions = Permission::pluck('display_name', 'id');
        $roles = Role::pluck('display_name', 'id');
//        $roles = array_add($roles , 0 , "همه نقش ها");
//        $roles = array_sort_recursive($roles);
        $limitStatus = [0 => 'نامحدود', 1 => 'محدود'];
        $enableStatus = [0 => 'غیرفعال', 1 => 'فعال'];

        $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $hasOrder = [0 => 'همه کاربران', 1 => 'کسانی که سفارش ثبت کرده اند', 2 => 'کسانی که سفارش ثبت نکرده اند'];

        $products = $this->makeProductCollection();

        $lockProfileStatus = [0 => "پروفایل باز", 1 => "پروفایل قفل شده"];
        $mobileNumberVerification = [0 => "تایید نشده", 1 => "تایید شده"];

        $tableDefaultColumns = ["نام خانوادگی","نام کوچک", "رشته", "کد ملی", "موبایل", "ایمیل", "شهر", "استان", "وضعیت شماره موبایل", "کد پستی", "آدرس", "مدرسه", "وضعیت", "زمان ثبت نام", "زمان اصلاح", "نقش های کاربر", "تعداد بن", "عملیات"];

        $sortBy = ["updated_at" => "تاریخ اصلاح", "created_at" => "تاریخ ثبت نام", "firstName" => "نام", "lastName" => "نام خانوادگی"];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        $pageName = "admin";

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|مدیریت کاربران", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

        return view("admin.index", compact("pageName", "majors", "userStatuses", "permissions", "roles", "limitStatus", "orderstatuses", "paymentstatuses", "enableStatus", "genders", "hasOrder", "products",
            "lockProfileStatus", "mobileNumberVerification", "tableDefaultColumns", "sortBy", "sortType", "coupons", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Show product admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProduct()
    {
        $attributecontrols = Attributecontrol::pluck('name', 'id')->toArray();
        $enableStatus = [0 => 'غیرفعال', 1 => 'فعال'];
        $attributesets = Attributeset::pluck('name', 'id')->toArray();
        $limitStatus = [0 => 'نامحدود', 1 => 'محدود'];

        $products = Product::pluck('name', 'id')->toArray();
        $coupontype = Coupontype::pluck('displayName', 'id');

        $productTypes = Producttype::pluck("displayName", "id");

        $lastProduct = Product::getProducts(0, 1)->get()->sortByDesc("order")->first();
        if (isset($lastProduct)) {
            $lastOrderNumber = $lastProduct->order + 1;
            $defaultProductOrder = $lastOrderNumber;
        } else {
            $defaultProductOrder = 1;
        }

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|مدیریت محصولات", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
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
        if (Auth::user()->can(Config::get('constants.SHOW_OPENBYADMIN_ORDER')))
            $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])->pluck('displayName', 'id');
        else
            $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN"), Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN")])->pluck('displayName', 'id')->toArray();
//        $orderstatuses= array_sort_recursive(array_add($orderstatuses , 0 , "دارای هر وضعیت سفارش")->toArray());

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id')->toArray();
        $majors = Major::pluck('name', 'id');
        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        if(Auth::user()->hasRole("onlineNoroozMarketing"))
        {
            $products = [Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT")];
            $products = $this->makeProductCollection($products);
        }
        else
        {
            $products = $this->makeProductCollection();
        }


        $paymentMethods = Paymentmethod::pluck('displayName', 'id')->toArray();

        $attributevalueCollection = collect();
        $extraAttributes = Attribute::whereHas("attributegroups", function ($q) {
            $q->where("attributetype_id", 2);
        })->get();
        foreach ($extraAttributes as $attribute) {
            $values = array();
            $values = array_merge($values, $attribute->attributevalues->pluck("id", "name")->toArray());
            if (!empty($values)) $attributevalueCollection->put($attribute->displayName, $values);
        }

        $sortBy = ["updated_at" => "تاریخ اصلاح مدیریتی", "completed_at" => "تاریخ ثبت نهایی", "created_at" => "تاریخ ثبت اولیه", "userFirstName" => "نام مشتری", "userLastName" => "نام خانوادگی مشتری" /* , "productName" => "نام محصول"*/];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];

        $transactionTypes = [0 => "واریز شده", 1 => "بازگشت داده شده"];

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $transactionStatuses = Transactionstatus::orderBy("order")->pluck("displayName", "id")->toArray();

        $userBonStatuses = Userbonstatus::pluck("displayName", "id");

        $orderTableDefaultColumns = ["محصولات", "نام خانوادگی","نام کوچک", "رشته", "استان", "شهر", "آدرس", "کد پستی", "موبایل", "مبلغ(تومان)", "عملیات", "ایمیل", "پرداخت شده(تومان)", "مبلغ برگشتی(تومان)", "بدهکار/بستانکار(تومان)", "توضیحات مسئول", "کد مرسوله پستی", "توضیحات مشتری", "وضعیت سفارش", "وضعیت پرداخت", "کدهای تراکنش", "تاریخ اصلاح مدیریتی", "تاریخ ثبت نهایی", "ویژگی ها", "تعداد بن استفاده شده", "تعداد بن اضافه شده به شما از این سفارش", "کپن استفاده شده", "تاریخ ایجاد اولیه"];
        $transactionTableDefaultColumns = ["نام مشتری", "تراکنش پدر", "موبایل", "مبلغ سفارش", "مبلغ تراکنش", "کد تراکنش", "نحوه پرداخت", "تاریخ ثبت", "عملیات", "توضیح مدیریتی", "مبلغ فیلتر شده", "مبلغ آیتم افزوده"];
        $userBonTableDefaultColumns = ["نام کاربر", "تعداد بن تخصیص داده شده", "وضعیت بن", "نام کالایی که از خرید آن بن دریافت کرده است", "تاریخ درج", "عملیات"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|مدیریت سفارش ها", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

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

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|مدیریت محتوا", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

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
        $questions = Userupload::all()->sortByDesc('created_at');
        $questionStatusDone = Useruploadstatus::all()->where("name", "done")->first();
        $questionStatusPending = Useruploadstatus::all()->where("name", "pending")->first();
        $newQuestionsCount = Userupload::all()->where("useruploadstatus_id", $questionStatusPending->id)->count();
        $answeredQuestionsCount = Userupload::all()->where("useruploadstatus_id", $questionStatusDone->id)->count();
        $counter = 0;

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|پنل مشاور", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
        $pageName = "consultantAdmin";
        return view("admin.consultant.consultantAdmin", compact("questions", "counter", "pageName", "newQuestionsCount", "answeredQuestionsCount"));
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantEntekhabReshte()
    {
        $user = User::FindOrFail(Input::get("user"));
        if (Storage::disk('entekhabReshte')->exists($user->id . "-" . $user->major->id . ".txt")) {
            $storedMajors = json_decode(Storage::disk('entekhabReshte')->get($user->id . "-" . $user->major->id . ".txt"));
            $parentMajorId = $user->major->id;
            $storedMajorsInfo = Major::whereHas("parents", function ($q) use ($storedMajors, $parentMajorId) {
                $q->where("major1_id", $parentMajorId)->whereIn("majorCode", $storedMajors);
            })->get();

            $selectedMajors = array();
            foreach ($storedMajorsInfo as $storedMajorInfo) {
                $storedMajor = $storedMajorInfo->parents->where("id", $parentMajorId)->first();
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
            $userSurveyAnswers->push(["questionStatement" => $question->statement, "questionAnswer" => $dataJson]);
        }

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|پنل انتخاب رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

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
        $usersurveyanswers = Usersurveyanswer::where("event_id", $eventId)->where("survey_id", $surveyId)->get()->groupBy("user_id");

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|لیست انتخاب رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

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
        $majorCodes = json_encode($request->get("majorCodes"));

        Storage::disk('entekhabReshte')->delete($userId . '-' . $parentMajor . '.txt');
        Storage::disk('entekhabReshte')->put($userId . "-" . $parentMajor . ".txt", $majorCodes);
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
        $userStatuses->prepend("انتخاب وضعیت");
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $roles = Role::pluck('display_name', 'id');

        $orderstatuses = Orderstatus::whereNotIn('name', ['open'])->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $products = $this->makeProductCollection();

        $lockProfileStatus = [0 => "پروفایل باز", 1 => "پروفایل قفل شده"];
        $mobileNumberVerification = [0 => "تایید نشده", 1 => "تایید شده"];

        $relatives = Relative::pluck('displayName', 'id');
        $relatives->prepend('فرد');

        $sortBy = ["updated_at" => "تاریخ اصلاح", "created_at" => "تاریخ ثبت نام", "firstName" => "نام", "lastName" => "نام خانوادگی"];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        $pageName = "admin";

        $smsCredit = (int)$this->helper->medianaGetCredit();

        $smsProviderNumber = Config::get('constants.SMS_PROVIDER_NUMBER');

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|پنل پیامک", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

        return view("admin.indexSMS", compact("pageName", "majors", "userStatuses",
            "roles", "relatives", "orderstatuses", "paymentstatuses", "genders", "products", "allRootProducts", "lockProfileStatus",
            "mobileNumberVerification", "sortBy", "sortType", "smsCredit", "smsProviderNumber",
            "numberOfFatherPhones", "numberOfMotherPhones", "coupons", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSlideShow()
    {

        $slideController = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()->where('url', "/home")->first()->id;
        $slides = $slideController->index()->where("websitepage_id", $slideWebsitepageId);
        $slideDisk = 9;
        $slideContentName = "عکس اسلاید صفحه اصلی";
        $sideBarMode = "closed";
        $section = "slideShow";

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|مدیریت اسلاید شو", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

        return view("admin.siteConfiguration.slideShow", compact("slides", "sideBarMode", "section", "slideDisk", "slideContentName", "slideWebsitepageId"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminArticleSlideShow()
    {

        $slideController = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()->where('url', "/لیست-مقالات")->first()->id;
        $slides = $slideController->index()->where("websitepage_id", $slideWebsitepageId);
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
        $setting = Websitesetting::where("version", 1)->get()->first();

        Meta::set('title', substr("تخته خاک|پیکربندی سایت", 0, Config::get("constants.META_TITLE_LIMIT")));
        return redirect(action('WebsiteSettingController@show', $setting));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminMajor()
    {
        $parentName = Input::get("parent");
        $parentMajor = Major::all()->where("name", $parentName)->where("majortype_id", 1)->first();

        $majors = Major::where("majortype_id", 2)->orderBy("name")->whereHas("parents", function ($q) use ($parentMajor) {
            $q->where("major1_id", $parentMajor->id);
        })->get();

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|مدیریت رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

        return view("admin.indexMajor", compact("parentMajor", "majors"));
    }

    /**
     * Admin panel for getting a special report
     */
    public function adminReport()
    {
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $userStatuses->prepend("انتخاب وضعیت");
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $permissions = Permission::pluck('display_name', 'id');
        $roles = Role::pluck('display_name', 'id');
//        $roles = array_add($roles , 0 , "همه نقش ها");
//        $roles = array_sort_recursive($roles);
        $limitStatus = [0 => 'نامحدود', 1 => 'محدود'];
        $enableStatus = [0 => 'غیرفعال', 1 => 'فعال'];

        $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $hasOrder = [0 => 'همه کاربران', 1 => 'کسانی که سفارش ثبت کرده اند', 2 => 'کسانی که سفارش ثبت نکرده اند'];

        $bookProductsId = [176 , 167];
        $bookProducts = $this->makeProductCollection($bookProductsId);

        $products = $this->makeProductCollection();


        $lockProfileStatus = [0 => "پروفایل باز", 1 => "پروفایل قفل شده"];
        $mobileNumberVerification = [0 => "تایید نشده", 1 => "تایید شده"];

//        $tableDefaultColumns = ["نام" , "رشته"  , "موبایل"  ,"شهر" , "استان" , "وضعیت شماره موبایل" , "کد پستی" , "آدرس" , "مدرسه" , "وضعیت" , "زمان ثبت نام" , "زمان اصلاح" , "نقش های کاربر" , "تعداد بن" , "عملیات"];

        $sortBy = ["updated_at" => "تاریخ اصلاح", "created_at" => "تاریخ ثبت نام", "firstName" => "نام", "lastName" => "نام خانوادگی"];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $lotteries = Lottery::pluck("displayName", 'id')->toArray();

        $pageName = "admin";

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|پنل گزارش", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        return view("admin.indexGetReport", compact("pageName", "majors", "userStatuses", "permissions", "roles", "limitStatus", "orderstatuses", "paymentstatuses", "enableStatus", "genders", "hasOrder", "products",
            "bookProducts", "lockProfileStatus", "mobileNumberVerification", "sortBy", "sortType", "coupons", "addressSpecialFilter", "lotteries", "checkoutStatuses"));
    }

    /**
     * Admin panel for lotteries
     */
    public function adminLottery()
    {
        $lottery = Lottery::where("name", Config::get("constants.HAMAYESH_DEY_LOTTERY"))->get()->first();
        $userlotteries = $lottery->users->where("pivot.rank", ">", 0)->sortBy("pivot.rank");

        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("تخته خاک|پنل قرعه کشی", 0, Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
        $pageName = "admin";
        return view("admin.indexLottery", compact("userlotteries", "pageName"));
    }

    /**
     * Send a custom SMS to the user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(SendSMSRequest $request)
    {
        $from = $request->get("smsProviderNumber");
        $message = $request->get("message");
        $usersId = $request->get("users");
        $usersId = explode(',', $usersId);
        $relatives = $request->get("relatives");
        $relatives = explode(',', $relatives);

        $users = User::whereIn("id", $usersId)->get();
        if ($users->isEmpty()) return $this->response->setStatusCode(451);

        if (!isset($from) || strlen($from) == 0) $from = getenv("SMS_PROVIDER_DEFAULT_NUMBER");

        /**
         *  for customized message to every user

        foreach ($users as $user) {
            $customizedMessage = "";
            $mobiles = [];
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
            $smsInfo = array();
            $gender = "";
            if(isset($user->gender_id))
            {
                if($user->gender->name=="خانم")
                    $gender = "خانم ";
                elseif($user->gender->name=="آقا")
                    $gender = "آقای ";
                else
                    $gender = "";
            }else{
                $gender = "";
            }
            $customizedMessage = "سلام ".$gender.$user->getfullName()."\n".$message;
            $smsInfo["message"] = $customizedMessage;
            $smsInfo["to"] = $mobiles;
            $smsInfo["from"] = "+985000145";
            $response = $this->helper->medianaSendSMS($smsInfo);
            if (!$response["error"]) {

            } else {
                dump("SMS was not sent to user: ".$user->id) ;
            }
        }
        dd("done");


        /**
         *
         */

        $mobiles = [];
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
        $response = $this->helper->medianaSendSMS($smsInfo);
        if (!$response["error"]) {
            $smsCredit = $this->helper->medianaGetCredit();
            return $this->response->setContent($smsCredit)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    function download()
    {
        $fileName = Input::get('fileName');
        $contentType = Input::get('content');
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
                if (!Auth::user()->can(Config::get("constants.DOWNLOAD_PRODUCT_FILE"))) {
                    $products = Product::whereIn('id',
                        Product::whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('parents', function ($q) use ($fileName) {
                        $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        });
                    })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('complimentaryproducts', function ($q) use ($fileName) {
                        $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        });
                    })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('gifts', function ($q) use ($fileName) {
                        $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        });
                    })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('parents', function ($q) use ($fileName) {
                        $q->whereHas('complimentaryproducts', function ($q) use ($fileName) {
                            $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                                $q->where("file", $fileName);
                            });
                        });
                    })->pluck("id")
                    )
                        ->get();
                    $validOrders = Auth::user()->orders()->whereHas('orderproducts', function ($q) use ($products) {
                        $q->whereIn("product_id", $products->pluck("id"));
                    })->whereIn("orderstatus_id", [Config::get("constants.ORDER_STATUS_CLOSED"), Config::get("constants.ORDER_STATUS_POSTED"), Config::get("constants.ORDER_STATUS_READY_TO_POST")])->whereIn("paymentstatus_id", [Config::get("constants.PAYMENT_STATUS_PAID")])->get();

                    if ($products->isEmpty()) {
                        $message = "چنین فایلی وجود ندارد ویا غیر فعال شده است";
                    } elseif ($validOrders->isEmpty()) {

                        $message = "شما ابتدا باید یکی از این محصولات را سفارش دهید و یا اگر سفارش داده اید مبلغ را تسویه نمایید: " . "<br>";
                        $productIds = array();
                        foreach ($products as $product) {
                            $myParents = $product->parents;
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
                $diskName = Config::get('constants.DISK13');
                $cloudFile = Productfile::where("file", $fileName)->where("product_id", $productId)->get()->first()->cloudFile;
                //TODO: verify "$productFileLink = "http://".env("SFTP_HOST" , "").":8090/". $cloudFile;"
                $productFileLink = env("DOWNLOAD_HOST_PROTOCOL" , "http://").env("DOWNLOAD_HOST_NAME" , "dl.takhtekhak.com"). $cloudFile;
                $unixTime = Carbon::today()->addDays(2)->timestamp;
                $userIP = Request::ip();
                //TODO: fix diffrent Ip
                $ipArray = explode(".",$userIP);
                $ipArray[3] = 0;
                $userIP = implode(".",$ipArray);

                $linkHash = $this->helper->generateSecurePathHash($unixTime, $userIP, "TakhteKhak", $cloudFile);
                $externalLink = $productFileLink . "?md5=" . $linkHash . "&expires=" . $unixTime;
//                dd($temp."+".$userIP);
                break;
            case "فایل کارنامه" :
                $diskName = Config::get('constants.DISK14');
                break;
            case Config::get('constants.DISK18') :
                if (Storage::disk(Config::get('constants.DISK18_CLOUD'))->exists($fileName))
                    $diskName = Config::get('constants.DISK18_CLOUD');
                else
                    $diskName = Config::get('constants.DISK18');
                break;
            case Config::get('constants.DISK19'):
                if (Storage::disk(Config::get('constants.DISK19_CLOUD'))->exists($fileName))
                    $diskName = Config::  get('constants.DISK19_CLOUD');
                else
                    $diskName = Config::get('constants.DISK19');
                break;
            case Config::get('constants.DISK20'):
                if (Storage::disk(Config::get('constants.DISK20_CLOUD'))->exists($fileName))
                    $diskName = Config::  get('constants.DISK20_CLOUD');
                else
                    $diskName = Config::get('constants.DISK20');
                break;
            default :
                $file = \App\File::where("uuid", $fileName)->get();
                if ($file->isNotEmpty() && $file->count() == 1) {
                    $diskName = $file->first()->disks->first()->name;
                    $file = $file->first();
                    $fileName = $file->name;
                } else {
                    abort("404");
                }
        }
        if (isset($downloadPriority) && strcmp($downloadPriority, "cloudFirst") == 0) {
            if (isset($externalLink)) {
                return redirect($externalLink);
            } elseif (Storage::disk($diskName)->exists($fileName)) {
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

                $filePrefixPath = Storage::drive($diskName)->getAdapter()->getPathPrefix();
                if (isset($filePrefixPath)) {
                    $fs = Storage::disk($diskName)->getDriver();
                    $stream = $fs->readStream($fileName);
                    return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, 200, [
                        "Content-Type" => $fs->getMimetype($fileName),
                        "Content-Length" => $fs->getSize($fileName),
                        "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                    ]);
                } else {
                    $fileHost = Storage::drive($diskName)->getAdapter()->getHost();
                    if (isset($fileHost)) {
                        $fileRoot = Storage::drive($diskName)->getAdapter()->getRoot();
                        //TODO: verify "$fileRemotePath = "http://" . $fileHost . ":8090" . "/public" . explode("public", $fileRoot)[1];"
                        $fileRemotePath = env("DOWNLOAD_HOST_PROTOCOL" , "http://").env("DOWNLOAD_HOST_NAME" , "dl.takhtekhak.com"). "/public" . explode("public", $fileRoot)[1];

                        return response()->redirectTo($fileRemotePath . $fileName);
                    } else {
                        $fs = Storage::disk($diskName)->getDriver();
                        $stream = $fs->readStream($fileName);
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            "Content-Type" => $fs->getMimetype($fileName),
                            "Content-Length" => $fs->getSize($fileName),
                            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                        ]);
                    }
                }

//
            }
        } else {
            if (Storage::disk($diskName)->exists($fileName)) {
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
//
                $diskAdapter = Storage::disk($diskName)->getAdapter();
                $diskType = class_basename($diskAdapter);
                //TODO: baraye chie ?
                switch ($diskType) {
                    case "SftpAdapter" :
                        if (isset($file)) {
                            $url = $file->getUrl();
                            if (isset($url[0])) {
                                return response()->redirectTo($url);
                            } else {
                                $fs = Storage::disk($diskName)->getDriver();
                                $stream = $fs->readStream($fileName);
                                return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                                    fpassthru($stream);
                                }, 200, [
                                    "Content-Type" => $fs->getMimetype($fileName),
                                    "Content-Length" => $fs->getSize($fileName),
                                    "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                                ]);
                            }
                        }
                        break;
                    case "Local" :
                        $fs = Storage::disk($diskName)->getDriver();
                        $stream = $fs->readStream($fileName);
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            "Content-Type" => $fs->getMimetype($fileName),
                            "Content-Length" => $fs->getSize($fileName),
                            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                        ]);
                        break;
                    default:
                        break;
                }
            } elseif (isset($externalLink)) {
                return redirect($externalLink);
            }
        }
        abort(404);
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
        if (Storage::disk($diskName)->exists($fileName)) {
            $file = Storage::disk($diskName)->get($fileName);
            $type = Storage::disk($diskName)->mimeType($fileName);
            $etag = md5($file);
            $lastModified = Storage::disk($diskName)->lastModified($fileName);
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

    function aboutUs()
    {
        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('keywords', substr($setting->site->seo->homepage->metaKeywords, 0, Config::get("META_KEYWORDS_LIMIT.META_KEYWORDS_LIMIT")));
        Meta::set('description', substr($setting->site->seo->homepage->metaDescription, 0, Config::get("constants.META_DESCRIPTION_LIMIT")));
        Meta::set('title', "تخته خاک|درباره ما");
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));

        return view("pages.aboutUs");
    }

    function contactUs()
    {
        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('keywords', substr($setting->site->seo->homepage->metaKeywords, 0, Config::get("META_KEYWORDS_LIMIT.META_KEYWORDS_LIMIT")));
        Meta::set('description', substr($setting->site->seo->homepage->metaDescription, 0, Config::get("constants.META_DESCRIPTION_LIMIT")));
        Meta::set('title', "تخته خاک|تماس با ما");
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
        $emergencyContacts = collect();
        foreach ($setting->branches->main->emergencyContacts as $emergencyContact)
        {
            $number = "";
            if(isset($emergencyContact->number)  && strlen($emergencyContact->number)>0) $number =$emergencyContact->number;

            $description = "";
            if(isset($emergencyContact->description) && strlen($emergencyContact->description)>0) $description =$emergencyContact->description;

            if(strlen($number)>0 || strlen($description)>0)
                $emergencyContacts->push(["number"=>$number , "description"=>$description]);
        }
        return view("pages.contactUs" , compact("emergencyContacts"));
    }

    function rules()
    {
        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', "تخته خاک|قوانین");
        Meta::set('keywords', substr($setting->site->seo->homepage->metaKeywords, 0, Config::get("META_KEYWORDS_LIMIT.META_KEYWORDS_LIMIT")));
        Meta::set('description', substr($setting->site->seo->homepage->metaDescription, 0, Config::get("constants.META_DESCRIPTION_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
        return view("pages.rules");
    }

    function siteMap()
    {
        $setting = Websitesetting::where("version", 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', 'تخته خاک|نقشه سایت');
        Meta::set('keywords', substr($setting->site->seo->homepage->metaKeywords, 0, Config::get("META_KEYWORDS_LIMIT.META_KEYWORDS_LIMIT")));
        Meta::set('description', substr($setting->site->seo->homepage->metaDescription, 0, Config::get("constants.META_DESCRIPTION_LIMIT")));
        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $setting->site->siteLogo]));
        $products = Product::getProducts(0, 1)->orderBy("order")->get();
        $articlecategories = Articlecategory::where('enable', 1)->orderBy('order')->get();
        $articlesWithoutCategory = Article::where('articlecategory_id', null)->get();
        return view("pages.siteMap", compact('products', 'articlecategories', 'articlesWithoutCategory'));
    }

    function siteMapXML()
    {
        $products = Product::getProducts(0, 1)->orderBy("order")->get();
        foreach ($products as $product) {
            Sitemap::addTag(route('product.show', $product), $product->updated_at, 'daily', '0.8');
        }

//        $articlecategories = Articlecategory::where('enable', 1)->orderBy('order')->get();
//
//        foreach ($articlecategories as $articlecategory)
//        {
//            Sitemap::addTag(action('ArticleController@showList', ["categoryId"=>$articlecategory]), $articlecategory->updated_at, 'daily', '0.8');
//            foreach ($articlecategory->articles as $article)
//            {
//                Sitemap::addTag(route('article.show', $article), $article->updated_at, 'daily', '0.8');
//            }
//        }
//
//        $articlesWithoutCategory = Article::where('articlecategory_id' , null)->get();
//        foreach ($articlesWithoutCategory as $articleWithoutCategory)
//        {
//            Sitemap::addTag(route('article.show', $articleWithoutCategory), $articleWithoutCategory->updated_at, 'daily', '0.8');
//
//        }

        Sitemap::addTag(action("HomeController@contactUs"), '', 'daily', '0.8');
        Sitemap::addTag(action("HomeController@aboutUs"), '', 'daily', '0.8');
//        Sitemap::addTag(action("HomeController@certificates"), '', 'daily', '0.8');
        return Sitemap::render();
    }

    /**
     * Sends an email to the website's own email
     *
     * @param \app\Http\Requests\ContactUsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(ContactUsFormRequest $request)
    {

        $setting = Websitesetting::where("version", 1)->get()->first();
        $wSetting = json_decode($setting->setting);

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

        if (isset($wSetting->branches->main->emails[0]->address)) $to = $wSetting->branches->main->emails[0]->address;
        else $to = "";
        // To send HTML mail, the Content-type header must be set
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"\r\n";//';charset=UTF-8' .
        $headers .= "From: " . strip_tags(getenv('MAIL_USERNAME')) . "\r\n" .
            "Reply-To: " . strip_tags($email) . "\r\n" .
            "X-Mailer: PHP/" . phpversion();


        $orginaltext = $request->get('message');

        $orginaltext = str_replace('\"', '"', $orginaltext);
        $orginaltext = str_replace('\\\\', '\\', $orginaltext);

        $sender = '<p dir="rtl"> نام فرستنده: ' . $name . '</p>';
        if (strlen($email) > 0) $sender .= '<p dir="rtl"> ایمیل فرستنده: ' . $email . '</p>';
        if (strlen($phone) > 0) $sender .= '<p dir="rtl">  شماره تماس فرستنده: ' . $phone . '</p>';

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

        $subject = "تخته خاک - تماس با ما";

        try {
            $numSent = mail($to, $subject, $text, $headers);
            if ($numSent) {
                session()->put('success', 'پیام با موفقیت ارسال شد');
                return redirect()->back();
            } else {
                session()->put('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
                return redirect()->back();
            }
        } catch (\Exception    $error) {
            $message = "با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید";
            return $this->errorPage($message);
        }


    }

    /**
     * Sends an email to the website's own email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(\Illuminate\Http\Request $request)
    {

        $filePath = $request->header("X-File-Name");
        $fileName = $request->header("X-Dataname");
        $filePrefix="";
        $contentId = $request->header("X-Dataid");
        $disk = $request->header("X-Datatype");
        $done = false;

        try {
            $dirname = pathinfo($filePath, PATHINFO_DIRNAME);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = basename($fileName, "." . $ext) . "_" . date("YmdHis") . '.' . $ext;

            $newFileNameDir = $dirname . '/' . $fileName;

            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);

            if (strcmp($disk , "product") == 0) {
                if($ext == "mp4") $directory = "video";
                elseif($ext == "pdf") $directory = "pamphlet";
                $adapter = new SftpAdapter([
                    'host' => env('SFTP_HOST', ''),
                    'port' => env('SFTP_PORT', '22'),
                    'username' => env('SFTP_USERNAME', ''),
                    'password' => env('SFTP_PASSSWORD', ''),
                    'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
                    'root' => env('SFTP_ROOT', '') . '/private/'.$contentId.'/',
                    'timeout' => env('SFTP_TIMEOUT', '10'),
                    'directoryPerm' => 0755
                ]);
                $filesystem = new Filesystem($adapter);
                if(isset($directory)){
                    if(!$filesystem->has($directory))
                    {
                        $filesystem->createDir($directory) ;
                    }

                    $filePrefix = $directory."/";
                    $filesystem = $filesystem->get($directory  );
                    $path = $filesystem->getPath();
                    $filesystem->setPath($path."/".$fileName);
                    if($filesystem->put(File::get($newFileNameDir))) $done = true;
                }else{
                    if($filesystem->put($fileName , File::get($newFileNameDir))) $done = true;
                }

            }else{
                $filesystem = Storage::disk($disk . "Sftp");
                if($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                    $done = true;
//                    dd($done);
                }

            }
            if($done)
                return $this->response->setStatusCode(200)->setContent(["fileName"=>$fileName , "prefix"=>$filePrefix]);
            else
                return $this->response->setStatusCode(503);
        } catch (\Exception $e) {
            //            return $this->TAG.' '.$e->getMessage();
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطای غیرمنتظره در آپلود فایل"]);
        }
    }

    public function smsBot()
    {
        abort("403");
        /**
        $lottery = Lottery::where("name", Config::get("constants.HAMAYESH_DEY_LOTTERY"))->get()->first();
        $userlotteries = $lottery->users->where("pivot.rank", ">", 0)->sortBy("pivot.rank");

        $counter = 0;
        foreach ($userlotteries as $userlottery) {
            $counter++;
            $smsInfo = array();
            $smsInfo["to"] = array(ltrim($userlottery->mobile, '0'));
            $smsInfo["from"] = getenv("SMS_PROVIDER_DEFAULT_NUMBER");
//
//            $prize = json_decode($userlottery->pivot->prizes)->items[0]->name ;
            $smsInfo["message"] = "سلام ، کاربر گرامی نتیجه قرعه کشی در پروفایل شما قرار داده شد - تخته خاک";
            $response = $this->helper->medianaSendSMS($smsInfo);
            dump($response);

        }
        dd($counter);
         */
    }
//    public function certificates()
//    {
//        return view("pages.certificates");
//    }

    public function bot()
    {

        /**
         *  Converting Hamayesh with Poshtibani to without poshtibani
        if (!Auth::user()->hasRole("admin")) abort(404);

        $productsArray = [164, 160, 156, 152, 148, 144, 140, 136, 132, 128, 124, 120];
        $orders = Order::whereHas("orderproducts", function ($q) use ($productsArray) {
            $q->whereIn("product_id", $productsArray);
        })->whereIn("orderstatus_id", [Config::get("constants.ORDER_STATUS_CLOSED"), Config::set("constants.ORDER_STATUS_POSTED")])->whereIn("paymentstatus_id", [Config::get("constants.PAYMENT_STATUS_PAID"), Config::get("constants.PAYMENT_STATUS_INDEBTED")])->get();


        dump("Number of orders: ".$orders->count());
        $counter = 0;
        foreach ($orders as $order)
        {
            if($order->successfulTransactions->isEmpty()) continue ;
            $totalRefund = 0;
            foreach ($order->orderproducts->whereIn("product_id", $productsArray) as $orderproduct)
            {
                $orderproductTotalRefund = 0 ;
                $orderproductRefund = (int)((($orderproduct->cost / 88000) * 9000))  ;
                $orderproductRefundWithBon = $orderproductRefund * (1 - ($orderproduct->getTotalBonNumber() / 100)) ;
                if($order->couponDiscount>0 && $orderproduct->includedInCoupon)
                    $orderproductTotalRefund += $orderproductRefundWithBon * (1 - ($order->couponDiscount / 100)) ;
                else
                    $orderproductTotalRefund += $orderproductRefundWithBon ;

                $totalRefund += $orderproductTotalRefund ;
                $orderproduct->cost = $orderproduct->cost - $orderproductRefund ;
                switch ($orderproduct->product_id)
                {
                    case 164:
                        $orderproduct->product_id = 165 ;
                        break;
                    case 160:
                        $orderproduct->product_id = 161 ;
                        break;
                    case 156:
                        $orderproduct->product_id = 157 ;
                        break;
                    case 152:
                        $orderproduct->product_id = 153 ;
                        break;
                    case 148:
                        $orderproduct->product_id = 149 ;
                        break;
                    case 144:
                        $orderproduct->product_id = 145 ;
                        break;
                    case 140:
                        $orderproduct->product_id = 141 ;
                        break;
                    case 136:
                        $orderproduct->product_id = 137 ;
                        break;
                    case 132:
                        $orderproduct->product_id = 133 ;
                        break;
                    case 128:
                        $orderproduct->product_id = 129 ;
                        break;
                    case 124:
                        $orderproduct->product_id = 125 ;
                        break;
                    case 120:
                        $orderproduct->product_id = 121 ;
                        break;
                    default:
                        break;
                }
                if(!$orderproduct->update()) dump("orderproduct ".$orderproduct->id." wasn't saved");
            }
            $newOrder = Order::where("id" , $order->id)->get()->first();
            $orderCostArray = $newOrder->obtainOrderCost(true , false , "REOBTAIN");
            $newOrder->cost = $orderCostArray["rawCostWithDiscount"] ;
            $newOrder->costwithoutcoupon = $orderCostArray["rawCostWithoutDiscount"];
            $newOrder->update();

            if($totalRefund > 0 )
            {
                $transactionRequest =  new \App\Http\Requests\InsertTransactionRequest();
                $transactionRequest->offsetSet("comesFromAdmin" , true);
                $transactionRequest->offsetSet("order_id" , $order->id);
                $transactionRequest->offsetSet("cost" , -$totalRefund);
                $transactionRequest->offsetSet("managerComment" , "ثبت سیستمی بازگشت هزینه پشتیبانی همایش 1+5");
                $transactionRequest->offsetSet("destinationBankAccount_id" , 1);
                $transactionRequest->offsetSet("paymentmethod_id" , Config::get("constants.PAYMENT_METHOD_ATM"));
                $transactionRequest->offsetSet("transactionstatus_id" ,  Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL"));
                $transactionController = new TransactionController();
                $transactionController->store($transactionRequest);

                if(session()->has("success")) {
                    session()->forget("success");
                }elseif(session()->has("error")){
                    dump("Transaction wasn't saved ,Order: ".$order->id);
                    session()->forget("error");
                }
                $counter++;
            }
        }
        dump("Processed: ".$counter) ;
        */
        /**
         *  Fixing complementary products
         *
        $products = \App\Product::all();
        $counter = 0 ;
        foreach ($products as $product)
        {
            $orders = \App\Order::whereHas("orderproducts" , function ($q2) use ($product){
                $q2->where("product_id" , $product->id)->whereNull("orderproducttype_id");
            })->whereIn("orderstatus_id" , [Config::get("constants.ORDER_STATUS_CLOSED") , Config::get("constants.ORDER_STATUS_POSTED") , Config::get("constants.ORDER_STATUS_READY_TO_POST")])
                ->whereIn("paymentstatus_id" , [Config::get("constants.PAYMENT_STATUS_INDEBTED") , Config::get("constants.PAYMENT_STATUS_PAID")])->get();

            dump("Number of orders: ".$orders->count());
            foreach ($orders as $order)
            {
                if ($product->hasGifts())
                {
                    foreach ($product->gifts as $gift)
                    {
                        if($order->orderproducts->where("product_id" , $gift->id)->isEmpty())
                        {
                            $orderproduct = new \App\Orderproduct();
                            $orderproduct->orderproducttype_id = 2;
                            $orderproduct->order_id = $order->id;
                            $orderproduct->product_id = $gift->id;
                            $orderproduct->cost = $gift->basePrice;
                            $orderproduct->discountPercentage = 100;
                            if ($orderproduct->save()) $counter++;
                            else dump("orderproduct was not saved! order: " . $order->id . " ,product: " . $gift->id);
                        }
                    }
                }

                $parentsArray = $product->parents;
                if (!empty($parentsArray)) {
                    foreach ($parentsArray as $parent) {
                        foreach ($parent->gifts as $gift) {
                            if($order->orderproducts->where("product_id" , $gift->id)->isEmpty())
                            {
                                $orderproduct = new \App\Orderproduct();
                                $orderproduct->orderproducttype_id = 2;
                                $orderproduct->order_id = $order->id;
                                $orderproduct->product_id = $gift->id;
                                $orderproduct->cost = $gift->basePrice;
                                $orderproduct->discountPercentage = 100;
                                if ($orderproduct->save()) $counter++;
                                else dump("orderproduct was not saved! order: " . $order->id . " ,product: " . $gift->id);
                            }
                        }
                    }
                }
            }
        }
        dump("Number of processed : ".$counter);
        dd("finish");
         * */
    }

}
