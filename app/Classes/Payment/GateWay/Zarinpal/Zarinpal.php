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
    const EXCEPTION = array(
        -1 => 'اطلاعات ارسال شده ناقص است.',
        -2 => 'IP و یا مرچنت کد پذیرنده صحیح نیست',
        -3 => 'رقم باید بالای 100 تومان باشد',
        -4 => 'سطح پذیرنده پایین تر از سطح نقره ای است',
        -11 => 'درخواست مورد نظر یافت نشد',
        -21 => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد. کاربر قبل از ورود به درگاه بانک در همان صفحه زرین پال منصرف شده است.',
        -22 => 'تراکنش ناموفق می باشد. کاربر بعد از ورود به درگاه بانک منصرف شده است.',
        -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد',
        -54 => 'درخواست مورد نظر آرشیو شده',
        100 => 'عملیات با موفقیت انجام شد',
        101 => 'عملیات پرداخت با موفقیت انجام شده ولی قبلا عملیات PaymentVertification بر روی این تراکنش انجام شده است',
    );

    public function __construct(TransactionController $transactionController)
    {
        parent::__construct();
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $this->merchantID = $zarinGate->merchantNumber;
        $this->transactiongatewayId = $zarinGate->id;
        $this->zarinpalComposer = new ZarinpalComposer($this->merchantID);
        if(config('app.env', 'deployment')!='deployment' && config('Zarinpal.Sandbox', false)) {
            $this->zarinpalComposer->enableSandbox(); // active sandbox mod for test env
        }
        if(config('Zarinpal.ZarinGate', false)) {
            $this->zarinpalComposer->isZarinGate(); // active zarinGate mode
        }
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
        $this->validateCallbackData($callbackData);

        if (!$this->result['status']) {
            return $this->result;
        }

        $authority = $this->result['data']['callbackData']['Authority'];
        $status = $this->result['data']['callbackData']['Status'];

        $transaction = $this->getTransaction($authority);

        if(!isset($transaction)) {
            return $this->result;
        }

        $transaction->order->detachUnusedCoupon();

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
        $this->result['data']['transaction'] = $transaction;
        $this->result['data']['order'] = $transaction->order;

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
        } else {
            $this->result['status'] = false;
            if (strcmp($result['Status'], 'canceled') == 0) {
                $this->result['message'][] = 'کاربر از پرداخت انصراف داده است.';
            } else if (strcmp($result['Status'], 'verified_before') ==0) {
                $this->result['message'][] = self::EXCEPTION[101];
            } else {
                $this->result['message'][] = 'خطایی در پرداخت رخ داده است.';
                if (isset($result['error'])) {
                    $this->result['message'][] = self::EXCEPTION[$result['error']];
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
     * @return void
     */
    private function validateCallbackData(array $callbackData): void
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
        }
        $this->result['data']['callbackData'] = $callbackData;
    }
}