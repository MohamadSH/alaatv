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

    /**
     * @var OrderController
     */
    private $orderController;

    /**
     * @var TransactionController
     */
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
     * @var int
     */
    private $paidFromWalletCost;
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $device;

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
     * @param string $device
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentRedirect(string $paymentMethod, string $device, Request $request)
    {
//        $request->offsetSet("order_id", 137);
//        $request->offsetSet("transaction_id", 65);
        $request->offsetSet("payByWallet", true);

        $this->device = $device;

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

        if ($this->isRedirectable()) {
            if($paymentMethod == 'zarinpal') {
                $this->zarinRequest();
            }
            return redirect(action("HomeController@error404"));
        } else {
            return redirect(action('OfflinePaymentController@verifyPayment', ['device' => $device, 'paymentMethod' => 'wallet', 'coi' => $this->order->id]));
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
        $results = $zarinpal->request(action('OnlinePaymentController@verifyPayment', ['paymentMethod' => 'zarinpal', 'device' => $this->device]), (int)$this->transaction->cost, $this->description);

//        $answer = $zarinpal->request(action("OrderController@verifyPayment"), (int)$cost, $description);

        if (isset($results['Authority']) && strlen($results['Authority']) > 0) {
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
     * @param string $device
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(string $paymentMethod, string $device, Request $request)
    {
        $result = [
            'sendSMS' => false,
            'Status' => 'error'
        ];

        $this->device = $device;

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
            'paymentMethod' => $paymentMethod,
            'device' => $device
        ]));
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

        $this->order->close(config("constants.PAYMENT_STATUS_UNPAID"), config("constants.ORDER_STATUS_CANCELED"));
        //ToDo : use updateWithoutTimestamp
        $this->order->timestamps = false;
        $this->order->update();
        $this->order->timestamps = true;

        $this->transaction->transactionstatus_id = config("constants.TRANSACTION_STATUS_UNSUCCESSFUL");
        $this->transaction->update();

        $totalWalletRefund = $this->order->refundWalletTransaction();

        if ($totalWalletRefund > 0) {
            $result['walletAmount'] = $totalWalletRefund;
            $result['walletRefund'] = true;
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
     * @param string $status
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     */
    public function showPaymentStatus(string $status, string $paymentMethod, string $device, Request $request) {
        $result = $request->session()->get('result');
        $this->device = $device;
        dd([
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'result' => $result
        ]);
    }
}
