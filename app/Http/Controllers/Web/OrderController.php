<?php

namespace App\Http\Controllers\Web;

use App\Classes\CouponSubmitter;
use App\Classes\OrderProduct\RefinementProduct\RefinementFactory;
use App\Classes\Pricing\Alaa\AlaaInvoiceGenerator;
use App\Collection\OrderproductCollection;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutReviewRequest;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests\IndexOrderRequest;
use App\Http\Requests\InsertTransactionRequest;
use App\Http\Requests\SubmitCouponRequest;
use App\Notifications\OrderStatusChanged;
use App\Notifications\PostCodeNotification;
use App\Order;
use App\Ordermanagercomment;
use App\Orderpostinginfo;
use App\Orderproduct;
use App\Orderstatus;
use App\Paymentmethod;
use App\Paymentstatus;
use App\Product;
use App\Productvoucher;
use App\Repositories\TransactionGatewayRepo;
use App\Traits\APIRequestCommon;
use App\Traits\DateTrait;
use App\Traits\Helper;
use App\Traits\MetaCommon;
use App\Traits\ProductCommon;
use App\Traits\RequestCommon;
use App\Traits\User\ResponseFormatter;
use App\Transaction;
use App\Transactiongateway;
use App\Transactionstatus;
use App\User;
use App\Websitesetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * @method getUserOpenOrderInfo($user)
 */
class OrderController extends Controller
{
    protected $setting;

    use APIRequestCommon;
    use Helper;
    use ProductCommon;
    use RequestCommon;
    use ResponseFormatter;
    use MetaCommon;
    use DateTrait;

    public function __construct(Websitesetting $setting)
    {

        $this->middleware('permission:' . config('constants.LIST_ORDER_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_ORDER_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_ORDER_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_ORDER_ACCESS'), ['only' => 'edit', 'show']);
        $this->middleware([
//            'completeInfo',
            'OrderCheckoutReview',
        ], ['only' => ['checkoutReview',],]);
//        $this->middleware([
//            'completeInfo',
//            'OrderCheckoutPayment',
//        ], ['only' => ['checkoutPayment'],]);
        $this->middleware('SubmitOrderCoupon', ['only' => ['submitCoupon'],]);
        $this->middleware('RemoveOrderCoupon', ['only' => ['removeCoupon'],]);
        $this->setting = $setting->setting;
    }

    public function index(IndexOrderRequest $request)
    {
        $user = Auth::user();
        if ($user->can(config('constants.SHOW_OPENBYADMIN_ORDER'))) {
            $orders = Order::where('orderstatus_id', '<>', config('constants.ORDER_STATUS_OPEN'));
        } else {
            $orders = Order::where('orderstatus_id', '<>', config('constants.ORDER_STATUS_OPEN'))
                ->where('orderstatus_id', '<>',
                    config('constants.ORDER_STATUS_OPEN_BY_ADMIN'));
        }

        $createdSinceDate  = $request->get('createdSinceDate');
        $createdTillDate   = $request->get('createdTillDate');
        $createdTimeEnable = $request->get('createdTimeEnable');
        if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
            $orders = $this->timeFilterQuery($orders, $createdSinceDate, $createdTillDate, 'created_at');
        }

        $updatedSinceDate  = $request->get('updatedSinceDate');
        $updatedTillDate   = $request->get('updatedTillDate');
        $updatedTimeEnable = $request->get('updatedTimeEnable');
        if (strlen($updatedSinceDate) > 0 && strlen($updatedTillDate) > 0 && isset($updatedTimeEnable)) {
            $orders = $this->timeFilterQuery($orders, $updatedSinceDate, $updatedTillDate, 'updated_at');
        }

        $completedSinceDate  = $request->get('completedSinceDate');
        $completedTillDate   = $request->get('completedTillDate');
        $completedTimeEnable = $request->get('completedTimeEnable');
        if (strlen($completedSinceDate) > 0 && strlen($completedTillDate) > 0 && isset($completedTimeEnable)) {
            $orders = $this->timeFilterQuery($orders, $completedSinceDate, $completedTillDate, 'completed_at',
                $sinceTime = '00:00:00', $tillTime = '23:59:59',
                false);
        }

        $firstName = trim($request->get('firstName'));
        if (isset($firstName) && strlen($firstName) > 0) {
            $orders = $orders->whereHas('user', function ($q) use ($firstName) {
                $q->where('firstName', 'like', '%' . $firstName . '%');
            });
        }

        $lastName = trim($request->get('lastName'));
        if (isset($lastName) && strlen($lastName) > 0) {
            $orders = $orders->whereHas('user', function ($q) use ($lastName) {
                $q->where('lastName', 'like', '%' . $lastName . '%');
            });
        }

        $nationalCode = trim($request->get('nationalCode'));
        if (isset($nationalCode) && strlen($nationalCode) > 0) {
            $orders = $orders->whereHas('user', function ($q) use ($nationalCode) {
                $q->where('nationalCode', 'like', '%' . $nationalCode . '%');
            });
        }

        $mobile = trim($request->get('mobile'));
        if (isset($mobile) && strlen($mobile) > 0) {
            $orders = $orders->whereHas('user', function ($q) use ($mobile) {
                $q->where('mobile', 'like', '%' . $mobile . '%');
            });
        }

        $orderStatusesId = $request->get('orderStatuses');
        //        if(isset($orderStatusesId) && !in_array(0, $orderStatusesId))
        if (isset($orderStatusesId)) {
            $orders = Order::orderStatusFilter($orders, $orderStatusesId);
        }

        $paymentStatusesId = $request->get('paymentStatuses');
        //        if(isset($paymentStatusesId) && !in_array(0, $paymentStatusesId))
        if (isset($paymentStatusesId)) {
            $orders = Order::paymentStatusFilter($orders, $paymentStatusesId);
        }

        $productsId = $request->get('products');
        if (isset($productsId) && !in_array(0, $productsId)) {
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

            $orders = $orders->whereHas('orderproducts', function ($q) use ($productsId) {
                $q->whereIn('product_id', $productsId);
            });
        }

        $extraAttributevaluesId = $request->get('extraAttributes');
        if (isset($extraAttributevaluesId)) {
            if (isset($productsId) && !in_array(0, $productsId)) {
                $orders = $orders->whereHas('orderproducts', function ($q) use ($extraAttributevaluesId, $productsId) {
                    $q->whereHas('attributevalues', function ($q) use ($extraAttributevaluesId) {
                        $q->whereIn('value_id', $extraAttributevaluesId);
                    })
                        ->whereIn('product_id', $productsId);
                });
            } else {
                $orders = $orders->whereHas('orderproducts', function ($q) use ($extraAttributevaluesId) {
                    $q->whereHas('attributevalues', function ($q) use ($extraAttributevaluesId) {
                        $q->whereIn('value_id', $extraAttributevaluesId);
                    });
                });
            }
        }

        $majorEnable = $request->get('majorEnable');
        $majorsId    = $request->get('majors');
        if (isset($majorEnable) && isset($majorsId)) {
            $orders = Order::UserMajorFilter($orders, $majorsId);
        }

        $couponEnable = $request->get('couponEnable');
        $couponsId    = $request->get('coupons');
        if (isset($couponEnable) && isset($couponsId)) {
            if (in_array(0, $couponsId)) {
                $orders = $orders->whereDoesntHave('coupon');
            } else {
                if (in_array(-1, $couponsId)) {
                    $orders = $orders->whereHas('coupon');
                } else {
                    $orders = $orders->whereIn('coupon_id', $couponsId);
                }
            }
        }

        $transactionStatusEnable = $request->get('transactionStatusEnable');
        $transactionStatusesId   = $request->get('transactionStatuses');
        if (isset($transactionStatusEnable) && isset($transactionStatusesId)) {
            $orders = $orders->whereHas('transactions', function ($q) use ($transactionStatusesId) {
                $q->whereIn('transactionstatus_id', $transactionStatusesId);
            });
        }

        $checkoutStatusEnable = $request->get('checkoutStatusEnable');
        $checkoutStatusesId   = $request->get('checkoutStatuses');
        if (isset($checkoutStatusEnable) && isset($checkoutStatusesId)) {
            if (isset($productsId) && !in_array(0, $productsId)) {
                $orders = $orders->whereHas('orderproducts', function ($q) use ($checkoutStatusesId, $productsId) {
                    $q->whereIn('product_id', $productsId)
                        ->where(function ($q2) use ($checkoutStatusesId) {
                            if (in_array('0', $checkoutStatusesId)) {
                                $q2->whereIn('checkoutstatus_id', $checkoutStatusesId)
                                    ->orWhereNull('checkoutstatus_id');
                            } else {
                                $q2->whereIn('checkoutstatus_id', $checkoutStatusesId);
                            }
                        });
                });
            } else {
                $orders = $orders->whereHas('orderproducts', function ($q) use ($checkoutStatusesId) {
                    if (in_array('0', $checkoutStatusesId)) {
                        $q->whereIn('checkoutstatus_id', $checkoutStatusesId)
                            ->orWhereNull('checkoutstatus_id');
                    } else {
                        $q->whereIn('checkoutstatus_id', $checkoutStatusesId);
                    }
                });
            }
        }

        $withoutPostalCode = $request->get('withoutPostalCode');
        if (isset($withoutPostalCode)) {
            $orders = $orders->whereHas('user', function ($q) {
                $q->where(function ($q) {
                    $q->whereNull('postalCode')
                        ->orWhere('postalCode', '');
                });
            });
        } else {
            $postalCode = $request->get('postalCode');
            if (isset($postalCode) && strlen($postalCode) > 0) {
                $orders = $orders->whereHas('user', function ($q) use ($postalCode) {
                    $q->where('postalCode', 'like', '%' . $postalCode . '%');
                });
            }
        }

        $withoutProvince = $request->get('withoutProvince');
        if (isset($withoutProvince)) {
            $orders = $orders->whereHas('user', function ($q) {
                $q->where(function ($q) {
                    $q->whereNull('province')
                        ->orWhere('province', '');
                });
            });
        } else {
            $province = $request->get('province');
            if (isset($province) && strlen($province) > 0) {
                $orders = $orders->whereHas('user', function ($q) use ($province) {
                    $q->where('province', 'like', '%' . $province . '%');
                });
            }
        }

        $withoutCity = $request->get('withoutCity');
        if (isset($withoutCity)) {
            $orders = $orders->whereHas('user', function ($q) {
                $q->where(function ($q) {
                    $q->whereNull('city')
                        ->orWhere('city', '');
                });
            });
        } else {
            $city = $request->get('city');
            if (isset($city) && strlen($city) > 0) {
                $orders = $orders->whereHas('user', function ($q) use ($city) {
                    $q->where('city', 'like', '%' . $city . '%');
                });
            }
        }

        $addressSpecialFilter = $request->get('addressSpecialFilter');
        if (isset($addressSpecialFilter)) {
            switch ($addressSpecialFilter) {
                case '0':
                    $address = $request->get('address');
                    if (isset($address) && strlen($address) > 0) {
                        $orders = $orders->whereHas('user', function ($q) use ($address) {
                            $q->where('address', 'like', '%' . $address . '%');
                        });
                    }
                    break;
                case '1':
                    $orders = $orders->whereHas('user', function ($q) {
                        $q->where(function ($q) {
                            $q->whereNull('address')
                                ->orWhere('address', '');
                        });
                    });
                    break;
                case  '2':
                    $orders = $orders->whereHas('user', function ($q) {
                        $q->where(function ($q) {
                            $q->whereNotNull('address')
                                ->Where('address', '<>', '');
                        });
                    });
                    break;
                default:
                    break;
            }
        } else {
            $address = $request->get('address');
            if (isset($address) && strlen($address) > 0) {
                $orders = $orders->whereHas('user', function ($q) use ($address) {
                    $q->where('address', 'like', '%' . $address . '%');
                });
            }
        }

        $withoutSchool = $request->get('withoutSchool');
        if (isset($withoutSchool)) {
            $orders = $orders->whereHas('user', function ($q) {
                $q->where(function ($q) {
                    $q->whereNull('school')
                        ->orWhere('school', '');
                });
            });
        } else {
            $school = $request->get('school');
            if (isset($school) && strlen($school) > 0) {
                $orders = $orders->whereHas('user', function ($q) use ($school) {
                    $q->where('school', 'like', '%' . $school . '%');
                });
            }
        }

        //customer description , manager comment
        $withoutCustomerDescription = $request->get('withoutOrderCustomerDescription');
        if (isset($withoutCustomerDescription)) {
            $orders = $orders->where(function ($q) {
                $q->whereNull('customerDescription')
                    ->orWhere('customerDescription', '');
            });
        } else {
            $customerDescription = $request->get('orderCustomerDescription');
            if (isset($customerDescription) && strlen($customerDescription) > 0) {
                $orders = $orders->where('customerDescription', 'like', '%' . $customerDescription . '%');
            }
        }

        $withoutManagerComments = $request->get('withoutOrderManagerComments');
        if (isset($withoutManagerComments)) {
            $orders = $orders->whereDoesntHave('ordermanagercomments')
                ->orWhereHas('ordermanagercomments', function ($q) {
                    $q->whereNull('comment')
                        ->orWhere('comment', '');
                });
        } else {
            $managerComments = $request->get('orderManagerComments');
            if (isset($managerComments) && strlen($managerComments) > 0) {
                $orders = $orders->whereHas('ordermanagercomments', function ($q) use ($managerComments) {
                    $q->where('comment', 'like', '%' . $managerComments . '%');
                });
            }
        }

        //        $orderCost = $request->get("cost");
        //        if(isset($orderCost) && strlen($orderCost) > 0){
        //            $compareBy = $request->get("filterByCost");
        //            if(isset($compareBy) && (strcmp("$compareBy" , "=") == 0
        //                || strcmp("$compareBy" , ">") == 0
        //                || strcmp("$compareBy" , "<") == 0))
        //            {
        //                $orders = $orders
        //                    ->whereNull("costwithoutcoupon")->where("cost" , $compareBy , $orderCost)
        //                    ->orwhereNull("cost")->where("costwithoutcoupon" , $compareBy , $orderCost)
        //                    ->orwhere(function ($q) use ($compareBy, $orderCost){
        //                        $q->whereNotNull("costwithoutcoupon")->whereNotNull("cost")->whereRaw("cost+costwithoutcoupon ".$compareBy." ".$orderCost);
        //                    });
        //            }
        //        }
        //
        //        $discountCost = $request->get("discountCost");
        //        if(isset($discountCost) && strlen($discountCost) > 0){
        //            $discountCompareBy = $request->get("filterByDiscount");
        //            if(isset($discountCompareBy) && (strcmp("$discountCompareBy" , "=") == 0
        //                || strcmp("$discountCompareBy" , ">") == 0
        //                || strcmp("$discountCompareBy" , "<") == 0))
        //            {
        //                $orders->where("discount" , $discountCompareBy , $discountCost);
        //            }
        //        }

        $sortBy   = $request->get('sortBy');
        $sortType = $request->get('sortType');
        if (strlen($sortBy) > 0 && strlen($sortType) > 0) {
            if (strcmp($sortBy, 'userLastName') == 0) {
                $orders = $orders->join('users', 'orders.user_id', '=', 'users.id')
                    ->orderBy('users.lastName', $sortType)
                    ->select('orders.*');
            } else {
                if (strcmp($sortBy, 'userFirstName') == 0) {
                    $orders = $orders->join('users', 'orders.user_id', '=', 'users.id')
                        ->orderBy('users.firstName', $sortType)
                        ->select('orders.*');
                } else {
                    $orders = $orders->orderBy($sortBy, $sortType);
                }
            }
        } else {
            $orders = $orders->orderBy('updated_at', 'desc');
        }

        $orders = $orders->paginate(10, ['*'], 'orders');
        return $orders;
    }

    public function create(Request $request)
    {
        $customer_id = $request->get('customer_id');
        $customer    = User::FindOrFail($customer_id);
        $openOrders  = $customer->orders->where('orderstatus_id', config('constants.ORDER_STATUS_OPEN_BY_ADMIN'));
        if ($openOrders->isEmpty()) {
            $request = new Request();
            $request->offsetSet('paymentstatus_id', config('constants.PAYMENT_STATUS_UNPAID'));
            $request->offsetSet('orderstatus_id', config('constants.ORDER_STATUS_OPEN_BY_ADMIN'));
            $request->offsetSet('user_id', $customer->id);
            $controller = new OrderController();
            $order      = $controller->store($request);
        } else {
            $order = $openOrders->first();
        }

        if ($order) {
            session()->put('customer_id', $customer_id);
            if (strlen($customer->firstName) > 0) {
                session()->put('customer_firstName', $customer->firstName);
            }
            if (strlen($customer->lastName) > 0) {
                session()->put('customer_lastName', $customer->lastName);
            }

            session()->put('adminOrder_id', $order->id);
            session()->save();
        } else {
            return redirect(action("Web\ErrorPageController@error500"));
        }

        return redirect(action("Web\ProductController@search"));
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->fill($request->all());
        if ($order->save()) {
            return $order;
        } else {
            return null;
        }
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function edit($order)
    {
        $orderstatuses                    = Orderstatus::pluck('displayName', 'id')
            ->toArray();
        $paymentstatuses                  = Paymentstatus::pluck('displayName', 'id')
            ->toArray();
        $transactionPaymentmethods        = Paymentmethod::pluck('displayName', 'id')->toArray();
        $offlineTransactionPaymentMethods = Paymentmethod::where('id', '<>', config('constants.PAYMENT_METHOD_ONLINE'))
            ->pluck('displayName', 'id')
            ->toArray();
        $transactionStatuses              = Transactionstatus::orderBy('order')
            ->pluck('displayName', 'id')
            ->toArray();
        $coupons                          = Coupon::pluck('name', 'id')->toArray();
        $coupons                          = Arr::add($coupons, 0, 'بدون کپن');
        $coupons                          = Arr::sortRecursive($coupons);

        $transactionGateways =
            TransactionGatewayRepo::getTransactionGateways(['enable' => 1])->get()->pluck('displayName', 'id');

        $products = $this->makeProductCollection();

        if (!isset($order->coupon->id)) {
            $order->coupon_id = 0;
        }

        $orderproducts             = $order->orderproducts()->get();
        $trashedOrderproducts      = $order->orderproducts()->onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $orderTransactions         =
            $order->successfulTransactions()->get()->merge($order->pendingTransactions()->get())->merge($order->unpaidTransactions()->get());
        $orderArchivedTransactions = $order->archivedSuccessfulTransactions()->get();
        $totalTransactions         = $order->transactions()->get();

        return view('order.edit',
            compact('order', 'orderstatuses', 'paymentstatuses', 'coupons', 'orderTransactions',
                'transactionPaymentmethods', 'transactionStatuses', 'products', 'orderArchivedTransactions',
                'offlineTransactionPaymentMethods', 'transactionGateways', 'totalTransactions', 'trashedOrderproducts', 'orderproducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \app\Http\Requests\EditOrderRequest $request
     * @param Order                               $order
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function update(EditOrderRequest $request, Order $order)
    {
        $user = $request->user();

        if (isset($order->coupon->id)) {
            $oldCoupon = $order->coupon;
        }

        $order->fill($request->all());

        if ($request->has('coupon_id')) {
            if (isset($oldCoupon)) {
                $oldCoupon->usageNumber = $oldCoupon->usageNumber - 1;
                $oldCoupon->update();//ToDo put if
            }
            if ($order->coupon_id == 0) {
                $order->coupon_id            = null;
                $order->couponDiscount       = 0;
                $order->couponDiscountAmount = 0;
            } else {
                /** Muhammad Shahrokhi
                 * Attention : I don't check coupon validation intentionally because it is admin
                 * update and I beleive it should be able to update submit any coupon for the order
                 * with out any limitations
                 */
                $coupon                = Coupon::all()
                    ->where('id', $order->coupon_id)
                    ->first();
                $order->couponDiscount = $coupon->discount;
                $coupon->usageNumber   = $coupon->usageNumber + 1;
                $coupon->update();

                if (!isset($oldCoupon)) {
                    if (!isset($order->cost) || $order->cost == 0) {
                        $order->cost              = $order->costwithoutcoupon;
                        $order->costwithoutcoupon = 0;
                    }
                }
            }
        }

        if ($request->has('managerDescription')) {
            if ($order->ordermanagercomments->isEmpty()) {
                $managerComment = new Ordermanagercomment();
                if ($request->has('managerDescription')) {
                    $managerComment->comment = $request->get('managerDescription');
                }
                $managerComment->order_id = $order->id;
                $managerComment->user_id  = $user->id;
                $managerComment->save();
            } else {
                $order->ordermanagercomments->first()->comment = $request->get('managerDescription');
                $order->ordermanagercomments->first()->user_id = $user->id;
                $order->ordermanagercomments->first()
                    ->update();
            }
        } else {
            if (!$order->ordermanagercomments->isEmpty()) {
                $order->ordermanagercomments->first()->comment = null;
                $order->ordermanagercomments->first()->user_id = $user->id;
                $order->ordermanagercomments->first()
                    ->update();
            }
        }

        if ($order->update()) {

            if ($request->has('orderstatusSMS')) {
                $order->user->notify(New OrderStatusChanged($order->orderstatus->displayName));
            }

            if ($request->has('postCode')) {
                $postCode = $request->get('postCode');
                if (strlen(preg_replace('/\s+/', '', $postCode)) > 0) {
                    $insertPostingInfo     = false;
                    $postingInfo           = new Orderpostinginfo();
                    $postingInfo->postCode = $request->get('postCode');
                    $postingInfo->order_id = $order->id;
                    $postingInfo->user_id  = $user->id;
                    if ($postingInfo->save()) {
                        $insertPostingInfo = true;
                    }

                    if ($insertPostingInfo && $request->has('postingSMS')) {
                        $postCode = $request->get('postCode');
                        $order->user->notify(New PostCodeNotification($postCode));
                    }
                }
            }

            $file = $this->getRequestFile($request->all(), 'file');
            if ($file !== false) {
                $extension = $file->getClientOriginalExtension();
                $fileName  =
                    basename($file->getClientOriginalName(), '.' . $extension) . '_' . date('YmdHis') . '.' . $extension;
                if (Storage::disk(config('constants.DISK10'))
                    ->put($fileName, File::get($file))) {
                    $orderFileRequest = new Request();
                    $orderFileRequest->offsetSet('order_id', $order->id);
                    $orderFileRequest->offsetSet('user_id', $user->id);
                    $orderFileRequest->offsetSet('file', $fileName);
                    $orderFileController = new OrderFileController();
                    $responseStatus      = $orderFileController->store($orderFileRequest);
                    if ($responseStatus->getStatusCode() != Response::HTTP_OK) {
                        session()->put('error', 'خطا در ذخیره اطلاعات فایل');
                    }
                } else {
                    session()->put('error', 'بارگذاری فایل سفارش با مشکل مواجه شد!');
                }
            }

            session()->put('success', 'اطلاعات سفارش با موفقیت اصلاح شد.');

            $asiatechProduct = config('constants.ASIATECH_FREE_ADSL');
            if ($order->hasTheseProducts([$asiatechProduct]) && $order->orderstatus_id == config('constants.ORDER_STATUS_CLOSED')) {
                $orderUser   = $order->user;
                $nowDateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                    ->timezone('Asia/Tehran');
                $userVoucher = $orderUser->productvouchers()
                    ->where('enable', 1)
                    ->where('expirationdatetime', '>', $nowDateTime)
                    ->where('product_id',
                        $asiatechProduct)
                    ->get();

                if ($userVoucher->isEmpty()) {
                    $unusedVoucher = Productvoucher::whereNull('user_id')
                        ->where('enable', 1)
                        ->where('expirationdatetime', '>',
                            $nowDateTime)
                        ->where('product_id', $asiatechProduct)
                        ->get()
                        ->first();
                    if (isset($unusedVoucher)) {
                        $unusedVoucher->user_id = $orderUser->id;
                        if ($unusedVoucher->update()) {
                            session()->put('success',
                                session()->pull('success') . ' کد تخفیف آسیاتک با موفقیت این کاربر داده شد.');
                        } else {
                            session()->put('error', 'خطا در تخصیص کد تخفیف آسیاتک');
                        }
                    } else {
                        session()->put('error', 'کد تخفیف آسیاتک برای این کاربر یافت نشد');
                    }
                } else {
                    session()->put('error', 'این کاربر قبلا کد تخفیف اینترنت رایگان آسیاتک گرفته است.');
                }
            }
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    public function destroy($order)
    {
        //        if ($order->delete()) session()->flash('success', 'سفارش با موفقیت اصلاح شد');
        //        else session()->flash('error', 'خطای پایگاه داده');
        $order->delete();

        return redirect()->back();
    }

    /**
     * Showing authentication step in the checkout process
     *
     * @param CheckoutReviewRequest $request
     *
     * @param AlaaInvoiceGenerator  $invoiceGenerator
     *
     * @return ResponseFactory|Factory|Response|View
     * @throws Exception
     */
    public function checkoutReview(CheckoutReviewRequest $request, AlaaInvoiceGenerator $invoiceGenerator)
    {
        $this->generateCustomMeta([
            'title'       => 'آلاء|بازبینی سفارش',
            'url'         => $request->url(),
            'siteName'    => 'آلاء',
            'description' => optional($this->setting)->site->seo->homepage->metaDescription,
            'image'       => optional($this->setting)->site->siteLogo,
        ]);

        $orderProductCount           = 0;
        $gateways                    = null;
        $coupon                      = null;
        $notIncludedProductsInCoupon = null;
        $orderHasDonate              = false;
        $credit                      = 0;
        $fromWallet                  = 0;
        $invoiceInfo                 = [];
        $user                        = $request->user();

        if (isset($user)) {
            $order = Order::Find($request->order_id);

            if (isset($order)) {
                Cache::tags([
                    'order_' . $order->id,
                    'user_' . $user->id . '_totalBonNumber',
                    'user_' . $user->id . '_validBons',
                    'user_' . $user->id . '_hasBon',
                ])->flush();

                $credit         = optional($order->user)->getTotalWalletBalance();
                $orderHasDonate = $order->hasTheseProducts([
                    Product::CUSTOM_DONATE_PRODUCT,
                    Product::DONATE_PRODUCT_5_HEZAR,
                ]);
                $gateways       = Transactiongateway::enable()
                    ->get()
                    ->sortBy('order')
                    ->pluck('displayName', 'name');

                $coupon                 = $order->coupon;
                $couponValidationStatus = optional($coupon)->validateCoupon();
                if (in_array($couponValidationStatus, [
                    Coupon::COUPON_VALIDATION_STATUS_DISABLED,
                    Coupon::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN,
                    Coupon::COUPON_VALIDATION_STATUS_EXPIRED,
                ])) {
                    $order->detachCoupon();
                    if ($order->updateWithoutTimestamp()) {
                        $coupon->decreaseUseNumber();
                        $coupon->update();
                    }

                    $order = $order->fresh();
                }
                $coupon                      = $order->coupon_info;
                $notIncludedProductsInCoupon = $order->reviewCouponProducts();
                /** checkout payment */

                $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);
                $fromWallet  = min($invoiceInfo['price']['payableByWallet'], $credit);
                $response    = response([
                    'invoiceInfo'                 => $invoiceInfo,
                    'fromWallet'                  => $fromWallet,
                    'credit'                      => $credit,
                    'couponInfo'                  => $coupon,
                    'notIncludedProductsInCoupon' => $notIncludedProductsInCoupon,
                    'orderHasDonate'              => $orderHasDonate,
                ], Response::HTTP_OK);

            } else {
                $response = response(['message' => 'Order not found'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            if (isset($_COOKIE['cartItems']) && strlen($_COOKIE['cartItems']) > 0) {
                $cookieOrderproducts = json_decode($_COOKIE['cartItems']);
                $fakeOrderproducts   = $this->convertOrderproductObjectsToCollection($cookieOrderproducts);
                $invoiceInfo         = $invoiceGenerator->generateFakeOrderproductsInvoice($fakeOrderproducts);
            }

            $response = response([], Response::HTTP_OK);
        }

        if ($request->expectsJson()) {
            return $response;
        }

        $pageName = 'review';
        return view('order.checkout.review',
            compact('invoiceInfo', 'orderProductCount', 'gateways', 'coupon', 'notIncludedProductsInCoupon', 'orderHasDonate', 'credit', 'fromWallet', 'pageName'));

    }

    /**
     * @param array $cookieOrderproducts
     *
     * @return OrderproductCollection
     */
    private function convertOrderproductObjectsToCollection(array $cookieOrderproducts): OrderproductCollection
    {
        $fakeOrderproducts = new OrderproductCollection();

        foreach ($cookieOrderproducts as $key => $cookieOrderproduct) {
            $grandParentProductId = optional($cookieOrderproduct)->product_id;
            $childrenIds          = optional($cookieOrderproduct)->products;
            $attributes           = optional($cookieOrderproduct)->attribute;
            $extraAttributes      = optional($cookieOrderproduct)->extraAttribute;

            $grandParentProduct = Product::Find($grandParentProductId);
            if (!isset($grandParentProduct)) {
                continue;
            }

            $data = [
                'products'       => $childrenIds,
                'atttibute'      => $attributes,
                'extraAttribute' => $extraAttributes,
            ];

            $products = (new RefinementFactory($grandParentProduct, $data))->getRefinementClass()
                ->getProducts();

            /** @var Product $product */
            foreach ($products as $product) {
                $fakeOrderproduct             = new Orderproduct();
                $fakeOrderproduct->id         = $product->id;
                $fakeOrderproduct->product_id = $product->id;
                $costInfo                     = $product->calculatePayablePrice();
                $fakeOrderproduct->cost       = $costInfo['cost'];
                $fakeOrderproduct->updated_at = Carbon::now();
                $fakeOrderproduct->created_at = Carbon::now();

                $fakeOrderproducts->push($fakeOrderproduct);
            }
        }

        return $fakeOrderproducts;
    }

    /**
     * Makes a copy from an order
     *
     * @param Order   $order
     * @param Request $request
     *
     * @return Response
     */
    public function copy(Order $order, Request $request)
    {
        $failed           = true;
        $copyOrderRequest = new Request();
        if ($request->has('paymenrstatus_id')) {
            $copyOrderRequest->offsetSet('paymentstatus_id', $request->get('paymenrstatus_id'));
        }
        if ($request->has('orderstatus_id')) {
            $copyOrderRequest->offsetSet('orderstatus_id', $request->get('orderstatus_id'));
        }
        $copyOrderRequest->offsetSet('user_id', $order->user_id);
        $copyOrderRequest->offsetSet('coupon_id', $order->coupon_id);
        $copyOrderRequest->offsetSet('couponDiscount', $order->couponDiscount);
        $copyOrderRequest->offsetSet('couponDiscountAmount', $order->couponDiscountAmount);
        $copyOrderRequest->offsetSet('checkOutDateTime', $order->checkOutDateTime);
        $newOrder = $this->store($copyOrderRequest);
        if ($newOrder) {
            $orderproducts = $order->orderproducts;
            foreach ($orderproducts as $orderproduct) {
                $newOrderproduct             = new Orderproduct();
                $newOrderproduct->product_id = $orderproduct->product_id;
                $newOrderproduct->order_id   = $newOrder->id;
                $newOrderproduct->quantity   = $orderproduct->quantity;
                if ($newOrderproduct->save()) {
                    $userbons = $orderproduct->userbons;
                    foreach ($userbons as $userbon) {
                        $newOrderproduct->userbons()
                            ->attach($userbon->id, [
                                'usageNumber' => $userbon->pivot->usageNumber,
                                'discount'    => $userbon->pivot->discount,
                            ]);
                    }
                    foreach ($orderproduct->attributevalues as $value) {
                        if ($orderproduct->product->hasParents()) {
                            $myParent       = $orderproduct->product->getAllParents();
                            $myParent       = $myParent->last();
                            $attributevalue = $myParent->attributevalues->where('id', $value->id);
                        } else {
                            $attributevalue = $orderproduct->product->attributevalues->where('id', $value->id);
                        }
                        if (!$attributevalue->isEmpty()) {
                            $newOrderproduct->attributevalues()
                                ->attach($attributevalue->first()->id,
                                    ['extraCost' => $attributevalue->first()->pivot->extraCost]);
                        }/* else {
                        }*/
                    }
                    $failed = false;
                }/* else {
                    // he just lost one of last orders items in his new order
                }*/
            }
        }/* else {
            // the new order was not created and no action is necessary.in fact he just lost his last order to add to.
        }*/

        if ($request->expectsJson()) {
            if (!$failed) {
                return response()->json();
            }

            return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Submits a coupon for the order
     *
     * @param SubmitCouponRequest  $request
     *
     * @param AlaaInvoiceGenerator $invoiceGenerator
     *
     * @return Response
     * @throws Exception
     */
    public function submitCoupon(SubmitCouponRequest $request, AlaaInvoiceGenerator $invoiceGenerator)
    {
        $coupon = Coupon::code($request->get('code'))->first();

        if (!isset($coupon)) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'The code is wrong',
                ],
            ]);
        }

        $order    = Order::Find($request->order_id);
        if (!isset($order)) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'Order not found',
                ],
            ]);
        }

        /** @var Coupon $coupon */
        $couponValidationStatus = $coupon->validateCoupon();
        if ($couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_OK) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => Coupon::COUPON_VALIDATION_INTERPRETER[$couponValidationStatus] ?? 'Coupon validation status is undetermined',
                ],
            ]);
        }

        $result = (new CouponSubmitter($order))->submit($coupon);
        if($result){
            Cache::tags([
                'order_' . $order->id . '_coupon',
                'order_' . $order->id . '_cost',
            ])->flush();

            $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);
            $priceInfo   = $invoiceInfo['price'];
            $order       = $order->fresh();

            $notIncludedProductsInCoupon = $order->reviewCouponProducts();

            $responseBody = $this->makeSubmitCouponSuccessfulResponse('Coupon attached successfully', $coupon, $priceInfo, $notIncludedProductsInCoupon);
            return response($responseBody);
        }

        return response($this->makeErrorResponse(Response::HTTP_SERVICE_UNAVAILABLE, 'Database error'));
    }

    /**
     * Cancels a coupon for the order
     *
     * @param Request              $request
     *
     * @param AlaaInvoiceGenerator $invoiceGenerator
     *
     * @return Response
     * @throws Exception
     */
    public function removeCoupon(Request $request, AlaaInvoiceGenerator $invoiceGenerator)
    {
        $order = Order::Find($request->get('order_id'));
        if (isset($order)) {
            $coupon = $order->coupon;
            if (isset($coupon)) {
                $order->detachCoupon();
                if ($order->updateWithoutTimestamp()) {
                    $coupon->decreaseUseNumber();
                    $coupon->update();
                    $resultCode = Response::HTTP_OK;
                    $resultText = 'Coupon detached successfully';
                } else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $resultText = 'Database error';
                }
            } else {
                $resultCode = Response::HTTP_BAD_REQUEST;
                $resultText = 'No coupon found for this order';
            }
        } else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            $resultText = 'No order found';
        }

        if ($resultCode == Response::HTTP_OK) {
            if (isset($order)) {
                $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);
                $priceInfo   = $invoiceInfo['price'];
            }

            $response = [
                'price'   => isset($priceInfo) ? $priceInfo : null,
                'message' => $resultText,
            ];
        } else {
            $response = [
                'error' => [
                    'code'    => $resultCode ?? $resultCode,
                    'message' => $resultText ?? $resultText,
                ],
            ];
        }

        return response($response, Response::HTTP_OK);
    }

    public function removeOrderproduct(Request $request, Product $product, OrderproductController $orderproductController)
    {
        $user = $request->user();

        /** @var Order $openOrder */
        $openOrder = $user->getOpenOrder();

        if (isset($openOrder)) {
            $orderproduct = $openOrder->orderproducts->where('product_id', $product->id)
                ->first();

            if (isset($orderproduct)) {
                try {
                    $orderproductController->destroy($orderproduct);
                } catch (Exception $e) {
                    return response()->json([
                        'error' => $e->getMessage(),
                        'line'  => $e->getLine(),
                        'file'  => $e->getFile(),
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                /** Has been commented for better performance in removing donate */ //                $openOrder = $openOrder->fresh();
//
//                $orderCost                      = $openOrder->obtainOrderCost(true, false);
//                $openOrder->cost                = $orderCost["rawCostWithDiscount"];
//                $openOrder->costwithoutcoupon   = $orderCost["rawCostWithoutDiscount"];
//                $updateFlag                     = $openOrder->updateWithoutTimestamp();
//                $cost                           = $openOrder->totalCost();

                if (true) {
                    $resultCode = Response::HTTP_OK;
                    $resultText = 'Product removed successfully';
                } else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $resultText = 'Database error on updating order';
                }
            } else {
                $resultCode = Response::HTTP_BAD_REQUEST;
                $resultText = 'No orderproducts found for passed product';
            }
        } else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            $resultText = 'No open order found';
        }

        if ($resultCode == Response::HTTP_OK) {
            $response = [//                'cost'  => $cost ?? $cost,
            ];
        } else {
            $response = [
                'error' => [
                    'code'    => $resultCode ?? $resultCode,
                    'message' => $resultText ?? $resultText,
                ],
            ];
        }

        return response($response, Response::HTTP_OK);
    }

    /**
     * Detach orderproducts from their order
     *
     * @param Request $request
     *
     * @return Response
     */
    public function detachOrderproduct(Request $request)
    {
        $orderproductsId = $request->get('orderproducts');
        $orderId         = $request->get('order');

        $orderproducts = Orderproduct::whereIn('id', $orderproductsId)
            ->get();

        $orderIds     = $orderproducts->pluck('order_id')
            ->unique();
        $countOrderId = count($orderIds);
        if ($countOrderId > 1 || $countOrderId == 0) {
            return response()->json([
                'message' => 'درخواست غیر مجاز',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if ($orderId != $orderIds[0]) {
            return response()->json([
                'message' => 'درخواست غیر مجاز',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        $oldOrder = Order::FindOrFail($orderId);

        if ($orderproducts->count() >= $oldOrder->orderproducts->where('orderproducttype_id', '<>',
                config('constants.ORDER_PRODUCT_GIFT'))
                ->count()) {
            return response()->json([
                'message' => 'شما نمی توانید سفارش را خالی کنید',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        $oldOrderBackup = $oldOrder->replicate();
        $newOrder       = $oldOrder->replicate();
        if (!$newOrder->save()) {
            return response()->json([
                'message' => 'خطا درایجاد سفارش جدید',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        foreach ($orderproducts as $orderproduct) {
            $gifts = $orderproduct->children;
            foreach ($gifts as $gift) {
                $gift->order_id = $newOrder->id;
                $gift->update();
            }
            $orderproduct->order_id = $newOrder->id;
            $orderproduct->update();
        }

        /**
         * Reobtaining old order cost
         */
        $oldOrder                    = Order::where('id', $oldOrder->id)
            ->get()
            ->first();
        $orderCost                   = $oldOrder->obtainOrderCost(true, false, 'REOBTAIN');
        $oldOrder->cost              = $orderCost['rawCostWithDiscount'];
        $oldOrder->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
        $oldOrderDone                = $oldOrder->updateWithoutTimestamp();
        if ($oldOrderDone) {

            /**
             * obtaining new order cost
             */
            $newOrder                    = Order::where('id', $newOrder->id)
                ->get()
                ->first();
            $newOrder->created_at        = Carbon::now();
            $newOrder->updated_at        = Carbon::now();
            $newOrder->completed_at      = Carbon::now();
            $newOrder->discount          = 0;
            $orderCost                   = $newOrder->obtainOrderCost(true, false, 'REOBTAIN');
            $newOrder->cost              = $orderCost['rawCostWithDiscount'];
            $newOrder->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
            $newOrderDone                = $newOrder->update();
            if ($newOrderDone) {
                /**
                 * Transactions
                 */
                $newCost = $newOrder->totalCost(); //$newOrder->totalCost() ;
                //                  if(($newOrder->totalCost() + $oldOrder->totalCost()) != $oldOrder->successfulTransactions->sum("cost") ) abort("403") ;
                $transactions = $oldOrder->successfulTransactions->where('cost', '>', 0)
                    ->sortBy('cost');
                foreach ($transactions as $transaction) {
                    if ($newCost <= 0) {
                        break;
                    }
                    if ($transaction->cost > $newCost) {
                        $newTransaction                            = new Transaction();
                        $newTransaction->destinationBankAccount_id = $transaction->destinationBankAccount_id;
                        $newTransaction->paymentmethod_id          = $transaction->paymentmethod_id;
                        $newTransaction->transactiongateway_id     = $transaction->transactiongateway_id;
                        $newTransaction->transactionstatus_id      = config('constants.TRANSACTION_STATUS_SUCCESSFUL');
                        $newTransaction->cost                      = $newCost;
                        $newTransaction->order_id                  = $newOrder->id;
                        $newTransaction->save();

                        $newTransaction2                            = new Transaction();
                        $newTransaction2->cost                      = $transaction->cost - $newCost;
                        $newTransaction2->destinationBankAccount_id = $transaction->destinationBankAccount_id;
                        $newTransaction2->paymentmethod_id          = $transaction->paymentmethod_id;
                        $newTransaction2->transactiongateway_id     = $transaction->transactiongateway_id;
                        $newTransaction2->transactionstatus_id      = config('constants.TRANSACTION_STATUS_SUCCESSFUL');
                        $newTransaction2->order_id                  = $oldOrder->id;
                        $newTransaction2->save();

                        if ($transaction->getGrandParent() !== false) {
                            $grandTransaction = $transaction->getGrandParent();
                            $newTransaction->parents()
                                ->attach($grandTransaction->id,
                                    ['relationtype_id' => config('constants.TRANSACTION_INTERRELATION_PARENT_CHILD')]);
                            $newTransaction2->parents()
                                ->attach($grandTransaction->id,
                                    ['relationtype_id' => config('constants.TRANSACTION_INTERRELATION_PARENT_CHILD')]);
                            $grandTransaction->children()
                                ->detach($transaction->id);
                            $transaction->delete();
                        } else {
                            $newTransaction->parents()
                                ->attach($transaction->id,
                                    ['relationtype_id' => config('constants.TRANSACTION_INTERRELATION_PARENT_CHILD')]);
                            $newTransaction2->parents()
                                ->attach($transaction->id,
                                    ['relationtype_id' => config('constants.TRANSACTION_INTERRELATION_PARENT_CHILD')]);
                            $transaction->transactionstatus_id =
                                config('constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL');
                            $transaction->update();
                        }

                        $newCost = 0;
                    } else {
                        $transaction->order_id = $newOrder->id;
                        $transaction->update();
                        $newCost -= $transaction->cost;
                    }
                }
                /**
                 * End
                 */

                if ($newOrder->totalPaidCost() >= $newOrder->totalCost()) {
                    $newOrder->paymentstatus_id = config('constants.PAYMENT_STATUS_PAID');
                    $newOrder->update();
                }

                session()->put('success',
                    'سفارش با موفقیت تفکیک شد . رفتن به سفارش جدید : ' . "<a target='_blank' href='" . action('Web\OrderController@edit',
                        $newOrder) . "'>" . $newOrder->id . '</a>');

                return response()->json([
                    'orderId' => $newOrder->id,
                ]);
            }

            $oldOrder->fill($oldOrderBackup->toArray());
            foreach ($orderproducts as $orderproduct) {
                $orderproduct->order_id = $oldOrder->id;
                $orderproduct->update();
            }
            if ($oldOrder->update()) {
                return response()->json([
                    'message' => 'آیتم با موفقیت حذف شد.',
                ]);
            }

            return response()->json([
                'message' => 'خطا در آپدیت سفارش جدید ایجاد شده . سفارش قدیم دچار تغییرات شد.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
        return response()->json([
            'message' => 'خطا در آپدیت اطلاعات سفارش قدیم',
        ], Response::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Exchange some order products
     *
     * @param Order                 $order
     * @param Request               $request
     * @param TransactionController $transactionController
     *
     * @return RedirectResponse
     */
    public function exchangeOrderproduct(Order $order, Request $request, TransactionController $transactionController)
    {
        $done           = false;
        $exchangeArray1 = $request->get('exchange-a');
        foreach ($exchangeArray1 as $key => $item) {
            $newProduct = Product::where('id', $item['orderproductExchangeNewProduct'])
                ->get()
                ->first();
            if (isset($newProduct)) {
                $done         = true;
                $orderproduct = Orderproduct::where('id', $key)
                    ->get()
                    ->first();
                if ($orderproduct->order_id != $order->id) {
                    continue;
                }
                if (isset($orderproduct)) {
                    $orderproduct->product_id = $newProduct->id;
                    if (strlen(preg_replace('/\s+/', '', $item['orderproductExchangeNewCost'])) > 0) {
                        $orderproduct->cost = $item['orderproductExchangeNewCost'];
                    }
                    if (strlen(preg_replace('/\s+/', '', $item['orderproductExchangeNewDiscountAmount'])) > 0) {
                        $orderproduct->discountAmount = $item['orderproductExchangeNewDiscountAmount'];
                    }
                    $orderproduct->discountPercentage = 0;
                    $orderproduct->includedInCoupon   = 0;
                    $orderproduct->userbons()
                        ->detach($orderproduct->userbons->pluck('id')
                            ->toArray());
                    $orderproduct->update();
                }
            }
        }

        $exchangeArray2 = $request->get('exchange-b');
        foreach ($exchangeArray2 as $item) {
            $newProduct = Product::where('id', $item['newOrderproductProduct'])
                ->get()
                ->first();
            if (isset($newProduct)) {
                $done                     = true;
                $orderproduct             = new Orderproduct();
                $orderproduct->product_id = $newProduct->id;
                $orderproduct->order_id   = $order->id;
                if (strlen(preg_replace('/\s+/', '', $item['neworderproductCost'])) > 0) {
                    $orderproduct->cost = $item['neworderproductCost'];
                }
                $orderproduct->save();
            }
        }
        if ($request->has('orderproductExchangeTransacctionCheckbox')) {
            $done = true;
            $request->offsetSet('order_id', $order->id);
            $transactionRequest = new InsertTransactionRequest();
            $transactionRequest->offsetSet('order_id', $order->id);
            $cost = $request->get('cost');
            if ($request->has('cost')) {
                $transactionRequest->offsetSet('cost', -$cost);
            }
            if (strlen(preg_replace('/\s+/', '', $request->get('traceNumber'))) != 0) {
                $transactionRequest->offsetSet('traceNumber', $request->get('traceNumber'));
            }
            if (strlen(preg_replace('/\s+/', '', $request->get('referenceNumber'))) != 0) {
                $transactionRequest->offsetSet('referenceNumber', $request->get('referenceNumber'));
            }
            if (strlen(preg_replace('/\s+/', '', $request->get('paycheckNumber'))) != 0) {
                $transactionRequest->offsetSet('paycheckNumber', $request->get('paycheckNumber'));
            }
            if (strlen(preg_replace('/\s+/', '', $request->get('managerComment'))) != 0) {
                $transactionRequest->offsetSet('managerComment', $request->get('managerComment'));
            }
            $transactionRequest->offsetSet('destinationBankAccount_id', 1);
            if ($request->has('paymentmethod_id')) {
                $transactionRequest->offsetSet('paymentmethod_id', $request->get('paymentmethod_id'));
            }
            if ($request->has('transactionstatus_id')) {
                $transactionRequest->offsetSet('transactionstatus_id', $request->get('transactionstatus_id'));
            }

            $transactionController->store($transactionRequest);
            session()->forget('success');
            session()->forget('error');
        }

        if ($done) {
            $newOrder                    = Order::where('id', $order->id)
                ->get()
                ->first();
            $orderCost                   = $newOrder->obtainOrderCost(true, false, 'REOBTAIN');
            $newOrder->cost              = $orderCost['rawCostWithDiscount'];
            $newOrder->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
            $newOrderDone                = $newOrder->update();
            if ($newOrderDone) {
                session()->put('success', 'عملیات تعویض آیتم های سفارش یا موفقیت انجام شد');
            } else {
                session()->put('error', 'خطا در بروز رسانی قیمت سفارش');
            }

            return redirect()->back();
        } else {
            session()->put('warning', 'عملیاتی انجام نشد');

            return redirect()->back();
        }
    }

    /**
     * Adds a product to intended order
     *
     * @param Request                $request
     * @param Product                $product
     * @param OrderproductController $orderproductController
     *
     * @return ResponseFactory|Response
     */
    public function addOrderproduct(Request $request, Product $product, OrderproductController $orderproductController)
    {
        try {
            /** @var User $user */
            $user      = $request->user();
            $openOrder = $user->getOpenOrder();

            $donate_5_hezar = Product::DONATE_PRODUCT_5_HEZAR;
            $createFlag     = true;
            $resultCode     = Response::HTTP_NO_CONTENT;
            if ($product->id == $donate_5_hezar) {
                /** @var OrderproductCollection $oldOrderproduct */
                $oldOrderproduct = $openOrder->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
                    ->where('product_id', $donate_5_hezar)
                    ->onlyTrashed()
                    ->get();
                if ($oldOrderproduct->isNotEmpty()) {
                    $deletedOrderproduct = $oldOrderproduct->first();
                    $deletedOrderproduct->restore();
                    $resultCode = Response::HTTP_OK;
                    $resultText = 'An old Orderproduct with the same data restored successfully';
                    $createFlag = false;
                }
            }

            if ($createFlag) {
                $data               = [];
                $data['product_id'] = $product->id;
                $data['order_id']   = $openOrder->id;
                $data['withoutBon'] = true;
                $result             = $orderproductController->new($data);
                if (!$result['status']) {
                    dd('Could not add donate to order.');
                }

                /** @var OrderproductCollection $storedOrderproducts */
                $storedOrderproducts = $result['data']['storedOrderproducts'];
                $newPrice            = $storedOrderproducts->calculateGroupPrice();
                $storedOrderproducts->setNewPrices($newPrice['newPrices']);
                $storedOrderproducts->updateCostValues();

                if ($result['status']) {
                    $resultCode = Response::HTTP_OK;
                    $resultText = 'Orderproduct added successfully';
                } else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $resultText = $result['message'];
                }
            }

            if ($resultCode == Response::HTTP_OK) {
                $response = [];
            } else {
                $response = [
                    'error' => [
                        'code'    => $resultCode ?? $resultCode,
                        'message' => $resultText ?? $resultText,
                    ],
                ];
            }

            return response($response, Response::HTTP_OK);
        } catch (Exception    $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param                                     $resultText
     * @param Coupon                              $coupon
     * @param array                               $priceInfo
     * @param \Illuminate\Support\Collection|null $notIncludedProductsInCoupon
     *
     * @return array
     */
    private function makeSubmitCouponSuccessfulResponse(string $resultText, Coupon $coupon, array $priceInfo, ?\Illuminate\Support\Collection $notIncludedProductsInCoupon): array
    {
        return [
            'message'                     => $resultText,
            'coupon'                      => $coupon,
            'price'                       => isset($priceInfo) ? $priceInfo : null,
            'notIncludedProductsInCoupon' => isset($notIncludedProductsInCoupon) ? $notIncludedProductsInCoupon : null,
        ];
}
}
