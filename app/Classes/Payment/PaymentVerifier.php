<?php

namespace App\Classes\Payment;

use App\Bankaccount;
use App\Order;
use App\PaymentModule\Gateways\Zarinpal\VerificationResponse;
use App\Traits\HandleOrderPayment;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentVerifier
{
    use HandleOrderPayment;

    /**
     * @param string $paymentMethod
     * @param string $device
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(string $paymentMethod, string $device, Request $request): \Illuminate\Http\RedirectResponse
    {
        $authority = $request->get(OnlineGateWay::getAuthorityKey());

        $transaction = $this->getTransaction($authority)->orFailWith([Responses::class, 'transactionNotFoundError']);
        $amount = abs($transaction->cost);

        $result = OnlineGateWay::verifyPayment($amount, $authority);

        $verifyResult = [];
        $transaction->order->detachUnusedCoupon();
        if ($result->isSuccessfulPayment()) {
            $this->handleTransactionStatus($transaction, $result->getRefId(), $result->getCardPanMask());
            $verifyResult['OrderSuccessPaymentResult'] = $this->handleOrderSuccessPayment($transaction->order);
        } else {
            $verifyResult['OrderCanceledPaymentResult'] = $this->handleOrderCanceledPayment($transaction->order);
            $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
            $transaction->update();
        }
//        if (isset($transaction->order_id)) {} else {
           /* if (isset($transaction->wallet_id))
            {
                if ($result['status']) {
                    $this->handleWalletChargingSuccessPayment($gatewayVerify['RefID'], $transaction, $gatewayVerify['cardPanMask']);
                } else {
                    $this->handleWalletChargingCanceledPayment($transaction);
                }
            }*/
//        }

        Cache::tags('bon')->flush();

        $request->session()->flash('verifyResult', $result->getMessages());

        return redirect()->action('Web\OnlinePaymentController@showPaymentStatus', [
            'status' => ($result->isSuccessfulPayment()) ? 'successful' : 'failed',
            'paymentMethod' => $paymentMethod,
            'device' => $device,
        ]);
    }

    /**
     * @param Transaction $transaction
     */
    /*private function handleWalletChargingCanceledPayment(Transaction $transaction)
    {
        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();
    }*/
    /**
     * @param string $refId
     * @param Transaction $transaction
     * @param string|null $cardPanMask
     */
    /*private function handleWalletChargingSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask = null)
    {
        $bankAccountId = null;
        if (isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber' => $cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }
        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);
        $transaction->wallet->deposit($transaction->cost * (-1), true);
    }*/

    /**
     * @param \App\Order $order
     *
     * @return array
     */
    private function handleOrderCanceledPayment(Order $order)
    {
        $result = [];
        if ($order->orderstatus_id == config("constants.ORDER_STATUS_OPEN")) {
            $order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
            $order->updateWithoutTimestamp();
        }

        $totalWalletRefund = $order->refundWalletTransaction();

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
     * @param \App\Transaction $transaction
     * @param string $refId
     * @param string|null $cardPanMask
     */
    private function handleTransactionStatus(Transaction $transaction, string $refId, string $cardPanMask = null)
    {
        $bankAccountId = null;

        if (! is_null($cardPanMask)) {
            $account = [
                'accountNumber' => $cardPanMask,
                'user_id' => optional($transaction->order)->user->id,
            ];

            $bankAccountId = Bankaccount::firstOrCreate($account)->id;
        }

        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);
    }

    /**
     * @param string $transactionID
     * @param Transaction $transaction
     * @param int|null $bankAccountId
     */
    private function changeTransactionStatusToSuccessful(string $transactionID, Transaction $transaction, int $bankAccountId = null)
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionID'] = $transactionID;
        $data['destinationBankAccount_id'] = $bankAccountId;
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
        $this->transactionController->modify($transaction, $data);
    }

    /**
     * @param string $msg
     * @param int $statusCode
     * @return JsonResponse
    private function sendErrorResponse(string $msg, int $statusCode): JsonResponse
    {
        $resp = response()->json(['message' => $msg], $statusCode);
        throw new HttpResponseException($resp);
    }
     */

    /**
     * @param $authority
     * @return \App\Classes\Nullable
     */
    private function getTransaction($authority)
    {
        return nullable(Transaction::authority($authority)->first());
    }
}