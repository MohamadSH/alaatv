<?php

namespace App\Http\Controllers\Web;

use SEO;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use League\Flysystem\Filesystem;
use Maatwebsite\ExcelLight\Excel;
use App\Http\Controllers\Controller;
use League\Flysystem\Sftp\SftpAdapter;
use App\Console\Commands\CategoryTree\Riazi;
use App\Console\Commands\CategoryTree\Ensani;
use App\Console\Commands\CategoryTree\Tajrobi;
use Illuminate\Contracts\Encryption\DecryptException;
use Maatwebsite\ExcelLight\Spout\{Row, Sheet, Reader, Writer};
use Illuminate\Support\Facades\{File, Input, Route, Config, Storage};
use App\{Bon,
    Role,
    User,
    Event,
    Major,
    Order,
    Coupon,
    Gender,
    Lottery,
    Product,
    Userbon,
    Question,
    Attribute,
    Contentset,
    Coupontype,
    Permission,
    Userstatus,
    Userupload,
    Eventresult,
    Orderstatus,
    Productfile,
    Producttype,
    Websitepage,
    Attributeset,
    Paymentmethod,
    Paymentstatus,
    Traits\Helper,
    Userbonstatus,
    Checkoutstatus,
    Productvoucher,
    Websitesetting,
    Assignmentstatus,
    Attributecontrol,
    Usersurveyanswer,
    Useruploadstatus,
    Traits\UserCommon,
    Transactionstatus,
    Consultationstatus,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Http\Requests\Request,
    Traits\CharacterCommon,
    Traits\APIRequestCommon,
    Events\FreeInternetAccept,
    Notifications\GeneralNotice,
    Notifications\UserRegisterd,
    Http\Requests\InsertUserRequest,
    Http\Requests\ContactUsFormRequest,
    Classes\Format\BlockCollectionFormatter,
    Classes\Repository\ContentRepositoryInterface,
    Classes\Repository\ProductRepository as ProductRepository};

class HomeController extends Controller
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
        $authException = [
            'debug',
            'newDownload',
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
            //            'uploadFile',
            'search',
            'schoolRegisterLanding',
            'lernitoTree',
            'getTreeInPHPArrayString',
        ];
        //        }
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('ability:'.config('constants.ROLE_ADMIN').','.config('constants.USER_ADMIN_PANEL_ACCESS'),
            ['only' => 'admin']);
        $this->middleware('permission:'.config('constants.CONSULTANT_PANEL_ACCESS'),
            ['only' => 'consultantAdmin']);
        $this->middleware('permission:'.config('constants.PRODUCT_ADMIN_PANEL_ACCESS'),
            ['only' => 'adminProduct']);
        $this->middleware('permission:'.config('constants.CONTENT_ADMIN_PANEL_ACCESS'),
            ['only' => 'adminContent']);
        $this->middleware('permission:'.config('constants.LIST_ORDER_ACCESS'), ['only' => 'adminOrder']);
        $this->middleware('permission:'.config('constants.SMS_ADMIN_PANEL_ACCESS'), ['only' => 'adminSMS']);
        $this->middleware('permission:'.config('constants.REPORT_ADMIN_PANEL_ACCESS'), ['only' => 'adminReport']);
        $this->middleware('permission:'.config('constants.LIST_EDUCATIONAL_CONTENT_ACCESS'),
            ['only' => 'contentSetListTest']);
        $this->middleware('ability:'.config('constants.ROLE_ADMIN').','.config('constants.TELEMARKETING_PANEL_ACCESS'),
            ['only' => 'adminTeleMarketing']);
        $this->middleware('permission:'.config('constants.INSERT_COUPON_ACCESS'),
            ['only' => 'adminGenerateRandomCoupon']);
        $this->middleware('role:admin', [
            'only' => [
                'adminLottery',
                'registerUserAndGiveOrderproduct',
                'specialAddUser',
            ],
        ]);
        $this->response = $response;
        $this->setting  = $setting->setting;
    }
    
    public function test(Product $product)
    {
        return $product;
    }
    
    public function debug(Request $request, BlockCollectionFormatter $formatter)
    {
        return (array) optional($request->user('alaatv'))->id;
    }
    
    public function search(Request $request)
    {
        return redirect(action("Web\ContentController@index"), Response::HTTP_MOVED_PERMANENTLY);
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
        $userStatuses       = Userstatus::pluck('displayName', 'id');
        $majors             = Major::pluck('name', 'id');
        $genders            = Gender::pluck('name', 'id');
        $gendersWithUnknown = clone $genders;
        $gendersWithUnknown->prepend('نامشخص');
        $permissions = Permission::pluck('display_name', 'id');
        $roles       = Role::pluck('display_name', 'id');
        //        $roles = array_add($roles , 0 , "همه نقش ها");
        //        $roles = array_sort_recursive($roles);
        $limitStatus  = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];
        $enableStatus = [
            0 => 'غیرفعال',
            1 => 'فعال',
        ];
    
        $orderstatuses = Orderstatus::whereNotIn('id', [config('constants.ORDER_STATUS_OPEN')])
            ->pluck('displayName', 'id');
        
        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');
        
        $hasOrder = [
            0 => 'همه کاربران',
            1 => 'کسانی که سفارش ثبت کرده اند',
            2 => 'کسانی که سفارش ثبت نکرده اند',
        ];
        
        $products = $this->makeProductCollection();
        
        $lockProfileStatus        = [
            0 => 'پروفایل باز',
            1 => 'پروفایل قفل شده',
        ];
        $mobileNumberVerification = [
            0 => 'تایید نشده',
            1 => 'تایید شده',
        ];
        
        $tableDefaultColumns = [
            'نام خانوادگی',
            'نام کوچک',
            'رشته',
            'کد ملی',
            'موبایل',
            'ایمیل',
            'شهر',
            'استان',
            'وضعیت شماره موبایل',
            'کد پستی',
            'آدرس',
            'مدرسه',
            'وضعیت',
            'زمان ثبت نام',
            'زمان اصلاح',
            'نقش های کاربر',
            'تعداد بن',
            'عملیات',
        ];
        
        $sortBy               = [
            'updated_at' => 'تاریخ اصلاح',
            'created_at' => 'تاریخ ثبت نام',
            'firstName'  => 'نام',
            'lastName'   => 'نام خانوادگی',
        ];
        $sortType             = [
            'desc' => 'نزولی',
            'asc'  => 'صعودی',
        ];
        $addressSpecialFilter = [
            'بدون فیلتر خاص',
            'بدون آدرس ها',
            'آدرس دارها',
        ];
        
        $coupons = Coupon::pluck('name', 'id')
            ->toArray();
        $coupons = array_sort_recursive($coupons);
        
        $checkoutStatuses    = Checkoutstatus::pluck('displayName', 'id')
            ->toArray();
        $checkoutStatuses[0] = 'نامشخص';
        $checkoutStatuses    = array_sort_recursive($checkoutStatuses);
    
        $pageName = 'admin';
    
        return view('admin.index',
            compact('pageName', 'majors', 'userStatuses', 'permissions', 'roles', 'limitStatus', 'orderstatuses',
                'paymentstatuses', 'enableStatus', 'genders',
                'gendersWithUnknown', 'hasOrder', 'products', 'lockProfileStatus', 'mobileNumberVerification',
                'tableDefaultColumns', 'sortBy', 'sortType',
                'coupons', 'addressSpecialFilter', 'checkoutStatuses'));
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
        $enableStatus      = [
            0 => 'غیرفعال',
            1 => 'فعال',
        ];
        $attributesets     = Attributeset::pluck('name', 'id')
            ->toArray();
        $limitStatus       = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];
        
        $products   = Product::pluck('name', 'id')
            ->toArray();
        $coupontype = Coupontype::pluck('displayName', 'id');
    
        $productTypes = Producttype::pluck('displayName', 'id');
        
        $lastProduct = Product::getProducts(0, 1)
            ->get()
            ->sortByDesc('order')
            ->first();
        if (isset($lastProduct)) {
            $lastOrderNumber     = $lastProduct->order + 1;
            $defaultProductOrder = $lastOrderNumber;
        } else {
            $defaultProductOrder = 1;
        }
    
        $pageName = 'admin';
    
        return view('admin.indexProduct',
            compact('pageName', 'attributecontrols', 'enableStatus', 'attributesets', 'limitStatus', 'products',
                'coupontype', 'productTypes',
                'defaultProductOrder'));
    }
    
    /**
     * Show order admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminOrder()
    {
        $pageName = 'admin';
        $user     = Auth::user();
        if ($user->can(config('constants.SHOW_OPENBYADMIN_ORDER'))) {
            $orderstatuses = Orderstatus::whereNotIn('id', [config('constants.ORDER_STATUS_OPEN')])
                ->pluck('displayName', 'id');
        } else {
            $orderstatuses = Orderstatus::whereNotIn('id', [
                config('constants.ORDER_STATUS_OPEN'),
                config('constants.ORDER_STATUS_OPEN_BY_ADMIN'),
            ])
                ->pluck('displayName', 'id')
                ->toArray();
        }
        //        $orderstatuses= array_sort_recursive(array_add($orderstatuses , 0 , "دارای هر وضعیت سفارش")->toArray());
        
        $paymentstatuses     = Paymentstatus::pluck('displayName', 'id')
            ->toArray();
        $majors              = Major::pluck('name', 'id');
        $checkoutStatuses    = Checkoutstatus::pluck('displayName', 'id')
            ->toArray();
        $checkoutStatuses[0] = 'نامشخص';
        $checkoutStatuses    = array_sort_recursive($checkoutStatuses);
        
        $products = collect();
        if ($user->hasRole('onlineNoroozMarketing')) {
            $products = [config('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT')];
            $products = $this->makeProductCollection($products);
        } else {
            $products = $this->makeProductCollection();
        }
        
        $paymentMethods = Paymentmethod::pluck('displayName', 'id')
            ->toArray();
        
        $attributevalueCollection = collect();
        $extraAttributes          = Attribute::whereHas('attributegroups', function ($q) {
            $q->where('attributetype_id', 2);
        })
            ->get();
        foreach ($extraAttributes as $attribute) {
            $values = [];
            $values = array_merge($values, $attribute->attributevalues->pluck('id', 'name')
                ->toArray());
            if (!empty($values)) {
                $attributevalueCollection->put($attribute->displayName, $values);
            }
        }
        
        $sortBy   = [
            'updated_at'    => 'تاریخ اصلاح مدیریتی',
            'completed_at'  => 'تاریخ ثبت نهایی',
            'created_at'    => 'تاریخ ثبت اولیه',
            'userFirstName' => 'نام مشتری',
            'userLastName'  => 'نام خانوادگی مشتری'
            /* , "productName" => "نام محصول"*/
        ];
        $sortType = [
            'desc' => 'نزولی',
            'asc'  => 'صعودی',
        ];
        
        $transactionTypes = [
            0 => 'واریز شده',
            1 => 'بازگشت داده شده',
        ];
        
        $coupons = Coupon::pluck('name', 'id')
            ->toArray();
        $coupons = array_sort_recursive($coupons);
    
        $transactionStatuses = Transactionstatus::orderBy('order')
            ->pluck('displayName', 'id')
            ->toArray();
    
        $userBonStatuses = Userbonstatus::pluck('displayName', 'id');
        
        $orderTableDefaultColumns       = [
            'محصولات',
            'نام خانوادگی',
            'نام کوچک',
            'رشته',
            'استان',
            'شهر',
            'آدرس',
            'کد پستی',
            'موبایل',
            'مبلغ(تومان)',
            'عملیات',
            'ایمیل',
            'پرداخت شده(تومان)',
            'مبلغ برگشتی(تومان)',
            'بدهکار/بستانکار(تومان)',
            'توضیحات مسئول',
            'کد مرسوله پستی',
            'توضیحات مشتری',
            'وضعیت سفارش',
            'وضعیت پرداخت',
            'کدهای تراکنش',
            'تاریخ اصلاح مدیریتی',
            'تاریخ ثبت نهایی',
            'ویژگی ها',
            'تعداد بن استفاده شده',
            'تعداد بن اضافه شده به شما از این سفارش',
            'کپن استفاده شده',
            'تاریخ ایجاد اولیه',
        ];
        $transactionTableDefaultColumns = [
            'نام مشتری',
            'تراکنش پدر',
            'موبایل',
            'مبلغ سفارش',
            'مبلغ تراکنش',
            'کد تراکنش',
            'نحوه پرداخت',
            'تاریخ ثبت',
            'عملیات',
            'توضیح مدیریتی',
            'مبلغ فیلتر شده',
            'مبلغ آیتم افزوده',
        ];
        $userBonTableDefaultColumns     = [
            'نام کاربر',
            'تعداد بن تخصیص داده شده',
            'وضعیت بن',
            'نام کالایی که از خرید آن بن دریافت کرده است',
            'تاریخ درج',
            'عملیات',
        ];
        $addressSpecialFilter           = [
            'بدون فیلتر خاص',
            'بدون آدرس ها',
            'آدرس دارها',
        ];
    
        return view('admin.indexOrder',
            compact('pageName', 'orderstatuses', 'products', 'paymentMethods', 'majors', 'paymentstatuses', 'sortBy',
                'sortType', 'transactionTypes',
                'orderTableDefaultColumns', 'coupons', 'transactionStatuses', 'transactionTableDefaultColumns',
                'userBonTableDefaultColumns', 'userBonStatuses',
                'attributevalueCollection', 'addressSpecialFilter', 'checkoutStatuses'));
    }
    
    /**
     * Show content admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminContent()
    {
        $majors             = Major::pluck('name', 'id');
        $assignmentStatuses = Assignmentstatus::pluck('name', 'id');
        $assignmentStatuses->prepend('انتخاب وضعیت');
        $consultationStatuses = Consultationstatus::pluck('name', 'id');
        $consultationStatuses->prepend('انتخاب وضعیت');
    
        $pageName = 'admin';
    
        return view('admin.indexContent', compact('pageName', 'assignmentStatuses', 'consultationStatuses', 'majors'));
    }
    
    /**
     * Show consultant admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantAdmin()
    {
        $questions              = Userupload::all()
            ->sortByDesc('created_at');
        $questionStatusDone     = Useruploadstatus::all()
            ->where('name', 'done')
            ->first();
        $questionStatusPending  = Useruploadstatus::all()
            ->where('name', 'pending')
            ->first();
        $newQuestionsCount      = Userupload::all()
            ->where('useruploadstatus_id', $questionStatusPending->id)
            ->count();
        $answeredQuestionsCount = Userupload::all()
            ->where('useruploadstatus_id', $questionStatusDone->id)
            ->count();
        $counter                = 0;
    
        $pageName = 'consultantAdmin';
    
        return view('admin.consultant.consultantAdmin',
            compact('questions', 'counter', 'pageName', 'newQuestionsCount', 'answeredQuestionsCount'));
    }
    
    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function consultantEntekhabReshte()
    {
        $user = User::FindOrFail(Input::get('user'));
        if (Storage::disk('entekhabReshte')
            ->exists($user->id.'-'.$user->major->id.'.txt')) {
            $storedMajors     = json_decode(Storage::disk('entekhabReshte')
                ->get($user->id.'-'.$user->major->id.'.txt'));
            $parentMajorId    = $user->major->id;
            $storedMajorsInfo = Major::whereHas('parents', function ($q) use ($storedMajors, $parentMajorId) {
                $q->where('major1_id', $parentMajorId)
                    ->whereIn('majorCode', $storedMajors);
            })
                ->get();
            
            $selectedMajors = [];
            foreach ($storedMajorsInfo as $storedMajorInfo) {
                $storedMajor    = $storedMajorInfo->parents->where('id', $parentMajorId)
                    ->first();
                $majorCode      = $storedMajor->pivot->majorCode;
                $majorName      = $storedMajorInfo->name;
                $selectedMajors = array_add($selectedMajors, $majorCode, $majorName);
            }
        }
        $eventId       = 1;
        $surveyId      = 1;
        $requestUrl    = action("Web\UserSurveyAnswerController@index");
        $requestUrl    .= '?event_id[]='.$eventId.'&survey_id[]='.$surveyId.'&user_id[]='.$user->id;
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response          = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $userSurveyAnswers = collect();
        foreach ($answersCollection as $answerCollection) {
            $answerArray    = $answerCollection->userAnswer->answer;
            $question       = Question::FindOrFail($answerCollection->userAnswer->question_id);
            $requestBaseUrl = $question->dataSourceUrl;
            $requestUrl     = url('/').$requestBaseUrl."?ids=$answerArray";
            $originalInput  = \Illuminate\Support\Facades\Request::input();
            $request        = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            $userSurveyAnswers->push([
                'questionStatement' => $question->statement,
                'questionAnswer'    => $dataJson,
            ]);
        }
        
        //        Meta::set('title', substr("آلاء|پنل انتخاب رشته", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));
    
        return view('admin.consultant.consultantEntekhabReshte',
            compact('user', 'storedMajors', 'selectedMajors', 'userSurveyAnswers'));
    }
    
    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantEntekhabReshteList()
    {
        $eventId           = 1;
        $surveyId          = 1;
        $usersurveyanswers = Usersurveyanswer::where('event_id', $eventId)
            ->where('survey_id', $surveyId)
            ->get()
            ->groupBy('user_id');
        
        //        Meta::set('title', substr("آلاء|لیست انتخاب رشته", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));
    
        return view('admin.consultant.consultantEntekhabReshteList', compact('usersurveyanswers'));
    }
    
    /**
     * Storing consultant entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantStoreEntekhabReshte(\Illuminate\Http\Request $request)
    {
        $userId      = $request->get('user');
        $user        = User::FindOrFail($userId);
        $parentMajor = $request->get('parentMajor');
        $majorCodes  = json_encode($request->get('majorCodes'), JSON_UNESCAPED_UNICODE);
        
        Storage::disk('entekhabReshte')
            ->delete($userId.'-'.$parentMajor.'.txt');
        Storage::disk('entekhabReshte')
            ->put($userId.'-'.$parentMajor.'.txt', $majorCodes);
        session()->put('success', 'رشته های انتخاب شده با موفقیت درج شدند');
    
        return redirect(action("Web\HomeController@consultantEntekhabReshte", ['user' => $user]));
    }
    
    /**
     * Show adminSMS panel main page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSMS()
    {
        $pageName = 'admin';
        
        $userStatuses       = Userstatus::pluck('name', 'id');
        $majors             = Major::pluck('name', 'id');
        $genders            = Gender::pluck('name', 'id');
        $gendersWithUnknown = clone $genders;
        $gendersWithUnknown->prepend('نامشخص');
        $roles = Role::pluck('display_name', 'id');
        
        $orderstatuses = Orderstatus::whereNotIn('name', ['open'])
            ->pluck('displayName', 'id');
        
        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');
        
        $products = $this->makeProductCollection();
        
        $lockProfileStatus        = [
            0 => 'پروفایل باز',
            1 => 'پروفایل قفل شده',
        ];
        $mobileNumberVerification = [
            0 => 'تایید نشده',
            1 => 'تایید شده',
        ];
    
        $relatives = ['فرد'];
//        $relatives = Relative::pluck('displayName', 'id');
//        $relatives->prepend('فرد');
        
        $sortBy               = [
            'updated_at' => 'تاریخ اصلاح',
            'created_at' => 'تاریخ ثبت نام',
            'firstName'  => 'نام',
            'lastName'   => 'نام خانوادگی',
        ];
        $sortType             = [
            'desc' => 'نزولی',
            'asc'  => 'صعودی',
        ];
        $addressSpecialFilter = [
            'بدون فیلتر خاص',
            'بدون آدرس ها',
            'آدرس دارها',
        ];
        
        $checkoutStatuses    = Checkoutstatus::pluck('displayName', 'id')
            ->toArray();
        $checkoutStatuses[0] = 'نامشخص';
        $checkoutStatuses    = array_sort_recursive($checkoutStatuses);
    
        $pageName = 'admin';
        
        $smsCredit = (int) $this->medianaGetCredit();
        
        $smsProviderNumber = config('constants.SMS_PROVIDER_NUMBER');
        
        $coupons = Coupon::pluck('name', 'id')
            ->toArray();
        $coupons = array_sort_recursive($coupons);
        //        Meta::set('title', substr("آلاء|پنل پیامک", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));
    
        $products = Product::where('id', 240)
            ->get();
        
        return view('admin.indexSMS',
            compact('pageName', 'majors', 'userStatuses', 'roles', 'relatives', 'orderstatuses', 'paymentstatuses',
                'genders', 'gendersWithUnknown', 'products',
                'allRootProducts', 'lockProfileStatus', 'mobileNumberVerification', 'sortBy', 'sortType', 'smsCredit',
                'smsProviderNumber',
                'numberOfFatherPhones', 'numberOfMotherPhones', 'coupons', 'addressSpecialFilter', 'heckoutStatuses' , 'checkoutStatuses' ));
    }
    
    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSlideShow()
    {
        
        $slideController    = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()
            ->where('url', '/home')
            ->first()->id;
        $slides             = $slideController->index()
            ->where('websitepage_id', $slideWebsitepageId);
        $slideDisk          = 9;
        $slideContentName   = 'عکس اسلاید صفحه اصلی';
        $sideBarMode        = 'closed';
        $section            = 'slideShow';
    
        return view('admin.siteConfiguration.slideShow',
            compact('slides', 'sideBarMode', 'section', 'slideDisk', 'slideContentName', 'slideWebsitepageId'));
    }
    
    /**
     * Admin panel for adjusting site configuration
     */
    public function adminArticleSlideShow()
    {
        
        $slideController    = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()
            ->where('url', '/لیست-مقالات')
            ->first()->id;
        $slides             = $slideController->index()
            ->where('websitepage_id', $slideWebsitepageId);
        $slideDisk          = 13;
        $slideContentName   = 'عکس اسلاید صفحه مقالات';
        $sideBarMode        = 'closed';
        $section            = 'articleSlideShow';
    
        return view('admin.siteConfiguration.articleSlideShow',
            compact('slides', 'sideBarMode', 'slideWebsitepageId', 'section', 'slideDisk', 'slideContentName'));
    }
    
    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSiteConfig()
    {
        $this->setting = Websitesetting::where('version', 1)
            ->get()
            ->first();
        
        return redirect(action('Web\WebsiteSettingController@show', $this->setting));
    }
    
    /**
     * Admin panel for adjusting site configuration
     */
    public function adminMajor()
    {
        $parentName  = Input::get('parent');
        $parentMajor = Major::all()
            ->where('name', $parentName)
            ->where('majortype_id', 1)
            ->first();
    
        $majors = Major::where('majortype_id', 2)
            ->orderBy('name')
            ->whereHas('parents', function ($q) use ($parentMajor) {
                $q->where('major1_id', $parentMajor->id);
            })
            ->get();
    
        return view('admin.indexMajor', compact('parentMajor', 'majors'));
    }
    
    /**
     * Admin panel for getting a special report
     */
    public function adminReport()
    {
        $userStatuses       = Userstatus::pluck('displayName', 'id');
        $majors             = Major::pluck('name', 'id');
        $genders            = Gender::pluck('name', 'id');
        $gendersWithUnknown = clone $genders;
        $gendersWithUnknown->prepend('نامشخص');
        $permissions = Permission::pluck('display_name', 'id');
        $roles       = Role::pluck('display_name', 'id');
        //        $roles = array_add($roles , 0 , "همه نقش ها");
        //        $roles = array_sort_recursive($roles);
        $limitStatus  = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];
        $enableStatus = [
            0 => 'غیرفعال',
            1 => 'فعال',
        ];
    
        $orderstatuses = Orderstatus::whereNotIn('id', [config('constants.ORDER_STATUS_OPEN')])
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
        $bookProducts   = $this->makeProductCollection($bookProductsId);
        
        $products = $this->makeProductCollection();
        
        $lockProfileStatus        = [
            0 => 'پروفایل باز',
            1 => 'پروفایل قفل شده',
        ];
        $mobileNumberVerification = [
            0 => 'تایید نشده',
            1 => 'تایید شده',
        ];
        
        //        $tableDefaultColumns = ["نام" , "رشته"  , "موبایل"  ,"شهر" , "استان" , "وضعیت شماره موبایل" , "کد پستی" , "آدرس" , "مدرسه" , "وضعیت" , "زمان ثبت نام" , "زمان اصلاح" , "نقش های کاربر" , "تعداد بن" , "عملیات"];
        
        $sortBy               = [
            'updated_at' => 'تاریخ اصلاح',
            'created_at' => 'تاریخ ثبت نام',
            'firstName'  => 'نام',
            'lastName'   => 'نام خانوادگی',
        ];
        $sortType             = [
            'desc' => 'نزولی',
            'asc'  => 'صعودی',
        ];
        $addressSpecialFilter = [
            'بدون فیلتر خاص',
            'بدون آدرس ها',
            'آدرس دارها',
        ];
        
        $coupons = Coupon::pluck('name', 'id')
            ->toArray();
        $coupons = array_sort_recursive($coupons);
    
        $lotteries = Lottery::pluck('displayName', 'id')
            ->toArray();
    
        $pageName = 'admin';
        
        $checkoutStatuses    = Checkoutstatus::pluck('displayName', 'id')
            ->toArray();
        $checkoutStatuses[0] = 'نامشخص';
        $checkoutStatuses    = array_sort_recursive($checkoutStatuses);
    
        return view('admin.indexGetReport',
            compact('pageName', 'majors', 'userStatuses', 'permissions', 'roles', 'limitStatus', 'orderstatuses',
                'paymentstatuses', 'enableStatus', 'genders',
                'gendersWithUnknown', 'hasOrder', 'products', 'bookProducts', 'lockProfileStatus',
                'mobileNumberVerification', 'sortBy', 'sortType', 'coupons',
                'addressSpecialFilter', 'lotteries', 'checkoutStatuses'));
    }
    
    /**
     * Admin panel for lotteries
     */
    public function adminLottery(Request $request)
    {
        $userlotteries = collect();
        if ($request->has('lottery')) {
            $lotteryName        = $request->get('lottery');
            $lottery            = Lottery::where('name', $lotteryName)
                ->get()
                ->first();
            $lotteryDisplayName = $lottery->displayName;
            $userlotteries      = $lottery->users->where('pivot.rank', '>', 0)
                ->sortBy('pivot.rank');
        }
    
        $bonName     = config('constants.BON2');
        $bon         = Bon::where('name', $bonName)
            ->first();
        $pointsGiven = Userbon::where('bon_id', $bon->id)
            ->where('userbonstatus_id', 1)
            ->get()
            ->isNotEmpty();
    
        $pageName = 'admin';
    
        return view('admin.indexLottery',
            compact('userlotteries', 'pageName', 'lotteryName', 'lotteryDisplayName', 'pointsGiven'));
    }
    
    /**
     * Admin panel for tele marketing
     */
    public function adminTeleMarketing(Request $request)
    {
        if ($request->has('group-mobile')) {
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
            $mobiles           = $request->get('group-mobile');
            $mobileArray       = [];
            foreach ($mobiles as $mobile) {
                $mobileArray[] = $mobile['mobile'];
            }
            $baseDataTime = Carbon::createFromTimeString('2018-05-03 00:00:00');
            $orders       = Order::whereHas('user', function ($q) use ($mobileArray, $baseDataTime) {
                $q->whereIn('mobile', $mobileArray);
            })
                ->whereHas('orderproducts', function ($q2) use ($marketingProducts) {
                    $q2->whereIn('product_id', $marketingProducts);
                })
                ->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                ->where('paymentstatus_id',
                    config('constants.PAYMENT_STATUS_PAID'))
                ->where('completed_at', '>=', $baseDataTime)
                ->get();
            $orders->load('orderproducts');
        }
    
        return view('admin.indexTeleMarketing', compact('orders', 'marketingProducts'));
    }
    
    /**
     * @param  Request                                             $request
     * @param                                                      $data
     *
     * @param  \App\Classes\Repository\ContentRepositoryInterface  $contentRepository
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function newDownload(Request $request, $data, ContentRepositoryInterface $contentRepository)
    {
        /** @var User $user */
        $user = $request->user('alaatv');
        if ($user === null) {
            abort(403, 'Not authorized.');
        }
        if ($data === null) {
            abort(403, 'Invalid Link');
        }
        try {
            $data = (array) decrypt($data);
        } catch (DecryptException $e) {
            abort(403, 'invalid Data!');
        }
        $url       = $data['url'];
        $contentId = $data['data']['content_id'];
        $content   = $contentRepository->getContentById($contentId);
        if (!$user->hasContent($content)) {
            return redirect()
                ->action('Web\ContentController@show', $content)
                ->setStatusCode(Response::HTTP_FOUND);
        }
        $finalLink = $this->getSecureUrl($url);
    
        return redirect($finalLink);
    }
    
    /**
     * @param $url
     *
     * @return string
     */
    private function getSecureUrl($url): string
    {
        $unixTime = Carbon::today()
            ->addDays(2)->timestamp;
        $userIP   = request()->ip();
        //TODO: fix diffrent Ip
        $ipArray    = explode('.', $userIP);
        $ipArray[3] = 0;
        $userIP     = implode('.', $ipArray);
    
        $linkHash  = $this->generateSecurePathHash($unixTime, $userIP, 'TakhteKhak', $url);
        $finalLink = $url.'?md5='.$linkHash.'&expires='.$unixTime;
        return $finalLink;
    }
    
    function download(Request $request)
    {
        $fileName    = $request->get('fileName');
        $contentType = $request->get('content');
        $user        = Auth::user();
        
        switch ($contentType) {
            case 'عکس پروفایل':
                $diskName = config('constants.DISK1');
                break;
            case 'عکس محصول':
                $diskName = config('constants.DISK4');
                break;
            case 'تمرین':
                // check if he has permission for downloading the assignment :
                
                //if(!Auth::user()->permissions->contains(Permission::all()->where("name", config('constants.DOWNLOAD_ASSIGNMENT_ACCESS'))->first()->id)) return redirect(action(("HomeController@error403"))) ;
                //  checking permission through the user's role
                //$user->hasRole('goldenUser');
                $diskName = config('constants.DISK2');
                break;
            case 'پاسخ تمرین':
                $diskName = config('constants.DISK3');
                break;
            case 'کاتالوگ محصول':
                $diskName = config('constants.DISK5');
                break;
            case 'سؤال مشاوره ای':
                $diskName = config('constants.DISK6');
                break;
            case 'تامبنیل مشاوره':
                $diskName = config('constants.DISK7');
                break;
            case 'عکس مقاله' :
                $diskName = config('constants.DISK8');
                break;
            case 'عکس اسلاید صفحه اصلی' :
                $diskName = config('constants.DISK9');
                break;
            case 'فایل سفارش' :
                $diskName = config('constants.DISK10');
                break;
            case 'فایل محصول' :
                $productId = Input::get('pId');
                $diskName  = config('constants.DISK13');
        
                if (!$user->can(config('constants.DOWNLOAD_PRODUCT_FILE'))) {
                    $products    = ProductRepository::getProductsThatHaveValidProductFileByFileNameRecursively($fileName);
                    $validOrders = $user->getOrdersThatHaveSpecificProduct($products);
                    
                    if (!$products->isEmpty()) {
                        if (!$validOrders->isEmpty()) {
                            $productId = (array) $productId;
                            if (isset($products)) {
                                $productId = array_merge($productId, $products->pluck('id')
                                    ->toArray());
                            }
                            $externalLink = (new Productfile)->getExternalLinkForProductFileByFileName($fileName,
                                $productId);
                            break;
                        }
                        $message = $this->getMessageThatShouldByWhichProducts($products);
                        return $this->errorPage($message);
                    }
                    $message = 'چنین فایلی وجود ندارد ویا غیر فعال شده است';
                    return $this->errorPage($message);
                }
                break;
            case 'فایل کارنامه' :
                $diskName = config('constants.DISK14');
                break;
            case config('constants.DISK18') :
                if (Storage::disk(config('constants.DISK18_CLOUD'))
                    ->exists($fileName)) {
                    $diskName = config('constants.DISK18_CLOUD');
                } else {
                    $diskName = config('constants.DISK18');
                }
                break;
            case config('constants.DISK19'):
                if (Storage::disk(config('constants.DISK19_CLOUD'))
                    ->exists($fileName)) {
                    $diskName = Config::  get('constants.DISK19_CLOUD');
                } else {
                    $diskName = config('constants.DISK19');
                }
                break;
            case config('constants.DISK20'):
                if (Storage::disk(config('constants.DISK20_CLOUD'))
                    ->exists($fileName)) {
                    $diskName = Config::  get('constants.DISK20_CLOUD');
                } else {
                    $diskName = config('constants.DISK20');
                }
                break;
            default :
                $file = \App\File::where('uuid', $fileName)
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
                    abort('404');
                }
        }
        if (isset($downloadPriority) && strcmp($downloadPriority, 'cloudFirst') == 0) {
            if (isset($externalLink)) {
                return redirect($externalLink);
            } else {
                if (Storage::disk($diskName)
                    ->exists($fileName)) {
                    $filePrefixPath = Storage::drive($diskName)
                        ->getAdapter()
                        ->getPathPrefix();
                    if (isset($filePrefixPath)) {
                        $fs     = Storage::disk($diskName)
                            ->getDriver();
                        $stream = $fs->readStream($fileName);
                        
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            'Content-Type'        => $fs->getMimetype($fileName),
                            'Content-Length'      => $fs->getSize($fileName),
                            'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
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
    
                            $fileRemotePath = config('constants.DOWNLOAD_HOST_PROTOCOL').config('constants.DOWNLOAD_HOST_NAME').'/public'.explode('public',
                                    $fileRoot)[1];
                            
                            return response()->redirectTo($fileRemotePath.$fileName);
                        } else {
                            $fs     = Storage::disk($diskName)
                                ->getDriver();
                            $stream = $fs->readStream($fileName);
                            
                            return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                                fpassthru($stream);
                            }, 200, [
                                'Content-Type'        => $fs->getMimetype($fileName),
                                'Content-Length'      => $fs->getSize($fileName),
                                'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                            ]);
                        }
                    }
                    //
                }
            }
        } else {
            if (isset($diskName) && Storage::disk($diskName)
                    ->exists($fileName)) {
                $diskAdapter = Storage::disk($diskName)
                    ->getAdapter();
                $diskType    = class_basename($diskAdapter);
                switch ($diskType) {
                    case 'SftpAdapter' :
                        if (isset($file)) {
                            $url = $file->getUrl();
                            if (isset($url[0])) {
                                return response()->redirectTo($url);
                            } else {
                                $fs     = Storage::disk($diskName)
                                    ->getDriver();
                                $stream = $fs->readStream($fileName);
                                
                                return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                                    fpassthru($stream);
                                }, 200, [
                                    'Content-Type'        => $fs->getMimetype($fileName),
                                    'Content-Length'      => $fs->getSize($fileName),
                                    'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                                ]);
                            }
                        }
                        
                        break;
                    case 'Local' :
                        $fs     = Storage::disk($diskName)
                            ->getDriver();
                        $stream = $fs->readStream($fileName);
                        
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            'Content-Type'        => $fs->getMimetype($fileName),
                            'Content-Length'      => $fs->getSize($fileName),
                            'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                        ]);
                        break;
                    default:
                        break;
                }
            } else {
                if (isset($externalLink)) {
                    return redirect($externalLink);
                }
            }
        }
        abort(404);
    }
    
    /**
     * @param $products
     *
     * @return string
     */
    private function getMessageThatShouldByWhichProducts($products): string
    {
        $message    = 'شما ابتدا باید یکی از این محصولات را سفارش دهید و یا اگر سفارش داده اید مبلغ را تسویه نمایید: '.'<br>';
        $productIds = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $myParents = $product->getAllParents();
            if ($myParents->isNotEmpty()) {
                $rootParent = $myParents->last();
                if (!in_array($rootParent->id, $productIds)) {
                    $message .= '<a href="'.action('ProductController@show',
                            $rootParent->id).'">'.$rootParent->name.'</a><br>';
                    array_push($productIds, $rootParent->id);
                }
            } else {
                if (!in_array($product->id, $productIds)) {
                    $message .= '<a href="'.action('ProductController@show',
                            $product->id).'">'.$product->name.'</a><br>';
                    array_push($productIds, $product->id);
                }
            }
        }
        return $message;
    }
    
    /**
     * Show the general error page.
     *
     * @param  string  $message
     *
     * @return \Illuminate\Http\Response
     */
    public function errorPage($message)
    {
        //        $message = Input::get("message");
        if (strlen($message) <= 0) {
            $message = '';
        }
    
        return view('errors.errorPage', compact('message'));
    }
    
    public function getImage($category, $w, $h, $fileName)
    {
        switch ($category) {
            case '1';
                $diskName = config('constants.DISK1');
                break;
            case '4':
                $diskName = config('constants.DISK4');
                break;
            case '7':
                $diskName = config('constants.DISK7');
                break;
            case '8':
                $diskName = config('constants.DISK8');
                break;
            case '9':
                $diskName = config('constants.DISK9');
                break;
            case '11':
                $diskName = config('constants.DISK11');
                break;
            default:
                break;
        }
        if (Storage::disk($diskName)
            ->exists($fileName)) {
            $file         = Storage::disk($diskName)
                ->get($fileName);
            $type         = Storage::disk($diskName)
                ->mimeType($fileName);
            $etag         = md5($file);
            $lastModified = Storage::disk($diskName)
                ->lastModified($fileName);
            $size         = strlen($file);
            
            return response($file, 200)
                ->header('Content-Type', $type)
                ->header('Content-Length',
                    $size)
                ->setMaxAge(3600)
                ->setPublic()
                ->setEtag($etag)
                ->setLastModified(Carbon::createFromTimestamp($lastModified));
        }
        
        return redirect(action("Web\HomeController@error404"));
    }
    
    function siteMapXML()
    {
        return redirect(action('SitemapController@index'), 301);
    }
    
    /**
     * Sends an email to the website's own email
     *
     * @param  \app\Http\Requests\ContactUsFormRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail(ContactUsFormRequest $request)
    {
    
        $this->setting = Websitesetting::where('version', 1)
            ->get()
            ->first();
        $wSetting      = $this->setting->setting;
        
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
        
        $email   = $request->get('email');
        $name          = $request->get('fullName');
        $phone         = $request->get('phone');
        $comment       = $request->get('message');
        
        //create a boundary for the email. This
        $boundary = uniqid('sh');
        
        // multiple recipients
        //    $to  = 'info@sanatisharif.ir' . ', '; // note the comma
        //    $to .= 'foratmail@gmail.com';
        
        if (isset($wSetting->branches->main->emails[0]->address)) {
            $to = $wSetting->branches->main->emails[0]->address;
        } else {
            $to = '';
        }
        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-Type: multipart/alternative; boundary="'.$boundary."\"\r\n";//';charset=UTF-8' .
        $headers .= 'From: '.strip_tags(config('constants.MAIL_USERNAME'))."\r\n".'Reply-To: '.strip_tags($email)."\r\n".'X-Mailer: PHP/'.phpversion();
        
        $orginaltext = $request->get('message');
        
        $orginaltext = str_replace('\"', '"', $orginaltext);
        $orginaltext = str_replace('\\\\', '\\', $orginaltext);
        
        $sender = '<p dir="rtl"> نام فرستنده: '.$name.'</p>';
        if (strlen($email) > 0) {
            $sender .= '<p dir="rtl"> ایمیل فرستنده: '.$email.'</p>';
        }
        if (strlen($phone) > 0) {
            $sender .= '<p dir="rtl">  شماره تماس فرستنده: '.$phone.'</p>';
        }
        
        //plainText version
        $text = "\r\n\r\n--".$boundary."\r\n"; //header
        $text .= "Content-type: text/plain; charset=utf-8 \r\n\r\n"; //header
        
        $text .= strip_tags($orginaltext)."\r\n".strip_tags($sender);
        
        //htmlText version
        
        $text .= "\r\n\r\n--".$boundary."\r\n"; //header
        $text .= "Content-type: text/html; charset=utf-8 \r\n\r\n"; //header
        
        //            $text .= $sender.str_replace('\"','\'','<p dir="rtl" style="text-align: right">'.$orginaltext.'</p>') ;
        $text .= view('emailLayouts.contactUs', compact('email', 'phone', 'comment', 'name'));
        
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
    
        $text .= "\r\n\r\n--".$boundary.'--';
    
        $subject = 'آلاء - تماس با ما';
        
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
            $message = 'با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید';
            
            return $this->errorPage($message);
        }
    }
    
    /**
     * Send a custom SMS to the user
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(Request $request)
    {
        $from      = $request->get('smsProviderNumber');
        $message   = $request->get('message');
        $usersId   = $request->get('users');
        $usersId   = explode(',', $usersId);
        $relatives = $request->get('relatives');
        $relatives = explode(',', $relatives);
        
        $smsNumber = config('constants.SMS_PROVIDER_DEFAULT_NUMBER');
        $users     = User::whereIn('id', $usersId)
            ->get();
        if ($users->isEmpty()) {
            return $this->response->setStatusCode(451);
        }
        
        if (!isset($from) || strlen($from) == 0) {
            $from = $smsNumber;
        }
        
        $mobiles    = [];
        $finalUsers = collect();
        foreach ($users as $user) {
            if (in_array(0, $relatives)) {
                array_push($mobiles, ltrim($user->mobile, '0'));
            }
            if (in_array(1, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $fatherMobiles = $user->contacts->where('relative_id', 1)
                        ->first()->phones->where('phonetype_id', 1)
                        ->sortBy('priority');
                    if (!$fatherMobiles->isEmpty()) {
                        foreach ($fatherMobiles as $fatherMobile) {
                            array_push($mobiles, ltrim($fatherMobile->phoneNumber, '0'));
                        }
                    }
                }
            }
            if (in_array(2, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $motherMobiles = $user->contacts->where('relative_id', 2)
                        ->first()->phones->where('phonetype_id', 1)
                        ->sortBy('priority');
                    if (!$motherMobiles->isEmpty()) {
                        foreach ($motherMobiles as $motherMobile) {
                            array_push($mobiles, ltrim($motherMobile->phoneNumber, '0'));
                        }
                    }
                }
            }
        }
        $smsInfo            = [];
        $smsInfo['message'] = $message;
        $smsInfo['to']      = $mobiles;
        $smsInfo['from']    = $from;
        $response           = $this->medianaSendSMS($smsInfo);
        //Sending notification to user collection
//        Notification::send($users, new GeneralNotice($message));
        if (!$response['error']) {
            $smsCredit = $this->medianaGetCredit();
            
            return $this->response->setContent($smsCredit)
                ->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }
    
    /**
     * Sends an email to the website's own email
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(\Illuminate\Http\Request $request)
    {
    
        $filePath         = $request->header('X-File-Name');
        $originalFileName = $request->header('X-Dataname');
        $filePrefix       = '';
        $contentSetId     = $request->header('X-Dataid');
        $disk             = $request->header('X-Datatype');
        $done             = false;
        
        //        dd($request->headers->all());
        try {
            $dirname  = pathinfo($filePath, PATHINFO_DIRNAME);
            $ext      = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $fileName = basename($originalFileName, '.'.$ext).'_'.date('YmdHis').'.'.$ext;
            
            $newFileNameDir = $dirname.'/'.$fileName;
            
            //            dd([
            //                "filePath"=>$filePath,
            //                "newFileNameDir"=>$newFileNameDir
            //            ]);
            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);
    
            if (strcmp($disk, 'product') == 0) {
                if ($ext == 'mp4') {
                    $directory = 'video';
                } else {
                    if ($ext == 'pdf') {
                        $directory = 'pamphlet';
                    }
                }
                
                $adapter    = new SftpAdapter([
                    'host'          => config('constants.SFTP_HOST'),
                    'port'          => config('constants.SFTP_PORT'),
                    'username'      => config('constants.SFTP_USERNAME'),
                    'password'      => config('constants.SFTP_PASSSWORD'),
                    'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                    'root'          => config('constants.SFTP_ROOT').'/private/'.$contentSetId.'/',
                    'timeout'       => config('constants.SFTP_TIMEOUT'),
                    'directoryPerm' => 0755,
                ]);
                $filesystem = new Filesystem($adapter);
                if (isset($directory)) {
                    if (!$filesystem->has($directory)) {
                        $filesystem->createDir($directory);
                    }
    
                    $filePrefix = $directory.'/';
                    $filesystem = $filesystem->get($directory);
                    $path       = $filesystem->getPath();
                    $filesystem->setPath($path.'/'.$fileName);
                    if ($filesystem->put(fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                } else {
                    if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                }
            } else {
                if (strcmp($disk, 'video') == 0) {
                    $adapter    = new SftpAdapter([
                        'host'          => config('constants.SFTP_HOST'),
                        'port'          => config('constants.SFTP_PORT'),
                        'username'      => config('constants.SFTP_USERNAME'),
                        'password'      => config('constants.SFTP_PASSSWORD'),
                        'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                        // example:  /alaa_media/cdn/media/203/HD_720p , /alaa_media/cdn/media/thumbnails/203/
                        'root'          => config('constants.DOWNLOAD_SERVER_ROOT').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH').$contentSetId,
                        'timeout'       => config('constants.SFTP_TIMEOUT'),
                        'directoryPerm' => 0755,
                    ]);
                    $filesystem = new Filesystem($adapter);
                    if ($filesystem->put($originalFileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                        // example:  https://cdn.sanatisharif.ir/media/203/hq/203001dtgr.mp4
                        $fileName = config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.DOWNLOAD_SERVER_NAME').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH').$contentSetId.$originalFileName;
                    }
                } else {
                    $filesystem = Storage::disk($disk.'Sftp');
                    //                Storage::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
                    if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                }
            }
            if ($done) {
                return $this->response->setStatusCode(Response::HTTP_OK)
                    ->setContent([
                        'fileName' => $fileName,
                        'prefix'   => $filePrefix,
                    ]);
            } else {
                return $this->response->setStatusCode(503);
            }
        } catch (\Exception $e) {
            //            return $this->TAG.' '.$e->getMessage();
            $message = 'unexpected error';
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    'message' => $message,
                    'error'   => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                ]);
        }
    }
    //    public function certificates()
    //    {
    //        return view("pages.certificates");
    //    }
    
    public function adminBot()
    {
        if (!Input::has('bot')) {
            dd('Please pass bot as input');
        }
    
        $bot    = Input::get('bot');
        $view   = '';
        $params = [];
        switch ($bot) {
            case 'wallet':
                $view = 'admin.bot.wallet';
                break;
            case 'excel':
                $view = 'admin.bot.excel';
                break;
            default:
                break;
        }
        $pageName = 'adminBot';
        if (strlen($view) > 0) {
            return view($view, compact('pageName', 'params'));
        } else {
            abort(404);
        }
    }
    
    public function smsBot()
    {
        abort('403');
    }
    
    public function bot(Request $request)
    {
        try {
            if ($request->has('emptyorder')) {
                $orders = Order::whereIn('orderstatus_id', [
                    config('constants.ORDER_STATUS_CLOSED'),
                    config('constants.ORDER_STATUS_POSTED'),
                    config('constants.ORDER_STATUS_READY_TO_POST'),
                ])
                    ->whereIn('paymentstatus_id', [config('constants.PAYMENT_STATUS_PAID')])
                    ->whereDoesntHave('orderproducts', function ($q) {
                        $q->whereNull('orderproducttype_id')
                            ->orWhere('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'));
                    })
                    ->get();
                dd($orders->pluck('id')
                    ->toArray());
            }
    
            if ($request->has('voucherbot')) {
                $asiatechProduct      = config('constants.ASIATECH_FREE_ADSL');
                $voucherPendingOrders = Order::where('orderstatus_id', config('constants.ORDER_STATUS_PENDING'))
                    ->where('paymentstatus_id',
                        config('constants.PAYMENT_STATUS_PAID'))
                    ->whereHas('orderproducts', function (
                        $q
                    ) use ($asiatechProduct) {
                        $q->where('product_id', $asiatechProduct);
                    })
                    ->orderBy('completed_at')
                    ->get();
                echo "<span style='color:blue'>Number of orders: ".$voucherPendingOrders->count().'</span>';
                echo '<br>';
                $counter     = 0;
                $nowDateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                    ->timezone('Asia/Tehran');
                foreach ($voucherPendingOrders as $voucherOrder) {
                    $orderUser     = $voucherOrder->user;
                    $unusedVoucher = Productvoucher::whereNull('user_id')
                        ->where('enable', 1)
                        ->where('expirationdatetime', '>',
                            $nowDateTime)
                        ->where('product_id', $asiatechProduct)
                        ->get()
                        ->first();
                    if (isset($unusedVoucher)) {
                        $voucherOrder->orderstatus_id = config('constants.ORDER_STATUS_CLOSED');
                        if ($voucherOrder->update()) {
                            $userVoucher = $orderUser->productvouchers()
                                ->where('enable', 1)
                                ->where('expirationdatetime', '>',
                                    $nowDateTime)
                                ->where('product_id', $asiatechProduct)
                                ->get();
                            
                            if ($userVoucher->isEmpty()) {
                                
                                $unusedVoucher->user_id = $orderUser->id;
                                if ($unusedVoucher->update()) {
                                    
                                    event(new FreeInternetAccept($orderUser));
                                    $counter++;
                                } else {
                                    echo "<span style='color:red'>Error on giving voucher to user #".$orderUser->id.'</span>';
                                    echo '<br>';
                                }
                            } else {
                                echo "<span style='color:orangered'>User  #".$orderUser->id.' already has a voucher code</span>';
                                echo '<br>';
                            }
                        } else {
                            echo "<span style='color:red'>Error on updating order #".$voucherOrder->id.' for user #'.$orderUser->id.'</span>';
                            echo '<br>';
                        }
                    } else {
                        echo "<span style='color:orangered'>Could not find voucher for user  #".$orderUser->id.'</span>';
                        echo '<br>';
                    }
                }
                echo "<span style='color:green'>Number of processed orders: ".$counter.'</span>';
                echo '<br>';
                dd('DONE!');
            }
    
            if ($request->has('smsarabi')) {
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
                $users         = User::whereHas('orderproducts', function ($q) use ($hamayeshTalai) {
                    $q->whereHas('order', function ($q) use ($hamayeshTalai) {
                        $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                            ->whereIn('paymentstatus_id', [
                                config('constants.PAYMENT_STATUS_PAID'),
                            ]);
                    })
                        ->whereIn('product_id', [214]);
                    //                        ->havingRaw('COUNT(*) > 0');
                })
                    ->whereDoesntHave('orderproducts', function ($q) use ($hamayeshTalai) {
                        $q->whereHas('order', function ($q) use ($hamayeshTalai) {
                            $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                                ->whereIn('paymentstatus_id', [
                                    config('constants.PAYMENT_STATUS_PAID'),
                                ]);
                        })
                            ->where('product_id', 223);
                    })
                    ->get();
        
                echo 'Number of users:'.$users->count();
                dd('stop');
                
                foreach ($users as $user) {
                    $message = 'آلایی عزیز تا جمعه ظهر فرصت دارید تا حضور خود در همایش  حضوری عربی را اعلام کنید';
                    $message .= "\n";
                    $message .= 'sanatisharif.ir/user/'.$user->id;
                    $user->notify(new GeneralNotice($message));
                }
        
                dd('Done');
            }
    
            if ($request->has('coupon')) {
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
                $smsNumber                  = config('constants.SMS_PROVIDER_DEFAULT_NUMBER');
                $users                      = User::whereHas('orderproducts', function ($q) use ($hamayeshTalai) {
                    $q->whereHas('order', function ($q) use ($hamayeshTalai) {
                        $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                            ->whereIn('paymentstatus_id', [
                                config('constants.PAYMENT_STATUS_PAID'),
                            ]);
                    })
                        ->whereIn('product_id', $hamayeshTalai);
                    //                        ->havingRaw('COUNT(*) > 0');
                })
                    ->whereDoesntHave('orderproducts', function ($q) use ($hamayeshTalai) {
                        $q->whereHas('order', function ($q) use ($hamayeshTalai) {
                            $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'))
                                ->whereIn('paymentstatus_id', [
                                    config('constants.PAYMENT_STATUS_PAID'),
                                ]);
                        })
                            ->where('product_id', 210);
                    })
                    ->whereNotIn('id', $notIncludedUsers_Shimi)
                    ->whereNotIn('id', $notIncludedUsers_Vafadaran)
                    ->get();
        
                echo 'number of users:'.$users->count();
                echo '<br>';
                dd('stop');
                $couponController = new CouponController();
                $failedCounter    = 0;
                $proccessed       = 0;
                dump($users->pluck('id')
                    ->toArray());
                
                foreach ($users as $user) {
                    do {
                        $couponCode = str_random(5);
                    } while (\App\Coupon::where('code', $couponCode)
                        ->get()
                        ->isNotEmpty());
                    
                    /** Coupon Settings */
                    $couponName        = 'قرعه کشی وفاداران آلاء برای '.$user->getFullName();
                    $couponDescription = 'قرعه کشی وفاداران آلاء برای '.$user->getFullName();
                    $validSinceDate    = '2018-06-11';
                    $validUntilDate    = ' 00:00:00';
                    $validSinceTime    = '2018-06-15';
                    $validUntilTime    = '12:00:00';
                    $couponProducts    = \App\Product::whereNotIn('id', [
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
                    $insertCouponRequest->offsetSet('enable', 1);
                    $insertCouponRequest->offsetSet('usageNumber', 0);
                    $insertCouponRequest->offsetSet('limitStatus', 0);
                    $insertCouponRequest->offsetSet('coupontype_id', 2);
                    $insertCouponRequest->offsetSet('discounttype_id', 1);
                    $insertCouponRequest->offsetSet('name', $couponName);
                    $insertCouponRequest->offsetSet('description', $couponDescription);
                    $insertCouponRequest->offsetSet('code', $couponCode);
                    $insertCouponRequest->offsetSet('products', $couponProducts);
                    $insertCouponRequest->offsetSet('discount', $discount);
                    $insertCouponRequest->offsetSet('validSince', $validSinceDate);
                    $insertCouponRequest->offsetSet('sinceTime', $validSinceTime);
                    $insertCouponRequest->offsetSet('validSinceEnable', 1);
                    $insertCouponRequest->offsetSet('validUntil', $validUntilDate);
                    $insertCouponRequest->offsetSet('untilTime', $validUntilTime);
                    $insertCouponRequest->offsetSet('validUntilEnable', 1);
                    
                    $storeCoupon = $couponController->store($insertCouponRequest);
                    
                    if ($storeCoupon->status() == 200) {
    
                        $message = 'شما در قرعه کشی وفاداران آلاء برنده یک کد تخفیف شدید.';
                        $message .= "\n";
                        $message .= 'کد شما:';
                        $message .= "\n";
                        $message .= $couponCode;
                        $message .= "\n";
                        $message .= 'مهلت استفاده از کد: تا پنجشنبه ساعت 11 شب';
                        $message .= "\n";
                        $message .= 'به امید اینکه با کمک دیگر همایش های آلاء در کنکور بدرخشید و برنده iphonex در قرعه کشی عید فطر آلاء باشید.';
                        $user->notify(new GeneralNotice($message));
                        echo "<span style='color:green'>";
                        echo 'user '.$user->id.' notfied';
                        echo '</span>';
                        echo '<br>';
                        
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
        
                dump('processed: '.$proccessed);
                dump('failed: '.$failedCounter);
                dd('coupons done');
            }
    
            if ($request->has('tagfix')) {
                $contentsetId = 159;
                $contentset   = Contentset::where('id', $contentsetId)
                    ->first();
                
                $tags = $contentset->tags->tags;
                array_push($tags, 'نادریان');
                $bucket           = 'contentset';
                $tagsJson         = [
                    'bucket' => $bucket,
                    'tags'   => $tags,
                ];
                $contentset->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                
                if ($contentset->update()) {
                    $params = [
                        'tags' => json_encode($contentset->tags->tags, JSON_UNESCAPED_UNICODE),
                    ];
                    if (isset($contentset->created_at) && strlen($contentset->created_at) > 0) {
                        $params['score'] = Carbon::createFromFormat('Y-m-d H:i:s', $contentset->created_at)->timestamp;
                    }
    
                    $response = $this->sendRequest(config('constants.TAG_API_URL')."id/$bucket/".$contentset->id, 'PUT',
                        $params);
                } else {
                    dump('Error on updating #'.$contentset->id);
                }
                
                $contents = $contentset->contents;
                
                foreach ($contents as $content) {
                    $tags = $content->tags->tags;
                    array_push($tags, 'نادریان');
                    $bucket        = 'content';
                    $tagsJson      = [
                        'bucket' => $bucket,
                        'tags'   => $tags,
                    ];
                    $content->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
                    if ($content->update()) {
                        $params = [
                            'tags' => json_encode($content->tags->tags, JSON_UNESCAPED_UNICODE),
                        ];
                        if (isset($content->created_at) && strlen($content->created_at) > 0) {
                            $params['score'] = Carbon::createFromFormat('Y-m-d H:i:s', $content->created_at)->timestamp;
                        }
    
                        $response = $this->sendRequest(config('constants.TAG_API_URL')."id/$bucket/".$content->id,
                            'PUT', $params);
                    } else {
                        dump('Error on updating #'.$content->id);
                    }
                }
                dd('Tags DONE!');
            }
        } catch (\Exception    $e) {
            $message = 'unexpected error';
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    'message' => $message,
                    'error'   => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
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
         * $giftOrderproduct->orderproducttype_id = config("constants.ORDER_PRODUCT_GIFT");
         * $giftOrderproduct->order_id = $order->id ;
         * $giftOrderproduct->product_id = 107 ;
         * $giftOrderproduct->cost = 24000 ;
         * $giftOrderproduct->discountPercentage = 100 ;
         * $giftOrderproduct->save() ;
         *
         * $giftOrderproduct->parents()->attach($orderproduct->id , ["relationtype_id"=>config("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);
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
         * })->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED"), Config::set("constants.ORDER_STATUS_POSTED")])->whereIn("paymentstatus_id", [config("constants.PAYMENT_STATUS_PAID"), config("constants.PAYMENT_STATUS_INDEBTED")])->get();
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
         * $transactionRequest->offsetSet("paymentmethod_id" , config("constants.PAYMENT_METHOD_ATM"));
         * $transactionRequest->offsetSet("transactionstatus_id" ,  config("constants.TRANSACTION_STATUS_SUCCESSFUL"));
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
         * })->whereIn("orderstatus_id" , [config("constants.ORDER_STATUS_CLOSED") , config("constants.ORDER_STATUS_POSTED") , config("constants.ORDER_STATUS_READY_TO_POST")])
         * ->whereIn("paymentstatus_id" , [config("constants.PAYMENT_STATUS_INDEBTED") , config("constants.PAYMENT_STATUS_PAID")])->get();
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
         * $parentsArray = $product->$parentsCollection();
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
        return iconv(mb_detect_encoding($result, mb_detect_order(), true), 'UTF-8', $result);
        //         return iconv('windows-1250', 'utf-8', $result) ;
        //        return chr(255) . chr(254).mb_convert_encoding($result, 'UTF-16LE', 'UTF-8');
        //        return utf8_encode($result);
    }
    
    public function registerUserAndGiveOrderproduct(Request $request)
    {
        try {
            $mobile       = $request->get('mobile');
            $nationalCode = $request->get('nationalCode');
            $firstName    = $request->get('firstName');
            $lastName     = $request->get('lastName');
            $major_id     = $request->get('major_id');
            $gender_id    = $request->get('gender_id');
            $user         = User::where('mobile', $mobile)
                ->where('nationalCode', $nationalCode)
                ->first();
            if (isset($user)) {
                $flag = false;
                if (!isset($user->firstName) && isset($firstName)) {
                    $user->firstName = $firstName;
                    $flag            = true;
                }
                if (!isset($user->lastName) && isset($lastName)) {
                    $user->lastName = $lastName;
                    $flag           = true;
                }
                if (!isset($user->major_id) && isset($major_id)) {
                    $user->major_id = $major_id;
                    $flag           = true;
                }
                if (!isset($user->gender_id) && isset($gender_id)) {
                    $user->gender_id = $gender_id;
                    $flag            = true;
                }
                
                if ($flag) {
                    $user->update();
                }
            } else {
                $registerRequest = new InsertUserRequest();
                $registerRequest->offsetSet('mobile', $mobile);
                $registerRequest->offsetSet('nationalCode', $nationalCode);
                $registerRequest->offsetSet('firstName', $firstName);
                $registerRequest->offsetSet('lastName', $lastName);
                $registerRequest->offsetSet('password', $nationalCode);
                //                $registerRequest->offsetSet("mobileNumberVerification" , 1);
                $registerRequest->offsetSet('major_id', $major_id);
                $registerRequest->offsetSet('gender_id', $gender_id);
                $registerRequest->offsetSet('userstatus_id', 1);
                $userController = new \App\Http\Controllers\UserController();
                $response       = $userController->store($registerRequest);
                $result         = json_decode($response->getContent());
                if ($response->getStatusCode() == 200) {
                    $userId = $result->userId;
                    if ($userId > 0) {
                        $user = User::where('id', $userId)
                            ->first();
                        $user->notify(new UserRegisterd());
                    }
                }
            }
            
            if (isset($user)) {
                $orderProductIds = [];
                
                $arabiProduct  = 214;
                $hasArabiOrder = $user->orderproducts()
                    ->where('product_id', $arabiProduct)
                    ->whereHas('order', function ($q) {
                        $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'));
                        $q->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                    })
                    ->get();
                if ($hasArabiOrder->isEmpty()) {
                    array_push($orderProductIds, $arabiProduct);
                }
                
                $shimiProduct  = 100;
                $hasShimiOrder = $user->orderproducts()
                    ->where('product_id', $shimiProduct)
                    ->whereHas('order', function ($q) {
                        $q->where('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'));
                        $q->where('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                    })
                    ->get();
                
                if ($hasShimiOrder->isEmpty()) {
                    array_push($orderProductIds, $shimiProduct);
                }
                
                $giftOrderDone = true;
                if (!empty($orderProductIds)) {
                    $orderController   = new OrderController();
                    $storeOrderRequest = new Request();
                    $storeOrderRequest->offsetSet('orderstatus_id', config('constants.ORDER_STATUS_CLOSED'));
                    $storeOrderRequest->offsetSet('paymentstatus_id', config('constants.PAYMENT_STATUS_PAID'));
                    $storeOrderRequest->offsetSet('cost', 0);
                    $storeOrderRequest->offsetSet('costwithoutcoupon', 0);
                    $storeOrderRequest->offsetSet('user_id', $user->id);
                    $giftOrderCompletedAt = Carbon::now()
                        ->setTimezone('Asia/Tehran');
                    $storeOrderRequest->offsetSet('completed_at', $giftOrderCompletedAt);
                    $giftOrder = $orderController->store($storeOrderRequest);
    
                    $giftOrderMessage = 'ثبت سفارش با موفیت انجام شد';
                    if ($giftOrder !== false) {
                        foreach ($orderProductIds as $productId) {
                            $request->offsetSet('cost', 0);
                            $request->offsetSet('orderId_bhrk', $giftOrder->id);
                            $request->offsetSet('userId_bhrk', $user->id);
                            $product = Product::where('id', $productId)
                                ->first();
                            if (isset($product)) {
                                $response       = $orderController->addOrderproduct($request, $product);
                                $responseStatus = $response->getStatusCode();
                                $result         = json_decode($response->getContent());
                                if ($responseStatus == 200) {
                                
                                } else {
                                    $giftOrderDone    = false;
                                    $giftOrderMessage = 'خطا در ثبت آیتم سفارش';
                                    foreach ($result as $value) {
                                        $giftOrderMessage .= '<br>';
                                        $giftOrderMessage .= $value;
                                    }
                                }
                            } else {
                                $giftOrderDone    = false;
                                $giftOrderMessage = 'خطا در ثبت آیتم سفارش. محصول یافت نشد.';
                            }
                        }
                    } else {
                        $giftOrderDone    = false;
                        $giftOrderMessage = 'خطا در ثبت سفارش';
                    }
                } else {
                    $giftOrderMessage = 'کاربر مورد نظر محصولات را از قبل داشت';
                }
            } else {
                $giftOrderMessage = 'خطا در یافتن کاربر';
            }
            
            if ($giftOrderDone) {
                if (isset($user->gender_id)) {
                    if ($user->gender->name == 'خانم') {
                        $gender = 'خانم ';
                    } else {
                        if ($user->gender->name == 'آقا') {
                            $gender = 'آقای ';
                        } else {
                            $gender = '';
                        }
                    }
                } else {
                    $gender = '';
                }
                $message = $gender.$user->full_name."\n";
                $message .= 'همایش طلایی عربی و همایش حل مسائل شیمی به فایل های شما افزوده شد . دانلود در:';
                $message .= "\n";
                $message .= 'sanatisharif.ir/asset/';
                $user->notify(new GeneralNotice($message));
                session()->put('success', $giftOrderMessage);
            } else {
                session()->put('error', $giftOrderMessage);
            }
            
            if ($request->expectsJson()) {
                if ($giftOrderDone) {
                    return $this->response->setStatusCode(200);
                } else {
                    return $this->response->setStatusCode(503);
                }
            } else {
                return redirect()->back();
            }
        } catch (\Exception    $e) {
            $message = 'unexpected error';
            
            return $this->response->setStatusCode(500)
                ->setContent([
                    'message' => $message,
                    'error'   => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
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
    
        $majors      = Major::where('majortype_id', 1)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
        $majors      = array_add($majors, 0, 'انتخاب رشته');
        $majors      = array_sort_recursive($majors);
        $event       = Event::where('name', 'konkur97')
            ->first();
        $sideBarMode = 'closed';
    
        $userEventReport = Eventresult::where('user_id', Auth::user()->id)
            ->where('event_id', $event->id)
            ->get()
            ->first();
    
        $pageName       = 'submitKonkurResult';
        $user           = Auth::user();
        $userCompletion = (int) $user->completion();
        $url            = $request->url();
        $title          = 'آلاء|کارنامه سراسری 97';
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite('آلاء');
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
    
        return view('user.submitEventResultReport',
            compact('majors', 'event', 'sideBarMode', 'userEventReport', 'pageName', 'user', 'userCompletion'));
    }
    
    public function schoolRegisterLanding(Request $request)
    {
        abort(404);
        $eventRegistered = false;
        if (Auth::check()) {
            $user  = Auth::user();
            $event = Event::where('name', 'sabtename_sharif_97')
                ->get();
            if ($event->isEmpty()) {
                dd('ثبت نام آغاز نشده است');
            } else {
                $event           = $event->first();
                $events          = $user->eventresults->where('user_id', $user->id)
                    ->where('event_id', $event->id);
                $eventRegistered = $events->isNotEmpty();
                if ($eventRegistered) {
                    $score = $events->first()->participationCodeHash;
                }
                if (isset($user->firstName) && strlen(preg_replace('/\s+/', '', $user->firstName)) > 0) {
                    $firstName = $user->firstName;
                }
                if (isset($user->lastName) && strlen(preg_replace('/\s+/', '', $user->lastName)) > 0) {
                    $lastName = $user->lastName;
                }
                if (isset($user->mobile) && strlen(preg_replace('/\s+/', '', $user->mobile)) > 0) {
                    $mobile = $user->mobile;
                }
                if (isset($user->nationalCode) && strlen(preg_replace('/\s+/', '', $user->nationalCode)) > 0) {
                    $nationalCode = $user->nationalCode;
                }
                $major = $user->major_id;
                $grade = $user->grade_id;
            }
        }
        $url   = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite('آلاء');
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
        $pageName = 'schoolRegisterLanding';
    
        return view('pages.schoolRegister',
            compact('pageName', 'user', 'major', 'grade', 'firstName', 'lastName', 'mobile', 'nationalCode', 'score',
                'eventRegistered'));
    }
    
    public function specialAddUser(Request $request)
    {
        $majors   = Major::pluck('name', 'id');
        $genders  = Gender::pluck('name', 'id');
        $pageName = 'admin';
    
        return view('admin.insertUserAndOrderproduct', compact('majors', 'genders', 'pageName'));
    }
    
    /**
     * Temporary method for generating special couopns
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminGenerateRandomCoupon(Request $request)
    {
        $productCollection = $products = $this->makeProductCollection();
    
        return view('admin.generateSpecialCoupon', compact('productCollection'));
    }
    
    /**
     * @param  Request  $request
     *
     * @return
     */
    public function lernitoTree(Request $request)
    {
        $Riazi   = new Riazi();
        $Tajrobi = new Tajrobi();
        $Ensani  = new Ensani();
        
        $lastUpdatedByLernito = $this->getLastUpdatedByLernito();
        
        /*return $lastUpdatedByLernito;*/
        
        $mote2 = [
            [
                'id'       => '6321',
                'text'     => 'ریاضی و فیزیک',
                'tags'     => json_encode(['ریاضی_و_فیزیک'], JSON_UNESCAPED_UNICODE),
                'children' => $Riazi->getLernitoStyle(),
            ],
            [
                'id'       => '11552',
                'text'     => 'علوم تجربی',
                'tags'     => json_encode(['علوم_تجربی'], JSON_UNESCAPED_UNICODE),
                'children' => $Tajrobi->getLernitoStyle(),
            ],
            [
                'id'       => '15896',
                'text'     => 'علوم انسانی',
                'tags'     => json_encode(['علوم_انسانی'], JSON_UNESCAPED_UNICODE),
                'children' => $Ensani->getLernitoStyle(),
            ],
        ];
        /*return $mote2;*/
        
        $htmlPrint    = '';
        $treePathData = [];
        // loop in reshte
        $htmlPrint .= '<ul>';
        foreach ($mote2 as $key => $value) {
            $pathString1 = $value['text'];
            $pathId1     = $value['id'];
            
            $lastUpdatedByLernitoKey = '';
            if ($key == 0) {
                $lastUpdatedByLernitoKey = 'riaziUpdate';
            } else {
                if ($key == 1) {
                    $lastUpdatedByLernitoKey = 'tajrobiUpdate';
                } else {
                    if ($key == 2) {
                        $lastUpdatedByLernitoKey = 'ensaniUpdate';
                    }
                }
            }
            
            if (isset($lastUpdatedByLernito[$lastUpdatedByLernitoKey]) && count($lastUpdatedByLernito[$lastUpdatedByLernitoKey]['diff']) > 0) {
                $value['hasNewItem'] = true;
                $this->updatePaieNodes($lastUpdatedByLernito[$lastUpdatedByLernitoKey], $value['children']);
            }
            
            $hasNew = '0';
            if (isset($value['hasNewItem']) && $value['hasNewItem'] === true) {
                $hasNew = '1';
            }
            $htmlPrint .= '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-alaa-node-id="'.$value['id'].'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>رشته: "'.$value['text'];
            
            // loop in paie
            $htmlPrint .= '<ul>';
            foreach ($value['children'] as $key1 => $value1) {
                $pathString2 = $pathString1.'@@**@@'.$value1['name'];
                $pathId2     = $pathId1.'-'.$value1['id'];
                
                $hasNew = '0';
                if (isset($value1['hasNewItem']) && $value1['hasNewItem'] === true) {
                    $hasNew = '1';
                }
                $isNew = '0';
                if (isset($value1['isNewItem']) && $value1['isNewItem'] === true) {
                    $isNew = '1';
                }
                
                $htmlPrint .= '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-is-new="'.$isNew.'" data-alaa-node-id="'.$value1['id'].'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>پایه: '.$value1['name'];
                
                // loop in dars
                $htmlPrint .= '<ul>';
                foreach ($value1['children'] as $key2 => $value2) {
                    $pathString3 = $pathString2.'@@**@@'.$value2['name'];
                    $pathId3     = $pathId2.'-'.$value2['id'];
                    $htmlPrint   .= $this->printDars($value2, $pathString3, $pathId3);
                }
                $htmlPrint .= '</ul></li>';
            }
            $htmlPrint .= '</ul></li>';
        }
        $htmlPrint .= '</ul>';
        
        return view('admin.topicsTree.index', compact('mote2', 'treePathData', 'htmlPrint', 'lastUpdatedByLernito'));
    }
    
    private function getLastUpdatedByLernito(): array
    {
        $Riazi                = new Riazi();
        $Tajrobi              = new Tajrobi();
        $Ensani               = new Ensani();
        $lastUpdatedByLernito = [
            'riaziUpdate'   => [
                'diff'     => $Riazi->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id'   => '6321',
                    'text' => 'ریاضی و فیزیک',
                    'tags' => json_encode(['ریاضی_و_فیزیک'], JSON_UNESCAPED_UNICODE),
                ],
            ],
            'tajrobiUpdate' => [
                'diff'     => $Tajrobi->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id'   => '11552',
                    'text' => 'علوم تجربی',
                    'tags' => json_encode(['علوم_تجربی'], JSON_UNESCAPED_UNICODE),
                ],
            ],
            'ensaniUpdate'  => [
                'diff'     => $Ensani->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id'   => '15896',
                    'text' => 'علوم انسانی',
                    'tags' => json_encode(['علوم_انسانی'], JSON_UNESCAPED_UNICODE),
                ],
            ],
        ];
        
        return $lastUpdatedByLernito;
    }
    
    private function updatePaieNodes(array $lastUpdatedByLernito, &$oldChildren)
    {
        if (isset($lastUpdatedByLernito['diff'])) {
            foreach ($lastUpdatedByLernito['diff'] as $diffKey => $diffNode) {
                if (!isset($diffNode['diff']) && isset($diffNode['lernitoNode'])) {
                    $newItem              = $this->changeLernitoNodeToAlaaNode($diffNode['lernitoNode']);
                    $newItem['isNewItem'] = true;
                    $oldChildren[]        = $newItem;
                } else {
                    if (isset($diffNode['diff']) && isset($diffNode['lernitoNode']) && isset($diffNode['alaaNode'])) {
                        foreach ($oldChildren as $oldChildrenKey => $oldChildrenValue) {
                            if ($diffNode['alaaNode']['id'] == $oldChildrenValue['id']) {
                                $oldChildren[$oldChildrenKey]['hasNewItem'] = true;
                                $this->updatePaieNodes($diffNode, $oldChildren[$oldChildrenKey]['children']);
                            }
                        }
                    }
                }
            }
        }
    }
    
    private function changeLernitoNodeToAlaaNode(array &$lernitoNode)
    {
        $this->changeLernitoNodeChildren($lernitoNode);
        
        return $lernitoNode;
    }
    
    private function changeLernitoNodeChildren(array &$lernitoNodeChildren)
    {
        $lernitoNodeChildren['id']   = time().'-'.$lernitoNodeChildren['_id'];
        $lernitoNodeChildren['name'] = $lernitoNodeChildren['label'];
        $lernitoNodeChildren['tags'] = json_encode([str_replace(' ', '_', $lernitoNodeChildren['label'])],
            JSON_UNESCAPED_UNICODE);
        unset($lernitoNodeChildren['_id']);
        unset($lernitoNodeChildren['label']);
        if (isset($lernitoNodeChildren['children'])) {
            foreach ($lernitoNodeChildren['children'] as $key => $child) {
                $this->changeLernitoNodeChildren($lernitoNodeChildren['children'][$key]);
            }
        }
    }
    
    private function printDars(array $nodeData, string $ps, string $pid)
    {
        global $treePathData;
        
        $name = 'درس: '.$nodeData['name'];
        $data = $nodeData['children'];
        $id   = $nodeData['id'];
        
        $hasNew = '0';
        if (isset($nodeData['hasNewItem']) && $nodeData['hasNewItem'] === true) {
            $hasNew = '1';
        }
        $isNew = '0';
        if (isset($nodeData['isNewItem']) && $nodeData['isNewItem'] === true) {
            $isNew = '1';
        }
        
        $htmlPrint = '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-is-new="'.$isNew.'" data-alaa-node-id="'.$id.'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>'.$name.'<ul>';
        foreach ($data as $key => $value) {
            $pathString = $ps.'@@**@@'.$value['name'];
            $pathId     = $pid.'-'.$value['id'];
            
            if (isset($value['children']) && count($value['children']) > 0) {
                //                $htmlPrint .= '<li>('.$value['name'].')'.$this->printDars($value['name'], $value['children'], $value['id'], $pathString, $pathId).'</li>';
                $htmlPrint .= $this->printDars($value, $pathString, $pathId);
            } else {
                
                $isNewItem = '0';
                if (isset($value['isNewItem']) && $value['isNewItem'] === true) {
                    $isNewItem = '1';
                }
                
                $htmlPrint                  .= '<li data-jstree=\'{"icon":"/acm/extra/topicsTree/img/book-icon-1.png"}\' data-alaa-node-id="'.$value['id'].'" data-is-new="'.$isNewItem.'" ps="'.$pathString.'" pid="'.$pathId.'" id="'.$value['id'].'">'.$value['name'].'</li>';
                $treePathData[$value['id']] = [
                    'ps'  => $pathString,
                    'pid' => $pathId,
                ];
            }
        }
        $htmlPrint .= '</ul></li>';
        
        return $htmlPrint;
    }
    
    public function getTreeInPHPArrayString(Request $request, $lnid)
    {
        if (!is_numeric($lnid)) {
            return '';
        }
        $lernitoNodeId        = $lnid;
        $lastUpdatedByLernito = $this->getLastUpdatedByLernito();
        $maxId                = $this->getLastIdOfTopicsTree();
        
        $nodeFound = $this->findLernitoNodeById($lastUpdatedByLernito, $lernitoNodeId);
        $this->changeLernitoNodeToAlaaNode($nodeFound);
        $stringFormat = str_replace('"', "'", $this->convertAlaaNodeArrayToStringFormat($nodeFound, $maxId));
        $stringFormat = str_replace(PHP_EOL, '', $stringFormat);
        
        return $stringFormat;
    }
    
    private function getLastIdOfTopicsTree(): int
    {
        $maxId     = 0;
        $totalTree = $this->getTotalTopicsTree();
        $maxId     = $this->iterateThroughTotalTree($totalTree);
        
        return $maxId;
    }
    
    private function getTotalTopicsTree(): array
    {
        $Riazi     = new Riazi();
        $Tajrobi   = new Tajrobi();
        $Ensani    = new Ensani();
        $totalTree = array_merge($Riazi->getTree(), $Tajrobi->getTree(), $Ensani->getTree());
        
        return $totalTree;
    }
    
    private function iterateThroughTotalTree($tree)
    {
        $maxId = 0;
        if (isset($tree['id'])) {
            $tree['id'] = (int) $tree['id'];
            if ($tree['id'] > $maxId) {
                $maxId = $tree['id'];
            }
            if (isset($tree['children']) && count($tree['children']) > 0) {
                $newMaxId = $this->iterateThroughTotalTree($tree['children']);
                if ($newMaxId > $maxId) {
                    $maxId = $newMaxId;
                }
            }
        } else {
            foreach ($tree as $key => $value) {
                if (isset($value['id'])) {
                    $value['id'] = (int) $value['id'];
                }
                if (isset($value['id']) && $value['id'] > $maxId) {
                    $maxId = $value['id'];
                }
                if (isset($value['children']) && count($value['children']) > 0) {
                    $newMaxId = $this->iterateThroughTotalTree($value['children']);
                    if ($newMaxId > $maxId) {
                        $maxId = $newMaxId;
                    }
                }
            }
        }
        
        return $maxId;
    }
    
    private function findLernitoNodeById(array $lastUpdatedByLernito, int $lernitoNodeId)
    {
        $nodeFound = null;
        foreach ($lastUpdatedByLernito as $key => $value) {
            if (isset($value['lernitoNode']['_id']) && $value['lernitoNode']['_id'] == $lernitoNodeId) {
                return $value['lernitoNode'];
            } else {
                if (isset($value['diff'])) {
                    $nodeFound = $this->findLernitoNodeById($value['diff'], $lernitoNodeId);
                    if ($nodeFound != null) {
                        return $nodeFound;
                    }
                }
            }
        }
        
        return $nodeFound;
    }
    
    private function convertAlaaNodeArrayToStringFormat(array $alaaNode, &$nodeId): string
    {
        
        if (isset($alaaNode['name'])) {
            $nodeId++;
            $nodeArrayString = "
            <div class='objectWraper'>
                <div>[</div>";
            $nodeArrayString .= "
                    <div class='objectBody'>
                        <div>'id' => '$nodeId',</div>
                        <div>'name' => '".$alaaNode['name']."',</div>
                        <div>'tags' => ".json_encode([str_replace(' ', '_', $alaaNode['name'])],
                    JSON_UNESCAPED_UNICODE).",</div>
                        <div>'children' => ".$this->convertAlaaNodeArrayToStringFormat((isset($alaaNode['children'])) ? $alaaNode['children'] : [],
                    $nodeId).'</div>
                    </div>';
            $nodeArrayString .= '
                <div>]</div>
            </div>';
        } else {
            $nodeArrayString = '[';
            foreach ($alaaNode as $key => $value) {
                $nodeId++;
                $nodeArrayString .= "
                    <div class='inChildren'>
                        <div>[</div>";
                $nodeArrayString .= "
                            <div class='objectBody'>
                                <div>'id' => '$nodeId',</div>
                                <div>'name' => '".$value['name']."',</div>
                                <div>'tags' => ".json_encode([str_replace(' ', '_', $value['name'])],
                        JSON_UNESCAPED_UNICODE).",</div>
                                <div>'children' => ".$this->convertAlaaNodeArrayToStringFormat((isset($value['children'])) ? $value['children'] : [],
                        $nodeId).'</div>
                            </div>';
                $nodeArrayString .= '
                        <div>],</div>
                    </div>';
            }
            if (count($alaaNode) > 0) {
                $nodeArrayString .= '
                    <div>]</div>';
            } else {
                $nodeArrayString .= ']';
            }
        }
        
        return $nodeArrayString;
    }
}
