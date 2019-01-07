<?php

namespace App\Http\Controllers;

use App\{Afterloginformcontrol,
    Bankaccount,
    Bloodtype,
    Bon,
    Classes\Search\UserSearch,
    Classes\SEO\SeoDummyTags,
    Contact,
    Employeeschedule,
    Employeetimesheet,
    Event,
    Gender,
    Grade,
    Http\Controllers\Auth\RegisterController,
    Http\Requests\EditUserRequest,
    Http\Requests\InsertUserRequest,
    Http\Requests\InsertVoucherRequest,
    Http\Requests\PasswordRecoveryRequest,
    Http\Requests\RegisterForSanatiSharifHighSchoolRequest,
    Http\Requests\UserIndexRequest,
    Lottery,
    Major,
    Order,
    Phone,
    Product,
    Province,
    Role,
    Traits\CharacterCommon,
    Traits\DateTrait,
    Traits\Helper,
    Traits\MetaCommon,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Traits\SearchCommon,
    Traits\UserCommon,
    Transactiongateway,
    User,
    Userstatus,
    Websitesetting};
use Auth;
use Carbon\Carbon;
use Illuminate\{Foundation\Http\FormRequest,
    Http\Request,
    Http\Response,
    Support\Collection,
    Support\Facades\Cache,
    Support\Facades\DB,
    Support\Facades\File,
    Support\Facades\Input,
    Support\Facades\Route,
    Support\Facades\Storage,
    Support\Facades\View};
use Jenssegers\Agent\Agent;
use PHPUnit\Framework\Exception;
use SEO;
use stdClass;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use ProductCommon;
    use DateTrait;
    use RequestCommon;
    use CharacterCommon;
    use Helper;
    use UserCommon;
    use SearchCommon;
    use MetaCommon;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    const PARTIAL_MAIN_INDEX_TEMPLATE = "user.index";
    const PARTIAL_SMS_INDEX_TEMPLATE = "user.index2";
    const PARTIAL_REPORT_INDEX_TEMPLATE = "admin.partials.getReportIndex";
    protected $setting;

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    public function __construct(Agent $agent, Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }


    /**
     * @param Agent $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        $authException = [];
        return $authException;
    }

    /**
     * @param array $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . config('constants.LIST_USER_ACCESS') . "|" . config('constants.GET_BOOK_SELL_REPORT') . "|" . config('constants.GET_USER_REPORT'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_USER_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_USER_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_USER_ACCESS'), ['only' => 'edit']);
        $this->middleware('trimUserUpdateRequest', ['only' => 'update']);
    }

    /**
     * @param Collection $items
     *
     * @return \Illuminate\Http\Response
     */
    private function makeJsonForAndroidApp(Collection $items)
    {
        $items = $items->pop();
        $key = md5($items->pluck("id")
            ->implode(","));
        $response = Cache::remember($key, config("constants.CACHE_60"), function () use ($items) {
            $response = collect();

        });
        return $response;
    }

    /**
     * Finding tech person based on his tech code
     *
     * @param Request $request
     *
     * @return int|string
     */
    public function findTech(Request $request)
    {
        $user = User::where('techCode', $request->techCode)
                    ->first();
        if (isset($user))
            return action('UserController@show', $user);
        return 0;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(UserIndexRequest $request)
    {
        $tags = $request->get('tags');
        $filters = array_filter($request->all()); //Removes null fields
        $isApp = $this->isRequestFromApp($request);
        $items = collect();
        $pageName = 'userPage';
        $userResult = (new UserSearch)->setPageName($pageName)
            ->get($filters);
        if ($isApp) {
            $items->push($userResult->getCollection());
        } else {
            if ($userResult->total() > 0) {
                $mainIndex = $this->getPartialSearchFromIds($userResult, self::PARTIAL_MAIN_INDEX_TEMPLATE);
                $smsIndex = $this->getPartialSearchFromIds($userResult, self::PARTIAL_SMS_INDEX_TEMPLATE);
//                $reportIndex = $this->getPartialSearchFromIds($userResult, self::PARTIAL_REPORT_INDEX_TEMPLATE);
            } else {
                $mainIndex = null;
                $smsIndex = null;
                $reportIndex = null ;
            }

            $uniqueUsers = $userResult->getCollection()->getUniqueUsers();

            $items->push([
                "totalitems" => $userResult->total(),
                "totalUniqueItems" => $uniqueUsers->count(),
                "itemIds"  => $userResult->pluck("id"),
                "uniqueItemsIds"    => $uniqueUsers->pluck("id"),
                "mainIndex"       => $mainIndex,
                "smsIndex"  => $smsIndex,
//                "reportIndex"  => $reportIndex,
            ]);
        }
        if ($isApp) {
            $response = $this->makeJsonForAndroidApp($items);
            return response()->json($response, Response::HTTP_OK);
        }
        if (request()->ajax()) {
            return response(
                [
                    "items"     => $items,
                ]
                , Response::HTTP_OK );
        }

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("مدیریت کاربران", "مدیریت کاربران سایت", $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        return redirect()->back();

        //======================================================================
        //=============================OLD CODE=================================
        //======================================================================

        $users = $users->get();
        /**
         * For selling books
         */
        $hasPishtaz = [];
        if (isset($orders))
            foreach ($users as $user) {
                if ($user->orders()
                         ->whereIn("id", $orders->pluck("id")
                                                ->toArray())
                         ->whereHas("orderproducts", function ($q) {
                             $q->whereHas("attributevalues", function ($q2) {
                                 $q2->where("id", 48);
                             });
                         })
                         ->get()
                         ->isNotEmpty())
                    array_push($hasPishtaz, $user->id);
            }

        /**
         * end
         */

        $sortBy = Input::get("sortBy");
        $sortType = Input::get("sortType");
        if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
            if (strcmp($sortType, "desc") == 0)
                $users = $users->sortByDesc($sortBy);
            else
                $users = $users->sortBy($sortBy);
        }

        $previousPath = url()->previous();
        $usersId = [];
        $numberOfFatherPhones = 0;
        $numberOfMotherPhones = 0;
        $usersIdCount = 0;
        $index = "";
        $reportType = "";

        if (strcmp($previousPath, action("HomeController@adminSMS")) == 0) {
            //Converted
        } else if (strcmp($previousPath, action("HomeController@admin")) == 0) {
            //Converted
        } else if (strcmp($previousPath, action("HomeController@adminReport")) == 0) {
            $index = "admin.partials.getReportIndex";

            $minCost = Input::get("minCost");
            if (isset($minCost[0])) {
                foreach ($users as $key => $user) {
                    $userOrders = $user->orders;
                    $transactionSum = 0;
                    foreach ($userOrders as $order) {
                        $successfullTransactions = $order->successfulTransactions()
                                                         ->where("created_at", ">", "2017-09-22")
                                                         ->get();
                        foreach ($successfullTransactions as $transaction) {
                            $transactionSum += $transaction->cost;
                        }
                    }
                    if ($transactionSum < (int)$minCost)
                        $users->forget($key);
                }
            }

            if (Input::has("lotteries")) {
                $lotteryId = Input::get("lotteries");
                $lotteries = Lottery::where("id", $lotteryId)
                                    ->get();
            }

            if (Input::has("reportType"))
                $reportType = Input::get("reportType");

            if (Input::has("seePaidCost"))
                $seePaidCost = true;
        }

        $result = [
            'index'                => View::make($index, compact('users', 'products', 'paymentStatusesId', 'reportType', 'hasPishtaz', 'orders', 'seePaidCost', 'lotteries'))
                                          ->render(),
            'products'             => (isset($products)) ? $products : [],
            'lotteries'            => (isset($lotteries)) ? $lotteries : [],
            "allUsers"             => $usersId,
            "allUsersNumber"       => $usersIdCount,
            "numberOfFatherPhones" => $numberOfFatherPhones,
            "numberOfMotherPhones" => $numberOfMotherPhones,
        ];

        return response(json_encode($result, JSON_UNESCAPED_UNICODE), 200)->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \app\Http\Requests\InsertUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUserRequest $request)
    {
        try {
            //ToDo : To be placed in a middleware
            $softDeletedUsers = User::onlyTrashed()
                                    ->where("mobile", $request->get("mobile"))
                                    ->where("nationalCode", $request->get("nationalCode"))
                                    ->get();

            if ($softDeletedUsers->isNotEmpty()) {
                $softDeletedUsers->first()
                                 ->restore();
                return response(
                    [],
                    Response::HTTP_OK
                );
            }

            $user = new User();
            $this->fillContentFromRequest($request, $user);

            $done = false;
            if ($user->save()) {
                if ($request->has("roles"))
                    $this->attachRoles($request->get("roles"), $request->user(), $user);

                $responseStatusCode = Response::HTTP_OK;
                $responseContent = "درج کاربر با موفقیت انجام شد";
                $done = true;

            } else {
                $responseStatusCode = Response::HTTP_SERVICE_UNAVAILABLE;
                $responseContent = "خطا در ذخیره کاربر";
            }

            return response(
                [
                    "message" => $responseContent,
                    "user"    => ($done ? $user : null),
                ],
                $responseStatusCode
            );
        }
        catch (\Exception    $e) {
            $message = "unexpected error";
            return response(
                [
                    "message" => $message,
                    "error"   => $e->getMessage(),
                    "line"    => $e->getLine(),
                    "file"    => $e->getFile(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    /**
     * @param FormRequest $request
     * @param User        $user
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function fillContentFromRequest(FormRequest $request, User &$user): void
    {
        $inputData = $request->all();
        $hasMobileVerifiedAt = $request->has("mobileNumberVerification");
        $hasPassword = $request->has("password");
        $hasLockProfile = $request->has("lockProfile");

        $user->fill($inputData);

        if ($hasMobileVerifiedAt)
            $user->mobile_verified_at = ($request->get("mobileNumberVerification") == "1") ? Carbon::now()
                                                                                                   ->setTimezone("Asia/Tehran") : null;


        if ($hasPassword)
            $user->password = bcrypt($request->get("password"));

        if ($hasLockProfile)
            $user->lockProfile = $request->get("lockProfile") == "1" ? 1 : 0;

        $file = $this->getRequestFile($request, "photo");
        if ($file !== false)
            $this->storePhotoOfUser($user, $file);
    }

    /*
    |--------------------------------------------------------------------------
    | Public methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param User $user
     * @param      $file
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function storePhotoOfUser(User &$user, $file): void
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
        if (Storage::disk(config('constants.DISK1'))
                   ->put($fileName, File::get($file))) {
            $oldPhoto = $user->photo;
            if (!$this->userHasDefaultAvatar($oldPhoto))
                Storage::disk(config('constants.DISK1'))
                       ->delete($oldPhoto);
            $user->photo = $fileName;
        }
    }

    /**
     * @param array $newRoleIds
     * @param User  $staffUser
     * @param User  $user
     */
    private function attachRoles(array $newRoleIds = [], User $staffUser, User $user): void
    {
        if ($staffUser->can(config('constants.INSET_USER_ROLE'))) {
            $oldRolesIds = $user->roles->pluck("id")
                                       ->toArray();
            $totalRoles = array_merge($oldRolesIds, $newRoleIds);
            $this->checkGivenRoles($totalRoles, $staffUser);

            if (!empty($newRoleIds)) {
                $user->roles()
                     ->sync($newRoleIds);
            }
        }
    }

    /**
     * Checks whether user can give these roles or not
     *
     * @param array $newRoleIds
     * @param User  $user
     */
    private function checkGivenRoles(array &$newRoleIds, User $user): void
    {
        foreach ($newRoleIds as $key => $newRoleId) {
            $newRole = Role::Find($newRoleId);
            if (isset($newRole)) {
                if ($newRole->isDefault) {
                    if (!$user->can(config('constants.GIVE_SYSTEM_ROLE')))
                        unset($newRoleIds[$key]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if (!$this->canSeeProfile($user))
            abort(403);

        $genders = Gender::pluck('name', 'id')
                         ->prepend("نامشخص");
        $majors = Major::pluck('name', 'id')
                       ->prepend("نامشخص");
        $sideBarMode = "closed";

        /** LOTTERY */
        [
            $exchangeAmount,
            $userPoints,
            $userLottery,
            $prizeCollection,
            $lotteryRank,
            $lottery,
            $lotteryMessage,
            $lotteryName,
        ] = $user->getLottery();

        $userCompletion = (int)$user->completion();
        $mobileVerificationCode = $user->getMobileVerificationCode();

        return view("user.profile.profile", compact("genders", "majors", "sideBarMode", "user", "userCompletion", "hasRequestedVerificationCode", "mobileVerificationCode", //lottery variables
                                                    "exchangeAmount", "userPoints", "userLottery", "prizeCollection", "lotteryRank", "lottery", "lotteryMessage", "lotteryName"

        ));

    }

    /**
     * Checks whether user can see profile
     *
     * @param $user
     *
     * @return bool
     */
    private function canSeeProfile($user): bool
    {
        if (Auth::check())
            return (($user->id === Auth::id()) || (Auth::user()
                                                       ->hasRole(config('constants.ROLE_ADMIN'))) || ($user->hasRole(config('constants.ROLE_TECH')))); else
            return false;
    }

    /**
     * Display a listing user's orders.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function userOrders(Request $request)
    {
        $debitCard = Bankaccount::all()
                                ->where("user_id", 2)
                                ->first();

        $user = $request->user();

        $key = "user:orders:" . $user->cacheKey();
        $orders = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getClosedOrders()
                        ->get()
                        ->sortByDesc("completed_at");
        });

        $key = "user:transactions:" . $user->cacheKey();
        $transactions = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getShowableTransactions()
                        ->get()
                        ->sortByDesc("completed_at")
                        ->groupBy("order_id");
        });

        $key = "user:instalments:" . $user->cacheKey();
        $instalments = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getInstalments()
                        ->get()
                        ->sortBy("deadline_at");
        });

        $gateways = Transactiongateway::enable()
                                      ->get()
                                      ->sortBy("order")
                                      ->pluck("displayName", "name");

        $key = "user:orderCoupons:" . $user->cacheKey() . ":Orders=" . md5($orders->pluck("id")
                                                                                  ->implode('-'));
        $orderCoupons = Cache::remember($key, config("constants.CACHE_60"), function () use ($orders) {
            return $orders->getCoupons();
        });

        return view("user.ordersList", compact("orders", "gateways", "debitCard", "transactions", "instalments", "orderCoupons"));
    }

    /**
     * Showing files to user which he has got for his orders
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function userProductFiles(Request $request)
    {

        $sideBarMode = "closed";
        $user = $request->user();
        $products = $user->products();


        $key = "user:userProductFiles:" . $user->cacheKey() . ":P=" . md5($products->pluck("id")
                                                                                   ->implode('-'));
        [
            $videos,
            $pamphlets,
        ] = Cache::remember($key, config("constants.CACHE_60"), function () use ($products) {
            $products->load('complimentaryproducts');
            $products->load('children');
            $products->load('validProductfiles');
            $pamphlets = collect();
            $videos = collect();
            foreach ($products as $product) {

                    $parentsArray = $this->makeParentArray($product);

                    $this->addVideoPamphlet($parentsArray, $pamphlets, $videos);

                    $childrenArray = $product->children;
                    $this->addVideoPamphlet($childrenArray, $pamphlets, $videos , "digChildren");

                    $pamphletArray = [];
                    $videoArray = [];
                    if ($pamphlets->has($product->id))
                        $pamphletArray = $pamphlets->pull($product->id);
                    if ($videos->has($product->id))
                        $videoArray = $videos->pull($product->id);

                    foreach ($product->validProductfiles as $productfile) {
                        if ($productfile->productfiletype_id == config("constants.PRODUCT_FILE_TYPE_PAMPHLET"))
                            array_push($pamphletArray, [
                                "file"       => $productfile->file,
                                "name"       => $productfile->name,
                                "product_id" => $productfile->product_id,
                            ]); else
                            array_push($videoArray, [
                                "file"       => $productfile->file,
                                "name"       => $productfile->name,
                                "product_id" => $productfile->product_id,
                            ]);

                    }
                    if (!empty($pamphletArray))
                        $pamphlets->put($product->id, [
                            "productName" => $product->name,
                            "pamphlets"   => $pamphletArray,
                        ]);

                    if (!empty($videoArray))
                        $videos->put($product->id, [
                            "productName" => $product->name,
                            "videos"      => $videoArray,
                        ]);
                    $c = $product->complimentaryproducts;
                    $this->addVideoPamphlet($c, $pamphlets, $videos);
            }
            return [
                $videos,
                $pamphlets,
            ];
        });

        $isEmptyProducts = $products->isEmpty();
        $userCompletion = (int)$user->completion();

        return view("user.assetsList", compact('section', 'sideBarMode', 'isEmptyProducts', 'pamphlets', 'videos', 'user', 'userCompletion'));
    }

    /**
     * Filling product's pamphlets and videos collection ( called by reference )
     *
     * @param            $productArray
     * @param Collection $pamphlets
     * @param Collection $videos
     */
    private function addVideoPamphlet($productArray, Collection &$pamphlets, Collection &$videos , $mode = "default")
    {
        if (!empty($productArray)) {
            $videoArray = [];
            $pamphletArray = [];
            foreach ($productArray as $product) {
                if (!in_array($product->id, $pamphletArray) && !in_array($product->id, $videoArray)) {

                    if (isset($pamphlets[$product->id]))
                        $pamphletArray = $pamphlets[$product->id]; else
                        $pamphletArray = [];
                    if (isset($videos[$product->id]))
                        $videoArray = $videos[$product->id]; else
                        $videoArray = [];

                    foreach ($product->validProductfiles as $productfile) {
                        if ($productfile->productfiletype_id == config("constants.PRODUCT_FILE_TYPE_PAMPHLET")) {
                            array_push($pamphletArray, [
                                "file"       => $productfile->file,
                                "name"       => $productfile->name,
                                "product_id" => $productfile->product_id,
                            ]);
                        } else {

                            array_push($videoArray, [
                                "file"       => $productfile->file,
                                "name"       => $productfile->name,
                                "product_id" => $productfile->product_id,
                            ]);
                        }

                    }

                    if (!empty($pamphletArray))
                        $pamphlets->put($product->id, [
                            "productName" => $product->name,
                            "pamphlets"   => $pamphletArray,
                        ]);

                    if (!empty($videoArray))
                        $videos->put($product->id, [
                            "productName" => $product->name,
                            "videos"      => $videoArray,
                        ]);
                }

                if($mode == "digChildren")
                    $this->addVideoPamphlet($product->children,$pamphlets,$videos);

                $this->addVideoPamphlet($product->complimentaryproducts, $pamphlets, $videos);
            }
        }
    }

    /**
     * Show authenticated user belongings
     *
     * @param
     *
     * @return \Illuminate\Http\Response
     */
    public function showBelongings(Request $request)
    {
        $user = $request->user();
        $belongings = $user->belongings;
        $sideBarMode = "closed";
        return view("user.belongings", compact("belongings", "sideBarMode", "user"));
    }

    /**
     * Showing a survey to user to take part in
     *
     * @return \Illuminate\Http\Response
     */
    public function showSurvey()
    {
        //        return redirect(action("HomeController@error404"));
        $event = Event::FindOrFail(1);
        $surveys = $event->surveys;
        foreach ($surveys as $survey) {
            $questions = $survey->questions->sortBy("pivot.order");
            $questionsData = collect();
            $answersData = collect();
            foreach ($questions as $question) {
                $requestBaseUrl = $question->dataSourceUrl;
                /**
                 * Getting raw answer
                 */
                $requestUrl = action("UserSurveyAnswerController@index");
                $requestUrl .= "?event_id[]=" . $event->id . "&survey_id[]=" . $survey->id . "&question_id[]=" . $question->id;
                $originalInput = \Illuminate\Support\Facades\Request::input();
                $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
                \Illuminate\Support\Facades\Request::replace($request->input());
                $response = Route::dispatch($request);
                $answersCollection = json_decode($response->content());
                \Illuminate\Support\Facades\Request::replace($originalInput);
                $questionAnswerArray = [];
                foreach ($answersCollection as $answerCollection) {
                    /** Making answers */
                    $answerArray = $answerCollection->userAnswer->answer;
                    $requestUrl = url("/") . $requestBaseUrl . "?ids=$answerArray";
                    $originalInput = \Illuminate\Support\Facades\Request::input();
                    $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
                    \Illuminate\Support\Facades\Request::replace($request->input());
                    $response = Route::dispatch($request);
                    $dataJson = json_decode($response->content());
                    \Illuminate\Support\Facades\Request::replace($originalInput);
                    foreach ($dataJson as $data) {
                        $questionAnswerArray = array_add($questionAnswerArray, $data->id, $data->name);
                    }
                }
                $answersData->put($question->id, $questionAnswerArray);
                /**
                 *  Making questions
                 */
                if (strpos($question->dataSourceUrl, "major") !== false) {
                    $userMajor = Auth()->user()->major;
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
                    $requestUrl = url("/") . $requestBaseUrl . "?";
                    foreach ($userMajors as $major) {
                        $requestUrl .= "&parents[]=$major";
                    }
                    $originalInput = \Illuminate\Support\Facades\Request::input();
                    $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
                    \Illuminate\Support\Facades\Request::replace($request->input());
                    $response = Route::dispatch($request);
                    $dataJson = json_decode($response->content());
                    \Illuminate\Support\Facades\Request::replace($originalInput);
                    $rootMajorArray = [];
                    $majorsArray = [];
                    foreach ($dataJson as $item) {
                        $majorsArray = array_add($majorsArray, $item->id, $item->name);
                    }
                    $rootMajorArray = array_add($rootMajorArray, $userMajor->name, $majorsArray);
                    $questionsData->put($question->id, $rootMajorArray);
                } else if (strpos($question->dataSourceUrl, "city") !== false) {
                    $provinces = Province::orderBy("name")
                                         ->get();
                    $provinceCityArray = [];
                    foreach ($provinces as $province) {
                        $requestUrl = url("/") . $requestBaseUrl . "?provinces[]=$province->id";
                        $originalInput = \Illuminate\Support\Facades\Request::input();
                        $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
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


            }

        }
        $pageName = "showSurvey";
        return view("survey.show", compact("event", "survey", "questions", "questionsData", "answersData", "pageName"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $majors = Major::pluck('name', 'id')
                       ->toArray();
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $roles = Role::pluck('display_name', 'id')
                     ->toArray();
        $userRoles = $user->roles()
                          ->pluck('id')
                          ->toArray();
        $genders = Gender::pluck('name', 'id')
                         ->toArray();

        return view("user.edit", compact("user", "majors", "userStatuses", "roles", "userRoles", "genders"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($user)
    {
        $user->delete();
        return redirect()->back();
    }

    /**
     * Show the form for completing information of the specified resource.(Created for orduatalaee 97)
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function informationPublicUrl(Request $request)
    {
        return redirect(action("UserController@information", $request->user()), 301);
    }

    /**
     * Show the form for completing information of the specified resource.(Created for orduatalaee 97)
     *
     * @param $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function information($user)
    {
        $validOrders = $user->orders()
                            ->whereHas("orderproducts", function ($q) {
                                $q->whereIn("product_id", config("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT"))
                                  ->orwhereIn("product_id", config("constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT"))
                                  ->orwhereIn("product_id", [
                                      199,
                                      202,
                                  ]);
                            })
                            ->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED")]);

        if ($validOrders->get()
                        ->isEmpty()) {
            return redirect(action("ProductController@landing2"));
        }
        $unPaidOrders = $validOrders->get();
        $paidOrder = $validOrders->whereIn("paymentstatus_id", [
            config("constants.PAYMENT_STATUS_PAID"),
            config("constants.PAYMENT_STATUS_INDEBTED"),
        ])
                                 ->get();
        if ($paidOrder->isNotEmpty())
            $order = $paidOrder->first(); else $order = $unPaidOrders->first();

        if (!isset($order))
            abort(403);

        $orderproduct = $order->orderproducts(config("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
                              ->get()
                              ->first();
        $product = $orderproduct->product;
        if (in_array($product->id, config("constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT")))
            $userHasMedicalQuestions = true; else $userHasMedicalQuestions = false;
        $grandParent = $product->grandParent;
        if ($grandParent !== false) {
            $userProduct = $grandParent->name;
        } else {
            $userProduct = $product->name;
        }


        $simpleContact = \App\Contacttype::where("name", "simple")
                                         ->get()
                                         ->first();
        $mobilePhoneType = \App\Phonetype::where("name", "mobile")
                                         ->get()
                                         ->first();
        $parents = \App\Relative::whereIn("name", [
            "father",
            "mother",
        ])
                                ->get();
        $parentsNumber = collect();
        foreach ($parents as $parent) {
            $parentContacts = $user->contacts->where("relative_id", $parent->id)
                                             ->where("contacttype_id", $simpleContact->id);
            if ($parentContacts->isNotEmpty()) {
                $parentContact = $parentContacts->first();
                $parentMobiles = $parentContact->phones->where("phonetype_id", $mobilePhoneType->id)
                                                       ->sortBy("priority");
                if ($parentMobiles->isNotEmpty()) {
                    $parentMobile = $parentMobiles->first()->phoneNumber;
                    $parentsNumber->put($parent->name, $parentMobile);
                }
            }
        }
        $majors = Major::pluck('name', 'id')
                       ->toArray();
        $majors[0] = "نامشخص";
        $majors = array_sort_recursive($majors);
        /////////////////////////////////////////
        $genders = Gender::pluck('name', 'id')
                         ->toArray();
        $genders[0] = "نامشخص";
        $genders = array_sort_recursive($genders);
        ///////////////////////
        $bloodTypes = Bloodtype::pluck('name', 'id')
                               ->toArray();
        $bloodTypes[0] = "نامشخص";
        $bloodTypes = array_sort_recursive($bloodTypes);
        //////////////////////////
        $grades = Grade::pluck('displayName', 'id')
                       ->toArray();
        $grades[0] = "نامشخص";
        $grades = array_sort_recursive($grades);
        $orderFiles = $order->files;

        //////////Lock fields//////////
        $lockedFields = [];
        if ($user->lockProfile) {
            $lockedFields = $user->returnLockProfileItems();
        }
        if ($userHasMedicalQuestions) {
            $completionFields = $user->returnCompletionItems();
            $completionFieldsCount = count($completionFields);
            $completionPercentage = (int)$user->completion("completeInfo");
        } else {
            $completionFields = array_diff($user->returnCompletionItems(), $user->returnMedicalItems());
            $completionFieldsCount = count($completionFields);
            $completionPercentage = (int)$user->completion("custom", $completionFields);
        }

        $completedFieldsCount = (int)ceil(($completionPercentage * $completionFieldsCount) / 100);
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

        $completionPercentage = (int)(($completedFieldsCount / $completionFieldsCount) * 100);
        if ($completionPercentage == 100) {
            if ($user->completion("lockProfile") == 100) {
                $user->lockProfile();
                $user->timestamps = false;
                $user->update();
                $user->timestamps = true;
            }
        }
        return view("user.completeInfo", compact("user", "parentsNumber", "majors", "genders", "bloodTypes", "grades", "userProduct", "order", "orderFiles", "userHasMedicalQuestions", "lockedFields", "completionPercentage", "customerExtraInfo"));
    }

    /**
     * Display a page where user can upaload his consulting questions
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadConsultingQuestion()
    {

        return view("user.uploadConsultingQuestion");
    }

    /**
     * Display the list of uploaded files by user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function uploads(Request $request)
    {

        $questions = $request->user()->useruploads->where("isEnable", "1");
        $counter = 1;
        return view("user.consultingQuestions", compact("questions", "counter"));
    }

    /**
     * Send system generated password to the user that does not belong to anyone
     *
     * @param \App\Http\Requests\PasswordRecoveryRequest $request
     *
     * @return \Illuminate\Http\Response
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
            } else $user = $users->first();
        }

        if (!isset($user)) {
            if (Auth::check())
                $user = $request->user(); else return redirect(action("HomeController@error403"));
        }

        $now = Carbon::now();
        if (isset($user->passwordRegenerated_at) && $now->diffInMinutes(Carbon::parse($user->passwordRegenerated_at)) < config('constants.GENERATE_PASSWORD_WAIT_TIME')) {
            if ($now->diffInMinutes(Carbon::parse($user->passwordRegenerated_at)) > 0)
                $timeInterval = $now->diffInMinutes(Carbon::parse($user->passwordRegenerated_at)) . " دقیقه "; else $timeInterval = $now->diffInSeconds(Carbon::parse($user->passwordRegenerated_at)) . " ثانیه ";
            session()->put("warning", "شما پس از گذشت ۵ دقیقه از آخرین درخواست خود می توانید دوباره درخواست ارسال رمز عبور نمایید .از زمان ارسال آخرین پیامک تایید برای شما " . $timeInterval . "می گذرد.");
            return redirect()->back();
        }
        //        $password = $this->generateRandomPassword(4);
        $password = [
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
            session()->put("success", "پیامک حاوی رمز عبور شما با موفقیت به شماره موبایلتان ارسال شد . در صورت عدم دریافت پیامک پس از ۵ دقیقه می توانید دوباره درخواست ارسال رمز عبور  نمایید");
        } else {
            $user->passwordRegenerated_at = null;
            session()->put("error", "ارسال پیامک حاوی رمز عبور با مشکل مواجه شد! لطفا دوباره درخواست ارسال پیامک نمایید.");
        }
        $user->update();
        return redirect()->back();
    }

    /**
     * Showing the form to the user for adding extra information after registeration
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function completeRegister(Request $request)
    {
        if ($request->has("redirectTo"))
            $targetUrl = $request->get("redirectTo");
        else
            $targetUrl = action("HomeController@index");

        if ($request->user()
                    ->completion("afterLoginForm") == 100) {
            return redirect($targetUrl);
        }

        $previousPath = url()->previous();
        if (strcmp($previousPath, route('login')) == 0) {
            $formByPass = false;
            $note = "برای ورود به سایت لطفا اطلاعات زیر را تکمیل نمایید";
        } else {
            $formByPass = true;
            $note = "برای استفاده از این خدمت سایت لطفا اطلاعات زیر را تکمیل نمایید";
        }

        $formFields = Afterloginformcontrol::getFormFields();
        $tables = [];
        foreach ($formFields as $formField) {
            if (strpos($formField->name, "_id")) {
                $tableName = $formField->name;
                $tableName = str_replace("_id", "s", $tableName);
                $tables[$formField->name] = DB::table($tableName)
                                              ->pluck('name', 'id');
            }
        }
        return view("user.completeRegister", compact("formFields", "note", "formByPass", "tables"));
    }

    /**
     * Storing user's work time (for employees)
     *
     * @param Request                                           $request
     * @param \App\Http\Controllers\EmployeetimesheetController $employeetimesheetController
     * @param \App\Http\Controllers\HomeController              $homeController
     *
     * @return \Illuminate\Http\Response
     */
    public function submitWorkTime(Request $request, EmployeetimesheetController $employeetimesheetController, HomeController $homeController)
    {
        $userId = $request->user()->id;
        $request->offsetSet("user_id", $userId);
        $request->offsetSet("date", Carbon::today('Asia/Tehran')
                                          ->format("Y-m-d"));

        $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
                                                       ->format('l'));
        $employeeSchedule = Employeeschedule::where("user_id", $userId)
                                            ->where("day", $toDayJalali)
                                            ->get()
                                            ->first();
        if (isset($employeeSchedule)) {
            $request->offsetSet("userBeginTime", $employeeSchedule->getOriginal("beginTime"));
            $request->offsetSet("userFinishTime", $employeeSchedule->getOriginal("finishTime"));
            $request->offsetSet("allowedLunchBreakInSec", gmdate("H:i:s", $employeeSchedule->getOriginal("lunchBreakInSeconds")));
        }

        $request->offsetSet("modifier_id", $userId);
        $request->offsetSet("serverSide", true);
        $insertRequest = new \App\Http\Requests\InsertEmployeeTimeSheet($request->all());
        $userTimeSheets = Employeetimesheet::where("date", Carbon::today('Asia/Tehran'))
                                           ->where("user_id", $userId->id)
                                           ->get();
        if ($userTimeSheets->count() == 0) {
            $done = $employeetimesheetController->store($insertRequest);
        } else if ($userTimeSheets->count() == 1) {
            $done = $employeetimesheetController->update($insertRequest, $userTimeSheets->first());
        } else {
            $message = "شما بیش از یک ساعت کاری برای امروز ثبت نموده اید!";
            return $homeController->errorPage($message);
        }
        if ($done)
            session()->flash("success", "ساعت کاری با موفقیت ذخیره شد"); else
            session()->flash("error", \Lang::get("responseText.Database error."));

        return redirect()->back();
    }

    /**
     * Removes user from lottery
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function removeFromLottery(Request $request)
    {
        $user = $request->user();
        $message = "";

        $bonName = config("constants.BON2");
        $bon = Bon::where("name", $bonName)
                  ->first();
        if (isset($bon)) {
            $userbons = $user->userValidBons($bon);
            if ($userbons->isNotEmpty()) {
                $usedUserBon = collect();
                $sumBonNumber = 0;
                foreach ($userbons as $userbon) {
                    $totalBonNumber = $userbon->totalNumber - $userbon->usedNumber;
                    $usedUserBon->put($userbon->id, ["used" => $totalBonNumber]);
                    $sumBonNumber += $totalBonNumber;
                    $userbon->usedNumber = $userbon->usedNumber + $totalBonNumber;
                    $userbon->userbonstatus_id = config("constants.USERBON_STATUS_USED");
                    $userbon->update();
                }
                $userBonTaken = true;

                [
                    $result,
                    $responseText,
                    $prizeName,
                    $walletId,
                ] = $this->exchangeLottery($user, $sumBonNumber);

                if ($result) {
                    $lottery = Lottery::where("name", config("constants.LOTTERY_NAME"))
                                      ->first();
                    if (isset($lottery)) {
                        $prizes = '{
                          "items": [
                            {
                              "name": "' . $prizeName . '",
                              "objectType": "App\\\\Wallet",
                              "objectId": "' . $walletId . '"
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
                        } else {
                            $done = false;
                            $message = "شما قبلا از قرعه کشی انصراف داده اید";
                        }
                    } else {
                        $done = false;
                        $message = "خطای غیر منتظره. لطفا بعدا دوباره اقدام نمایید";
                    }
                } else {
                    $message = $responseText;
                    $done = false;
                }
            } else {
                $done = false;
                $message = "شما در قرعه کشی نیستید";
            }
        } else {
            $done = false;
            $message = "خطای غیر منتظره . لطفا بعدا اقدام فرمایید";
        }

        if (isset($done))
            if ($done) {
                return response(
                    [
                        "message" => "OK",
                    ],
                    Response::HTTP_OK
                );
            } else {
                if (isset($userBonTaken) && $userBonTaken) {
                    foreach ($userbons as $userbon) {
                        if (isset($usedUserBon[$userbon->id])) {
                            $usedNumber = $usedUserBon[$userbon->id]["used"];
                            $userbon->usedNumber = max($userbon->usedNumber - $usedNumber, 0);
                            $userbon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
                        } else {
                            $userbon->usedNumber = 0;
                            $userbon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
                        }

                        $userbon->update();
                    }
                }
                return response(
                    [
                        ["message" => $message],
                    ],
                    Response::HTTP_SERVICE_UNAVAILABLE
                );

            } else
            return response(
                [
                    ["message" => "عملیاتی انجام نشد"],
                ],
                Response::HTTP_SERVICE_UNAVAILABLE
            );
    }

    /**
     * Store the complentary information of specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function completeInformation(User $user, Request $request, UserController $userController, PhoneController $phoneController, ContactController $contactController, OrderController $orderController)
    {
        if (strlen($request->get("phone")) > 0)
            $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("phone")));
        if (strlen($request->get("postalCode")) > 0)
            $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("postalCode")));
        if (strlen($request->get("parentMobiles")["father"]) > 0)
            $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("parentMobiles")["father"]));
        if (strlen($request->get("parentMobiles")["mother"]) > 0)
            $this->convertToEnglish(preg_replace('/\s+/', '', $request->get("parentMobiles")["mother"]));
        if (strlen($request->get("school")) > 0)
            $this->convertToEnglish($request->get("school"));
        if (strlen($request->get("allergy")) > 0)
            $this->convertToEnglish($request->get("allergy"));
        if (strlen($request->get("medicalCondition")) > 0)
            $this->convertToEnglish($request->get("medicalCondition"));
        if (strlen($request->get("diet")) > 0)
            $this->convertToEnglish($request->get("diet"));
        if (strlen($request->get("introducer")) > 0)
            $this->convertToEnglish($request->get("introducer"));
        $this->validate($request, [
            'photo' => 'image|mimes:jpeg,jpg,png|max:200',
            'file'  => 'mimes:jpeg,jpg,png,zip,pdf,rar',
        ]);
        if ($request->user()->id != $user->id)
            abort(403);
        if ($request->has("order")) {
            $orderId = $request->get("order");
            $order = Order::FindOrFail($orderId);
            if ($order->user_id != $request->user()->id)
                abort(403);
        } else {
            return response(
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        /**
         * User's basic info
         **/
        $editUserRequest = new EditUserRequest();
        if ($request->hasFile("photo"))
            $editUserRequest->offsetSet("photo", $request->file("photo"));
        $editUserRequest->offsetSet("province", $request->get("province"));
        $editUserRequest->offsetSet("address", $request->get("address"));
        $editUserRequest->offsetSet("postalCode", $request->get("postalCode"));
        $editUserRequest->offsetSet("city", $request->get("city"));
        $editUserRequest->offsetSet("school", $request->get("school"));
        if ($request->get("major_id") != 0)
            $editUserRequest->offsetSet("major_id", $request->get("major_id"));
        if ($request->get("grade_id") != 0)
            $editUserRequest->offsetSet("grade_id", $request->get("grade_id"));
        if ($request->get("gender_id") != 0)
            $editUserRequest->offsetSet("gender_id", $request->get("gender_id"));
        if ($request->get("bloodtype_id") != 0)
            $editUserRequest->offsetSet("bloodtype_id", $request->get("bloodtype_id"));
        $editUserRequest->offsetSet("phone", $request->get("phone"));
        $editUserRequest->offsetSet("allergy", $request->get("allergy"));
        $editUserRequest->offsetSet("medicalCondition", $request->get("medicalCondition"));
        $editUserRequest->offsetSet("diet", $request->get("diet"));
        $userController->update($editUserRequest, $user);

        /**
         *
         */
        /**
         * Parent's basic info
         **/
        $simpleContact = \App\Contacttype::where("name", "simple")
                                         ->get()
                                         ->first();
        $mobilePhoneType = \App\Phonetype::where("name", "mobile")
                                         ->get()
                                         ->first();
        $parentsNumber = $request->get("parentMobiles");

        foreach ($parentsNumber as $relative => $mobile) {
            if (strlen(preg_replace('/\s+/', '', $mobile)) == 0)
                continue;
            $parent = \App\Relative::where("name", $relative)
                                   ->get()
                                   ->first();
            $parentContacts = $user->contacts->where("relative_id", $parent->id)
                                             ->where("contacttype_id", $simpleContact->id);
            if ($parentContacts->isEmpty()) {
                $storeContactRequest = new \App\Http\Requests\InsertContactRequest();
                $storeContactRequest->offsetSet("name", $relative);
                $storeContactRequest->offsetSet("user_id", $user->id);
                $storeContactRequest->offsetSet("contacttype_id", $simpleContact->id);
                $storeContactRequest->offsetSet("relative_id", $parent->id);
                $storeContactRequest->offsetSet("isServiceRequest", true);
                $response = $contactController->store($storeContactRequest);
                if ($response->getStatusCode() == 200) {
                    $responseContent = json_decode($response->getContent("contact"));
                    $parentContact = $responseContent->contact;
                } else if ($response->getStatusCode() == 503) {

                }
            } else {
                $parentContact = $parentContacts->first();
            }
            if (isset($parentContact)) {
                $parentContact = Contact::where("id", $parentContact->id)
                                        ->get()
                                        ->first();
                $parentMobiles = $parentContact->phones->where("phonetype_id", $mobilePhoneType->id)
                                                       ->sortBy("priority");
                if ($parentMobiles->isEmpty()) {
                    $storePhoneRequest = new \App\Http\Requests\InsertPhoneRequest();
                    $storePhoneRequest->offsetSet("phoneNumber", $mobile);
                    $storePhoneRequest->offsetSet("contact_id", $parentContact->id);
                    $storePhoneRequest->offsetSet("phonetype_id", $mobilePhoneType->id);
                    $response = $phoneController->store($storePhoneRequest);
                    if ($response->getStatusCode() == 200) {

                    } else if ($response->getStatusCode() == 503) {

                    }

                } else {
                    $parentMobile = $parentMobiles->first();
                    $parentMobile->phoneNumber = $mobile;
                    if ($parentMobile->update()) {

                    } else {

                    }
                }
            }
        }
        /**
         *
         */


        $updateOrderRequest = new \App\Http\Requests\EditOrderRequest();
        if ($request->hasFile("file"))
            $updateOrderRequest->offsetSet("file", $request->file("file"));
        /**
         * customerExtraInfo
         */
        $jsonConcats = "";
        $extraInfoQuestions = array_sort_recursive($request->get("customerExtraInfoQuestion"));
        $customerExtraInfoAnswers = $request->get("customerExtraInfoAnswer");
        foreach ($extraInfoQuestions as $key => $question) {
            $obj = new stdClass();
            $obj->title = $question;
            if (strlen(preg_replace('/\s+/', '', $customerExtraInfoAnswers[$key])) > 0)
                $obj->info = $customerExtraInfoAnswers[$key]; else $obj->info = null;
            if (strlen($jsonConcats) > 0)
                $jsonConcats = $jsonConcats . ',' . json_encode($obj, JSON_UNESCAPED_UNICODE); else
                $jsonConcats = json_encode($obj, JSON_UNESCAPED_UNICODE);
        }
        $customerExtraInfo = "[" . $jsonConcats . "]";
        $updateOrderRequest->offsetSet("customerExtraInfo", $customerExtraInfo);
        $orderController->update($updateOrderRequest, $order);

        session()->put("success", "اطلاعات با موفقیت ذخیره شد");
        return redirect()->back();

    }

    /**
     * Update the specified resource in storage.
     * Note: Requests to this method must pass \App\Http\Middleware\trimUserRequest middle ware
     *
     * @param  \app\Http\Requests\EditUserRequest $request
     * @param  User                               $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(EditUserRequest $request, $user)
    {
        $user->fill($request->all());

        $this->fillContentFromRequest($request, $user);

        if ($user->completion("lockProfile") == 100)
            $user->lockProfile();

        /** snippet code for changing user's password
         *  note that an admin user can change any passwords and that works fine
         *  but when a user is updating his password it needs some extra work as you can see below
         *  and this extra work should not conflict with updating passwords by admin
         */
        //        $oldPassword = $request->oldPassword;
        //        $newPassword = $request->password;
        //
        //        $confirmation = $this->userPasswordConfirmation($user, $oldPassword, $newPassword);
        //
        //        if ($confirmation["confirmed"]) {
        //            $user->changePassword($newPassword);
        //            if ($user->update()) {
        //                session()->put("success", "رمز عبور با موفقیت تغییر یافت.");
        //            } else {
        //                session()->put("error", "خطا در تغییر رمز عبور ، لطفا دوباره اقدام نمایید.");
        //            }
        //        } else {
        //            session()->put("error", $confirmation["message"]);
        //        }


        $isAjax = false;
        if ($user->update()) {

            if ($request->has("roles"))
                $this->attachRoles($request->get("roles"), $request->user(), $user);

            $newPhotoSrc = route('image', [
                'category' => '1',
                'w'        => '150',
                'h'        => '150',
                'filename' => $user->photo,
            ]);

            $message = "اطلاعات با موفقیت اصلاح شد";
            if ($request->ajax()) {
                $isAjax = true;
                $status = Response::HTTP_OK;
            } else {
                session()->flash("success", $message);
            }
        } else {

            $message = \Lang::get("responseText.Database error.");
            if ($request->ajax()) {
                $isAjax = true;
                $status = Response::HTTP_SERVICE_UNAVAILABLE;
            } else {
                session()->flash("error", $message);
            }
        }

        if ($isAjax)
            return response(
                [
                    "newPhoto" => isset($newPhotoSrc) ? $newPhotoSrc : null,
                    "message"  => $message,
                ],
                $status
            );
        else
            return redirect()->back();
    }

    /**
     * Register student for sanati sharif highschool
     *
     * @param  \App\Http\Requests\RegisterForSanatiSharifHighSchoolRequest $request
     * @param EventresultController                                        $eventResultController
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function registerForSanatiSharifHighSchool(RegisterForSanatiSharifHighSchoolRequest $request, EventresultController $eventResultController)
    {
        $event = Event::where("name", "sabtename_sharif_97")
                      ->get();
        if ($event->isEmpty()) {
            session()->put("error", "رخداد یافت نشد");
            return redirect()->back();
        } else {
            $event = $event->first();
        }

        if (Auth::check())
            $user = $request->user(); else
            $registeredUser = User::where("mobile", $request->get("mobile"))
                                  ->where("nationalCode", $request->get("nationalCode"))
                                  ->get();

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
            $response = $registerController->register($registerRequest);
            if ($response->getStatusCode() != 302) {
                session()->put("error", "خطایی در ثبت اطلاعات شما اتفاق افتاد . لطفا دوباره اقدام نمایید.");
                return redirect()->back();
            }
            $user = $request->user();
        } else {
            if (!isset($user))
                $user = $registeredUser->first();
            $updateRequest = new EditUserRequest();
            if ($request->has("firstName") && (!isset($user->firstName) || strlen(preg_replace('/\s+/', '', $user->firstName)) == 0))
                $updateRequest->offsetSet("firstName", $request->get("firstName"));
            if ($request->has("lastName") && (!isset($user->lastName) || strlen(preg_replace('/\s+/', '', $user->lastName)) == 0))
                $updateRequest->offsetSet("lastName", $request->get("lastName"));
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
        } else {
            $evenResultRequest = new \App\Http\Requests\InsertEventResultRequest();
            $evenResultRequest->offsetSet("user_id", $user->id);
            $evenResultRequest->offsetSet("event_id", $event->id);
            $evenResultRequest->offsetSet("participationCodeHash", $request->get("score"));
            RequestCommon::convertRequestToAjax($evenResultRequest);
            $response = $eventResultController->store($evenResultRequest);
            if ($response->getStatusCode() == 503) {
                session()->put("error", "خطایی در ثبت نام شما رخ داد. لطفا مجددا اقدام نمایید");
                return redirect()->back();
            } else {
                //                $result = json_decode($response->getContent());
                //                if(isset($result->participationCode))
                //                    $participationCode = $result->participationCode;
            }
        }

        $message = "پیش ثبت نام شما در دبیرستان دانشگاه صنعتی شریف با موفقیت انجام شد .";
        if (isset($participationCode))
            $message .= "کد داوطلبی شما: " . $participationCode;
        session()->put("success", $message);
        return redirect()->back();
    }

    /**
     * Submit user request for voucher request
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function voucherRequest(Request $request)
    {
        $url = $request->url();
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

        $user = $request->user();
        $genders = Gender::pluck('name', 'id')
                         ->prepend("انتخاب کنید");
        $majors = Major::pluck('name', 'id')
                       ->prepend("انتخاب کنید");
        $sideBarMode = "closed";

        $asiatechProduct = config("constants.ASIATECH_FREE_ADSL");
        $nowDateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                             ->timezone('Asia/Tehran');
        $userHasRegistered = false;

        $asitechPendingOrders = Order::whereHas("orderproducts", function ($q) use ($asiatechProduct) {
            $q->where("product_id", $asiatechProduct);
        })
                                     ->where("orderstatus_id", config("constants.ORDER_STATUS_PENDING"))
                                     ->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"))
                                     ->orderBy("completed_at")
                                     ->get();
        $userAsitechPendingOrders = $asitechPendingOrders->where("user_id", $user->id);
        if ($userAsitechPendingOrders->isNotEmpty()) {
            $rank = $userAsitechPendingOrders->keys()
                                             ->first() + 1;

            $userHasRegistered = true;
        } else {
            $asitechApprovedOrders = $user->orders()
                                          ->whereHas("orderproducts", function ($q) use ($asiatechProduct) {
                                              $q->where("product_id", $asiatechProduct);
                                          })
                                          ->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                                          ->where("paymentstatus_id", config("constants.PAYMENT_STATUS_PAID"))
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
        return view("user.submitVoucherRequest", compact("user", "genders", "majors", "sideBarMode", "userHasRegistered", "rank", "userVoucher", "mobileVerificationCode"));
    }

    /**
     * Submit user request for voucher request
     *
     * @param  \App\Http\Requests\InsertVoucherRequest InsertVoucherRequest
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function submitVoucherRequest(InsertVoucherRequest $request)
    {
        $asiatechProduct = config("constants.ASIATECH_FREE_ADSL");
        $user = $request->user();
        $nowDateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                             ->timezone('Asia/Tehran');
        $vouchers = $user->productvouchers->where("expirationdatetime", ">", $nowDateTime)
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
        if ($user->hasVerifiedMobile())
            $updateRequest->offsetSet("mobileNumberVerification", 1);
        $birthdate = Carbon::parse($request->get("birthdate"))
                           ->setTimezone("Asia/Tehran")
                           ->format('Y-m-d');
        $updateRequest->offsetSet("birthdate", $birthdate);
        $updateRequest->offsetSet("school", $request->get("school"));
        $updateRequest->offsetSet("major_id", $request->get("major_id"));
        $updateRequest->offsetSet("introducedBy", $request->get("introducedBy"));
        $response = $this->update($updateRequest, $user);
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
        if ($response->getStatusCode() == 200) {
            if ($user->completion("custom", $completionColumns) < 100) {
                session()->put("error", "اطلاعات شما ذخیره شد اما برای ثبت درخواست اینترنت رایگان آسیاتک کامل نمی باشند . لطفا اطلاعات خود را تکمیل نمایید.");
            } else {
                $asiatechOrder = new Order();
                $asiatechOrder->orderstatus_id = config("constants.ORDER_STATUS_PENDING");
                $asiatechOrder->paymentstatus_id = config("constants.PAYMENT_STATUS_PAID");
                $asiatechOrder->cost = 0;
                $asiatechOrder->costwithoutcoupon = 0;
                $asiatechOrder->user_id = $user->id;
                $asiatechOrder->completed_at = Carbon::now()
                                                     ->setTimezone("Asia/Tehran");
                if ($asiatechOrder->save()) {
                    $request->offsetSet("cost", 0);
                    $request->offsetSet("orderId_bhrk", $asiatechOrder->id);
                    $product = Product::where("id", $asiatechProduct)
                                      ->first();
                    if (isset($product)) {
                        $orderController = new OrderController();
                        $response = $orderController->addOrderproduct($request, $product);
                        $responseStatus = $response->getStatusCode();
                        $result = json_decode($response->getContent());
                        if ($responseStatus == 200) {
                            $user->lockProfile();

                            $user->update();
                        } else {
                            session()->put("error", "خطا در ثبت محصول اینرنت رایگان آسیاتک");
                        }
                    } else {
                        session()->put("error", "محصول اینترنت آسیاتک یافت نشد");
                    }
                } else {
                    session()->put("error", "خطا در ثبت سفارش اینترنت رایگان. لطفا بعدا اقدام نمایید");
                }
            }
        } else {
            session()->put("error", "مشکل غیر منتظره ای در ذخیره اطلاعات شما پیش آمد . لطفا مجددا اقدام نمایید");
        }

        return redirect()->back();
    }
}
