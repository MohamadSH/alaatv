<?php

namespace App\Http\Controllers\Web;

use App\{Assignmentstatus,
    Attribute,
    Attributecontrol,
    Attributeset,
    Bon,
    Checkoutstatus,
    Collection\OrderCollections,
    Consultationstatus,
    Coupon,
    Coupontype,
    Gender,
    Lottery,
    Major,
    Notifications\UserRegisterd,
    Order,
    Orderproduct,
    Orderstatus,
    Paymentmethod,
    Paymentstatus,
    Permission,
    Product,
    Producttype,
    Repositories\WebsitePageRepo,
    Role,
    Traits\APIRequestCommon,
    Traits\CharacterCommon,
    Traits\Helper,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Traits\UserCommon,
    Transactiongateway,
    Transactionstatus,
    User,
    Userbon,
    Userbonstatus,
    Userstatus,
    Userupload,
    Useruploadstatus,
    Websitepage,
    Websitesetting,
    Http\Controllers\Controller};
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;

class AdminController extends Controller
{
    use Helper;
    use APIRequestCommon;
    use ProductCommon;
    use CharacterCommon;
    use UserCommon;
    use RequestCommon;

    public function __construct()
    {
        $this->middleware('ability:'.config('constants.ROLE_ADMIN').','.config('constants.USER_ADMIN_PANEL_ACCESS'), ['only' => 'admin']);
        $this->middleware('permission:'.config('constants.CONSULTANT_PANEL_ACCESS'), ['only' => 'consultantAdmin']);
        $this->middleware('permission:'.config('constants.PRODUCT_ADMIN_PANEL_ACCESS'), ['only' => 'adminProduct']);
        $this->middleware('permission:'.config('constants.CONTENT_ADMIN_PANEL_ACCESS'), ['only' => 'adminContent']);
        $this->middleware('permission:'.config('constants.LIST_ORDER_ACCESS'), ['only' => 'adminOrder']);
        $this->middleware('permission:'.config('constants.SMS_ADMIN_PANEL_ACCESS'), ['only' => 'adminSMS']);
        $this->middleware('permission:'.config('constants.REPORT_ADMIN_PANEL_ACCESS'), ['only' => 'adminReport']);
        $this->middleware('permission:'.config('constants.LIST_BLOCK_ACCESS'), ['only' => 'adminBlock']);
        $this->middleware('ability:'.config('constants.ROLE_ADMIN').','.config('constants.TELEMARKETING_PANEL_ACCESS'), ['only' => 'adminTeleMarketing']);
        $this->middleware('permission:'.config('constants.INSERT_COUPON_ACCESS'), ['only' => 'adminGenerateRandomCoupon']);
        $this->middleware('permission:'.config('constants.WALLET_ADMIN_PANEL'), ['only' => 'adminGiveWalletCredit']);
        $this->middleware('permission:'.config('constants.LIST_EVENTRESULT_ACCESS'), ['only' => 'adminRegistrationList']);
        $this->middleware('role:admin', [
            'only' => [
                'adminLottery',
                'registerUserAndGiveOrderproduct',
                'specialAddUser',
                'adminSalesReport',
            ],
        ]);


    }

    /**
     * Show admin panel main page
     *
     * @return Response
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
     * @return Response
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
     * @return Response
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

        $paymentGateways = Transactiongateway::enable()->get()->pluck('displayName' , 'id');

        return view('admin.indexOrder',
            compact('pageName', 'orderstatuses', 'products', 'paymentMethods', 'majors', 'paymentstatuses', 'sortBy',
                'sortType', 'transactionTypes',
                'orderTableDefaultColumns', 'coupons', 'transactionStatuses', 'transactionTableDefaultColumns',
                'userBonTableDefaultColumns', 'userBonStatuses',
                'attributevalueCollection', 'addressSpecialFilter', 'checkoutStatuses', 'paymentGateways'));
    }

    /**
     * Show content admin panel page
     *
     * @return Response
     */
    public function adminContent()
    {
        $majors             = Major::pluck('name', 'id');
//        $assignmentStatuses = Assignmentstatus::pluck('name', 'id');
//        $assignmentStatuses->prepend('انتخاب وضعیت');
//        $consultationStatuses = Consultationstatus::pluck('name', 'id');
//        $consultationStatuses->prepend('انتخاب وضعیت');

        return view('admin.indexContent', compact('majors'));
    }

    /**
     * Show consultant admin panel page
     *
     * @return Response
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
     * Show adminSMS panel main page
     *
     * @return Response
     */
    public function adminSMS()
    {
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

        return view('admin.indexSMS',
            compact('pageName', 'majors', 'userStatuses', 'roles', 'relatives', 'orderstatuses', 'paymentstatuses',
                'genders', 'gendersWithUnknown', 'products',
                 'lockProfileStatus', 'mobileNumberVerification', 'sortBy', 'sortType', 'smsCredit',
                'smsProviderNumber',
                 'coupons', 'addressSpecialFilter', 'checkoutStatuses'));
    }

    /**
     * Admin panel for adjusting site configuration
     * @param Request $request
     * @param SlideShowController $slideShowController
     * @return Factory|View
     */
    public function adminSlideShow(Request $request , SlideShowController $slideShowController)
    {

        $slides             = $slideShowController->index();
        $slideDisk          = 9;
        $section            = 'slideShow';

        $websitePages = WebsitePageRepo::getWebsitePages(
            ['url' => [
                '/home',
                '/shop',
            ]]
        )->pluck('displayName' , 'id');


        return view('admin.siteConfiguration.slideShow',
            compact('slides', 'section', 'slideDisk', 'websitePages'));
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
     * @param Request $request
     * @return Factory|View
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
     * @param Request $request
     * @return Factory|View
     */
    public function adminTeleMarketing(Request $request)
    {
        $orders= new OrderCollections();
        $marketingProducts = [];
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
     * Temporary method for generating special couopns
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return Factory|View
     */
    public function adminGenerateRandomCoupon(Request $request)
    {
        $productCollection = $products = $this->makeProductCollection();
        $childrenCollection = collect();
        /** @var Product $product */
        foreach ($productCollection as $product) {
            $children = $product->getAllChildren();
            $childrenCollection->put( $product->id , $children);
        }

        return view('admin.generateSpecialCoupon', compact('productCollection' , 'childrenCollection'));
    }

    public function registerUserAndGiveOrderproduct(Request $request , OrderController $orderController)
    {
        try {
            $mobile       = $request->get('mobile');
            $nationalCode = $request->get('nationalCode');
            $firstName    = $request->get('firstName');
            $lastName     = $request->get('lastName');
            $major_id     = $request->get('major_id');
            $gender_id    = $request->get('gender_id');
            $productIds   = $request->get('products' , []);
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
                $user = User::craete([
                    'mobile'        => $mobile,
                    'nationalCode'  => $nationalCode,
                    'firstName'     => $firstName,
                    'lastName'      => $lastName,
                    'password'      => bcrypt($nationalCode),
                    'major_id'      => $major_id,
                    'gender_id'     => $gender_id,
                    'userstatus_id' => 1,
                ]);
                if (isset($user)) {
                    $user = User::where('id', $user->id)->first();
                    $user->notify(new UserRegisterd());
                }
            }

            $giftOrderDone = false;
            $responseStatus = Response::HTTP_SERVICE_UNAVAILABLE;
            if (isset($user)) {
                if (!empty($productIds)) {
                    $giftOrder = Order::create([
                        'orderstatus_id'    => config('constants.ORDER_STATUS_CLOSED'),
                        'paymentstatus_id'  => config('constants.PAYMENT_STATUS_PAID'),
                        'cost'              => 0,
                        'costwithoutcoupon' => 0,
                        'user_id'           => $user->id,
                        'completed_at'      => Carbon::now('Asia/Tehran'),
                    ]);

                    if (isset($giftOrder)) {
                        foreach ($productIds as $productId) {
                            $orderproduct = Orderproduct::create([
                                'cost'  => 0 ,
                                'order_id'  =>  $giftOrder->id,
                                'product_id'=> $productId,
                                'orderproducttype_id'=> config('constants.ORDER_PRODUCT_TYPE_DEFAULT'),
                            ]);
                            if (isset($orderproduct)) {
                                $giftOrderDone    = true;
                                $responseStatus = Response::HTTP_OK;
                                $giftOrderSuccessMessage = 'ثبت سفارش با موفیت انجام شد';
                            }else{
                                $giftOrderErrorMessage = 'خطا در ثبت آیتم سفارش';
                            }
                        }
                    } else {
                        $giftOrderErrorMessage = 'خطا در ثبت سفارش';
                    }
                } else {
                    $giftOrderErrorMessage = 'محصولی انتخاب نشده است';
                }
            } else {
                $giftOrderErrorMessage = 'خطا در یافتن کاربر';
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
                $message .= "\n";
                $message .= 'alaatv.com/asset';
//                $user->notify(new GeneralNotice($message));

            }

            if ($request->expectsJson()) {
                return response()->json([] , $responseStatus);
            } else {
                if(isset($giftOrderSuccessMessage)){
                    session()->put('success', $giftOrderSuccessMessage);
                }
                if(isset($giftOrderErrorMessage)){
                    session()->put('error', $giftOrderErrorMessage);
                }
                return redirect()->back();
            }
        } catch (Exception    $e) {
            return response()->json([
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ] , Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function specialAddUser(Request $request)
    {
        $majors   = Major::pluck('name', 'id');
        $genders  = Gender::pluck('name', 'id');
        $pageName = 'admin';

        return view('admin.insertUserAndOrderproduct', compact('majors', 'genders', 'pageName'));
    }

    public function adminBlock(Request $request)
    {
        $blockTypes = [
            [
                'value' => '1',
                'name' => 'صفحه اصلی',
            ],
            [
                'value' => '2',
                'name' => 'فروشگاه',
            ],
            [
                'value' => '3',
                'name' => 'صفحه محصول',
            ]
        ];
        $pageName = 'indexBlock';
        return view('admin.indexBlock', compact('pageName', 'blockTypes'));
    }

    public function adminSalesReport(Request $request) {
        $pageName = 'adminSalesReport';
        $products   = Product::orderBy('created_at' , 'desc')->get();
        $ajaxActionUrl = action('Web\OrderproductController@index');
        $checkoutStatuses       = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0]   = 'همه';
        $checkoutStatuses       = array_sort_recursive($checkoutStatuses);

        return view('admin.salesReport', compact('products', 'pageName', 'ajaxActionUrl' , 'checkoutStatuses'));
    }

    public function adminRegistrationList(Request $request) {
        return view('admin.indexRegistration');
    }

    public function adminGiveWalletCredit(Request $request){
        return view('admin.wallet');
    }
}
