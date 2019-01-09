<?php

namespace App\Http\Controllers;

use App\Classes\Payment\RefinementRequest\RefinementRequest;
use App\Http\Requests\EditTransactionRequest;
use App\Order;
use App\Traits\OrderCommon;
use App\Transaction;
use App\Transactiongateway;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Zarinpal\Zarinpal;
use App\Bankaccount;
use App\Bon;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    use OrderCommon;

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

        dd($data);

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
            $this->zarinReqeust($order, (int)$cost, $description, $transaction);
        } else {
            session()->put("closedOrder_id", $order->id);
            return redirect(action("OrderController@verifyPayment"));
        }
        return redirect(action("HomeController@error404"));
    }

    /**
     * Making request to ZarinPal gateway
     * @param Order $order
     * @param int $cost
     * @param string $description
     * @param Transaction $transaction
     * @return mixed
     */
    protected function zarinReqeust(Order $order, int $cost, string  $description, Transaction $transaction)
    {
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $merchant = $zarinGate->merchantNumber;
        $zarinpal = new Zarinpal($merchant);
//        $zarinpal->enableSandbox(); // active sandbox mod for test env
//        $zarinpal->isZarinGate(); // active zarinGate mode

        //ToDo : putting verify url in .env or database
        $results = $zarinpal->request(action("PaymentController@verifyPayment"), (int)$cost, $description);

//        $answer = $zarinpal->request(action("OrderController@verifyPayment"), (int)$cost, $description);

        if (isset($results['Authority']) && strlen($results['Authority']) > 0) {

            $transactionController = new TransactionController();
            $request = new EditTransactionRequest();
            $request->offsetSet("authority", $results['Authority']);
            $request->offsetSet("transactiongateway_id", $zarinGate->id);
            $request->offsetSet("destinationBankAccount_id", 1);
            $request->offsetSet("paymentmethod_id", Config::get("constants.PAYMENT_METHOD_ONLINE"));
            $request->offsetSet("apirequest", true);
            $request->offsetSet("gateway", $zarinpal);
            $response = $transactionController->update($request, $transaction);
            if ($response->getStatusCode() == 200) {
                $zarinpal->redirect();
            }
            else {
                dd("مشکل در برقراری ارتباط با درگاه زرین پال");
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
     * Verify customer online payment after comming back from payment gateway
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyPayment(Request $request)
    {
        $sendSMS = false;
        $user = Auth::user();
        if ($request->has('Authority') && $request->has('Status')) {    // Come back from ZarinPal
            $result["isAdminOrder"] = false;
            $authority = $request->get('Authority');
            $status = $request->get('Status');

            $transaction = Transaction::where('authority', $authority)
                ->firstOrFail();
            $order = Order::FindorFail($transaction->order_id);

            $usedCoupon = $order->hasProductsThatUseItsCoupon();
            if (!$usedCoupon) {
                /** if order has not used coupon reverse it    */

                $order->detachCoupon();
            }

            $zarinpal = new Zarinpal($transaction->transactiongateway->merchantNumber);
            $result = $zarinpal->verify($status, $transaction->cost, $authority);

            //return $result["status"] = success / canceled
//            if (Auth::user()
//                ->hasRole("admin")) {
//                $result["Status"] = "success";
//                $result["RefID"] = "mohamad" . rand(0, 1000);
//            }
            if (!isset($result)) {
                abort(Response::HTTP_NOT_FOUND);
            }

            if (strcmp(array_get($result, "Status"), 'canceled') == 0 ||
                (strcmp(array_get($result, "Status"), 'error') == 0 && strcmp(array_get($result, "error"), '-22') == 0)) {
                dd('hi');
            }
            dd($result);

            if (strcmp(array_get($result, "Status"), 'success') == 0) {
                $user = $order->user;
                $transaction->transactionID = $result["RefID"];
                $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL");
                $transaction->completed_at = Carbon::now();
                $transaction->update();

                /** Wallet transactions */
                $order->closeWalletPendingTransactions();
                /** End */
                $order->close(Config::get("constants.PAYMENT_STATUS_PAID"));
                if ($transaction->cost < (int)$order->totalCost()) {
                    if ((int)$order->totalPaidCost() < (int)$order->totalCost())
                        $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_INDEBTED");
                }

                $order->timestamps = false;
                if ($order->update())
                    $result = array_add($result, "saveOrder", 1);
                else
                    $result = array_add($result, "saveOrder", 0);
                $order->timestamps = true;

                /** Attaching user bons for this order */
                $bonName = Config::get("constants.BON1");
                $bon = Bon::where("name", $bonName)
                    ->first();
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
                    $result = array_add($result, "bonName", $bonDisplayName);
                }

                $sendSMS = true;
            } else if (strcmp(array_get($result, "Status"), 'canceled') == 0 ||
                (strcmp(array_get($result, "Status"), 'error') == 0 && strcmp(array_get($result, "error"), '-22') == 0)) {

                $result["Status"] = 'canceled';
                $user = $order->user;
                if ($order->orderstatus_id == Config::get("constants.ORDER_STATUS_OPEN")) {
                    $result["tryAgain"] = true;

                    $order->close(Config::get("constants.PAYMENT_STATUS_UNPAID"), Config::get("constants.ORDER_STATUS_CANCELED"));
                    $order->timestamps = false;
                    if ($order->update()) {
                        $request = new Request();
                        $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
                        $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
                        $response = $this->copy($order, $request);
                    } else {
                        //last order is not closed and no action is necessary
                    }
                    $order->timestamps = true;
                } else if ($order->orderstatus_id == Config::get("constants.ORDER_STATUS_OPEN_DONATE")) {
                    //                    $order->close( Config::get("constants.PAYMENT_STATUS_UNPAID"),Config::get("constants.ORDER_STATUS_CANCELED")) ;
                    //                    $order->timestamps = false;
                    //                    $order->update();
                    //                    $order->timestamps = true;
                    $result["tryAgain"] = false;
                } else {
                    $result["tryAgain"] = false;
                    $walletTransactions = $order->suspendedTransactions
                        ->where("paymentmethod_id", config("constants.PAYMENT_METHOD_WALLET"));
                    $totalWalletRefund = 0;
                    $closeOrderFlag = false;
                    foreach ($walletTransactions as $transaction) {
                        $wallet = $transaction->wallet;
                        $amount = $transaction->cost;
                        if (isset($wallet)) {
                            $response = $wallet->deposit($amount);
                            if ($response["result"]) {
                                $transaction->delete();
                                $totalWalletRefund += $amount;
                            } else {

                            }
                        } else {
                            $response = $user->deposit($amount, config("constants.WALLET_TYPE_GIFT"));
                            if ($response["result"]) {
                                $transaction->delete();
                                $totalWalletRefund += $amount;
                            } else {

                            }
                        }
                        $closeOrderFlag = true;

                    }
                    if ($totalWalletRefund > 0) {
                        $result["walletAmount"] = $totalWalletRefund;
                        $result["walletRefund"] = true;
                    }

                    if ($closeOrderFlag) {
                        $order->close(Config::get("constants.PAYMENT_STATUS_UNPAID"), Config::get("constants.ORDER_STATUS_CANCELED"));
                        $order->timestamps = false;
                        $order->update();
                        $order->timestamps = true;
                    }
                }
            }
        } else {
            $result = [];
            if (session()->has("adminOrder_id")) {
                $result["isAdminOrder"] = true;

                if (!$user->can(Config::get('constants.INSERT_ORDER_ACCESS')))
                    return redirect(action("HomeController@error403"));

                $order_id = session()->get("adminOrder_id");
                $order = Order::FindorFail($order_id);

                $result["customer_firstName"] = session()->get("customer_firstName");
                $result["customer_lastName"] = session()->get("customer_lastName");
                session()->forget("adminOrder_id");
                session()->forget("customer_id");
                session()->forget("customer_firstName");
                session()->forget("customer_lastName");
            } else if (session()->has("closedOrder_id")) {
                $result["isAdminOrder"] = false;

                $order_id = session()->get("closedOrder_id");
                session()->forget("closedOrder_id");
                $order = Order::FindorFail($order_id);

                if ($order->user->id != $user->id)
                    abort(403);
            } else if (session()->has("order_id")) {
                $result["isAdminOrder"] = false;

                $order_id = session()->get("order_id");
                session()->forget("order_id");
                $order = Order::FindorFail($order_id);

                if ($order->orderstatus_id != Config::get("constants.ORDER_STATUS_OPEN"))
                    abort(403);
                if ($order->user->id != $user->id)
                    abort(403);
            } else {
                abort(404);
            }

            if ($order->orderproducts->isEmpty())
                return redirect(action("OrderController@checkoutReview"));

            if ($request->has("customerDescription")) {
                $customerDescription = $request->get("customerDescription");
                $order->customerDescription = $customerDescription;
            }
            if ($request->has('paymentmethod')) {
                $paymentMethod = $request->get('paymentmethod');

                $usedCoupon = $order->hasProductsThatUseItsCoupon();
                if (!$usedCoupon) {
                    /** if order has not used coupon reverse it    */
                    $order->detachCoupon();
                }

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

                $order->close(Config::get("constants.PAYMENT_STATUS_UNPAID"));
                $order->timestamps = false;
                if ($order->update())
                    $result = array_add($result, "saveOrder", 1);
                else
                    $result = array_add($result, "saveOrder", 0);
                $order->timestamps = true;
                $sendSMS = true;

            } else {
                /** Wallet transactions */
                $order->closeWalletPendingTransactions();
                /** End */
                $cost = $order->totalCost() - $order->totalPaidCost();

                if ($cost == 0 &&
                    (isset($order->cost) || isset($order->costwithoutcoupon))) {
                    $order->close(Config::get("constants.PAYMENT_STATUS_PAID"));
                    $order->timestamps = false;
                    if ($order->update())
                        $result = array_add($result, "saveOrder", 1);
                    else
                        $result = array_add($result, "saveOrder", 0);
                    $order->timestamps = true;
                    /** Attaching user bons for this order */
                    $bonName = Config::get("constants.BON1");
                    $bon = Bon::where("name", $bonName)
                        ->first();
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
                        $result = array_add($result, "bonName", $bonDisplayName);
                    }
                    $result["Status"] = "freeProduct";
                    $sendSMS = true;
                }
            }
        }

        /**
         * Sending SMS to Ordoo 97 customers
         */
        if ($sendSMS && isset($order)) {
            $user = $order->user;
            $order = $order->fresh();
            $user->notify(new InvoicePaid($order));
            Cache::tags('bon')
                ->flush();
        }


        if (isset($result["Status"])) {
            if (isset($result["RefID"]) || strcmp($result["Status"], 'freeProduct') == 0) {
                session()->put("verifyPayment", 1);
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
     *  Payments other than successful and failed
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    function otherPayment(Request $request)
    {
        if ($request->has("result")) {
            $result = $request->get("result");
            return view('order.checkout.verification', compact('result'));
        } else {
            abort(404);
        }
    }
}
