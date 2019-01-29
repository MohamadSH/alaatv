<?php

namespace App\Http\Controllers;

use Cache;
use App\Bon;
use App\User;
use App\Order;
use Carbon\Carbon;
use App\Transaction;
use App\Bankaccount;
use App\Traits\OrderCommon;
use App\Transactiongateway;
use Illuminate\Http\{Request, Response};
use App\Classes\Payment\Gateway\GatewayFactory;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;
use App\Classes\Payment\RefinementRequest\Refinement;
use App\Classes\Payment\RefinementRequest\Strategies\
{OpenOrderRefinement, OrderIdRefinement, TransactionRefinement, ChargingWalletRefinement};

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

    public function __construct(OrderController $orderController, TransactionController $transactionController)
    {
        $this->orderController = $orderController;
        $this->transactionController = $transactionController;
    }

    /**********************************************************
     * Redirect
     ***********************************************************/

    /**
     * @param Request $request
     * @param string $paymentMethod
     * @param string $device
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentRedirect(string $paymentMethod, string $device, Request $request)
    {
        /*$request->offsetSet('order_id', 137);*/
        /*$request->offsetSet('transaction_id', 65);*/
//        $request->offsetSet('payByWallet', true);

//        $request->offsetSet('walletId', 1);
//        $request->offsetSet('walletChargingAmount', 50000);

        $transactiongateway = Transactiongateway::where('name', $paymentMethod)->first();
        if(!isset($transactiongateway)) {
            return response()->json([
                'error' => 'اطلاعات درگاه مورد نظر یافت نشد.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $inputData = $request->all();
        $inputData['transactionController'] = $this->transactionController;
        $inputData['user'] = $request->user();

        $refinementLauncher = new RefinementLauncher($this->gteRefinementRequestStrategy($inputData));
        $data = $refinementLauncher->getData($inputData);

        /** @var User $user */
        $user = $data['user'];
        /** @var Order $order */
        $order = $data['order'];
        /** @var int $cost */
        $cost = (int)$data['cost'];
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];
        /** @var string $description */
        $description = $data['description'];

        if($data['statusCode']!=Response::HTTP_OK) {
            return response()->json([
                'error' => $data['message']
            ], $data['statusCode']);
        }

        $description = $this->setTransactionDescription($description, $user, $order);

        if(isset($order)) {
            $this->setCustomerDescriptionForOrder($request, $order);
        }

        if ($this->isRedirectable($cost)) {

            $callbackUrl = action('OnlinePaymentController@verifyPayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);

            $gateWay = (new GatewayFactory())->setGateway($paymentMethod, $this->setDataForGateway($transactiongateway, $paymentMethod));
            $paymentRequestData = [
                'amount'=>$cost,
                'callbackUrl'=>$callbackUrl,
                'description'=>$description
            ];
            $result = $gateWay->paymentRequest($paymentRequestData);

            if ($result['status']) {

                $transactionModifyResult = $this->setAuthorityForTransaction($result['data']['Authority'], $transactiongateway->id, $transaction);

                if ($transactionModifyResult['statusCode'] == Response::HTTP_OK) {
                    $gateWay->redirect([]);
                } else {
                    return response()->json([
                        'message' => 'مشکلی در ویرایش تراکنش رخ داده است.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                return response()->json([
                    'message' => $result['message']
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            return redirect(action('HomeController@error404'));
        } else {
            return redirect(action('OfflinePaymentController@verifyPayment', ['device' => $device, 'paymentMethod' => 'wallet', 'coi' => (isset($order)?$order->id:null)]));
        }
    }

    /**
     * @param int $cost
     * @return bool
     */
    private function isRedirectable(int $cost) {
        if ($cost > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $description
     * @param User $user
     * @param Order|null $order
     * @return string
     */
    private function setTransactionDescription(string $description, User $user, Order $order=null): string
    {
        $description .= 'آلاء - ' . $user->mobile . ' - محصولات: ';

        if(isset($order)) {
            $orderProducts = $order->orderproducts->load('product');

            foreach ($orderProducts as $orderProduct) {
                if (isset($orderProduct->product->id))
                    $description .= $orderProduct->product->name . ' , ';
                else
                    $description .= 'یک محصول نامشخص , ';
            }
        }

        return $description;
    }

    /**
     * @param Request $request
     * @param Order $order
     */
    private function setCustomerDescriptionForOrder(Request $request, Order $order): void
    {
        $order->customerDescription = optional($request->get('customerDescription'));
    }

    /**
     * @param string $authority
     * @param int $transactiongatewayId
     * @param Transaction $transaction
     * @return array
     */
    private function setAuthorityForTransaction(string $authority, int $transactiongatewayId, Transaction $transaction): array
    {
        $data['destinationBankAccount_id'] = 1; // ToDo: Hard Code
        $data['authority'] = $authority;
        $data['transactiongateway_id'] = $transactiongatewayId;
        $data['paymentmethod_id'] = config('constants.PAYMENT_METHOD_ONLINE');
        $transactionModifyResult = $this->transactionController->modify($transaction, $data);
        return $transactionModifyResult;
    }

    /**
     * @param array $inputData
     * @return Refinement
     */
    private function gteRefinementRequestStrategy(array $inputData): Refinement
    {
        if (isset($inputData['transaction_id'])) { // closed order
            return new TransactionRefinement();
        } else if (isset($inputData['order_id'])) { // closed order
            return new OrderIdRefinement();
        } else if (isset($inputData['walletId']) && isset($inputData['walletChargingAmount'])) { // Charging Wallet
            return new ChargingWalletRefinement();
        } else { // open order
            return new OpenOrderRefinement();
        }
    }

    /**********************************************************
     * VerifyPayment
    ***********************************************************/

    /**
     * Verify customer online payment after coming back from payment gateway
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(string $paymentMethod, string $device, Request $request)
    {
        $transactiongateway = Transactiongateway::where('name', $paymentMethod)->first();
        if(!isset($transactiongateway)) {
            return response()->json([
                'error' => 'اطلاعات درگاه مورد نظر یافت نشد.'
            ], Response::HTTP_BAD_REQUEST);
        }


        $gateWay = (new GatewayFactory())->setGateway($paymentMethod, $this->setDataForGateway($transactiongateway, $paymentMethod));
        $callbackData = $gateWay->readCallbackData($request->all());
        $authority = $callbackData['data']['Authority'];

        $transaction = Transaction::authority($authority)->first();

        if(!isset($transaction)) {
            return response()->json([
                'error' => 'تراکنشی متناظر با شماره تراکنش ارسالی یافت نشد.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $verifyResult = [];

        $data = $request->all();
        $dataForGatewayVerify = $this->setDataForGatewayVerify($paymentMethod, $transaction);
        $data = array_merge($data, $dataForGatewayVerify);
        $gateWayVerify = $gateWay->verify($data);
        $verifyResult['gateWayVerify'] = $gateWayVerify;

        if (isset($transaction->order_id)) {
            $transaction->order->detachUnusedCoupon();
            if ($gateWayVerify['status']) {
                $verifyResult['OrderSuccessPaymentResult'] = $this->handleOrderSuccessPayment($gateWayVerify['data']['RefID'], $transaction, $gateWayVerify['data']['cardPanMask']);
            } else {
                $verifyResult['OrderCanceledPaymentResult'] = $this->handleOrderCanceledPayment($transaction);
            }
        } else if (isset($transaction->wallet_id)) {
            if ($gateWayVerify['status']) {
                $this->handleWalletChargingSuccessPayment($gateWayVerify['data']['RefID'], $transaction, $gateWayVerify['data']['cardPanMask']);
            } else {
                $this->handleWalletChargingCanceledPayment($transaction);
            }
        }



//        if ($result['status'] && isset($result['data']['order'])) {
//            /** @var Order $order */
//            $order = $result['data']['order'];
//            optional($order->user)->notify(new InvoicePaid($order));
//        }

        Cache::tags('bon')->flush();

        $request->session()->flash('verifyResult', $verifyResult);

        return redirect(action('OnlinePaymentController@showPaymentStatus', [
            'status' => ($gateWayVerify['status'])?'successful':'failed',
            'paymentMethod' => $paymentMethod,
            'device' => $device
        ]));
    }

    /**
     * @param string $refId
     * @param Transaction $transaction
     * @param string|null $cardPanMask
     */
    private function handleWalletChargingSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask=null): void
    {
        $bankAccountId = null;

        if(isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber'=>$cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }

        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);

        $transaction->wallet->deposit($transaction->cost*(-1), true);
    }

    /**
     * @param Transaction $transaction
     */
    private function handleWalletChargingCanceledPayment(Transaction $transaction): void
    {
        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();
    }

    /**
     * @param string $refId
     * @param Transaction $transaction
     * @param string|null $cardPanMask
     * @return array
     */
    private function handleOrderSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask=null): array
    {
        $bankAccountId = null;

        if(isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber'=>$cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }

        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);

        $transaction->order->closeWalletPendingTransactions();

        $updateOrderPaymentStatusResult = $this->updateOrderPaymentStatus($transaction);

        /** Attaching user bons for this order */
        $givesOrderBonsToUserResult = $this->givesOrderBonsToUser($transaction);

        return array_merge($updateOrderPaymentStatusResult, $givesOrderBonsToUserResult);
    }

    /**
     * @param Transaction $transaction
     * @return array
     */
    private function handleOrderCanceledPayment(Transaction $transaction): array
    {
        $result = [];
        $transaction->order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
        $transaction->order->updateWithoutTimestamp();

        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();

        $totalWalletRefund = $transaction->order->refundWalletTransaction();

        if ($totalWalletRefund > 0) {
            $result['walletAmount'] = $totalWalletRefund;
            $result['walletRefund'] = true;
        } else {
            $result['walletAmount'] = 0;
            $result['walletRefund'] = false;
        }

        return $result;
    }

    /**
     * @param string $transactionID
     * @param Transaction $transaction
     * @param int|null $bankAccountId
     */
    protected function changeTransactionStatusToSuccessful(string $transactionID, Transaction $transaction, int $bankAccountId = null): void
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionID'] = $transactionID;
        $data['destinationBankAccount_id'] = $bankAccountId;
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
        $this->transactionController->modify($transaction, $data);
    }

    /**
     * @param Transaction $transaction
     * @return array
     */
    protected function givesOrderBonsToUser(Transaction $transaction): array
    {
        $result = [];
        $bonName = config('constants.BON1');
        $bon = Bon::ofName($bonName)->first();

        if (isset($bon)) {
            list($givenBonNumber, $failedBonNumber) = $transaction->order->giveUserBons($bonName);
            if ($givenBonNumber == 0) {
                if ($failedBonNumber > 0) {
                    $result['saveBon'] = -1;
                }
                else {
                    $result['saveBon'] = 0;
                }
            }
            else {
                $result['saveBon'] = $givenBonNumber;
            }

            $bonDisplayName = $bon->displayName;
            $result['bonName'] = $bonDisplayName;
        }
        return $result;
    }

    /**
     * @param Transaction $transaction
     * @return array
     */
    protected function updateOrderPaymentStatus(Transaction $transaction): array
    {
        $result = [];
        $paymentstatus_id = null;
        if ((int)$transaction->order->totalPaidCost() < (int)$transaction->order->totalCost())
            $paymentstatus_id = config('constants.PAYMENT_STATUS_INDEBTED');
        else
            $paymentstatus_id = config('constants.PAYMENT_STATUS_PAID');
        $transaction->order->close($paymentstatus_id);
        $orderUpdateStatus = $transaction->order->updateWithoutTimestamp();

        if ($orderUpdateStatus) {
            $result['saveOrder'] = 1;
        } else {
            $result['saveOrder'] = 0;
        }
        return $result;
    }

    /**
     * @param Transactiongateway $transactiongateway
     * @param string $paymentMethod
     * @return array
     */
    private function setDataForGateway(Transactiongateway $transactiongateway, string $paymentMethod): array {
        $data = [];
        switch ($paymentMethod) {
            case 'zarinpal':
                $data['merchantID'] = $transactiongateway->merchantNumber;
                break;
            default:
                // zarinpal
                $data['merchantID'] = $transactiongateway->merchantNumber;
        }
        return $data;
    }

    /**
     * @param string $paymentMethod
     * @param Transaction $transaction
     * @return array
     */
    private function setDataForGatewayVerify(string $paymentMethod, Transaction $transaction): array {
        $data = [];
        switch ($paymentMethod) {
            case 'zarinpal':
                $data['amount'] = isset($transaction->wallet_id)?($transaction->cost*-1):$transaction->cost;
                break;
            default:
                // zarinpal
                $data['amount'] = isset($transaction->wallet_id)?($transaction->cost*-1):$transaction->cost;
        }
        return $data;
    }

    /**
     * @param string $status
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return void
     */
    public function showPaymentStatus(string $status, string $paymentMethod, string $device, Request $request) {
        $result = $request->session()->get('verifyResult');
        dd([
            'status' => $status,
            'status' => csrf_token(),
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'verifyResult' => $result
        ]);
    }
}
