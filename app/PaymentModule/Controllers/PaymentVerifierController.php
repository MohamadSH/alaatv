<?php

namespace  App\PaymentModule\Controllers;

use AlaaTV\Gateways\Facades\OnlineGateWay;
use AlaaTV\Gateways\Money;
use AlaaTV\Gateways\PaymentDriver;
use App\Order;
use App\Traits\HandleOrderPayment;
use Illuminate\Routing\Controller;
use App\Repositories\TransactionRepo;
use Illuminate\Support\Facades\{Cache, Request};
use App\PaymentModule\Responses;

class PaymentVerifierController extends Controller
{
    use HandleOrderPayment;
    
    /**
     * @param  string  $paymentMethod
     * @param  string  $device
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(string $paymentMethod, string $device)
    {
        PaymentDriver::select($paymentMethod);
        $authority = OnlineGateWay::getAuthorityValue();

        $transaction = TransactionRepo::getTransactionByAuthority($authority)
            ->orFailWith([Responses::class, 'transactionNotFoundError']);

        $money = Money::fromTomans(abs($transaction->cost));
        /**
         * @var OnlinePaymentVerificationResponseInterface $verificationResult
         */
        $verificationResult = OnlineGateWay::verifyPayment($money, $authority);
        
        $transaction->order->detachUnusedCoupon();
        if ($verificationResult->isSuccessfulPayment()) {
            TransactionRepo::handleTransactionStatus(
                $transaction,
                $verificationResult->getRefId(),
                $verificationResult->getCardPanMask()
            );
            $this->handleOrderSuccessPayment($transaction->order);
        } else {
            $this->handleOrderCanceledPayment($transaction->order);
            $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
            $transaction->update();
        }
        /*
        if (isset($transaction->order_id)) {} else { if (isset($transaction->wallet_id)) { if ($result['status']) { $this->handleWalletChargingSuccessPayment($gatewayVerify['RefID'], $transaction, $gatewayVerify['cardPanMask']); } else { $this->handleWalletChargingCanceledPayment($transaction); } } } */
        
        Cache::tags('bon')->flush();

        Request::session()->flash('verifyResult', [
            'messages' => $verificationResult->getMessages(),
            'cardPanMask' => $verificationResult->getCardPanMask(),
            'RefID' => $verificationResult->getRefId(),
            'isCanceled' => $verificationResult->isCanceled(),
        ]);
        
        return redirect()->route('showOnlinePaymentStatus', [
            'status'        => ($verificationResult->isSuccessfulPayment()) ? 'successful' : 'failed',
            'paymentMethod' => $paymentMethod,
            'device'        => $device,
        ]);
    }
    
    /**
     * @param  \App\Order  $order
     *
     * @return array
     */
    private function handleOrderCanceledPayment(Order $order)
    {
        if ($order->orderstatus_id == config("constants.ORDER_STATUS_OPEN")) {
            $order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
            $order->updateWithoutTimestamp();
        }
        $order->refundWalletTransaction();
    }
    
    /*
     * private function handleWalletChargingCanceledPayment(Transaction $transaction)
    {
        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();
    }

    private function handleWalletChargingSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask = null)
    {
        $bankAccountId = null;
        if (isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber' => $cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }
        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);
        $transaction->wallet->deposit($transaction->cost * (-1), true);
    }*/
}