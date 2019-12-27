<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Requests\InsertZarinpalTransaction;
use App\Order;
use App\Traits\HandleOrderPayment;
use App\Traits\ZarinpalGateway;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ZarinpalTransactionController extends Controller
{
    use ZarinpalGateway;
    use HandleOrderPayment;

    const GATE_WAY_NAME = 'zarinpal';

    protected $transactionController;


    function __construct(TransactionController $transactionController)
    {
        $this->middleware(['CheckPermissionForSendOrderId',]);
        $this->transactionController = $transactionController;
    }

    public function __invoke(InsertZarinpalTransaction $request)
    {
        $paymentData['Authority'] = $request->get('authority');
        $amount                   = $request->get('cost');
        $orderId                  = $request->get('order_id');
        $refId                    = $request->get('refId');
        $initialDescription       = $request->get('description', '');
        if (strlen($initialDescription) > 0) {
            $initialDescription .= ' - ';
        }

        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        } else {
            $order = Order::findorfail($orderId);
        }

        $gatewayResult      = $this->buildZarinpalGateway(self::GATE_WAY_NAME, false);
        $gateway            = $gatewayResult['gatewayComposer'];
        $transactionGateway = $gatewayResult['transactiongateway'];

        $gatewayVerify = $this->verify($gateway, $amount, $paymentData["Authority"]);

        if ($gatewayVerify['status']) {
            if ($gatewayVerify['data']['RefID'] != $refId) {
                $refIdStatus = Response::HTTP_FORBIDDEN;
                $message     = 'Reference number is wrong';
            } else {
                $refIdStatus = Response::HTTP_OK;
            }

            if ($refIdStatus == Response::HTTP_OK) {
                $description = 'اپ آلاء - ' . $initialDescription;
                $description = $this->setTransactionDescription($description, optional($order)->user, $order);
                $transaction = $this->getNewTransaction($amount, $orderId, $transactionGateway->id, $description,
                    $paymentData['Authority'], $refId);
                if (isset($transaction)) {
                    $verifyResult['OrderSuccessPaymentResult'] = $this->handleOrderSuccessPayment($transaction->order);
                    $resultCode                                = Response::HTTP_OK;
                } else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $message    = 'Database error on inserting transaction';
                }
            }
        } else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            $message    = 'Unverified transaction';
//            $verifyResult['OrderCanceledPaymentResult'] = $this->handleOrderCanceledPayment($transaction);
        }

        if ($resultCode != Response::HTTP_OK) {
            $responseContent = [
                'error' => [
                    'code'    => $resultCode,
                    'message' => $message ?? $message,
                ],
            ];
        } else {
            $responseContent = [
                'message' => 'Transaction saved successfully',
            ];
        }

        return response($responseContent, Response::HTTP_OK);
    }

    /**
     * @param int    $cost
     * @param int    $orderId
     * @param int    $transactionGatewayId
     * @param string $description
     * @param string $authority
     *
     * @param string $refId
     *
     * @return Transaction|null
     */
    private function getNewTransaction(int $cost, int $orderId, int $transactionGatewayId, string $description, string $authority, string $refId)
    {
        $data['authority']                 = $authority;
        $data['transactionID']             = $refId;
        $data['cost']                      = $cost;
        $data['description']               = $description;
        $data['order_id']                  = $orderId;
        $data['destinationBankAccount_id'] = 1; // ToDo: Hard Code
        $data['paymentmethod_id']          = config('constants.PAYMENT_METHOD_ONLINE');
        $data['transactionstatus_id']      = config('constants.TRANSACTION_STATUS_SUCCESSFUL');
        $data['transactiongateway_id']     = $transactionGatewayId;
        $data['completed_at']              = Carbon::now()
            ->setTimezone('Asia/Tehran');
        $result                            = $this->transactionController->new($data);
        if ($result['statusCode'] == Response::HTTP_OK) {
            return $result['transaction'];
        } else {
            return null;
        }
    }
}
