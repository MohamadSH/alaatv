<?php

namespace App;

use App\Http\Controllers\OrderController;
use App\Traits\ProductCommon;
use Helpers\Helper;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Illuminate\Support\Facades\Config;

class Order extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $cascadeDeletes = ['transactions' ,'files'];
    protected $dates = ['deleted_at'];
    use ProductCommon ;

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
    ];

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

    public function orderproducts($type = null)
    {
        if(isset($type))
            if($type == Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
            {
                return $this->hasMany('App\Orderproduct')->where(function($q) use ($type){
                    $q->where("orderproducttype_id" , $type)
                        ->orWhereNull("orderproducttype_id");
                });
            }
            else
            {
                return $this->hasMany('App\Orderproduct')->where("orderproducttype_id" , $type);
            }
        else
            return $this->hasMany('App\Orderproduct');
    }

    public function onlinetransactions()
    {
        //ToDo : add where to get only paymentMethod = online
        return $this->hasMany('App\Transaction')->where('paymentmethod_id', 1);
    }

    public function successfulTransactions()
    {
        //ToDo : add where to get only paymentMethod = online
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL"));
    }

    public function pendingTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", Config::get("constants.TRANSACTION_STATUS_PENDING"));
    }

    public function unpaidTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", Config::get("constants.TRANSACTION_STATUS_UNPAID"));
    }

    public function archivedSuccessfulTransactions()
    {
        return $this->hasMany('App\Transaction')->where("transactionstatus_id", Config::get("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL"));
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function files()
    {
        return $this->hasMany('\App\Orderfile');
    }

    public function orderpostinginfos(){
        return $this->hasMany('\App\Orderpostinginfo');
    }

    public function normalOrderproducts()
    {
          return $this->hasMany('App\Orderproduct')->where(function ($q){
             $q->whereNull("orderproducttype_id")->orWhere("orderproducttype_id" , Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT") );
          });

    }

    /**
     * Obtain order total cost
     *
     * @param boolean $calculateOrderCost
     * @param boolean $calculateOrderproductCost
     * @return array
     */
    public function obtainOrderCost( $calculateOrderCost = false , $calculateOrderproductCost = true , $mode = "DEFAULT"){
        /**
         * Muhammad Shahrokhi
         * Attention : In obtaining order cost I don't coupon validation
         * In the other words , if he has submitted a coupon for this order before, at the time we
         * have validated coupon before accepting it.so at this time I believe we can jsut let him use it.
         */
//
        if($calculateOrderCost){
            $orderproducts = $this->normalOrderproducts->sortByDesc("created_at") ;
            $totalCostWithoutDiscount = null;
            $totalCostWithDiscount = null;
            foreach ($orderproducts as $orderproduct)
            {
                $costArray = array();
                if($calculateOrderproductCost)
                {
                    $costArray  = $orderproduct->obtainOrderproductCost();
                    /**
                     * Updating orderproduct cost with new numbers
                     */
                    $orderproduct->fillCostValues($costArray);

                    $orderproduct->update();
                }
                else
                {
                    $costArray  = $orderproduct->obtainOrderproductCost(false);
                }

                if(isset($costArray["cost"]))
                {
                    $orderproductCost = $orderproduct->quantity * ((1 - ($costArray["bonDiscount"] / 100)) * (((1 - ($costArray["productDiscount"] / 100)) * $costArray["cost"]) - $costArray["productDiscountAmount"] ) );
                    $orderproductExtraCost = $costArray["extraCost"] ;
                    switch ($mode)
                    {
                        case "DEFAULT" :
                            if ($this->hasCoupon())
                            {

                                if (!isset($this->coupon->coupontype->id) || $this->coupon->coupontype->id == 1) {
                                    $totalCostWithDiscount += $orderproductCost;
                                    $orderproduct->includedInCoupon = 1 ;
                                }
                                else
                                {
                                    $flag = true;
                                    if(!in_array($this->coupon->id, $orderproduct->product->coupons->pluck('id')->toArray()))
                                    {
                                        $flag = false;
                                        $parentsArray = $this->makeParentArray($orderproduct->product);
                                        foreach ($parentsArray as $parent)
                                        {
                                            if(in_array($this->coupon->id, $parent->coupons->pluck('id')->toArray()))
                                            {
                                                $flag = true;
                                                break ;
                                            }
                                        }
                                    }
                                    if ($flag) {
                                        $totalCostWithDiscount += $orderproductCost;
                                        $orderproduct->includedInCoupon = 1 ;
                                    }
                                    else {
                                        $totalCostWithoutDiscount += $orderproductCost;
                                        $orderproduct->includedInCoupon = 0 ;
                                    }
                                }
                            } else {
                                $totalCostWithoutDiscount += $orderproductCost;
                                $orderproduct->includedInCoupon = 0 ;
                            }
                            $orderproduct->update();
                            break;
                        case "REOBTAIN" :
                            if($this->hasCoupon())
                            {
                                if (!isset($this->coupon->coupontype->id) || $this->coupon->coupontype->id == 1){
                                    $totalCostWithDiscount += $orderproductCost;
                                }else{
                                    if($orderproduct->includedInCoupon == 1)
                                    {
                                        $totalCostWithDiscount += $orderproductCost;
                                    }else{
                                        $totalCostWithoutDiscount += $orderproductCost;
                                    }
                                }
                            }else{
                                $totalCostWithoutDiscount += $orderproductCost;
                            }
                            break;
                        default:
                            break;
                    }

                    $totalCostWithoutDiscount += $orderproductExtraCost ;

                }
            }
            }else{
                $totalCostWithoutDiscount = $this->costwithoutcoupon ;
                $totalCostWithDiscount = $this->cost ;
            }

        if(isset($totalCostWithDiscount)) $rawCostWithDiscount = (int)($totalCostWithDiscount);
        else $rawCostWithDiscount = null ;

        if(isset($totalCostWithoutDiscount)) $rawCostWithoutDiscount = (int)$totalCostWithoutDiscount;
        else $rawCostWithoutDiscount = null ;

        if(isset($totalCostWithDiscount) || isset($totalCostWithoutDiscount)) $totalCost = ($totalCostWithoutDiscount + intval(round($this->obtainCouponDiscount($totalCostWithDiscount)),0) )- $this->discount;
        else $totalCost = null ;

        if($totalCost < 0 ) $totalCost =  0 ;

        return array("rawCostWithDiscount"=>$rawCostWithDiscount , 'rawCostWithoutDiscount'=>$rawCostWithoutDiscount , "totalCost"=>$totalCost);

    }

    public function totalPaidCost(){
        if($this->transactions->isEmpty()) return 0 ;
        else return $this->transactions->where("transactionstatus_id" , Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL"))->where('cost' , '>' , 0)->sum("cost");
    }

    public function totalRefund(){
        if($this->transactions->isEmpty()) return 0 ;
        else return $this->transactions->where("transactionstatus_id" , Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL"))->where('cost' , '<' , 0)->sum("cost");
    }

    public function totalCost()
    {
        return $this->obtainOrderCost()["totalCost"];
    }

    public function debt(){
        $cost = $this->obtainOrderCost()["totalCost"];
        if(strcmp($this->orderstatus->name, 'refunded') == 0) return  -($this->totalPaidCost()+$this->totalRefund());
        else return $cost - ($this->totalPaidCost()+$this->totalRefund());
    }

    public function hasCoupon()
    {
        if(isset($this->coupon->id)) return true;
        else return false;
    }

    public function obtainCouponDiscount($totalCost ){
        if(!isset($totalCost) || $totalCost == 0) return $totalCost;
        $couponType = $this->determineCoupontype();
        if ($couponType !== false)
        {
            if($couponType["type"] == Config::get("constants.DISCOUNT_TYPE_PERCENTAGE"))
                $totalCost = ((1-($couponType["discount"]/100)) * $totalCost);
            elseif($couponType["type"] == Config::get("constants.DISCOUNT_TYPE_COST"))
                $totalCost = $totalCost - $couponType["discount"];
        }
        return $totalCost;
    }

    public function determineCoupontype()
    {
        if ($this->hasCoupon())
        {
            if($this->couponDiscount > 0)
            {
                return ["type"=>Config::get("constants.DISCOUNT_TYPE_PERCENTAGE") , "discount"=>$this->couponDiscount];
            }
            else
            {
                return ["type"=>Config::get("constants.DISCOUNT_TYPE_COST") , "discount"=>$this->couponDiscountAmount];
            }
        }
        return false;
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at , "toJalali" );
    }

    public function CompletedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->completed_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->completed_at , "toJalali" );
    }

    public static function orderStatusFilter($orders, $orderStatusesId){
        return $orders->whereIn('orderstatus_id', $orderStatusesId);
    }

    public static function UserMajorFilter($orders, $majorsId)
    {
        if (in_array(0, $majorsId))
            $orders = $orders->whereHas('user', function ($q) use ($majorsId) {
                $q->whereDoesntHave("major");
            });
        else
            $orders = $orders->whereHas('user', function ($q) use ($majorsId) {
                $q->whereIn("major_id", $majorsId);
            });
        return $orders;
    }

    public static function paymentStatusFilter($orders, $paymentStatusesId){
        return $orders->whereIn('paymentstatus_id', $paymentStatusesId);
    }

    public function ordermanagercomments(){
        return $this->hasMany('App\Ordermanagercomment');
    }

    public function usedBonSum()
    {
        $bonSum = 0 ;
        if(isset($this->orderproducts))
            foreach ($this->orderproducts as $orderproduct)
            {
                $bonSum += $orderproduct->userbons->sum("pivot.usageNumber") ;
            }
        return $bonSum ;
    }

    public function addedBonSum($intendedUser =  null)
    {
        $bonSum = 0 ;
        if(isset($intendedUser))
        {
            $user = $intendedUser ;
        }
        elseif(Auth::check())
        {
            $user = Auth::user();
        }

        if(isset($user))
        {
            foreach ($this->orderproducts as $orderproduct)
            {
                if(!$user->userbons->where("orderproduct_id",$orderproduct->id)->isEmpty())
                    $bonSum += $user->userbons->where("orderproduct_id",$orderproduct->id)->sum("totalNumber") ;
            }
        }
        return $bonSum ;
    }

    /**
     * Checks which order products this coupon does not submit to
     *
     * @param \App\Order $order
     * @return array
     */
    public function reviewCoupon()
    {
        $infoMessage = "";
        $warningMessage = "";
        $errorMessage = "";

        $collapseCoupon = false;
        if(isset($this->coupon->maxCost) && $this->totalCost() > $this->coupon->maxCost)
        {
            $collapseCoupon = true;
            $errorMessage .= "حداکثر مبلغ سبد خرید برای استفاده از این کپن ".number_format($this->coupon->maxCost)." تومان  می باشد.";
        }

        if(strlen($this->coupon->validateCoupon()) > 0 )
        {
            $collapseCoupon = true;
        }

        $couponRemoved = false;
        if($collapseCoupon)
        {
            $orderController = new \App\Http\Controllers\OrderController();
            $orderController->removeCoupon();
            if (session()->has("couponMessageSuccess")) {
                $couponRemoved = true;
                session()->forget("couponMessageSuccess");
            } elseif (session()->has("couponMessageError")) {
                session()->forget("couponMessageError");
            }
        }

        if(!$couponRemoved)
        {
            $orderproducts = $this->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->orderBy("created_at","desc")->get() ;

            $orderHasExtraAttribute = false;
            foreach ($orderproducts as $orderproduct)
            {
                if($orderproduct->attributevalues->isNotEmpty()) {
                    $orderHasExtraAttribute = true;
                    break;
                }
            }
            if($orderHasExtraAttribute) $infoMessage .= "کد تخفیف شامل قیمت ویژگی های افزوده (مانند پست) نمی باشد.";

            if($this->coupon->coupontype->id == 2){

                $couponProducts = $this->coupon->products->pluck('id')->toArray();
                foreach ($orderproducts as $orderproduct)
                {
                    if(!in_array($orderproduct->product->id , $couponProducts)) $warningMessage .= "این کپن برای `".$orderproduct->product->name."` تخفیف ندارد. ";
                }
            }
        }

        return ["warning"=>$warningMessage , "info"=>$infoMessage , "error"=>$errorMessage , "couponRemoved"=>$couponRemoved];
    }

    public function cancelOpenOnlineTransactions()
    {
        $openOnlineTransactions = $this->onlinetransactions->where("transactionstatus_id", Config::get("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY"));
        if($openOnlineTransactions->isNotEmpty())
        {
            foreach($openOnlineTransactions as $openOnlineTransaction){
                $openOnlineTransaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_UNSUCCESSFUL");
                $openOnlineTransaction->update();
            }
        }
    }

    public function refreshCost(){
        $orderCost = $this->obtainOrderCost(true) ;
        $this->cost = $orderCost["rawCostWithDiscount"];
        $this->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
        $this->timestamps = false;
        $this->update();
        $this->timestamps = true;
        return ["newCost"=>$orderCost];
    }

}
