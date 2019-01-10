<?php

namespace App\Http\Controllers;

use App\Classes\Payment\RefinementRequest\RefinementRequest;
use App\Http\Requests\EditTransactionRequest;
use App\Order;
use App\Traits\OrderCommon;
use App\Transaction;
use App\Transactiongateway;
use App\User;
use Auth;
use Illuminate\Http\{Request, Response};
use Zarinpal\Zarinpal;
use App\Bankaccount;
use App\Bon;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\{Config, Cache};

class PaymentController extends Controller
{
    use OrderCommon;

    private $orderController;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var User
     */
    private $user;

    private $zarinpalAuthority;
    private $zarinpalRefId;
    private $zarinpalStatus;
    private $zarinpalError;

    public function __construct(OrderController $orderController)
    {
        $this->orderController = $orderController;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentRedirect(Request $request)
    {
//        $request->offsetSet("order_id", 137);
//        $request->offsetSet("transaction_id", 65);

        $refinementRequest = new RefinementRequest($request);
        $data = $refinementRequest->getData();

//        dd($data);

        if($data['statusCode']!=Response::HTTP_OK) {
            return response()->json([
                'error' => $data['message']
            ], $data['statusCode']);
        }

        $user = $data['user'];
        $order = $data['order'];
        $cost = $data['cost'];
        $donateCost = $data['donateCost'];
        $transaction = $data['transaction'];

        $description = $this->setDescription($request, $order, $user);

        $this->setCustomerDescription($request, $order);

        if ($request->has("payByWallet")) {
            $remainedCost = $this->payByWallet($cost, $donateCost, $order, $user);
            $cost = $remainedCost;
        }

        if ($cost > 0) {
            $this->zarinReqeust((int)$cost, $description, $transaction);
        } else {
            return redirect(action('PaymentController@verifyPayment', ['type' => 'offline', 'gateway' => 'wallet']));
        }
        return redirect(action("HomeController@error404"));
    }

    /**
     * Making request to ZarinPal gateway
     * @param int $cost
     * @param string $description
     * @param Transaction $transaction
     * @return mixed
     */
    protected function zarinReqeust(int $cost, string  $description, Transaction $transaction)
    {
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $merchant = $zarinGate->merchantNumber;
        $zarinpal = new Zarinpal($merchant);
        $zarinpal->enableSandbox(); // active sandbox mod for test env
        $zarinpal->isZarinGate(); // active zarinGate mode

        //ToDo : putting verify url in .env or database
        $results = $zarinpal->request(action('PaymentController@verifyPayment', ['type' => 'online', 'gateway' => 'zarinpal']), (int)$cost, $description);

//        $answer = $zarinpal->request(action("OrderController@verifyPayment"), (int)$cost, $description);

        if (isset($results['Authority']) && strlen($results['Authority']) > 0) {

            $transactionController = new TransactionController();
            $request = new EditTransactionRequest();
            $request->offsetSet("authority", $results['Authority']);
            $request->offsetSet("transactiongateway_id", $zarinGate->id);
            $request->offsetSet("destinationBankAccount_id", 1);
            $request->offsetSet("paymentmethod_id", config("constants.PAYMENT_METHOD_ONLINE"));
            $request->offsetSet("apirequest", true);
            $request->offsetSet("gateway", $zarinpal);
            $response = $transactionController->update($request, $transaction);
            if ($response->getStatusCode() == 200) {
                $zarinpal->redirect();
                return null;
            }
            else {
                dd("مشکل در برقراری ارتباط با درگاه زرین پال");
                return null;
            }
        } else {
            return $results['error'];
        }
    }

    /**
     * @param Request $request
     * @param Order $order
     * @param User $user
     * @return string
     */
    private function setDescription(Request $request, Order $order, User $user): string
    {
        $description = '';

        if ($request->has("transaction_id")) {
            $description .= "پرداخت قسط -";
        }

        $description .= "آلاء - " . $user->mobile . " - محصولات: ";

        $orderProducts = $order->orderproducts;
        foreach ($orderProducts as $orderProduct) {
            if (isset($orderProduct->product->id))
                $description .= $orderProduct->product->name . " , ";
            else
                $description .= "یک محصول نامشخص , ";
        }
        return $description;
    }

    /**
     * @param int $cost
     * @param int $donateCost
     * @param Order $order
     * @param User $user
     * @return int
     */
    private function payByWallet(int $cost, int $donateCost, Order $order, User $user): int
    {
        $deductibleCostFromWallet = $cost - $donateCost;
        $remainedCost = $deductibleCostFromWallet;
        $walletPayResult = $this->payOrderCostByWallet($user, $order, $deductibleCostFromWallet);
        if ($walletPayResult["result"]) {
            $remainedCost = $walletPayResult["cost"];
            $order->closeOrderWithIndebtedStatus();
        }
        $remainedCost = $remainedCost + $donateCost;
        return $remainedCost;
    }

    /**
     * @param Request $request
     * @param Order $order
     */
    private function setCustomerDescription(Request $request, Order $order): void
    {
        if ($request->has("customerDescription")) {
            $customerDescription = $request->get("customerDescription");
            $order->customerDescription = $customerDescription;
            $order->timestamps = false;
            $order->update();
            $order->timestamps = true;
        }
    }


    /**
     * Verify customer online payment after coming back from payment gateway
     * @param string $type
     * @param string $gateway
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(string $type, string $gateway, Request $request)
    {
        $result = [
            'sendSMS' => false
        ];
        if($type=='online') {
            if($gateway=='zarinpal') {
                $result = $this->handleZarinpal($request, $result);
            }
        } else if($type=='offline') {
            $result = [];
            if (session()->has("adminOrder_id")) {
                $result["isAdminOrder"] = true;
                $this->user = Auth::user();
                if (!$this->user->can(config('constants.INSERT_ORDER_ACCESS')))
                    return redirect(action("HomeController@error403"));

                $order_id = session()->get("adminOrder_id");
                $this->order = Order::FindorFail($order_id);

                $result["customer_firstName"] = session()->get("customer_firstName");
                $result["customer_lastName"] = session()->get("customer_lastName");
                session()->forget("adminOrder_id");
                session()->forget("customer_id");
                session()->forget("customer_firstName");
                session()->forget("customer_lastName");
            } else if (session()->has("closedOrder_id")) {
                $this->user = Auth::user();
                $result["isAdminOrder"] = false;

                $order_id = session()->get("closedOrder_id");
                session()->forget("closedOrder_id");
                $this->order = Order::FindorFail($order_id);

                if ($this->order->user->id != $this->user->id)
                    abort(403);
            } else if (session()->has("order_id")) {
                $this->user = Auth::user();
                $result["isAdminOrder"] = false;

                $order_id = session()->get("order_id");
                session()->forget("order_id");
                $this->order = Order::FindorFail($order_id);

                if ($this->order->orderstatus_id != Config::get("constants.ORDER_STATUS_OPEN"))
                    abort(403);
                if ($this->order->user->id != $this->user->id)
                    abort(403);
            } else {
                abort(404);
            }

            if ($this->order->orderproducts->isEmpty())
                return redirect(action("OrderController@checkoutReview"));

            if ($request->has("customerDescription")) {
                $customerDescription = $request->get("customerDescription");
                $this->order->customerDescription = $customerDescription;
            }
            if ($request->has('paymentmethod')) {
                $paymentMethod = $request->get('paymentmethod');

                $this->order->detachUnusedCoupon();

                $debitCard = Bankaccount::all()
                    ->where("user_id", 2)
                    ->first();
                if (isset($debitCard)) {
                    $result["debitCardNumber"] = $debitCard->cardNumber;
                    $result["debitCardBank"] = $debitCard->bank->name;
                    $result["debitCardOwner"] = $debitCard->user->firstName . " " . $debitCard->user->lastName;
                }

                switch ($paymentMethod) {
                    case "inPersonPayment" :
                        $result["Status"] = "inPersonPayment";
                        break;
                    case "offlinePayment":

                        $result["Status"] = "offlinePayment";
                        break;
                    default :
                        return redirect(action(("HomeController@error404")));
                        break;
                }

                $this->order->close(Config::get("constants.PAYMENT_STATUS_UNPAID"));
                $this->order->timestamps = false;
                if ($this->order->update())
                    $result = array_add($result, "saveOrder", 1);
                else
                    $result = array_add($result, "saveOrder", 0);
                $this->order->timestamps = true;
                $result["sendSMS"] = true;

            } else {
                /** Wallet transactions */
                $this->order->closeWalletPendingTransactions();
                /** End */
                $cost = $this->order->totalCost() - $this->order->totalPaidCost();

                if ($cost == 0 &&
                    (isset($this->order->cost) || isset($this->order->costwithoutcoupon))) {
                    $this->order->close(Config::get("constants.PAYMENT_STATUS_PAID"));
                    $this->order->timestamps = false;
                    if ($this->order->update())
                        $result = array_add($result, "saveOrder", 1);
                    else
                        $result = array_add($result, "saveOrder", 0);
                    $this->order->timestamps = true;
                    /** Attaching user bons for this order */
                    $bonName = Config::get("constants.BON1");
                    $bon = Bon::where("name", $bonName)
                        ->first();
                    if (isset($bon)) {
                        [
                            $givenBonNumber,
                            $failedBonNumber,
                        ] = $this->order->giveUserBons($bonName);

                        if ($givenBonNumber == 0)
                            if ($failedBonNumber > 0)
                                $result = array_add($result, "saveBon", -1);
                            else
                                $result = array_add($result, "saveBon", 0);
                        else
                            $result = array_add($result, "saveBon", $givenBonNumber);

                        $bonDisplayName = $bon->displayName;
                        $result = array_add($result, "bonName", $bonDisplayName);
                    }
                    $result["Status"] = "freeProduct";
                    $result["sendSMS"] = true;
                }
            }
        }

        /**
         * Sending SMS to Ordoo 97 customers
         */
        $sendSMS = $result['sendSMS'];
        if ($sendSMS && isset($this->order)) {
            $user = $this->order->user;
            $this->order = $this->order->fresh();
            $user->notify(new InvoicePaid($this->order));
            Cache::tags('bon')
                ->flush();
        }


        if (isset($result['Status'])) {
            if (isset($result['RefID']) || strcmp($result['Status'], 'freeProduct') == 0) {
                session()->put('verifyPayment', 1);
                return redirect(action("OrderController@successfulPayment", [
                    "result" => $result,
                ]));
            } else if (strcmp($result["Status"], 'canceled') == 0 ||
                (strcmp($result["Status"], 'error') == 0 && isset($result["error"]) && strcmp($result["error"], '-22') == 0)) {
                if (isset($result["tryAgain"]) && $result["tryAgain"]) {
                    session()->put("verifyPayment", 1);
                    return redirect(action("OrderController@failedPayment", [
                        "result" => $result,
                    ]));
                }
            }
        }

        return redirect(action("OrderController@otherPayment", [
            "result" => $result,
        ]));

        //        return view('order.checkout.verification',compact('result')) ;
        //'Status'(index) going to be 'success', 'error' or 'canceled'
    }



    /**
     * Successful payments
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    function successfulPayment(Request $request)
    {
        if (session()->has("verifyPayment")) {
            $flag = true;
            session()->forget("verifyPayment");
        } else {
            $flag = false;
        }

        if (!$flag)
            return redirect(action("HomeController@error403"));
        if ($request->has("result")) {
            $result = $request->get("result");
            return view('order.checkout.verification', compact('result'));
        } else {
            return redirect(action("HomeController@error403"));
        }
    }


    /**
     *  repeat an old payment
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    function failedPayment(Request $request)
    {
        if (session()->has("verifyPayment")) {
            $flag = true;
            session()->forget("verifyPayment");
        } else {
            $flag = false;
        }

        if (!$flag)
            return redirect(action("HomeController@error403"));
        if ($request->has("result")) {
            $result = $request->get("result");
            return view('order.checkout.verification', compact('result'));
        } else {
            return redirect(action("HomeController@error403"));
        }
    }

    /**
     * Payments other than successful and failed
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    function otherPayment(Request $request)
    {
        if ($request->has("result")) {
            $result = $request->get("result");
            return view('order.checkout.verification', compact('result'));
        } else {
            abort(404);
            return null;
        }
    }

    /**
     * @return array
     */
    private function verifyZarinpal(): array
    {
        $zarinpal = new Zarinpal($this->transaction->transactiongateway->merchantNumber);
        $result = $zarinpal->verify($this->zarinpalStatus, $this->transaction->cost, $this->zarinpalAuthority);

        $this->zarinpalError = (strcmp(array_get($result, "Status"), 'error') == 0)? array_get($result, "error") : null;


        if (strcmp(array_get($result, "Status"), 'success') == 0) {
            $this->zarinpalStatus = 'success';
        } else if (strcmp(array_get($result, "Status"), 'canceled') == 0 ||
            (strcmp(array_get($result, "Status"), 'error') == 0 && (
                    strcmp(array_get($result, "error"), '-22') == 0 || //وارد درگاه بانک شده و انصراف زده
                    strcmp(array_get($result, "error"), '-21') == 0 // قبل از ورود به درگاه بانک در همان صفحه زرین پال انصراف زده
                ))) {
            $this->zarinpalStatus = 'canceled';
        } else {
            $this->zarinpalStatus = 'canceled';
        }

        /*if (Auth::user()
            ->hasRole("admin")) {
            $result["Status"] = "success";
            $result["RefID"] = "mohamad" . rand(0, 1000);
        }*/

        return $result;
    }

    /**
     * @param Order $order
     * @param array $result
     * @return array
     */
    private function givesOrderBonsToUser(Order $order, array $result): array
    {
        $bonName = config("constants.BON1");
        $bon = Bon::ofName($bonName)
            ->first();
        if (isset($bon)) {
            list($givenBonNumber, $failedBonNumber) = $order->giveUserBons($bonName);

            if ($givenBonNumber == 0)
                if ($failedBonNumber > 0)
                    $result = array_add($result, "saveBon", -1);
                else
                    $result = array_add($result, "saveBon", 0);
            else
                $result = array_add($result, "saveBon", $givenBonNumber);

            $bonDisplayName = $bon->displayName;
            $result = array_add($result, "bonName", $bonDisplayName);
        }
        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    private function updateOrderPaymentStatus(array $result): array
    {
        $orderUpdateStatus = $this->order->changePaymentStatusToPaidOrIndebted($this->transaction);

        if ($orderUpdateStatus)
            $result = array_add($result, "saveOrder", 1);
        else
            $result = array_add($result, "saveOrder", 0);
        return $result;
    }

    private function copyOrderWithOpenAndUnpaidStatus(): void
    {
        $request = new Request();
        $request->offsetSet("paymentstatus_id", config("constants.PAYMENT_STATUS_UNPAID"));
        $request->offsetSet("orderstatus_id", config("constants.ORDER_STATUS_OPEN"));
        $this->orderController->copy($this->order, $request);
    }


    /**
     * @param array $result
     * @return array
     */
    private function zarinpalHandleSuccessStatus(array $result): array
    {
        $this->transaction->changeStatusToSuccessfull($this->zarinpalRefId);

        /** Wallet transactions */
        $this->order->closeWalletPendingTransactions();
        /** End */
        $result = $this->updateOrderPaymentStatus($result);

        /** Attaching user bons for this order */
        $result = $this->givesOrderBonsToUser($this->order, $result);

        $result['sendSMS'] = true;
        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    private function zarinpalHandleCanceledStatus(array $result): array
    {
        $result['Status'] = 'canceled';

        if ($this->order->orderstatus_id == config("constants.ORDER_STATUS_OPEN")) {
            $result = $this->zarinpalCanceledStatusHandleOpenOrder($result);
        } else if ($this->order->orderstatus_id == config("constants.ORDER_STATUS_OPEN_DONATE")) {
            /*$updateStatus = $order->setCanceledAndUnpaid();*/
            $result["tryAgain"] = false;
        } else {
            $result = $this->zarinpalCanceledStatusHandleOtherTypeOrder($result);
        }
        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    private function zarinpalCanceledStatusHandleOpenOrder(array $result): array
    {
        $result["tryAgain"] = true;

        $updateStatus = $this->order->setCanceledAndUnpaid();

        $this->transaction->changeStatusToUnsuccessful();

        if ($updateStatus) {
            $this->copyOrderWithOpenAndUnpaidStatus();
        }/*else {
            last order is not closed and no action is necessary
        }*/
        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    private function zarinpalCanceledStatusHandleOtherTypeOrder(array $result): array
    {
        $result["tryAgain"] = false;

        $refundWalletTransactionResult = $this->order->refundWalletTransaction();
        $totalWalletRefund = $refundWalletTransactionResult['totalWalletRefund'];
        $closeOrderFlag = $refundWalletTransactionResult['closeOrderFlag'];

        if ($totalWalletRefund > 0) {
            $result["walletAmount"] = $totalWalletRefund;
            $result["walletRefund"] = true;
        }

        if ($closeOrderFlag) {
            $this->order->setCanceledAndUnpaid();
        }
        return $result;
    }

    /**
     * @param Request $request
     */
    private function zarinpalVerifyInit(Request $request): void
    {
        $this->zarinpalAuthority = $request->get('Authority');
        $this->zarinpalStatus = $request->get('Status');
        $this->transaction = Transaction::authority($this->zarinpalAuthority)->firstOrFail();
        $this->order = Order::FindorFail($this->transaction->order_id);
    }

    /**
     * @param Request $request
     * @param array $result
     * @return array
     */
    private function handleZarinpal(Request $request, array $result): array
    {
        $result['isAdminOrder'] = false;

        $this->zarinpalVerifyInit($request);

        $this->order->detachUnusedCoupon();

        $verifyZarinpalResult = $this->verifyZarinpal();

        if (!isset($verifyZarinpalResult)) {
            abort(Response::HTTP_NOT_FOUND);
        }

//        $this->zarinpalStatus = 'success';
//        $this->zarinpalAuthority = '000000000000000000000000000099314972';
//        $this->zarinpalRefId = '1';
//
//        $this->zarinpalStatus = 'canceled';
//        $this->zarinpalAuthority = '000000000000000000000000000099314972';
//        $this->zarinpalRefId = '1';

        if ($this->zarinpalStatus === 'success') {
            $result = $this->zarinpalHandleSuccessStatus($result);
        } else if ($this->zarinpalStatus === 'canceled') {
            $result = $this->zarinpalHandleCanceledStatus($result);
        }
        dd($result);
        return $result;
    }
}
