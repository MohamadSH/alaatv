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
use App\Classes\Payment\GateWay\GateWayFactory;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;

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
        $request->offsetSet('payByWallet', true);

        $request->offsetSet('walletId', 1);
        $request->offsetSet('walletChargingAmount', 50000);

        $transactiongateway = Transactiongateway::where('name', $paymentMethod)->first();
        if(!isset($transactiongateway)) {
            return response()->json([
                'error' => 'اطلاعات درگاه مورد نظر یافت نشد.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $inputData = $request->all();
        $inputData['transactionController'] = $this->transactionController;
        $inputData['user'] = $request->user();

        $refinementLauncher = new RefinementLauncher();
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

        $description = $this->setTransactionDescription($description, $order, $user);

        if(isset($order)) {
            $this->setCustomerDescriptionForOrder($request, $order);
        }

        if ($this->isRedirectable($cost)) {

            $callbackUrl = action('OnlinePaymentController@verifyPayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);

            $gateWay = (new GateWayFactory())->setGateWay($paymentMethod, $transactiongateway->merchantNumber);
            $result = $gateWay->paymentRequest($cost, $callbackUrl, $description);

            if ($result['status']) {

                $transactionModifyResult = $this->setAuthorityForTransaction($result['data']['Authority'], $transactiongateway->id, $transaction);

                if ($transactionModifyResult['statusCode'] == Response::HTTP_OK) {
                    $gateWay->redirect();
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
     * @param Order|null $order
     * @param User $user
     * @return string
     */
    private function setTransactionDescription(string $description, Order $order=null, User $user): string
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
        $order->customerDescription = optional($request->customerDescription);
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

        $gateWay = (new GateWayFactory())->setGateWay($paymentMethod, $transactiongateway->merchantNumber);
        $callbackData = $gateWay->getCallbackData();
        $authority = $callbackData['Authority'];

        $transaction = Transaction::authority($authority)->first();

        if(!isset($transaction)) {
            return response()->json([
                'error' => 'تراکنشی متناظر با شماره تراکنش ارسالی یافت نشد.'
            ], Response::HTTP_BAD_REQUEST);
        }

        if (isset($transaction->order_id)) {
            $gateWayVerify = $gateWay->verify($transaction->cost);
            $transaction->order->detachUnusedCoupon();
            if ($gateWayVerify['status']) {
                $this->handleOrderSuccessPayment($gateWayVerify['data']['RefID'], $transaction, $gateWayVerify['data']['cardPanMask']);
            } else {
                $this->handleOrderCanceledPayment($transaction);
            }
        } else if (isset($transaction->wallet_id)) {
            $gateWayVerify = $gateWay->verify($transaction->cost*(-1));
            if ($gateWayVerify['status']) {
                $transaction->wallet->deposit($transaction->cost*(-1), true);
            }
        }



//        if ($result['status'] && isset($result['data']['order'])) {
//            /** @var Order $order */
//            $order = $result['data']['order'];
//            optional($order->user)->notify(new InvoicePaid($order));
//        }

        Cache::tags('bon')->flush();

        $request->session()->flash('gateWayVerify', $gateWayVerify);

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
    private function handleOrderSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask=null): void
    {
        $bankAccountId = null;

        if(isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber'=>$cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }

        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);

        $transaction->order->closeWalletPendingTransactions();

        $this->updateOrderPaymentStatus($transaction);

        /** Attaching user bons for this order */
        $this->givesOrderBonsToUser($transaction);

        $this->result['status'] = true;
        $this->result['message'][] = 'تراکنش با موفقیت انجام شد.';
        $this->result['data']['transactionID'] = $refId;
    }

    /**
     * @param Transaction $transaction
     */
    private function handleOrderCanceledPayment(Transaction $transaction): void
    {
        $this->result['status'] = false;

        $transaction->order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
        //ToDo : use updateWithoutTimestamp
        $transaction->order->timestamps = false;
        $transaction->order->update();
        $transaction->order->timestamps = true;

        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();

        $totalWalletRefund = $transaction->order->refundWalletTransaction();

        if ($totalWalletRefund > 0) {
            $this->result['data']['walletAmount'] = $totalWalletRefund;
            $this->result['data']['walletRefund'] = true;
        }
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
     */
    protected function givesOrderBonsToUser(Transaction $transaction): void
    {
        $bonName = config('constants.BON1');
        $bon = Bon::ofName($bonName)->first();

        if (isset($bon)) {
            list($givenBonNumber, $failedBonNumber) = $transaction->order->giveUserBons($bonName);
            if ($givenBonNumber == 0) {
                if ($failedBonNumber > 0) {
                    $this->result['data']['saveBon'] = -1;
                }
                else {
                    $this->result['data']['saveBon'] = 0;
                }
            }
            else {
                $this->result['data']['saveBon'] = $givenBonNumber;
            }

            $bonDisplayName = $bon->displayName;
            $this->result['data']['bonName'] = $bonDisplayName;
        }
    }

    /**
     * @param Transaction $transaction
     */
    protected function updateOrderPaymentStatus(Transaction $transaction): void
    {
        $paymentstatus_id = null;
        if ((int)$transaction->order->totalPaidCost() < (int)$transaction->order->totalCost())
            $paymentstatus_id = config('constants.PAYMENT_STATUS_INDEBTED');
        else
            $paymentstatus_id = config('constants.PAYMENT_STATUS_PAID');
        $transaction->order->close($paymentstatus_id);

        //ToDo : use updateWithoutTimestamp
        $transaction->order->timestamps = false;
        $orderUpdateStatus = $transaction->order->update();
        $transaction->order->timestamps = true;

        if ($orderUpdateStatus) {
            $this->result['data']['saveOrder'] = 1;
        } else {
            $this->result['data']['saveOrder'] = 0;
        }
    }

    /**
     * @param string $status
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return void
     */
    public function showPaymentStatus(string $status, string $paymentMethod, string $device, Request $request) {
        $result = $request->session()->get('gateWayVerify');
        dd([
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'gateWayVerify' => $result
        ]);
    }
}
