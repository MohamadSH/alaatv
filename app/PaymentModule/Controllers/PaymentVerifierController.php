<?php

namespace  App\PaymentModule\Controllers;

use AlaaTV\Gateways\Contracts\OnlinePaymentVerificationResponseInterface;
use App\Order;
use AlaaTV\Gateways\Money;
use App\PaymentModule\Responses;
use App\Traits\HandleOrderPayment;
use Illuminate\Routing\Controller;
use AlaaTV\Gateways\PaymentDriver;
use App\Repositories\TransactionRepo;
use Illuminate\Support\Facades\{Cache, Request};

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
        Cache::tags('bon')->flush();
        Cache::tags('order')->flush();
        Cache::tags('orderproduct')->flush();

        $paymentClient = PaymentDriver::select($paymentMethod);
        $authority = $paymentClient->getAuthorityValue();

        $transaction = TransactionRepo::getTransactionByAuthority($authority)
            ->orFailWith([Responses::class, 'transactionNotFoundError']);

        $money = Money::fromTomans(abs($transaction->cost));
        /**
         * @var OnlinePaymentVerificationResponseInterface $verificationResult
         */
        $verificationResult = $paymentClient->verifyPayment($money, $authority);
        $responseMessages = $verificationResult->getMessages();

        $transaction->order->detachUnusedCoupon();
        if ($verificationResult->isSuccessfulPayment()) {
            TransactionRepo::handleTransactionStatus(
                $transaction,
                $verificationResult->getRefId(),
                $verificationResult->getCardPanMask()
            );
            $this->handleOrderSuccessPayment($transaction->order);
            $assetLink = '<a href="'.route('user.asset').'">دانلودهای من</a>';
            $responseMessages[]= 'برای دانلود محصولاتی که خریده اید به صفحه روبرو بروید: '.$assetLink;
            $responseMessages[]= 'توجه کنید که محصولات پیش خرید شده در تاریخ مقرر شده برای دانلود قرار داده می شوند';
        } else {
            $this->handleOrderCanceledPayment($transaction->order);
            $this->handleOrderCanceledTransaction($transaction);
            $transaction->update();
            $responseMessages[]= 'یک سفارش پرداخت نشده به لیست سفارش های شما افزوده شده است که می توانید با رفتن به صفحه سفارش های من آن را پرداخت کنید';
        }

        setcookie('cartItems', '', time() - 3600, '/');

        /*
        if (isset($transaction->order_id)) {} else { if (isset($transaction->wallet_id)) { if ($result['status']) { $this->handleWalletChargingSuccessPayment($gatewayVerify['RefID'], $transaction, $gatewayVerify['cardPanMask']); } else { $this->handleWalletChargingCanceledPayment($transaction); } } } */

        Request::session()->flash('verifyResult', [
            'messages' => $responseMessages,
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
            $order->update();
        }
        $order->refundWalletTransaction();
    }

    /**
     * @param $transaction
     */
    private function handleOrderCanceledTransaction($transaction): void
    {
        if ($transaction->transactionstatus_id != config("constants.TRANSACTION_STATUS_UNPAID"))
            //it is not an instalment payment
            $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
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
