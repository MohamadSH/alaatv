<?php

namespace App\Http\Controllers;

use App\Bon;
use App\User;
use App\Order;
use Carbon\Carbon;
use App\Transaction;
use Zarinpal\Zarinpal;
use App\Transactiongateway;
use App\Traits\OrderCommon;
use App\Notifications\InvoicePaid;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Cache;
use App\Classes\Payment\RefinementRequest\Refinement;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;
use App\Classes\Payment\RefinementRequest\Strategies\{OpenOrderRefinement, OrderIdRefinement, TransactionRefinement};

class OnlinePaymentController extends Controller
{
    use OrderCommon;

    private $orderController;
    private $transactionController;

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

    /**
     * @var Refinement
     */
    private $refinementRequest;

    /**
     * @var int
     */
    private $cost;
    /**
     * @var int
     */
    private $donateCost;
    /**
     * @var string
     */
    private $description;

    private $zarinpalCardPanHash;
    private $zarinpalAuthority;
    private $zarinpalStatus;
    private $zarinpalRefId;
    private $zarinpalError;

    public function __construct(OrderController $orderController, TransactionController $transactionController)
    {
        $this->orderController = $orderController;
        $this->transactionController = $transactionController;
    }

    /**
     * @param Request $request
     * @param string $paymentMethod
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentRedirect(Request $request, string $paymentMethod)
    {
//        $request->offsetSet("order_id", 137);
//        $request->offsetSet("transaction_id", 65);
        $request->offsetSet("payByWallet", true);

        $refinementRequestStrategy = $this->gteRefinementRequestStrategy($request);

        $inputData = $request->all();
        $inputData['transactionController'] = $this->transactionController;
        $inputData['user'] = $request->user();
        $data = $this->launchRefinementRequest($inputData, $refinementRequestStrategy);

        if($data['statusCode']!=Response::HTTP_OK) {
            return response()->json([
                'error' => $data['message']
            ], $data['statusCode']);
        }

        $this->setDescription();

        $this->setCustomerDescription($request);

        if ($request->has("payByWallet")) {
            $remainedCost = $this->payByWallet();
            $this->cost = (int)$remainedCost;
        }

        if ($this->isRedirectable()) {
            if($paymentMethod == 'zarinpal') {
//                $this->zarinRequest();

                return response($this->zarinRequest())
                    ->withHeaders([
                        'laravel_session' => 'eyJpdiI6IkdtMWVuNklOU2xOdHJiY3g1Nmt5cGc9PSIsInZhbHVlIjoiTW02NWJkWXZFaDAzMGdYUTZvaHFoM1VNRExwM3F5ZDFTVFwvYmZsdDk0OSthM0hMa2RQa3pXWXZkMmJJU2djWVgiLCJtYWMiOiJkYmU1NGM3MGNhODk2MzU5NzA1MWE1NTU3NDZkNTAzMjI0NTMzYjdmMTFhZjk3ZjI2NTg0MjdlNmRmN2UxMWU0In0%3D',
                        'XSRF-TOKEN' => 'eyJpdiI6IkpxQ0NhbnEyQkRqZEI5Q1lJWDQ2NkE9PSIsInZhbHVlIjoicURORzNSK1VWcDcydDlNTGN5a0NpUFhhdWh5N0RTTWFhQ25ha1N5aXZqd2YrTTdvdFRiK015SUdua20wY3hEQSIsIm1hYyI6ImQwMmExODlhZmRjZWNlMmI3NTY1MzNmODUxNmVjY2Q3MjZiNzdmZmE3M2YwN2E5YmU4YzZkMDcwMjNiNTQ0NTgifQ%3D%3D',
                    ]);

            }
            return redirect(action("HomeController@error404"));
        } else {
            return redirect(action('OnlinePaymentController@verifyPayment', ['type' => 'offline', 'paymentMethod' => 'wallet', 'coi' => $this->order->id]));
        }
    }

    /**
     * @return bool
     */
    private function isRedirectable() {
        if ($this->cost > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Making request to ZarinPal gateway
     * @return mixed
     */
    protected function zarinRequest()
    {
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $merchant = $zarinGate->merchantNumber;
        $zarinpal = new Zarinpal($merchant);
        $zarinpal->enableSandbox(); // active sandbox mod for test env
        $zarinpal->isZarinGate(); // active zarinGate mode

        //ToDo : putting verify url in .env or database
        $results = $zarinpal->request(action('OnlinePaymentController@verifyPayment', ['type' => 'online', 'paymentMethod' => 'zarinpal']), (int)$this->transaction->cost, $this->description);

//        $answer = $zarinpal->request(action("OrderController@verifyPayment"), (int)$cost, $description);

        if (isset($results['Authority']) && strlen($results['Authority']) > 0) {
            $data["apirequest"] = true;
            $data["gateway"] = $zarinpal;
            $data["destinationBankAccount_id"] = 1;
            $data["authority"] = $results['Authority'];
            $data["transactiongateway_id"] = $zarinGate->id;
            $data["paymentmethod_id"] = config("constants.PAYMENT_METHOD_ONLINE");
            $result = $this->transactionController->modify($this->transaction, $data);
            if ($result['statusCode'] == Response::HTTP_OK) {
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

    private function setDescription()
    {
        $this->description .= "آلاء - " . $this->user->mobile . " - محصولات: ";

        $orderProducts = $this->order->orderproducts;
        foreach ($orderProducts as $orderProduct) {
            if (isset($orderProduct->product->id))
                $this->description .= $orderProduct->product->name . " , ";
            else
                $this->description .= "یک محصول نامشخص , ";
        }
    }

    /**
     * @return int
     */
    private function payByWallet(): int
    {
        $deductibleCostFromWallet = $this->cost - $this->donateCost;
        $remainedCost = $deductibleCostFromWallet;
        $walletPayResult = $this->payOrderCostByWallet($this->user, $this->order, $deductibleCostFromWallet);
        if ($walletPayResult["result"]) {
            $remainedCost = $walletPayResult["cost"];

            $this->order->close(config("constants.PAYMENT_STATUS_INDEBTED"));
            //ToDo : use updateWithoutTimestamp
            $this->order->timestamps = false;
            $this->order->update();
            $this->order->timestamps = true;
        }
        $remainedCost = $remainedCost + $this->donateCost;
        return $remainedCost;
    }

    /**
     * @param Request $request
     */
    private function setCustomerDescription(Request $request): void
    {
        if ($request->has("customerDescription")) {
            $customerDescription = $request->get("customerDescription");
            $this->order->customerDescription = $customerDescription;
            //ToDo : use updateWithoutTimestamp
            $this->order->timestamps = false;
            $this->order->update();
            $this->order->timestamps = true;

        }
    }

    /**
     * Verify customer online payment after coming back from payment gateway
     * @param string $paymentMethod
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(string $paymentMethod, Request $request)
    {
        $result = [
            'sendSMS' => false,
            'Status' => 'error'
        ];

        if($paymentMethod=='zarinpal') {
            $result = $this->handleZarinpal($request, $result);
        }

        $sendSMS = $result['sendSMS'];
        if ($sendSMS && isset($this->order)) {
            $user = $this->order->user;
            $this->order = $this->order->fresh();
            $user->notify(new InvoicePaid($this->order));
            Cache::tags('bon')->flush();
        }

        $request->session()->flash('result', $result);

        if (isset($result['transactionID'])) {
            $status = 'successful';
        } else {
            $status = 'failed';
        }

        //'Status'(index) going to be 'success', 'error' or 'canceled'
        return redirect(action("OnlinePaymentController@showPaymentStatus", [
            'status' => $status,
            'paymentMethod' => $paymentMethod
        ]));
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
        $zarinpal->enableSandbox();
        $result = $zarinpal->verify($this->zarinpalStatus, $this->transaction->cost, $this->zarinpalAuthority);
        $this->zarinpalError = (strcmp($result['Status'], 'error') == 0)? $result['error'] : null;

        if (isset($result['RefID']) && strcmp($result['Status'], 'success') == 0) {
            $this->zarinpalRefId = $result['RefID'];
            $this->zarinpalStatus = 'success';
            $this->zarinpalCardPanHash = $result['ExtraDetail']['Transaction']['CardPanHash'];
        } else if (strcmp($result['Status'], 'canceled') == 0 ||
            (strcmp($result['Status'], 'error') == 0 && (
                    strcmp($result['error'], '-22') == 0 || //وارد درگاه بانک شده و انصراف زده
                    strcmp($result['error'], '-21') == 0 // قبل از ورود به درگاه بانک در همان صفحه زرین پال انصراف زده
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
        $paymentstatus_id = null;
        if ((int)$this->order->totalPaidCost() < (int)$this->order->totalCost())
            $paymentstatus_id = config("constants.PAYMENT_STATUS_INDEBTED");
        else
            $paymentstatus_id = config("constants.PAYMENT_STATUS_PAID");
        $this->order->close($paymentstatus_id);

        //ToDo : use updateWithoutTimestamp
        $this->order->timestamps = false;
        $orderUpdateStatus = $this->order->update();
        $this->order->timestamps = true;


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
        $this->changeTransactionStatusToSuccessful();

        $this->order->closeWalletPendingTransactions();

        $result = $this->updateOrderPaymentStatus($result);

        /** Attaching user bons for this order */
        $result = $this->givesOrderBonsToUser($this->order, $result);

        $result['transactionID'] = $this->zarinpalRefId;
        $result['sendSMS'] = true;
        $result['Status'] = 'success';
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
            /*$order->close(config("constants.PAYMENT_STATUS_UNPAID"), config("constants.ORDER_STATUS_CANCELED"));
            //ToDo : use updateWithoutTimestamp
            $order->timestamps = false;
            $updateStatus = $order->update();
            $order->timestamps = true;*/
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

        $this->order->close(config("constants.PAYMENT_STATUS_UNPAID"), config("constants.ORDER_STATUS_CANCELED"));
        //ToDo : use updateWithoutTimestamp
        $this->order->timestamps = false;
        $updateStatus = $this->order->update();
        $this->order->timestamps = true;

        $this->changeTransactionStatusToUnsuccessful();

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
            $this->order->close(config("constants.PAYMENT_STATUS_UNPAID"), config("constants.ORDER_STATUS_CANCELED"));
            //ToDo : use updateWithoutTimestamp
            $this->order->timestamps = false;
            $this->order->update();
            $this->order->timestamps = true;
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

        if ($this->zarinpalStatus === 'success') {
            $result = $this->zarinpalHandleSuccessStatus($result);
        } else if ($this->zarinpalStatus === 'canceled') {
            $result = $this->zarinpalHandleCanceledStatus($result);
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return Refinement
     */
    private function gteRefinementRequestStrategy(Request $request): Refinement
    {
        if ($request->has('transaction_id')) { // closed order
            return new TransactionRefinement();
        } else if ($request->has('order_id')) { // closed order
            return new OrderIdRefinement();
        } else { // open order
            return new OpenOrderRefinement();
        }
    }

    private function changeTransactionStatusToSuccessful(): void
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionID'] = $this->zarinpalRefId;
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
        $this->transactionController->modify($this->transaction, $data);
    }

    private function changeTransactionStatusToUnsuccessful(): void
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_UNSUCCESSFUL");
        $this->transactionController->modify($this->transaction, $data);
    }

    /**
     * @param array $inputData
     * @param Refinement $refinementRequestStrategy
     * @return array
     */
    private function launchRefinementRequest(array $inputData, Refinement $refinementRequestStrategy): array
    {
        $this->refinementRequest = new RefinementLauncher($inputData, $refinementRequestStrategy);
        $data = $this->refinementRequest->getData();

        $this->user = $data['user'];
        $this->order = $data['order'];
        $this->cost = (int)$data['cost'];
        $this->donateCost = $data['donateCost'];
        $this->transaction = $data['transaction'];
        $this->description = $data['description'];
        return $data;
    }

    /**
     * @param Request $request
     * @param string $status
     * @param string $paymentMethod
     */
    public function showPaymentStatus(Request $request, string $status, string $paymentMethod) {
        $result = $request->session()->get('result');
        dd([
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'result' => $result
        ]);
    }
}
