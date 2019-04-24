<?php

namespace App;

use App\Classes\Checkout\Alaa\OrderCheckout;
use App\Classes\Checkout\Alaa\ReObtainOrderFromRecords;
use App\Collection\OrderCollections;
use App\Collection\OrderproductCollection;
use App\Collection\ProductCollection;
use App\Collection\TransactionCollection;
use App\Traits\Helper;
use App\Traits\ProductCommon;
use App\Traits\UserCommon;
use Auth;
use Carbon\Carbon;
use DB;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * App\Order
 *
 * @property int $id
 * @property int|null $user_id              آیدی مشخص
 *           کننده کاربر سفارش دهنده
 * @property int|null $orderstatus_id       آیدی مشخص
 *           کننده وضعیت سفارش
 * @property int|null $paymentstatus_id     آیدی مشخص
 *           کننده وضعیت پرداخت سفارش
 * @property int|null $coupon_id            آیدی مشخص
 *           کننده کپن استفاده شده برای سفارش
 * @property float $couponDiscount       میزان تخفیف
 *           کپن برای سفارش به درصد
 * @property int $couponDiscountAmount میزان تخفیف
 *           کپن(به تومان)
 * @property int|null $cost                 مبلغ قابل
 *           پرداخت توسط کاربر
 * @property int|null $costwithoutcoupon    بخشی از
 *           قیمت که مشمول کپن تخفیف نمی شود
 * @property int $discount             تخفیف خاص
 *           برای این سفارش به تومان
 * @property string|null $customerDescription  توضیحات
 *           مشتری درباره سفارش
 * @property string|null $customerExtraInfo    اطلاعات
 *           تکمیلی مشتری برای این سفارش
 * @property string|null $checkOutDateTime     تاریخ تسویه
 *           حساب کامل
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $completed_at         مشخص کننده
 *           زمان تکمیل سفارش کاربر
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $archivedSuccessfulTransactions
 * @property-read \App\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderfile[] $files
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $normalOrderproducts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $onlinetransactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ordermanagercomment[] $ordermanagercomments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderpostinginfo[] $orderpostinginfos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $orderproducts
 * @property-read \App\Orderstatus|null $orderstatus
 * @property-read \App\Paymentstatus|null $paymentstatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $pendingTransactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $successfulTransactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $suspendedTransactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $unpaidTransactions
 * @property-read \App\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCheckOutDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCostwithoutcoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerExtraInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @property-read array|bool $coupon_discount_type
 * @property-read mixed $number_of_products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed $invoice
 * @property-read mixed $info
 * @property mixed donates
 * @property mixed donate_amount
 */
class Order extends BaseModel
{
    protected $table = 'orders';

    /*
    |--------------------------------------------------------------------------
    | Traits methods
    |--------------------------------------------------------------------------
    */
    use ProductCommon;
    use Helper;

    /*
    |--------------------------------------------------------------------------
    | Properties methods
    |--------------------------------------------------------------------------
    */

    protected $cascadeDeletes = [
        'transactions',
        'files',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'orderstatus_id',
        'paymentstatus_id',
        'coupon_id',
        'couponDiscount',
        'couponDiscountAmount',
        'cost',
        'costwithoutcoupon',
        'discount',
        'customerDescription',
        'customerExtraInfo',
        'checkOutDateTime',
        'completed_at',
    ];

    protected $appends = [
        'price',
        'orderstatus',
        'paymentstatus',
        'orderproducts',
        'couponInfo',
        'paidPrice',
        'refundPrice',
        'successfulTransactions',
        'pendingTransactions',
        'unpaidTransactions',
        'orderPostingInfo',
        'debt',
        'usedBonSum',
        'addedBonSum',
        'user',
        'jalaliCreatedAt',
        'jalaliUpdatedAt',
        'jalaliCompletedAt',
        'postingInfo',
        'managerComment',
        'editOrderLink',
        'removeOrderLink'
    ];

    const OPEN_ORDER_STATUSES = [
        1,
        4,
        8,
    ];

    protected $hidden = [
        'id',
        'couponDiscount',
        'coupon',
        'orderstatus_id',
        'paymentstatus_id',
        'checkOutDateTime',
        'couponDiscountAmount',
        'coupon_id',
        'cost',
        'costwithoutcoupon',
        'normalOrderproducts',
        'user_id',
        'updated_at',
        'deleted_at',
        'created_at',
    ];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new OrderCollections($models);
    }

    public static function orderStatusFilter($orders, $orderStatusesId)
    {
        /** @var Order $orders */
        return $orders->whereIn('orderstatus_id', $orderStatusesId);
    }

    public static function UserMajorFilter($orders, $majorsId)
    {
        /** @var Order $orders */
        if (in_array(0, $majorsId)) {
            $orders = $orders->whereHas('user', function ($q) use ($majorsId) {
                /** @var QueryBuilder $q */
                $q->whereDoesntHave("major");
            });
        } else {
            $orders = $orders->whereHas('user', function ($q) use ($majorsId) {
                /** @var QueryBuilder $q */
                $q->whereIn("major_id", $majorsId);
            });
        }

        return $orders;
    }

    public static function paymentStatusFilter($orders, $paymentStatusesId)
    {
        /** @var QueryBuilder $orders */
        return $orders->whereIn('paymentstatus_id', $paymentStatusesId);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orderstatus()
    {
        return $this->belongsTo('App\Orderstatus');
    }

    public function paymentstatus()
    {
        return $this->belongsTo('App\Paymentstatus');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }

    public function onlinetransactions()
    {
        return $this->hasMany('App\Transaction')->where('paymentmethod_id', 1);
    }

    public function successfulTransactions()
    {
        return $this->hasMany('App\Transaction')->where(function ($q) {
            /** @var QueryBuilder $q */
            $q->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUCCESSFUL"))->orWhere("transactionstatus_id",
                config("constants.TRANSACTION_STATUS_SUSPENDED"));
        });
    }

    public function pendingTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_PENDING"));
    }

    public function unpaidTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_UNPAID"));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Transaction
     */
    public function suspendedTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUSPENDED"));
    }

    public function archivedSuccessfulTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL"));
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function files()
    {
        return $this->hasMany('\App\Orderfile');
    }

    public function orderpostinginfos()
    {
        return $this->hasMany('\App\Orderpostinginfo');
    }

    public function normalOrderproducts()
    {
        return $this->hasMany('App\Orderproduct')->where(function ($q) {
            /** @var QueryBuilder $q */
            $q->whereNull("orderproducttype_id")->orWhere("orderproducttype_id", config("constants.ORDER_PRODUCT_TYPE_DEFAULT"));
        });
    }

    public function giftOrderproducts()
    {
        return $this->orderproducts(config('constants.ORDER_PRODUCT_GIFT'));
    }

    public function debt()
    {
        $order = $this;
        $key = "order:debt:" . $order->cacheKey();
        return Cache::tags(["order"])
                    ->remember($key, config("constants.CACHE_60"), function () use ($order) {
                        if ($this->orderstatus_id == config("constants.ORDER_STATUS_REFUNDED"))
                            return -($this->totalPaidCost() + $this->totalRefund());

                        $cost = $this->obtainOrderCost()["totalCost"];
                        return $cost - ($this->totalPaidCost() + $this->totalRefund());
                    });
    }

    /**
     * Obtain order total cost
     *
     * @param boolean $calculateOrderCost
     * @param boolean $calculateOrderproductCost
     *
     * @param string $mode
     * @return array
     */
    public function obtainOrderCost($calculateOrderCost = false, $calculateOrderproductCost = true, $mode = "DEFAULT")
    {
        $order = $this;
        $key = "order:debt:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_60"),
            function () use ($order, $calculateOrderCost, $calculateOrderproductCost, $mode) {
                if ($calculateOrderCost) {
                    $this->load('user', 'user.wallets', 'normalOrderproducts', 'normalOrderproducts.product', 'normalOrderproducts.product.parents',
                        'normalOrderproducts.userbons', 'normalOrderproducts.attributevalues', 'normalOrderproducts.product.attributevalues');
                    $orderproductsToCalculateFromBaseIds = [];
                    if ($calculateOrderproductCost) {
                        $orderproductsToCalculateFromBaseIds = $this->normalOrderproducts->pluck("id")->toArray();
                    }

                    $reCheckIncludedOrderproductsInCoupon = false;
                    if ($this->hasCoupon()) {
                        $reCheckIncludedOrderproductsInCoupon = ($mode == 'REOBTAIN') ? false : true;
                    }
                    $alaaCashierFacade = new OrderCheckout($this, $orderproductsToCalculateFromBaseIds, $reCheckIncludedOrderproductsInCoupon);
                } else {
                    $this->load('normalOrderproducts', 'normalOrderproducts.product', 'normalOrderproducts.product.parents', 'normalOrderproducts.userbons',
                        'normalOrderproducts.attributevalues', 'normalOrderproducts.product.attributevalues');
                    $alaaCashierFacade = new ReObtainOrderFromRecords($this);
                }

                $priceInfo = $alaaCashierFacade->checkout();

                return [
                    'sumOfOrderproductsRawCost' => $priceInfo['totalPriceInfo']['sumOfOrderproductsRawCost'],
                    'rawCostWithDiscount' => $priceInfo['totalPriceInfo']['totalRawPriceWhichHasDiscount'],
                    'rawCostWithoutDiscount' => $priceInfo['totalPriceInfo']['totalRawPriceWhichDoesntHaveDiscount'],
                    'totalCost' => $priceInfo['totalPriceInfo']['finalPrice'],
                    'payableAmountByWallet' => $priceInfo['totalPriceInfo']['payableAmountByWallet'],
                    'calculatedOrderproducts' => $priceInfo['orderproductsInfo']['calculatedOrderproducts'],
                ];
            });
    }

    /**
     * Determines this order's coupon discount type
     * Note: In case it has any coupons returns false
     *
     * @return array|bool
     */
    public function getCouponDiscountTypeAttribute()
    {
        if ($this->couponDiscount > 0) {
            return [
                'type' => config('constants.DISCOUNT_TYPE_PERCENTAGE'),
                'typeHint' => 'percentage',
                'discount' => $this->couponDiscount,
            ];
        } else {
            if ($this->couponDiscountAmount > 0) {
                return [
                    'type' => config('constants.DISCOUNT_TYPE_COST'),
                    'typeHint' => 'amount',
                    'discount' => $this->couponDiscountAmount,
                ];
            }
        }

        return false;
    }

    /**
     * Determines whether order has coupon or not
     *
     * @return bool
     */
    public function hasCoupon()
    {
        if (isset($this->coupon->id)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determines whether the coupon is usable for this order or not
     *
     * @return bool
     */
    public function hasProductsThatUseItsCoupon(): bool
    {
        $flag = true;
        $notIncludedProducts = $this->reviewCouponProducts();
        $orderproductCount = $this->orderproducts->whereType([config("constants.ORDER_PRODUCT_TYPE_DEFAULT")])->count();
        if ($orderproductCount == optional($notIncludedProducts)->count()) {
            $flag = false;
        }

        return $flag;
    }

    /**
     * Determines if this order has given products
     *
     * @param array $products
     * @return bool
     */
    public function hasTheseProducts(array $products): bool
    {
        return $this->orderproducts->whereIn("product_id", $products)->isNotEmpty();
    }

    /**
     * Indicated whether order cost has been determined or not
     *
     * @return bool
     */
    public function hasCost(): bool
    {
        return (isset($this->cost) || isset($this->costwithoutcoupon));
    }

    /**
     * @param $user
     * @return bool
     */
    public function doesBelongToThisUser($user): bool
    {
        return optional($this->user)->id == optional($user)->id;
    }

    /**
     * Calculates the discount amount of totalCost relevant to this order's coupon
     *
     * @param int $totalCost
     * @return float|int|mixed
     */
    public function obtainCouponDiscount(int $totalCost = 0)
    {
        $couponType = $this->coupon_discount_type;
        if ($couponType !== false) {
            if ($couponType["type"] == config("constants.DISCOUNT_TYPE_PERCENTAGE")) {
                $totalCost = ((1 - ($couponType["discount"] / 100)) * $totalCost);
            } else {
                if ($couponType["type"] == config("constants.DISCOUNT_TYPE_COST")) {
                    $totalCost = $totalCost - $couponType["discount"];
                }
            }
        }

        return $totalCost;
    }

    public function determineCoupontype()
    {
        if ($this->hasCoupon()) {
            if ($this->couponDiscount > 0) {
                return [
                    "type" => config("constants.DISCOUNT_TYPE_PERCENTAGE"),
                    "discount" => $this->couponDiscount,
                ];
            } else {
                return [
                    "type" => config("constants.DISCOUNT_TYPE_COST"),
                    "discount" => $this->couponDiscountAmount,
                ];
            }
        }

        return false;
    }

    public function totalPaidCost()
    {
        $order = $this;
        $key = "order:totalPaidCost:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_60"), function () use ($order) {
            $totalPaidCost = 0;
            $successfulTransactions = $order->successfulTransactions;
            if ($successfulTransactions->isNotEmpty()) {
                $totalPaidCost = $successfulTransactions->where('cost', '>', 0)->sum("cost");
            }

            return $totalPaidCost;
        });
    }

    public function totalRefund()
    {
        $order = $this;
        $key = "order:totalRefund:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_60"), function () use ($order) {
            $totalRefund = 0;
            $successfulTransactions = $order->successfulTransactions;
            if ($successfulTransactions->isNotEmpty()) {
                $totalRefund = $successfulTransactions->where('cost', '<', 0)->sum("cost");
            }

            return $totalRefund;
        });
    }

    public function CompletedAt_Jalali()
    {
        /**
         * Unnecessary variable
         */ /*$explodedDateTime = explode(" ", $this->completed_at);*/
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->completed_at, "toJalali");
    }

    public function ordermanagercomments()
    {
        return $this->hasMany('App\Ordermanagercomment');
    }

    public function usedBonSum()
    {
        $order = $this;
        $key = "order:usedBonSum:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_600"), function () use ($order) {
            $bonSum = 0;
            if (isset($this->orderproducts)) {
                foreach ($this->orderproducts as $orderproduct) {
                    $bonSum += $orderproduct->userbons->sum("pivot.usageNumber");
                }
            }

            return $bonSum;
        });
    }

    public function addedBonSum($intendedUser = null)
    {
        $order = $this;
        $key = "order:addedBonSum:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_600"), function () use ($order) {
            $bonSum = 0;
            if (isset($intendedUser)) {
                $user = $intendedUser;
            } else {
                if (Auth::check()) {
                    $user = Auth::user();
                }
            }

            if (isset($user)) {
                foreach ($this->orderproducts as $orderproduct) {
                    if (! $user->userbons->where("orderproduct_id", $orderproduct->id)->isEmpty()) {
                        $bonSum += $user->userbons->where("orderproduct_id", $orderproduct->id)->sum("totalNumber");
                    }
                }
            }

            return $bonSum;
        });
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function reviewCouponProducts(): ?Collection
    {
        $orderproducts = $this->orderproducts->whereType([config("constants.ORDER_PRODUCT_TYPE_DEFAULT")]);

        $coupon = $this->coupon;
        $notIncludedProducts = new  ProductCollection();
        if (isset($coupon)) {
            foreach ($orderproducts->getProducts() as $product) {
                if (! $coupon->hasProduct($product)) {
                    $notIncludedProducts->push($product);
                }
            }
        }

        if ($notIncludedProducts->isNotEmpty()) {
            return $notIncludedProducts;
        } else {
            return null;
        }
    }

    public function totalCost()
    {
        return $this->obtainOrderCost()["totalCost"];
    }

    public function getNumberOfProductsAttribute()
    {
        return $this->orderproducts->count();
    }

    /**
     * @param null $type
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Orderproduct
     */
    public function orderproducts($type = null, $filters = [])
    {
        if (isset($type)) {
            if ($type == config("constants.ORDER_PRODUCT_TYPE_DEFAULT")) {
                $relation = $this->hasMany('App\Orderproduct')->where(function ($q) use ($type) {
                    /** @var QueryBuilder $q */
                    $q->where("orderproducttype_id", $type)->orWhereNull("orderproducttype_id");
                });
            } else {
                $relation = $this->hasMany('App\Orderproduct')->where("orderproducttype_id", $type);
            }
        } else {
            $relation = $this->hasMany('App\Orderproduct');
        }

        foreach ($filters as $filter) {
            if (isset($filter["isArray"])) {
                $relation->whereIn($filter["attribute"], $filter["value"]);
            } else {
                $relation->where($filter["attribute"], $filter["value"]);
            }
        }

        return $relation;
    }

    /**
     * Gets this order's products
     *
     * @param array $orderproductTypes
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function products(array $orderproductTypes = [])
    {
        $result = DB::table('products')->join('orderproducts', function ($join) use ($orderproductTypes) {
            if (empty($orderproductTypes)) {
                $join->on('products.id', '=', 'orderproducts.product_id')->whereNull('orderproducts.deleted_at');
            } else {
                $join->on('products.id', '=', 'orderproducts.product_id')->whereNull('orderproducts.deleted_at')->whereIn("orderproducttype_id",
                    $orderproductTypes);
            }
        })->join('orders', function ($join) {
            $join->on('orders.id', '=', 'orderproducts.order_id')->whereNull('orders.deleted_at');
        })->select([
            "products.*",
        ])->where('orders.id', '=', $this->getKey())->whereNull('products.deleted_at')->distinct()->get();
        $result = Product::hydrate($result->toArray());

        return $result;
    }

    /**
     * Detaches coupon from this order
     *
     */
    public function detachCoupon(): void
    {
        $this->coupon_id = null;
        $this->couponDiscount = 0;
        $this->couponDiscountAmount = 0;
    }

    /**
     * Recalculates order's cost and updates it's cost
     *
     * @return array
     */
    //ToDo : must refresh donate product cost
    public function refreshCost()
    {
        $orderCost = $this->obtainOrderCost(true);
        $calculatedOrderproducts = $orderCost["calculatedOrderproducts"];
        $calculatedOrderproducts->updateCostValues();

        $calculatedOrderproducts = $orderCost["calculatedOrderproducts"];
        /** @var Orderproduct $orderproduct */
        foreach ($calculatedOrderproducts as $orderproduct) {
            $newPriceInfo = $orderproduct->newPriceInfo;
            $orderproduct->fillCostValues($newPriceInfo);
            $orderproduct->updateWithoutTimestamp();
        }

        $this->cost = $orderCost["rawCostWithDiscount"];
        $this->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
        $this->updateWithoutTimestamp();

        return ["newCost" => $orderCost];
    }

    /**
     * Gives order bons to user
     *
     * @param string $bonName
     *
     * @return array [$totalSuccessfulBons, $totalFailedBons]
     */
    public function giveUserBons($bonName)
    {
        $totalSuccessfulBons = 0;
        $totalFailedBons = 0;
        $checkedProducts = [];
        $user = $this->user;

        $orderproducts = $this->orderproducts(config("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->get();
        foreach ($orderproducts as $orderproduct) {
            if (! isset($user)) {
                break;
            }
            if ($user->userbons->where("orderproduct_id", $orderproduct->id)->isNotEmpty()) {
                continue;
            }
            /** @var Product $simpleProduct */
            $simpleProduct = $orderproduct->product;
            $bons = $simpleProduct->bons->where("name", $bonName);
            if ($bons->isEmpty()) {
                $grandParent = $simpleProduct->grand_parent;
                if (isset($grandParent)) {
                    $simpleProduct = $grandParent;
                    $bons = $grandParent->bons->where("name", $bonName)->where("isEnable", 1);
                }
            }
            if (in_array($simpleProduct->id, $checkedProducts)) {
                continue;
            }
            if ($bons->isNotEmpty()) {
                $bon = $bons->first();
                $bonPlus = $bon->pivot->bonPlus;
                if ($bonPlus) {
                    $userbon = new Userbon();
                    $userbon->user_id = $user->id;
                    $userbon->bon_id = $bon->id;
                    $userbon->totalNumber = $bon->pivot->bonPlus;
                    $userbon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
                    $userbon->orderproduct_id = $orderproduct->id;
                    if ($userbon->save()) {
                        $totalSuccessfulBons += $userbon->totalNumber;
                    } else {
                        $totalFailedBons += $bon->pivot->bonPlus;
                    }
                }
            }
        }

        return [
            $totalSuccessfulBons,
            $totalFailedBons,
        ];
    }

    /**
     * Closes this order
     *
     * @param string $paymentStatus
     *
     * @param int $orderStatus
     * @return void
     */
    public function close($paymentStatus, int $orderStatus = null)
    {
        if (! isset($orderStatus)) {
            $orderStatus = config("constants.ORDER_STATUS_CLOSED");
        }

        $this->orderstatus_id = $orderStatus;
        $this->paymentstatus_id = $paymentStatus;
        $this->completed_at = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran');
    }

    public function closeWalletPendingTransactions()
    {
        /**
         * for reduce query
         */
        /*$walletTransactions = $this->suspendedTransactions*/
        $walletTransactions = $this->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_SUSPENDED"))->where("paymentmethod_id",
            config("constants.PAYMENT_METHOD_WALLET"));
        foreach ($walletTransactions as $transaction) {
            /** @var Transaction $transaction */
            $transaction->transactionstatus_id = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
            $transaction->update();
        }
    }

    /**
     * @param ProductCollection $products
     * @return ProductCollection
     */
    public function checkProductsExistInOrderProducts(ProductCollection $products): ProductCollection
    {
        $notDuplicateProduct = new ProductCollection();
        foreach ($products as $product) {
            if ($this->hasTheseProducts([$product->id])) {
                // can increase amount of product
            } else {
                $notDuplicateProduct->push($product);
            }
        }

        return $notDuplicateProduct;
    }

    /**
     * @return int
     */
    public function getDonateCost(): int
    {
        $donateCost = 0;
        $orderProducts = $this->orderproducts->whereIn('product_id', [
            Product::CUSTOM_DONATE_PRODUCT,
            Product::DONATE_PRODUCT_5_HEZAR,
        ]);
        foreach ($orderProducts as $orderProduct) {
            $donateCost += $orderProduct->cost;
        }

        return $donateCost;
    }

    public function closeOrderWithIndebtedStatus()
    {
        $this->close(config("constants.PAYMENT_STATUS_INDEBTED"));
        $this->timestamps = false;
        $this->update();
        $this->timestamps = true;
    }

    public function detachUnusedCoupon()
    {
        $usedCoupon = $this->hasProductsThatUseItsCoupon();
        if (! $usedCoupon) {
            /** if order has not used coupon reverse it    */
            $coupon = $this->coupon;
            if (isset($coupon)) {
                $this->detachCoupon();
                if ($this->updateWithoutTimestamp()) {
                    $coupon->decreaseUseNumber();
                    $coupon->update();
                }
            }
        }
    }

    /**
     * @return int $totalWalletRefund
     */
    public function refundWalletTransaction(): int
    {
        $walletTransactions = $this->suspendedTransactions()->walletMethod()->get();

        $totalWalletRefund = 0;
        foreach ($walletTransactions as $transaction) {
            $response = $transaction->depositThisWalletTransaction();
            if ($response["result"]) {
                $transaction->delete();
                $totalWalletRefund += $transaction->cost;
            }
        }

        return $totalWalletRefund;
    }

    public function getOrderstatusAttribute()
    {
        $order = $this;
        $key = "order:orderstatus:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_10"), function () use ($order) {
            return optional($order->orderstatus()->first())->setVisible([
                'name',
                'displayName',
                'description',
            ]);
        });
    }

    public function getPaymentstatusAttribute()
    {
        $order = $this;
        $key = "order:paymentstatus:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_10"), function () use ($order) {
            return optional($order->paymentstatus()->first())->setVisible([
                'name',
                'displayName',
                'description',
            ]);
        });
    }

    public function getCouponInfoAttribute()
    {
        $order = $this;
        $key = "order:coupon:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_10"), function () use ($order) {
            $coupon = $order->coupon()->first();
            if (! isset($coupon)) {
                return null;
            }

            $coupon->setVisible([
                'name',
                'code',
//                            'discountType',
            ]);

            return array_merge($coupon->toArray(), $this->coupon_discount_type);
        });
    }

    public function getPriceAttribute()
    {
        return $this->totalCost();
    }

    /**
     * @return Collection
     */
    public function getOrderproductsAttribute(): Collection
    {
        $order = $this;
        $key = "order:orderproducts:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_5"), function () use ($order) {
            /** @var OrderproductCollection $orderproducts */
            $orderproducts = $this->orderproducts()->get();
            if ($orderproducts->isNotEmpty()) {
                $orderproducts->setVisible([
                    'id',
                    'cost',
                    'discountPercentage',
                    'discountAmount',
                    'quantity',
                    'orderproducttype',
                    'product',
                    'grandId',
                    'price',
                    'bons',
                    'attributevalues',
                    'photo',
                    'grandProduct',
                ]);
            }

            return $orderproducts;
        });
    }

    /**
     * @return int
     */
    public function getPaidPriceAttribute(): int
    {
        return $this->totalPaidCost() + $this->totalRefund();
    }

    /**
     * @return int
     */
    public function getRefundPriceAttribute(): int
    {
        return $this->totalRefund();
    }

    /**
     * @return Collection
     */
    public function getDonatesAttribute(): Collection
    {
        $order = $this;
        $key = "order:donates:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_10"), function () use ($order) {
            return $this->orderproducts->whereIn('product_id', [
                Product::CUSTOM_DONATE_PRODUCT,
                Product::DONATE_PRODUCT_5_HEZAR,
            ]);
        });
    }

    /**
     * @return int
     */
    public function getDonateAmountAttribute(): int
    {
        $donateOrderProducts = $this->donates;

        $donateCost = 0;
        if ($donateOrderProducts->isNotEmpty()) {
            $donateCost = $donateOrderProducts->sum("cost");
        }

        return $donateCost;
    }

    public function getSuccessfulTransactionsAttribute()
    {
        $order = $this;
        $key = "order:transactions:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_60"), function () use ($order) {
            /** @var TransactionCollection $successfulTransactions */
            $successfulTransactions = $order->successfulTransactions()->get();
            $successfulTransactions->setVisible([
                'cost',
                'transactionID',
                'traceNumber',
                'referenceNumber',
                'paycheckNumber',
                'description',
                'completed_at',
                'paymentmethod',
                'transactiongateway',
            ]);

            return $successfulTransactions;
        });
    }

    public function getPendingTransactionsAttribute()

    {
        $order = $this;
        $key = "order:pendingtransactions:" . $order->cacheKey();
        return Cache::tags(["order"])
                    ->remember($key, config("constants.CACHE_60"), function () use ($order) {
                        /** @var TransactionCollection $pendingTransaction */
                        $pendingTransaction = $order->pendingTransactions()->get();
                        $pendingTransaction->setVisible([
                            'cost',
                            'transactionID',
                            'traceNumber',
                            'referenceNumber',
                            'paycheckNumber',
                            'description',
                            'completed_at',
                            'paymentmethod',
                            'transactiongateway',
                        ]);

                        return $pendingTransaction;
                    });
    }

    public function getUnpaidTransactionsAttribute()

    {
        $order = $this;
        $key = "order:unpaidtransactions:" . $order->cacheKey();
        return Cache::tags(["order"])
                    ->remember($key, config("constants.CACHE_60"), function () use ($order) {
                        /** @var TransactionCollection $unpaidTransaction */
                        $unpaidTransaction = $order->unpaidTransactions()->get();
                        $unpaidTransaction->setVisible([
                            'cost',
                            'transactionID',
                            'traceNumber',
                            'referenceNumber',
                            'paycheckNumber',
                            'description',
                            'completed_at',
                            'paymentmethod',
                            'transactiongateway',
                        ]);

                        return $unpaidTransaction;
                    });
    }

    public function getOrderPostingInfoAttribute()
    {
        $order = $this;
        $key = "order:postInfo:".$order->cacheKey();

        return Cache::tags(["order"])->remember($key, config("constants.CACHE_600"), function () use ($order) {
            return $order->orderpostinginfos()->get();
        });
    }

    public function getDebtAttribute()
    {
        return $this->debt();
    }

    public function getUsedBonSumAttribute()
    {
        return $this->usedBonSum();
    }

    public function getAddedBonSumAttribute()

    {
        return $this->addedBonSum();
    }

    public function getUserAttribute(){

        $order = $this;
        $key = "order:user:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                $visibleColumns = [
                    'firstName',
                    'lastName',
                    'nationalCode',
                    'province',
                    'city',
                    'address',
                    'postalCode',
                    'school',
                    'info',
                    'userstatus'
                ];

                if($this->isAuthenticatedUserHasPermission(config('constants.SHOW_USER_MOBILE')))
                    $visibleColumns = array_merge($visibleColumns , ['mobile']);

                if($this->isAuthenticatedUserHasPermission(config('constants.SHOW_USER_EMAIL')))
                    $visibleColumns = array_merge($visibleColumns , ['email']);

                return $order->user()->first()->setVisible($visibleColumns);
            });
     }

    public function getJalaliUpdatedAtAttribute(){
        $order = $this;
        $key = "order:updated_at:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                if($this->isAuthenticatedUserHasPermission(config('constants.SHOW_ORDER_ACCESS')))
                    return $this->convertDate($order->updated_at, "toJalali");

                return null;
            });

    }

    public function getJalaliCreatedAtAttribute(){
        $order = $this;
        $key = "order:created_at:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                if($this->isAuthenticatedUserHasPermission(config('constants.SHOW_ORDER_ACCESS')))
                    return $this->convertDate($order->created_at, "toJalali");

                return null;
            });

    }

    public function getJalaliCompletedAtAttribute(){
        $order = $this;
        $key = "order:completed_at:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                if($this->isAuthenticatedUserHasPermission(config('constants.SHOW_ORDER_ACCESS')))
                    return $this->convertDate($order->completed_at, "toJalali");

                return null;
            });
    }

    public function getPostingInfoAttribute(){

        $order = $this;
        $key   = "order:postingInfo:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_60"), function () use ($order) {
                return $order->orderpostinginfos()->get();
            });

    }

    public function getManagerCommentAttribute(){
        $order = $this;
        $key   = "order:managerComment:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                if($this->isAuthenticatedUserHasPermission('constants.SHOW_ORDER_ACCESS'))
                    return $order->ordermanagercomments()->get();

                return null;
            });

    }

    public function getEditOrderLinkAttribute(){
        $order = $this;
        $key = "order:editLink:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                if($this->isAuthenticatedUserHasPermission(config('constants.EDIT_ORDER_ACCESS')))
                    return action('Web\OrderController@edit' , $order->id);

                return null;
            });

    }

    public function getRemoveOrderLinkAttribute(){
        $order = $this;
        $key = "order:removeLink:" . $order->cacheKey();
        return Cache::tags(["order"])
            ->remember($key, config("constants.CACHE_600"), function () use ($order) {
                if($this->isAuthenticatedUserHasPermission(config('constants.REMOVE_ORDER_ACCESS')))
                    return action('Web\OrderController@destroy' , $order->id);

                return null;
            });

    }

    private function isAuthenticatedUserHasPermission(string $permission):bool{
        return (Auth::check() && Auth::user()->can($permission));
    }
}
