<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:31 PM
 */

namespace App\Classes\Payment\GateWay\Zarinpal;

use App\Bankaccount;
use App\Transaction;
use App\Transactiongateway;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Zarinpal\Zarinpal as ZarinpalComposer;
use App\Http\Controllers\TransactionController;
use App\Classes\Payment\GateWay\GateWayAbstract;

class Zarinpal extends GateWayAbstract
{
    private $merchantID;
    private $zarinpalComposer;
    private $transactiongatewayId;

    public function __construct(TransactionController $transactionController)
    {
        parent::__construct();
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $this->merchantID = $zarinGate->merchantNumber;
        $this->transactiongatewayId = $zarinGate->id;
        $this->zarinpalComposer = new ZarinpalComposer($this->merchantID);
        if(config('app.env')!='deployment' && config('Zarinpal.Sandbox')) {
            $this->zarinpalComposer->enableSandbox(); // active sandbox mod for test env
        }
        $this->zarinpalComposer->isZarinGate(); // active zarinGate mode
        $this->transactionController = $transactionController;
    }

    /**
     * Making request to ZarinPal gateway
     * must loadForRedirect before
     * @param Transaction $transaction
     * @param string $callbackUrl
     * @param string|null $description
     * @return array
     */
    public function redirect(Transaction $transaction, string $callbackUrl, string $description=null): array
    {
        $zarinpalResponse = $this->zarinpalComposer->request($callbackUrl, (int)$transaction->cost, $description);

        if (isset($zarinpalResponse['Authority']) && strlen($zarinpalResponse['Authority']) > 0) {
            $data['destinationBankAccount_id'] = 1; // ToDo: Hard Code
            $data['authority'] = $zarinpalResponse['Authority'];
            $data['transactiongateway_id'] = $this->transactiongatewayId;
            $data['paymentmethod_id'] = config('constants.PAYMENT_METHOD_ONLINE');
            $transactionModifyResult = $this->transactionController->modify($transaction, $data);
            if ($transactionModifyResult['statusCode'] == Response::HTTP_OK) {
                $this->zarinpalComposer->redirect();
                $this->result['status'] = true;
                $this->result['message'][] = 'ریدایرکت به درگاه با موفقیت انجام شد.';
            }
            else {
                $this->result['status'] = false;
                $this->result['message'][] = 'مشکلی در ویرایش تراکنش رخ داده است.';
                $this->result['data']['transactionModifyResult'] = $transactionModifyResult;
            }
        } else {
            $this->result['status'] = false;
            $this->result['message'][] = 'مشکل در برقراری ارتباط با درگاه زرین پال';
            $this->result['data']['zarinpalResponse'] = $zarinpalResponse;
        }
        return $this->result;
    }

    /**
     * verify ZarinPal callback request
     * must loadForVerify before
     * @param array $callbackData
     * @return array $this->result
     */
    public function verify(array $callbackData): array
    {
        [$authority, $status] = $this->validateCallbackData($callbackData);

        if (!$this->result['status']) {
            return $this->result;
        }

        $transaction = $this->getTransaction($authority);

        if(!isset($transaction)) {
            return $this->result;
        }

        $transaction->order->detachUnusedCoupon();
        $this->result['data']['order'] = $transaction->order;

        $verifyZarinpalResult = $this->verifyZarinpal($status, $transaction->cost, $authority);

        if (!isset($verifyZarinpalResult)) {
            $this->result['status'] = false;
            $this->result['message'][] = 'مشکل در برقراری ارتباط با زرین پال';
            $this->result['data']['verifyZarinpalResult'] = $verifyZarinpalResult;
            return $this->result;
        }

        if ($verifyZarinpalResult['Status'] === 'success') {
            $cardPanMask = isset($verifyZarinpalResult['ExtraDetail']['Transaction']['CardPanMask'])?$verifyZarinpalResult['ExtraDetail']['Transaction']['CardPanMask']:null;
            $this->handleSuccessStatus($verifyZarinpalResult['RefID'], $transaction, $cardPanMask);
        } else {
            $this->handleCanceledStatus($transaction);
        }

        return $this->result;
    }

    /**
     * @param string $authority
     * @return Transaction|null
     */
    private function getTransaction(string $authority): ?Transaction
    {
        $transaction = Transaction::authority($authority)->first();
        if(!isset($transaction)) {
            $this->result['status'] = false;
            $this->result['message'][] = 'تراکنش متناظر با authority یافت نشد.';
            $this->result['data']['authority'] = $authority;
        } else {
            $this->result['data']['transaction'] = $transaction;
        }
        return $transaction;
    }

    /**
     * @param string $status
     * @param int $amount
     * @param string $authority
     * @return array
     */
    private function verifyZarinpal(string $status, int $amount, string $authority): array
    {
        $result = $this->zarinpalComposer->verify($status, $amount, $authority);
        $this->result['data']['zarinpalVerifyResult'] = $result;

        if (isset($result['RefID']) && strcmp($result['Status'], 'success') == 0) {
            $this->result['status'] = true;
            //$this->result['data']['zarinpalVerifyResult'] = $result;
            //$this->result['data']['RefID'] = $result['RefID'];
            //$this->cardPanHash = isset($result['ExtraDetail']['Transaction']['CardPanHash'])?$result['ExtraDetail']['Transaction']['CardPanHash']:null;
            //$this->cardPanMask = isset($result['ExtraDetail']['Transaction']['CardPanMask'])?$result['ExtraDetail']['Transaction']['CardPanMask']:null;
        } else {
            $this->result['status'] = false;
            if (strcmp($result['Status'], 'canceled') == 0) {
                $this->result['message'][] = 'کاربر از پرداخت انصراف داده است.';
            } else if (strcmp($result['Status'], 'verified_before') ==0) {
                $this->result['message'][] = 'عملیات پرداخت با موفقیت انجام شده ولی قبلا عملیات PaymentVertification بر روی این تراکنش انجام شده است';
            } else {
                if(strcmp($result['error'], '-21') == 0) {
                    $this->result['message'][] = 'کاربر قبل از ورود به درگاه بانک در همان صفحه زرین پال منصرف شده است.';
                } else if(strcmp($result['error'], '-22') == 0) {
                    $this->result['message'][] = 'کاربر بعد از ورود به درگاه بانک منصرف شده است.';
                } else {
                    $this->result['message'][] = 'خطایی در پرداخت رخ داده است.';
                }
            }
        }
        return $result;
    }

    /**
     * @param string $refId
     * @param Transaction $transaction
     * @param string|null $cardPanMask
     */
    private function handleSuccessStatus(string $refId, Transaction $transaction, string $cardPanMask=null): void
    {
        $bankAccountId = null;

        if($cardPanMask!=null) {
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

    private function handleCanceledStatus(Transaction $transaction): void
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
     * @return array
     */
    public function getUnverifiedTransactions() {
        $inputs = [
            'MerchantID' => $this->merchantID
        ];
        $result = $this->zarinpalComposer->getDriver()->unverifiedTransactions($inputs);
        return $result;
    }

    /**
     * @param int $amount
     * @param string $authority
     * @return array
     */
    public function forceVerify(int $amount, string $authority) {
        $verifyZarinpalResult = $this->verifyZarinpal('OK', $amount, $authority);
        return $verifyZarinpalResult;
    }

    /**
     * @param array $callbackData
     * @return array
     */
    private function validateCallbackData(array $callbackData): array
    {
        $validator = Validator::make($callbackData, [
            'Authority' => 'required|string|min:36|max:36',
            'Status' => 'required|string|min:2|max:3',
        ]);
        if ($validator->fails()) {
            $this->result['status'] = false;
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $this->result['message'][] = $messages;
            }
            $this->result['data']['callbackData'] = $callbackData;
        }
        return [
            (isset($callbackData['Authority'])?$callbackData['Authority']:null),
            (isset($callbackData['Status'])?$callbackData['Status']:null)
        ];
    }
}