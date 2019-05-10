<?php

namespace App\PaymentModule\Controllers;

use AlaaTV\Gateways\Money;
use App\Repositories\TransactionGatewayRepo;
use App\User;
use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\PaymentModule\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use AlaaTV\Gateways\PaymentDriver;
use App\Repositories\TransactionRepo;
use App\PaymentModule\Repositories\OrdersRepo;
use App\Http\Controllers\Web\TransactionController;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;

class RedirectUserToPaymentPage extends Controller
{
    /**
     * redirect the user to online payment page
     *
     * @param  Request  $request
     * @param  string   $paymentMethod
     * @param  string   $device
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function __invoke(string $paymentMethod, string $device, Request $request)
    {
        $data = $this->getRefinementData($request->all(), $request->user());

        /** @var User $user */
        $user = $data['user'];
        /** @var Order $order */
        $order = $data['order'];
        /** @var Order $order */
        $orderUniqueId = $data['orderUniqueId'];
        /** @var Money $cost */
        $cost = Money::fromTomans((int) $data['cost']);
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];

        if ($data['statusCode'] != Response::HTTP_OK) {
            $this->sendErrorResponse($data['message'], $data['statusCode']);
        }

        /** @var string $description */
        $description = $this->getTransactionDescription($data['description'], $user->mobile, $order);

        if ($this->isPayingAnOrder($order)) {
            $order->customerDescription = $request->get('customerDescription');
        }
    
        $this->shouldGoToOfflinePayment($cost->rials())
            ->thenRespondWith([Responses::class, 'sendToOfflinePaymentProcess'], [$device, $order->id]);

        $paymentClient = PaymentDriver::select($paymentMethod);
        $url = $this->comeBackFromGateWayUrl($paymentMethod, $device);

        if($this->shouldCloseOrder($order))
            OrdersRepo::closeOrder($order->id);

        $authorityCode = nullable($paymentClient->generateAuthorityCode($url, $cost, $description, $orderUniqueId))
            ->orFailWith([Responses::class, 'noResponseFromBankError']);

        TransactionRepo::setAuthorityForTransaction($authorityCode, $transaction->id , $this->getGatewyId($paymentMethod), $description)
            ->orRespondWith([Responses::class, 'editTransactionError']);

        //ToDo
//        $this->saveOrderInCookie($order);

        return view("order.checkout.gatewayRedirect", ['authority' => $authorityCode, 'paymentMethod' => $paymentMethod]);
    }

    /**
     * @param $inputData
     * @param $user
     *
     * @return array
     */
    private function getRefinementData($inputData, $user): array
    {
        $inputData['transactionController'] = app(TransactionController::class);
        $inputData['user']                  = $user;

        return (new RefinementLauncher($inputData))->getData($inputData);
    }

    /**
     * @param  string  $msg
     * @param  int     $statusCode
     *
     * @return JsonResponse
     */
    private function sendErrorResponse(string $msg, int $statusCode): JsonResponse
    {
        respondWith(response()->json(['message' => $msg], $statusCode));
    }

    /**
     * @param  string      $description
     * @param              $mobile
     * @param  Order|null  $order
     *
     * @return string
     */
    private function getTransactionDescription(string $description, $mobile, $order = null)
    {
        $description .= 'سایت آلاء - ';
        $description .= $mobile.' - محصولات: ';

        if (is_null($order)) {
            return $description;
        }

        $order->orderproducts->load('product');

        foreach ($order->orderproducts as $orderProduct) {
            if (isset($orderProduct->product->id)) {
                $description .= $orderProduct->product->name.' , ';
            } else {
                $description .= 'یک محصول نامشخص , ';
            }
        }
    
        return $description;
    }
    
    /**
     * @param  Order  $order
     *
     * @return bool
     */
    private function isPayingAnOrder($order): bool
    {
        return isset($order);
    }
    
    /**
     * @param  int  $cost
     *
     * @return Boolean
     */
    private function shouldGoToOfflinePayment(int $cost)
    {
        return boolean($cost <= 0);
    }
    
    /**
     * @param  string  $paymentMethod
     * @param  string  $device
     *
     * @return string
     */
    private function comeBackFromGateWayUrl(string $paymentMethod, string $device)
    {
        return route('verifyOnlinePayment',
            ['paymentMethod' => $paymentMethod, 'device' => $device, '_token' => csrf_token()]);
    }

    private function getGatewyId(string $gateway){
        $myGateway = TransactionGatewayRepo::getTransactionGatewayByName($gateway)
            ->orFailWith([Responses::class, 'sendErrorResponse'] , ['msg'   =>  'No DB record found for this gateway' , Response::HTTP_BAD_REQUEST]);

        return $myGateway->id;
    }

    /**
     * @param Order $order
     * @return bool
     */
    private function shouldCloseOrder(Order $order): bool
    {
        return $order->orderstatus_id == config('constants.ORDER_STATUS_OPEN');
    }

    /**
     * Saves order in cookie
     *
     * @param Order $order
     */
    private function saveOrderInCookie(Order $order)
    {
        $totalCookie = collect();
        $orderproducts = $order->orderproducts ;

        foreach ($orderproducts as $orderproduct){
            $extraAttributesIds = $orderproduct->attributevalues->pluck('id')->toArray() ;
            $myProduct = $orderproduct->product;

            $grandId = $myProduct->id;
            $productsId = [];
            if(isset($myProduct->grand_id))
            {
                $grandId = $myProduct->grand_id;
                $productsId = [$myProduct->id];
            }

            $isAdded =  $totalCookie->where('product_id' , $grandId);

            if($isAdded->isEmpty())
            {
                $totalCookie->push([
                    'product_id'    =>  $grandId,
                    'products'      =>  $productsId,
                    'extraAttribute'=>  $extraAttributesIds
                ]);
            }
            else{
                if(isEmpty($productsId))
                {
                    $totalCookie->push([
                        'product_id'    =>  $grandId,
                        'products'      =>  $productsId,
                        'extraAttribute'=>  $extraAttributesIds
                    ]);
                }
                else
                {
                    $key           = $isAdded->keys()->last();
                    $addedCookie   = $isAdded->first();
                    $addedCookie['products'] =  array_merge_recursive($addedCookie['products'] , $productsId);
                    $totalCookie->put($key, $addedCookie);
                }
            }
        }

        setcookie('cartItems', $_COOKIE["cartItems"], time() - 3600, '/');
    }
}
