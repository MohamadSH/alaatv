<?php

namespace App\Http\Controllers\Web;

use App\Bon;
use App\Http\Controllers\Controller;
use App\Notifications\InvoicePaid;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class OfflinePaymentController extends Controller
{

    /**
     * OfflinePaymentController constructor.
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
//        $this->middleware('OfflineVerifyPayment', ['only' => ['verifyPayment'],]);
    }
    
    /**
     * @param  Request  $request
     * @param  string   $paymentMethod
     * @param  string   $device
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(Request $request, string $paymentMethod, string $device)
    {
        Cache::tags('bon')->flush();
        Cache::tags('order')->flush();
        Cache::tags('orderproduct')->flush();

        $user = $request->user();

        // We had middleware called OfflineVerifyPayment for this,
        //but after reconsidering about queries in middleware I put the code in here
        $getOrder = $this->getOrder($request , $user);
        if ($getOrder["error"])
            return response($getOrder["text"], $getOrder["httpStatusCode"]);


        /** @var Order $order */
        $order = $getOrder["data"]["order"];

        $check = $this->checkOrder($order , $user);
        if ($check["error"])
            return response($check["text"] , $check["httpStatusCode"]);

        
        if (!$this->processVerification($order, $paymentMethod))
            return response( ["message" => "Invalid inputs"] , Response::HTTP_BAD_REQUEST);

        Cache::tags('user')->flush();
        Cache::tags('order')->flush();
        Cache::tags('orderproduct')->flush();

        return redirect()->route('showOnlinePaymentStatus', [
            'status'        => 'successful',
            'paymentMethod' => $paymentMethod,
            'device'        => $device,
        ]);
    }

    /**
     * @param Request $request
     *
     * @param User $user
     * @return array
     */
    private function getOrder(Request $request , User $user): array
    {
        if ($request->has("coi")) {
            $order = Order::Find($request->coi);
        }
        else{
            $order = $user->openOrders->first();
        }
        
        $error    = false;
        $response = Response::HTTP_OK;
        if (!isset($order)) {
            $error    = true;
            $response = Response::HTTP_BAD_REQUEST;
            $text     = 'No order found';
        }
        
        $result = [
            'error'          => $error,
            'httpStatusCode' => $response,
            'text'           => isset($text) ? $text : "",
            'data'           => [
                'order' => isset($order) ? $order : null,
            ],
        ];
        
        return $result;
    }

    private function checkOrder(Order $order , User $user): array
    {
        $result = [
            "error" => false,
        ];
        if (isset($order)) {
            if (!$order->doesBelongToThisUser($user)) {
                $result = [
                    "error"          => true,
                    "httpStatusCode" => Response::HTTP_UNAUTHORIZED,
                    "text"           => "Order doesn't belong to you",
                ];
            }
        }
        else {
            $result = [
                "error"          => true,
                "httpStatusCode" => Response::HTTP_NOT_FOUND,
                "text"           => "Order not found",
            ];
        }
        
        return $result;
    }

    /**
     * @param Order $order
     * @param string $paymentMethod
     *
     * @param string $customerDescription
     * @return bool
     */
    private function processVerification(Order $order, string $paymentMethod): bool
    {
        $done = true;
        switch ($paymentMethod) {
            case "inPersonPayment" :
            case "offlinePayment":
                $usedCoupon = $order->hasProductsThatUseItsCoupon();
                if (!$usedCoupon) {
                    /** if order has not used coupon reverse it    */
                    $coupon = $order->coupon;
                    if (isset($coupon)) {
                        $order->detachCoupon();
                        if ($order->updateWithoutTimestamp()) {
                            $coupon->decreaseUseNumber();
                            $coupon->update();
                        }
                    }
                }
                
                $orderPaymentStatus = config("constants.PAYMENT_STATUS_UNPAID");
                $order->close($orderPaymentStatus);
                
                break;
            case "wallet":
            case "noPayment":
                
                /** Wallet transactions */
                $order->closeWalletPendingTransactions();
                $order = $order->fresh();
                /** End */

                if ($order->hasCost()) {
                    $cost = $order->totalCost() - $order->totalPaidCost();
                    if ($cost == 0) {
                        /** Attaching user bons for this order */
                        $bonName = config("constants.BON1");
                        $bon     = Bon::where("name", $bonName)
                            ->first();
                        if (isset($bon))
                            [
                                $givenBonNumber,
                                $failedBonNumber,
                            ] = $order->giveUserBons($bonName);

                        /** End */

                        $order->paymentstatus_id = config("constants.PAYMENT_STATUS_PAID");
                        if ($order->update())
                            $order->user->notify(new InvoicePaid($order));

                    }
                }
                break;
            default :
                $done = false;
                break;
        }
        return $done;
    }
}
