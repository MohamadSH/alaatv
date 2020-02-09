<?php

namespace App\Http\Controllers\Web;

use App\{Afterloginformcontrol,
    Bloodtype,
    Collection\OrderCollections,
    Contact,
    Contacttype,
    Event,
    Gender,
    Grade,
    Http\Requests\EditOrderRequest,
    Http\Requests\EditUserRequest,
    Http\Requests\InsertContactRequest,
    Http\Requests\InsertPhoneRequest,
    Http\Requests\InsertUserRequest,
    Http\Requests\UserIndexRequest,
    Lottery,
    Major,
    Order,
    Phone,
    Phonetype,
    Product,
    Relative,
    Repositories\OrderRepo,
    Role,
    Traits\CharacterCommon,
    Traits\DateTrait,
    Traits\Helper,
    Traits\MetaCommon,
    Traits\RequestCommon,
    Traits\SearchCommon,
    Traits\UserCommon,
    Transactiongateway,
    User,
    Userstatus,
    Websitesetting};
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\{Contracts\Filesystem\FileNotFoundException,
    Contracts\View\Factory,
    Http\RedirectResponse,
    Http\Request,
    Http\Response,
    Support\Arr,
    Support\Collection,
    Support\Facades\Cache,
    Support\Facades\DB,
    Support\Facades\View,
    Validation\ValidationException};
use Jenssegers\Agent\Agent;
use Kalnoy\Nestedset\QueryBuilder;
use stdClass;

class UserController extends Controller
{
    use DateTrait;
    use RequestCommon;
    use CharacterCommon;
    use Helper;
    use UserCommon;
    use SearchCommon;
    use MetaCommon;

    private $setting;

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
        return ['show', 'userProductFiles'];
    }

    /**
     * @param array $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . config('constants.LIST_USER_ACCESS') . '|' . config('constants.GET_BOOK_SELL_REPORT') . '|' . config('constants.GET_USER_REPORT'),
            ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_USER_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_USER_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_USER_ACCESS'), ['only' => 'edit']);
    }

    public function index(UserIndexRequest $request)
    {
        $products    = [];
        $lotteries   = [];
        $reportType  = null;
        $hasPishtaz  = [];
        $orders      = null;
        $seePaidCost = null;


        $createdTimeEnable = $request->get('createdTimeEnable');
        $createdSinceDate  = $request->get('createdSinceDate');
        $createdTillDate   = $request->get('createdTillDate');
        if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
            $createdSinceDate = Carbon::parse($createdSinceDate)
                    ->format('Y-m-d') . ' 00:00:00';
            $createdTillDate  = Carbon::parse($createdTillDate)
                    ->format('Y-m-d') . ' 23:59:59';
            $users            = User::whereBetween('created_at', [$createdSinceDate, $createdTillDate])
                ->orderBy('created_at', 'Desc');
        } else {
            $users = User::orderBy('created_at', 'Desc');
        }

        $updatedSinceDate  = $request->get('updatedSinceDate');
        $updatedTillDate   = $request->get('updatedTillDate');
        $updatedTimeEnable = $request->get('updatedTimeEnable');
        if (strlen($updatedSinceDate) > 0 && strlen($updatedTillDate) > 0 && isset($updatedTimeEnable)) {
            $users = $this->timeFilterQuery($users, $updatedSinceDate, $updatedTillDate, 'updated_at');
        }

        //filter by firstName, lastName, nationalCode, mobile
        $firstName = trim($request->get('firstName'));
        if (isset($firstName) && strlen($firstName) > 0) {
            $users = $users->where('firstName', 'like', '%' . $firstName . '%');
        }

        $lastName = trim($request->get('lastName'));
        if (isset($lastName) && strlen($lastName) > 0) {
            $users = $users->where('lastName', 'like', '%' . $lastName . '%');
        }

        $nationalCode = trim($request->get('nationalCode'));
        if (isset($nationalCode) && strlen($nationalCode) > 0) {
            $users = $users->where('nationalCode', 'like', '%' . $nationalCode . '%');
        }

        $mobile = trim($request->get('mobile'));
        if (isset($mobile) && strlen($mobile) > 0) {
            $users = $users->where('mobile', 'like', '%' . $mobile . '%');
        }

        //filter by role, major , coupon
        $roleEnable = $request->get('roleEnable');
        $rolesId    = $request->get('roles');
        if (isset($roleEnable) && isset($rolesId)) {
            $users = User::roleFilter($users, $rolesId);
        }

        $majorEnable = $request->get('majorEnable');
        $majorsId    = $request->get('majors');
        if (isset($majorEnable) && isset($majorsId)) {
            $users = User::majorFilter($users, $majorsId);
        }

        $couponEnable = $request->get('couponEnable');
        $couponsId    = $request->get('coupons');
        if (isset($couponEnable) && isset($couponsId)) {
            if (in_array(0, $couponsId)) {
                $users = $users->whereHas('orders', function ($q) use ($couponsId) {
                    $q->whereDoesntHave('coupon')
                        ->whereNotIn('orderstatus_id',
                            [
                                config('constants.ORDER_STATUS_OPEN'), config('constants.ORDER_STATUS_CANCELED'),
                                config('constants.ORDER_STATUS_OPEN_BY_ADMIN'),
                            ]);
                });
            } else {
                $users = $users->whereHas('orders', function ($q) use ($couponsId) {
                    $q->whereIn('coupon_id', $couponsId)
                        ->whereNotIn('orderstatus_id',
                            [
                                config('constants.ORDER_STATUS_OPEN'), config('constants.ORDER_STATUS_CANCELED'),
                                config('constants.ORDER_STATUS_OPEN_BY_ADMIN'),
                            ]);
                });
            }
        }

        //filter by product
        $seenProductEnable = $request->get('productEnable');
        $productsId        = $request->get('products');
        if (isset($seenProductEnable) && isset($productsId)) {
            $productUrls = [];
            $baseUrl     = url('/');
            foreach ($productsId as $productId) {
                array_push($productUrls, str_replace($baseUrl, '', action('Web\ProductController@show', $productId)));
            }
            $users = $users->whereHas('seensitepages', function ($q) use ($productUrls) {
                $q->whereIn('url', $productUrls);
            });
        }

        $orderProductEnable = $request->get('orderProductEnable');
        $productsId         = $request->get('orderProducts');
        if (isset($orderProductEnable) && isset($productsId)) {
            if (in_array(-1, $productsId)) {
                $users = $users->whereDoesntHave('orders', function ($q) {
                    $q->whereNotIn('orderstatus_id', [
                        config('constants.ORDER_STATUS_OPEN'),
                        config('constants.ORDER_STATUS_CANCELED'),
                        config('constants.ORDER_STATUS_OPEN_BY_ADMIN'),
                        config('constants.ORDER_STATUS_OPEN_DONATE'),
                        config('constants.ORDER_STATUS_PENDING'),
                    ]);
                });
            } else if (in_array(0, $productsId)) {
                $users = $users->whereHas('orders', function ($query) {
                    $query->whereNotIn('orderstatus_id', [
                        config('constants.ORDER_STATUS_OPEN'),
                        config('constants.ORDER_STATUS_CANCELED'),
                        config('constants.ORDER_STATUS_OPEN_BY_ADMIN'),
                        config('constants.ORDER_STATUS_OPEN_DONATE'),
                        config('constants.ORDER_STATUS_PENDING'),
                    ]);
                });
            } else if (isset($productsId)) {
                $products = Product::whereIn('id', $productsId)
                    ->get();
                foreach ($products as $product) {
                    if ($product->producttype_id == config('constants.PRODUCT_TYPE_CONFIGURABLE')) {
                        if ($product->hasChildren()) {
                            $productsId = array_merge($productsId,
                                Product::whereHas('parents', function ($q) use ($productsId) {
                                    $q->whereIn('parent_id', $productsId);
                                })
                                    ->pluck('id')
                                    ->toArray());
                        }
                    }
                }

                if ($request->has('checkoutStatusEnable')) {
                    $checkoutStatuses = $request->get('checkoutStatuses');
                    if (in_array(0, $checkoutStatuses)) {
                        $orders = Order::whereHas('orderproducts', function ($q) use ($productsId) {
                            $q->whereIn('product_id', $productsId)
                                ->whereNull('checkoutstatus_id');
                        })
                            ->whereNotIn('orderstatus_id', [config('constants.ORDER_STATUS_OPEN')]);
                    } else {
                        $orders = Order::whereHas('orderproducts', function ($q) use ($productsId, $checkoutStatuses) {
                            $q->whereIn('product_id', $productsId)
                                ->whereIn('checkoutstatus_id', $checkoutStatuses);
                        })
                            ->whereNotIn('orderstatus_id', [config('constants.ORDER_STATUS_OPEN')]);
                    }
                } else {
                    $orders = Order::whereHas('orderproducts', function ($q) use ($productsId) {
                        $q->whereIn('product_id', $productsId);
                    })
                        ->whereNotIn('orderstatus_id', [config('constants.ORDER_STATUS_OPEN')]);
                }

                $createdSinceDate  = $request->get('completedSinceDate');
                $createdTillDate   = $request->get('completedTillDate');
                $createdTimeEnable = $request->get('completedTimeEnable');
                if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
                    $orders = $this->timeFilterQuery($orders, $createdSinceDate, $createdTillDate, 'created_at');
                }
                $orders = $orders->get();
                $users  = $users->whereIn('id', $orders->pluck('user_id')
                    ->toArray());
            }
        } else if ($request->has('checkoutStatusEnable')) {
            $checkoutStatuses = $request->get('checkoutStatuses');
            if (in_array(0, $checkoutStatuses)) {
                $orders = Order::whereHas('orderproducts', function ($q) use ($productsId) {
                    $q->whereNull('checkoutstatus_id');
                })
                    ->whereNotIn('orderstatus_id', [config('constants.ORDER_STATUS_OPEN')]);
            } else {
                $orders = Order::whereHas('orderproducts', function ($q) use ($productsId, $checkoutStatuses) {
                    $q->whereIn('checkoutstatus_id', $checkoutStatuses);
                })
                    ->whereNotIn('orderstatus_id', [config('constants.ORDER_STATUS_OPEN')]);
            }
            $orders = $orders->get();
            $users  = $users->whereIn('id', $orders->pluck('user_id')
                ->toArray());
        }

        $paymentStatusesId = $request->get('paymentStatuses');
        if (isset($paymentStatusesId)) {
            //Muhammad Shahrokhi : kar nemikone!
//            $users = $users->whereHas('orders' , function ($q) use ($paymentStatusesId) {
//                $q->whereIn('paymentstatus_id', $paymentStatusesId)->whereNotIn('orderstatus_id', [1]);
//            }

            if (!isset($orders)) {
                $orders = Order::all();
            } else {
                $orders = OrderRepo::paymentStatusFilter($orders, $paymentStatusesId);
            }
            $users = $users->whereIn('id', $orders->pluck('user_id')
                ->toArray());
        }

        $orderStatusesId = $request->get('orderStatuses');
        if (isset($orderStatusesId)) {
            //Muhammad Shahrokhi : kar nemikone!
//            $users = $users->whereHas('orders' , function ($q) use ($orderStatusesId) {
//                $q->whereIn('orderstatus_id', $orderStatusesId)->whereNotIn('orderstatus_id', [1]);
//            });
            if (!isset($orders)) {
                $orders = Order::all();
            } else {
                $orders = OrderRepo::orderStatusFilter($orders, $orderStatusesId);
            }
            $users = $users->whereIn('id', $orders->pluck('user_id')
                ->toArray());
        }
        //filter by gender ,lockProfile , mobileVerification
        $genderId = $request->get('gender_id');
        if (isset($genderId) && strlen($genderId) > 0) {
            if ($genderId == 0) {
                $users = $users->whereDoesntHave('gender');
            } else {
                $users = $users->where('gender_id', $genderId);
            }
        }

        $userstatusId = $request->get('userstatus_id');
        if (isset($userstatusId) && strlen($userstatusId) > 0 && $userstatusId != 0) {
            $users = $users->where('userstatus_id', $userstatusId);
        }

        $lockProfileStatus = $request->get('lockProfileStatus');
        if (isset($lockProfileStatus) && strlen($lockProfileStatus) > 0) {
            $users = $users->where('lockProfile', $lockProfileStatus);
        }

        $mobileNumberVerification = $request->get('mobileNumberVerification');
        if (isset($mobileNumberVerification) && strlen($mobileNumberVerification) > 0) {
            $users = $users->where('mobileNumberVerification', $mobileNumberVerification);
        }

        //filter by postalCode, province , city, address, school , email
        $withoutPostalCode = $request->get('withoutPostalCode');
        if (isset($withoutPostalCode)) {
            $users = $users->where(function ($q) {
                $q->whereNull('postalCode')
                    ->orWhere('postalCode', '');
            });
        } else {
            $postalCode = $request->get('postalCode');
            if (isset($postalCode) && strlen($postalCode) > 0) {
                $users = $users->where('postalCode', 'like', '%' . $postalCode . '%');
            }
        }

        $withoutProvince = $request->get('withoutProvince');
        if (isset($withoutProvince)) {
            $users = $users->where(function ($q) {
                $q->whereNull('province')
                    ->orWhere('province', '');
            });
        } else {
            $province = $request->get('province');
            if (isset($province) && strlen($province) > 0) {
                $users = $users->where('province', 'like', '%' . $province . '%');
            }
        }

        $withoutCity = $request->get('withoutCity');
        if (isset($withoutCity)) {
            $users = $users->where(function ($q) {
                $q->whereNull('city')
                    ->orWhere('city', '');
            });
        } else {
            $city = $request->get('city');
            if (isset($city) && strlen($city) > 0) {
                $users = $users->where('city', 'like', '%' . $city . '%');
            }
        }

//        $withoutAddress = $request->get('withoutAddress');
//        if(isset($withoutAddress)) {
//            $users = $users->where(function ($q){
//                $q->whereNull('address')->orWhere('address' , '');
//            });
//        }
//        else{
//            $address = $request->get('address');
//            if (isset($address) && strlen($address) > 0)
//                $users = $users->where('address', 'like', '%' . $address . '%');
//        }

        $addressSpecialFilter = $request->get('addressSpecialFilter');
        if (isset($addressSpecialFilter)) {
            switch ($addressSpecialFilter) {
                case '0':
                    $address = $request->get('address');
                    if (isset($address) && strlen($address) > 0) {
                        $users = $users->where('address', 'like', '%' . $address . '%');
                    }
                    break;
                case '1':
                    $users = $users->where(function ($q) {
                        $q->whereNull('address')
                            ->orWhere('address', '');
                    });
                    break;
                case  '2':
                    $users = $users->where(function ($q) {
                        $q->whereNotNull('address')
                            ->Where('address', '<>', '');
                    });
                    break;
                default:
                    break;
            }
        } else {
            $address = $request->get('address');
            if (isset($address) && strlen($address) > 0) {
                $users = $users->where('address', 'like', '%' . $address . '%');
            }
        }

        $withoutSchool = $request->get('withoutSchool');
        if (isset($withoutSchool)) {
            $users = $users->where(function ($q) {
                $q->whereNull('school')
                    ->orWhere('school', '');
            });
        } else {
            $school = $request->get('school');
            if (isset($school) && strlen($school) > 0) {
                $users = $users->where('school', 'like', '%' . $school . '%');
            }
        }

        $withoutEmail = $request->get('withoutEmail');
        if (isset($withoutEmail)) {
            $users = $users->where(function ($q) {
                $q->whereNull('email')
                    ->orWhere('email', '');
            });
        } else {
            $email = $request->get('email');
            if (isset($email) && strlen($email) > 0) {
                $users = $users->where('email', 'like', '%' . $email . '%');
            }
        }

        $previousPath = url()->previous();
        if (strcmp($previousPath, action('Web\AdminController@adminSMS')) == 0 || $request->has('smsAdmin')) {
            $index = 'user.index2';

            $items = $users->get();

            /**
             * end
             */

            $sortBy   = $request->get('sortBy');
            $sortType = $request->get('sortType');
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, 'desc') == 0) {
                    $items = $items->sortByDesc($sortBy);
                } else {
                    $items = $items->sortBy($sortBy);
                }
            }

            $uniqueUsers = $items->groupBy('nationalCode');
            $uniqueItems = collect();
            foreach ($uniqueUsers as $user) {
                if ($user->where('mobileNumberVerification', 1)->isNotEmpty())
                    $uniqueItems->push($user->where('mobileNumberVerification', 1)->first());
                else
                    $uniqueItems->push($user->first());
            }

            $uniqueItemsId        = $uniqueItems->pluck('id');
            $uniqueItemsIdCount   = $uniqueItemsId->count();
            $numberOfFatherPhones = Phone::whereIn('contact_id',
                Contact::whereIn('user_id', $uniqueItemsId)
                    ->where('relative_id', 1)
                    ->pluck('id'))
                ->where('phonetype_id', 1)
                ->count();
            $numberOfMotherPhones = Phone::whereIn('contact_id',
                Contact::whereIn('user_id', $uniqueItemsId)
                    ->where('relative_id', 2)
                    ->pluck('id'))
                ->where('phonetype_id', 1)
                ->count();
        } else if (strcmp($previousPath, action('Web\AdminController@admin')) == 0 || $request->has('userAdmin')) {
            $items = $users->paginate(10, ['*'], 'orders');

            $sortBy   = $request->get('sortBy');
            $sortType = $request->get('sortType');
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, 'desc') == 0) {
                    $items = $items->sortByDesc($sortBy);
                } else {
                    $items = $items->sortBy($sortBy);
                }
            }

            return $items;
        } else if (strcmp($previousPath, action('Web\AdminController@adminReport')) == 0 || $request->has('reportAdmin')) {
            $index = 'admin.partials.getReportIndex';

            $items = $users->get();

            $sortBy   = $request->get('sortBy');
            $sortType = $request->get('sortType');
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, 'desc') == 0) {
                    $items = $items->sortByDesc($sortBy);
                } else {
                    $items = $items->sortBy($sortBy);
                }
            }


            /** For selling books */
            if (isset($orders)) {
                foreach ($items as $user) {
                    if ($user->orders()
                        ->whereIn('id', $orders->pluck('id')
                            ->toArray())
                        ->whereHas('orderproducts', function ($q) {
                            $q->whereHas('attributevalues', function ($q2) {
                                $q2->where('id', 48);
                            });
                        })
                        ->get()
                        ->isNotEmpty()) {
                        array_push($hasPishtaz, $user->id);
                    }
                }
            }
            /** end */

            $minCost = $request->get('minCost');
            if (isset($minCost[0])) {
                foreach ($items as $key => $user) {
                    $userOrders     = $user->orders;
                    $transactionSum = 0;
                    foreach ($userOrders as $order) {
                        $successfullTransactions = $order->successfulTransactions()
                            ->where('created_at', '>', '2017-09-22')
                            ->get();
                        foreach ($successfullTransactions as $transaction) {
                            $transactionSum += $transaction->cost;
                        }
                    }
                    if ($transactionSum < (int)$minCost) {
                        $items->forget($key);
                    }
                }
            }

            if ($request->has('lotteries')) {
                $lotteryId = $request->get('lotteries');
                $lotteries = Lottery::where('id', $lotteryId)
                    ->get();
            }

            if ($request->has('reportType')) {
                $reportType = $request->get('reportType');
            }

            if ($request->has('seePaidCost')) {
                $seePaidCost = true;
            }
        } else {
            $items = $users->get();

            $sortBy   = $request->get('sortBy');
            $sortType = $request->get('sortType');
            if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
                if (strcmp($sortType, 'desc') == 0) {
                    $items = $items->sortByDesc($sortBy);
                } else {
                    $items = $items->sortBy($sortBy);
                }
            }
            return response([
                'data' => [
                    'users' => $items,
                ],
            ], Response::HTTP_OK);
        }

        $result = [
            'index'                => View::make($index,
                compact('items', 'products', 'paymentStatusesId', 'reportType', 'hasPishtaz', 'orders', 'seePaidCost',
                    'lotteries'))->render(),
            'products'             => $products,
            'lotteries'            => $lotteries,
            'allUsers'             => $uniqueItemsId ?? [],
            'allUsersNumber'       => $uniqueItemsIdCount ?? 0,
            'numberOfFatherPhones' => $numberOfFatherPhones ?? 0,
            'numberOfMotherPhones' => $numberOfMotherPhones ?? 0,
        ];

        return response(json_encode($result), Response::HTTP_OK)->header('Content-Type', 'application/json');
    }

    public function store(InsertUserRequest $request)
    {
        try {
            $result = $this->new($request->all(), $request->user());

            if (isset($result['error'])) {
                $resultMessage = 'خطا در ذخیره کاربر';
                $resultCode    = Response::HTTP_INTERNAL_SERVER_ERROR;
            } else {
                $resultMessage = 'درج کاربر با موفقیت انجام شد';
                $resultCode    = Response::HTTP_OK;
                $savedUser     = $result['user'];
            }

            if ($resultCode == Response::HTTP_OK) {
                $responseContent = [
                    'user' => $savedUser ?? $savedUser,
                ];
            } else {
                $responseContent = [
                    'error' => [
                        'message' => $resultMessage,
                    ],
                ];
            }

            return response($responseContent, Response::HTTP_OK);
        } catch (Exception    $e) {
            return response([
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param array     $data
     * @param User|null $authenticatedUser
     *
     * @return array
     */
    public function new(array $data, User $authenticatedUser): array
    {
        $softDeletedUsers = User::onlyTrashed()
            ->where('mobile', $data['mobile'])
            ->where('nationalCode', $data['nationalCode'])
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
                'error' => true,
                'data'  => [
                    'resultCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'text'       => $e->getMessage(),
                    'line'       => $e->getLine(),
                    'file'       => $e->getFile(),
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

        if (in_array('roles', $data) && isset($data['roles']) && $authenticatedUser->can(config('constants.INSET_USER_ROLE'))) {
            $this->syncRoles($data['roles'], $user);
        }

        $resultText = 'User save successfully';
        $resultCode = Response::HTTP_OK;
        return [
            'user' => $user,
        ];
    }

    /**
     * @param array $inputData
     * @param User  $user
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function fillUserFromRequest(array $inputData, User $user): void
    {
        $user->fillByPublic($inputData);

        $file = $this->getRequestFile($inputData, 'photo');
        if ($file !== false) {
            $storePicResult = $this->storePhotoOfUser($user, $file);
            if (isset($storePicResult)) {
                $user->photo = $storePicResult;
            }
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
        $userCompletion = $user->info['completion'];

        $genders = Gender::pluck('name', 'id')->prepend('نامشخص');
        $majors  = Major::pluck('name', 'id')->prepend('نامشخص');

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


        $sideBarMode = 'closed';
        $pageType    = 'profile';
        return view('user.profile.profile',
            compact('user', 'genders', 'majors', 'sideBarMode', 'userCompletion', 'pageType'
            /*'exchangeAmount', 'userPoints', 'userLottery', 'prizeCollection', 'lotteryRank', 'lottery', 'lotteryMessage', 'lotteryName' , */
            ));
    }

    /**
     * @param User $authenticaedUser
     * @param User $user
     *
     * @return bool
     */
    private function authenticatedUserCantSeeThisUser(User $authenticaedUser, User $user): bool
    {
        return ($user->id !== $authenticaedUser->id) && !($authenticaedUser->can(config('constants.SHOW_USER_ACCESS')));
    }

    public function submitKonkurResult(Request $request)
    {
        $user           = $request->user();
        $userCompletion = $user->info['completion'];

        $event            = Event::name('konkur98')->first();
        $userKonkurResult = $user->eventresults->where('event_id', $event->id)->first();

        $sideBarMode = 'closed';
        $pageType    = 'sabteRotbe';
        return view('user.profile.profile',
            compact('user', 'event', 'userKonkurResult', 'sideBarMode', 'userCompletion', 'pageType'));
    }

    /**
     * Display a listing user's orders.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userOrders(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        /** @var OrderCollections $orders */
        $orders = $user->getClosedOrders($request->get('orders', 1));

        $key          = 'user:transactions:' . $user->cacheKey();
        $transactions =
            Cache::tags(['user', 'transaction', 'user_' . $user->id, 'user_' . $user->id . '_transactions'])->remember($key, config('constants.CACHE_60'), function () use ($user) {
                return $user->getShowableTransactions()
                    ->get()
                    ->groupBy('order_id');
            });

        $key         = 'user:instalments:' . $user->cacheKey();
        $instalments =
            Cache::tags(['user', 'instalment', 'user_' . $user->id, 'user_' . $user->id . '_instalments'])->remember($key, config('constants.CACHE_60'), function () use ($user) {
                return $user->getInstalments()
                    ->get()
                    ->sortBy('deadline_at');
            });

        $gatewaysCollection = Transactiongateway::enable()
            ->get()
            ->sortBy('order');

        $gateways = [];
        foreach ($gatewaysCollection as $gateway) {
            $gateways[route('redirectToBank', ['paymentMethod' => $gateway->name, 'device' => 'web'])] =
                $gateway->displayName;
        }

        $orderIdString = $orders->pluck('id')->implode('-');
        $key           = 'orders:coupons:' . md5($orderIdString);
        $cacheTags     = ['order', 'coupon'];
        foreach ($orders as $order) {
            $cacheTags[] = 'order_' . $order->id;
            $cacheTags[] = 'order_' . $order->id . '_coupon';
        }
        $orderCoupons =
            Cache::tags($cacheTags)->remember($key, config('constants.CACHE_60'), function () use ($orders) {
                return $orders->getCoupons();
            });

        $credit = $user->getTotalWalletBalance();

        return view('user.ordersList',
            compact('orders', 'gateways', 'transactions', 'instalments', 'orderCoupons', 'credit'));
    }

    /**
     * Showing files to user which he has got for his orders
     *
     * @param Request $request
     *
     * @return Factory|RedirectResponse|\Illuminate\View\View
     */
    public function userProductFiles(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('web.user.dashboard', [$request->user()]);
        }

        return view('user.dashboard');
    }

    /**
     * Display the list of uploaded files by user
     *
     * @param Request $request
     *
     * @return Factory|\Illuminate\View\View
     */
    public function userQuestions(Request $request)
    {
        abort(Response::HTTP_FORBIDDEN);
        $questions = $request->user()->useruploads->where('isEnable', '1');
        $counter   = 1;

        return view('user.consultingQuestions', compact('questions', 'counter'));
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

        return view('user.edit', compact('user', 'majors', 'userStatuses', 'roles', 'userRoles', 'genders'));
    }

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
     * @return Response
     */
    public function informationPublicUrl(Request $request)
    {
        return redirect(action('Web\UserController@information', $request->user()), 301);
    }

    /**
     * Show the form for completing information of the specified resource.(Created for orduatalaee 97)
     *
     * @param User $user
     *
     * @return Factory|\Illuminate\View\View
     */
    public function information(User $user)
    {
        $validOrders = $user->orders()
            ->whereHas('orderproducts', function ($q) {
                /** @var QueryBuilder $q */
                $q->whereIn('product_id', config('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT'))
                    ->orwhereIn('product_id',
                        config('constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT'))
                    ->orwhereIn('product_id', [
                        199,
                        202,
                    ]);
            })
            ->whereIn('orderstatus_id', [config('constants.ORDER_STATUS_CLOSED')]);

        if ($validOrders->get()
            ->isEmpty()) {
            return redirect(action('Web\ProductLandingController@landing2'));
        }
        $unPaidOrders = $validOrders->get();
        $paidOrder    = $validOrders->whereIn('paymentstatus_id', [
            config('constants.PAYMENT_STATUS_PAID'),
            config('constants.PAYMENT_STATUS_INDEBTED'),
        ])
            ->get();

        $order = $unPaidOrders->first();

        if (is_null($order)) {
            $order = $paidOrder->first();
        }

        if (!isset($order)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $orderproduct = $order->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->get()
            ->first();
        /** @var Product $product */
        $product                 = $orderproduct->product;
        $userHasMedicalQuestions = false;
        if (in_array($product->id, config('constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT'))) {
            $userHasMedicalQuestions = true;
        }
        $userProduct = $product->name;
        $grandParent = $product->grandParent;
        if (isset($grandParent)) {
            $userProduct = $grandParent->name;
        }

        $simpleContact   = Contacttype::where('name', 'simple')
            ->get()
            ->first();
        $mobilePhoneType = Phonetype::where('name', 'mobile')
            ->get()
            ->first();
        $parents         = Relative::whereIn('name', [
            'father',
            'mother',
        ])
            ->get();
        $parentsNumber   = collect();
        foreach ($parents as $parent) {
            /** @var Collection|Contact $parentContacts */
            $parentContacts = $user->contacts->where('relative_id', $parent->id)
                ->where('contacttype_id', $simpleContact->id);
            if ($parentContacts->isEmpty()) {
                continue;
            }

            $parentContact = $parentContacts->first();
            $parentMobiles = $parentContact->phones->where('phonetype_id', $mobilePhoneType->id)
                ->sortBy('priority');
            if ($parentMobiles->isEmpty()) {
                continue;
            }

            $parentMobile = $parentMobiles->first()->phoneNumber;
            $parentsNumber->put($parent->name, $parentMobile);
        }
        $majors    = Major::pluck('name', 'id')
            ->toArray();
        $majors[0] = 'نامشخص';
        $majors    = Arr::sortRecursive($majors);
        /////////////////////////////////////////
        $genders    = Gender::pluck('name', 'id')
            ->toArray();
        $genders[0] = 'نامشخص';
        $genders    = Arr::sortRecursive($genders);
        ///////////////////////
        $bloodTypes    = Bloodtype::pluck('name', 'id')
            ->toArray();
        $bloodTypes[0] = 'نامشخص';
        $bloodTypes    = Arr::sortRecursive($bloodTypes);
        //////////////////////////
        $grades     = Grade::pluck('displayName', 'id')
            ->toArray();
        $grades[0]  = 'نامشخص';
        $grades     = Arr::sortRecursive($grades);
        $orderFiles = $order->files;

        //////////Lock fields//////////
        $lockedFields = [];
        if ($user->lockProfile) {
            $lockedFields = $user->returnLockProfileItems();
        }
        if ($userHasMedicalQuestions) {
            $completionFields      = $user->returnCompletionItems();
            $completionFieldsCount = count($completionFields);
            $completionPercentage  = (int)$user->completion('completeInfo');
        } else {
            $completionFields      = array_diff($user->returnCompletionItems(), $user->returnMedicalItems());
            $completionFieldsCount = count($completionFields);
            $completionPercentage  = (int)$user->completion('custom', $completionFields);
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

        if (isset($parentsNumber['father'])) {
            $completedFieldsCount++;
        }
        $completionFieldsCount++;

        if (isset($parentsNumber['mother'])) {
            $completedFieldsCount++;
        }
        $completionFieldsCount++;

        $completionPercentage = (int)(($completedFieldsCount / $completionFieldsCount) * 100);

        if ($completionPercentage == 100 && $user->completion('lockProfile') == 100) {
            $user->lockHisProfile();
            $user->updateWithoutTimestamp();
        }

        return view('user.completeInfo',
            compact('user', 'parentsNumber', 'majors', 'genders', 'bloodTypes', 'grades', 'userProduct', 'order',
                'orderFiles', 'userHasMedicalQuestions',
                'lockedFields', 'completionPercentage', 'customerExtraInfo'));
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Showing the form to the user for adding extra information after registeration
     *
     * @param Request $request
     *
     * @return Response
     */
    public function completeRegister(Request $request)
    {
        if ($request->has('redirectTo')) {
            $targetUrl = $request->get('redirectTo');
        } else {
            $targetUrl = action('Web\IndexPageController');
        }

        if ($request->user()
                ->completion('afterLoginForm') == 100) {
            return redirect($targetUrl);
        }

        $previousPath = url()->previous();
        if (strcmp($previousPath, route('login')) == 0) {
            $formByPass = false;
            $note       = 'برای ورود به سایت لطفا اطلاعات زیر را تکمیل نمایید';
        } else {
            $formByPass = true;
            $note       = 'برای استفاده از این خدمت سایت لطفا اطلاعات زیر را تکمیل نمایید';
        }

        $formFields = Afterloginformcontrol::getFormFields();
        $tables     = [];
        foreach ($formFields as $formField) {
            if (!strpos($formField->name, '_id')) {
                continue;
            }
            $tableName                = $formField->name;
            $tableName                = str_replace('_id', 's', $tableName);
            $tables[$formField->name] = DB::table($tableName)
                ->pluck('name', 'id');
        }

        return view('user.completeRegister', compact('formFields', 'note', 'formByPass', 'tables'));
    }

    /**
     * Store the complentary information of specified resource in storage.
     *
     * @param User              $user
     *
     * @param Request           $request
     * @param UserController    $userController
     * @param PhoneController   $phoneController
     * @param ContactController $contactController
     * @param OrderController   $orderController
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

        $request->offsetSet('phone', $this->convertToEnglish(preg_replace('/\s+/', '', $request->get('phone'))));
        $request->offsetSet('postalCode',
            $this->convertToEnglish(preg_replace('/\s+/', '', $request->get('postalCode'))));
        $parentMobiles = [
            'father' => $this->convertToEnglish(preg_replace('/\s+/', '', $request->get('parentMobiles')['father'])),
            'mother' => $this->convertToEnglish(preg_replace('/\s+/', '', $request->get('parentMobiles')['mother'])),
        ];
        $request->offsetSet('parentMobiles', $parentMobiles);

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
            abort(Response::HTTP_FORBIDDEN);
        }
        if ($request->has('order')) {
            $orderId = $request->get('order');
            $order   = Order::FindOrFail($orderId);
            if ($order->user_id != $request->user()->id) {
                abort(Response::HTTP_FORBIDDEN);
            }
        } else {
            return response([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * User's basic info
         **/
        $editUserRequest = new EditUserRequest();
        if ($request->hasFile('photo')) {
            $editUserRequest->offsetSet('photo', $request->file('photo'));
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
        $simpleContact   = Contacttype::where('name', 'simple')
            ->get()
            ->first();
        $mobilePhoneType = Phonetype::where('name', 'mobile')
            ->get()
            ->first();
        $parentsNumber   = $request->get('parentMobiles');

        foreach ($parentsNumber as $relative => $mobile) {
            if (strlen(preg_replace('/\s+/', '', $mobile)) == 0) {
                continue;
            }
            $parent         = Relative::where('name', $relative)
                ->get()
                ->first();
            $parentContacts = $user->contacts->where('relative_id', $parent->id)
                ->where('contacttype_id', $simpleContact->id);
            if ($parentContacts->isEmpty()) {
                $storeContactRequest = new InsertContactRequest();
                $storeContactRequest->offsetSet('name', $relative);
                $storeContactRequest->offsetSet('user_id', $user->id);
                $storeContactRequest->offsetSet('contacttype_id', $simpleContact->id);
                $storeContactRequest->offsetSet('relative_id', $parent->id);
                $storeContactRequest->offsetSet('isServiceRequest', true);
                $response = $contactController->store($storeContactRequest);
                if ($response->getStatusCode() == Response::HTTP_OK) {
                    $responseContent = json_decode($response->getContent('contact'));
                    $parentContact   = $responseContent->contact;
                }
            } else {
                $parentContact = $parentContacts->first();
            }
            if (!isset($parentContact)) {
                continue;
            }
            $parentContact = Contact::where('id', $parentContact->id)
                ->get()
                ->first();
            $parentMobiles = $parentContact->phones->where('phonetype_id', $mobilePhoneType->id)
                ->sortBy('priority');
            if ($parentMobiles->isEmpty()) {
                $storePhoneRequest = new InsertPhoneRequest();
                $storePhoneRequest->offsetSet('phoneNumber', $mobile);
                $storePhoneRequest->offsetSet('contact_id', $parentContact->id);
                $storePhoneRequest->offsetSet('phonetype_id', $mobilePhoneType->id);
                $response = $phoneController->store($storePhoneRequest);
                $response->getStatusCode();
            } else {
                $parentMobile              = $parentMobiles->first();
                $parentMobile->phoneNumber = $mobile;
                $parentMobile->update();
            }
        }

        $updateOrderRequest = new EditOrderRequest();
        if ($request->hasFile('file')) {
            $updateOrderRequest->offsetSet('file', $request->file('file'));
        }
        /**
         * customerExtraInfo
         */
        $jsonConcats              = '';
        $extraInfoQuestions       = Arr::sortRecursive($request->get('customerExtraInfoQuestion'));
        $customerExtraInfoAnswers = $request->get('customerExtraInfoAnswer');
        foreach ($extraInfoQuestions as $key => $question) {
            $obj        = new stdClass();
            $obj->title = $question;
            $obj->info  = null;
            if (strlen(preg_replace('/\s+/', '', $customerExtraInfoAnswers[$key])) > 0) {
                $obj->info = $customerExtraInfoAnswers[$key];
            }
            if (strlen($jsonConcats) > 0) {
                $jsonConcats = $jsonConcats . ',' . json_encode($obj, JSON_UNESCAPED_UNICODE);
            } else {
                $jsonConcats = json_encode($obj, JSON_UNESCAPED_UNICODE);
            }
        }
        $customerExtraInfo = '[' . $jsonConcats . ']';
        $updateOrderRequest->offsetSet('customerExtraInfo', $customerExtraInfo);
        $orderController->update($updateOrderRequest, $order);

        session()->put('success', 'اطلاعات با موفقیت ذخیره شد');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * Note: Requests to this method must pass \App\Http\Middleware\trimUserRequest middle ware
     *
     * @param EditUserRequest $request
     * @param User            $user
     *
     * @return array|Response
     */
    public function update(EditUserRequest $request, User $user = null)
    {
        $authenticatedUser = $request->user();
        if ($user === null) {
            $user = $authenticatedUser;
        }

        if ($user->isUserProfileLocked() && !$authenticatedUser->can(config('constants.EDIT_USER_ACCESS')))
            return response(['message' => 'User profile is locked'], Response::HTTP_LOCKED);
        try {
            if ($request->has('moderator') && $authenticatedUser->can(config('constants.EDIT_USER_ACCESS'))) {
                $this->fillUserFromModeratorRequest($request->all(), $user);
                if ($authenticatedUser->can(config('constants.INSET_USER_ROLE'))) {
                    $this->syncRoles($request->get('roles', []), $user);
                }
            } else {
                $this->fillUserFromRequest($request->all(), $user);
            }
        } catch (FileNotFoundException $e) {
            return response([
                'error' => [
                    'text' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //ToDo : place in UserObserver
        if ($user->checkUserProfileForLocking()) {
            $user->lockHisProfile();
        }

        if ($user->update()) {
            $message = 'اطلاعات با موفقیت اصلاح شد';
            $status  = Response::HTTP_OK;
        } else {
            $message = 'Database error on updating user';
            $status  = Response::HTTP_SERVICE_UNAVAILABLE;
        }

        if ($request->expectsJson()) {
            if ($status == Response::HTTP_OK) {
                $response = [
                    'user'    => $user,
                    'message' => $message,
                ];
            } else {
                $response = [
                    'error' => [
                        'code'    => $status,
                        'message' => $message,
                    ],
                ];
            }

            return response($response, Response::HTTP_OK);
        } else {
            session()->flash('success', $message);
            return redirect()->back();
        }
    }

    /**
     * @param array $inputData
     * @param User  $user
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function fillUserFromModeratorRequest(array $inputData, User $user): void
    {
        // Checks both if $inputData has password index and it is not null
        $hasPassword = isset($inputData['password']);

        if ($hasPassword) {
            $user->password = bcrypt($inputData['password']);
        }

        Arr::pull($inputData, 'password');
        $user->fill($inputData);
        $hasMobileVerifiedAt = isset($inputData['mobile_verified_at']);

        //ToDo : When a moderator is updating his profile, this won't work
        if ($hasMobileVerifiedAt) {
            $user->mobile_verified_at = ($inputData['mobile_verified_at'] == '1') ? Carbon::now()
                ->setTimezone('Asia/Tehran') : null;
        } else {
            $user->mobile_verified_at = null;
        }

        $hasLockProfile = isset($inputData['lockProfile']);
        if ($hasLockProfile) {
            $user->lockProfile = ($inputData['lockProfile'] == '1') ? 1 : 0;
        } else {
            $user->lockProfile = 0;
        }

        $file = $this->getRequestFile($inputData, 'photo');
        if ($file !== false) {
            $storePicResult = $this->storePhotoOfUser($user, $file);
            if (isset($storePicResult)) {
                $user->photo = $storePicResult;
            }
        }
    }

    public function partialUpdate(Request $request)
    {
        $user = $request->user();
        $this->fillUserFromRequest($request->all(), $user);

        $updateResult = false;
        if ($user->update()) {
            $updateResult = true;
        }

        if (!$updateResult) {
            return response()->json([
                'error' => [
                    'message' => 'خطا در اصلاح اطلاعات کاربر',
                ],
            ]);
        }

//        $wallet = $user->wallets->where('wallettype_id' , config('constants.WALLET_TYPE_GIFT'))->first();
//        if(isset($wallet)){
//            /** @var TransactionCollection $depositTransactions */
//            $depositTransactions = $wallet->transactions->where('cost' , '<' , 0)->where('created_at' , '>=' , '2019-11-03 00:00:00');
//            if($depositTransactions->isNotEmpty()){
//                return response()->json([
//                    'error' =>[
//                        'message' => 'شما قبلا هدیه کیف پول را دریافت کرده اید',
//                    ]
//                ]);
//            }
//        }
//
//        $userCompletion = $user->completion('custom' , LandingPageController::ROOZE_DANESH_AMOOZ_USER_NECESSARY_INFO);
//        if($userCompletion == 100){
//            $depositResult =  $user->deposit( LandingPageController::ROOZE_DANESH_AMOOZ_GIFT_CREDIT  , config('constants.WALLET_TYPE_GIFT'));
//            if($depositResult['result']){
//                return response()->json([
//                    'message'=>'14 هزار تومان اعتبار هدیه به کیف پول شما افزوده شد'
//                ]);
//            }else{
//                return response()->json([
//                    'error' =>[
//                        'message' => 'خطایی در اعدای هدیه کیف پول رخ داد. لطفا دوباره اقدام کنید',
//                    ]
//                ]);
//            }
//        }

        return response()->json([
            'error' => [
                'message' => 'اطلاعات شما تکمیل نیست',
            ],
        ]);
    }
}
