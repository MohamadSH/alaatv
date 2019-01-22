<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Transaction;
use App\Traits\OrderCommon;
use Illuminate\Http\{Request, Response};
use App\Classes\Payment\GateWay\GateWayFactory;
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
        /*$request->offsetSet('order_id", 137);*/
        /*$request->offsetSet('transaction_id", 65);*/
        $request->offsetSet('payByWallet', true);

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
            $data = [
                'description' => $this->description,
                'transaction' => $this->transaction,
                'device' => $this->device,
            ];
            $gateWay = new GateWayFactory($this->transactionController);
            $gateWay->setGateWay($paymentMethod)->redirect($data);

            /*return response()->json([
                'message' => 'done'
            ], Response::HTTP_OK);*/

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

    private function setDescription()
    {
        $this->description .= "آلاء - " . $this->user->mobile . " - محصولات: ";

        $orderProducts = $this->order->orderproducts->load('product');

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

        $data = [
            'callbackData' => $request->all(),
            'result' => $result
        ];
//        $gateWay = new GateWay($this->transactionController);
//        $result = $gateWay->setGateWay($paymentMethod)->verify($data);

        /*$sendSMS = $result['sendSMS'];
        if ($sendSMS && isset($this->order)) {
            $user = $this->order->user;
            $this->order = $this->order->fresh();
            $user->notify(new InvoicePaid($this->order));
            Cache::tags('bon')->flush();
        }*/

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
     * @return array
     */
    public function showPaymentStatus(string $status, string $paymentMethod, string $device, Request $request) {
        $result = $request->session()->get('result');
        $this->device = $device;
        return [
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'result' => $result
        ];

        /*dd([
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'result' => $result
        ]);*/
    }
}
