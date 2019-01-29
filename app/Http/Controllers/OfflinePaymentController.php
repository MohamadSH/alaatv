<?php

namespace App\Http\Controllers;

use App\Bon;
use App\Notifications\InvoicePaid;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class OfflinePaymentController extends Controller
{


    private $user;

    /**
     * OfflinePaymentController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
//        $this->middleware('OfflineVerifyPayment', ['only' => ['verifyPayment'],]);

        $this->user = $request->user();

    }

    /**
     * @param Request $request
     * @param string $paymentMethod
     * @param string $device
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(Request $request , string $paymentMethod , string $device){
        $result = [];

        // We had middleware called OfflineVerifyPayment for this,
        //but after reconsidering about queries in middleware I put the code in here
        $getOrder = $this->getOrder($request);
        if($getOrder["error"])
            return response()->setStatusCode($getOrder["httpStatusCode"])->setContent($getOrder["text"]);

        $order = $getOrder["data"]["order"];

        $check =  $this->checkOrder($order);
        if($check["error"])
            return response()->setStatusCode($check["httpStatusCode"])->setContent($check["text"]);


        if(!$this->processVerification( $order , $paymentMethod))
            return response()->setStatusCode(Response::HTTP_BAD_REQUEST)->setContent(["message"=>"Invalid inputs"]);

        $customerDescription = optional($request)->customerDescription;
        $order->customerDescription = $customerDescription;

        if($order->updateWithoutTimestamp())
            $result = array_add($result, "saveOrder", 1);
        else
            $result = array_add($result, "saveOrder", 0);

        $this->user->notify(new InvoicePaid($order));
        Cache::tags('bon')->flush();

        if (strcmp($result["Status"], 'freeProduct') == 0)
            $actionMethod = "OrderController@successfulPayment";
        else
            $actionMethod = "OrderController@otherPayment";

        return redirect(action($actionMethod, [
            "result" => $result,
        ]));
    }

    /**
     * @param Order $order
     * @param string $paymentMethod
     * @return bool
     */
    private function processVerification( Order $order , string $paymentMethod):bool
    {
        $done = true;

        switch ($paymentMethod) {
            case "inPersonPayment" :
            case "offlinePayment":
                $result["Status"] = $paymentMethod;

                $usedCoupon = $order->hasProductsThatUseItsCoupon();
                if (!$usedCoupon) {
                    /** if order has not used coupon reverse it    */
                    $order->detachCoupon();
                }

                $orderPaymentStatus = config("constants.PAYMENT_STATUS_UNPAID");
                $order->close($orderPaymentStatus);

                break;
            case "wallet":
            case "noPayment":

                $result["Status"] = "freeProduct";

                /** Wallet transactions */
                $order->closeWalletPendingTransactions();
                /** End */

                if($order->hasCost())
                {
                    $cost = $order->totalCost() - $order->totalPaidCost();
                    if ($cost == 0) {

                        $orderPaymentStatus = config("constants.PAYMENT_STATUS_PAID");

                        /** Attaching user bons for this order */
                        $bonName = config("constants.BON1");
                        $bon = Bon::where("name", $bonName)->first();
                        if (isset($bon)) {
                            [
                                $givenBonNumber,
                                $failedBonNumber,
                            ] = $order->giveUserBons($bonName);

                            if ($givenBonNumber == 0)
                                if ($failedBonNumber > 0)
                                    $result = array_add($result, "saveBon", -1);
                                else
                                    $result = array_add($result, "saveBon", 0);
                            else
                                $result = array_add($result, "saveBon", $givenBonNumber);

                            $bonDisplayName = $bon->displayName;
                            /*$result = */array_add($result, "bonName", $bonDisplayName);
                        }
                        /** End */

                        $order->close($orderPaymentStatus);

                    }
                }
                break;
            default :
                $done = false;
                break;
        }

        return $done;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getOrder(Request $request):array
    {
        if($request->has("coi"))
            $order = Order::Find($request->coi);
        elseif(isset($user))
            $order = $this->user->openOrders->first();

        $error = false;
        $response = Response::HTTP_OK;
        if(!isset($order)){
            $error = true;
            $response = Response::HTTP_BAD_REQUEST;
            $text = 'No order found';
        }

        $result = [
            'error'           => $error,
            'httpStatusCode'  => $response,
            'text'            => isset($text)?$text:"",
            'data'            => [
                    'order' => isset($order)?$order:null
            ]
        ];

        return $result;
    }

    /**
     * @param Order $order
     * @return array
     */
    private function checkOrder(Order $order):array
    {
        $result = [
            "error" => false,
        ];
        if(isset($order))
        {
            if (!$order->doesBelongToThisUser($this->user))
                $result = [
                    "error" => true,
                    "httpStatusCode"  => Response::HTTP_UNAUTHORIZED,
                    "text"  => "Order not found"
                ];
        }
        else
        {
            $result = [
                "error" => true,
                "httpStatusCode"  => Response::HTTP_NOT_FOUND,
                "text"  => "User does not own this order"
            ];
        }

        return $result;
    }
}
