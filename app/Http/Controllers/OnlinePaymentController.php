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

    public function __construct(OrderController $orderController, TransactionController $transactionController)
    {
        $this->orderController = $orderController;
        $this->transactionController = $transactionController;
    }

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

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

        $refinementRequestStrategy = $this->gteRefinementRequestStrategy($request);

        $inputData = $request->all();
        $inputData['transactionController'] = $this->transactionController;
        $inputData['user'] = $request->user();

        $refinementLauncher = new RefinementLauncher($inputData, $refinementRequestStrategy);
        $data = $refinementLauncher->getData();

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

        $description = $this->setDescription($description, $order, $user);

        $this->setCustomerDescription($request, $order);


        if ($this->isRedirectable($cost)) {

            $callbackUrl = action('OnlinePaymentController@verifyPayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);

            $gateWay = new GateWayFactory($this->transactionController);
            $gateWay->setGateWay($paymentMethod)->redirect($transaction, $callbackUrl, $description);

            /*return response()->json([
                'message' => 'done'
            ], Response::HTTP_OK);*/

            return redirect(action('HomeController@error404'));
        } else {
            return redirect(action('OfflinePaymentController@verifyPayment', ['device' => $device, 'paymentMethod' => 'wallet', 'coi' => $order->id]));
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
     * @param Order $order
     * @param User $user
     * @return string
     */
    private function setDescription(string $description, Order $order, User $user): string
    {
        $description .= 'آلاء - ' . $user->mobile . ' - محصولات: ';

        $orderProducts = $order->orderproducts->load('product');

        foreach ($orderProducts as $orderProduct) {
            if (isset($orderProduct->product->id))
                $description .= $orderProduct->product->name . ' , ';
            else
                $description .= 'یک محصول نامشخص , ';
        }
        return $description;
    }

    /**
     * @param Request $request
     * @param Order $order
     */
    private function setCustomerDescription(Request $request, Order $order): void
    {
        if ($request->has('customerDescription')) {
            $customerDescription = $request->get('customerDescription');
            $order->customerDescription = $customerDescription;
            //ToDo : use updateWithoutTimestamp
            $order->timestamps = false;
            $order->update();
            $order->timestamps = true;
        }
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

    /*
    |--------------------------------------------------------------------------
    | VerifyPayment
    |--------------------------------------------------------------------------
    */

    /**
     * Verify customer online payment after coming back from payment gateway
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(string $paymentMethod, string $device, Request $request)
    {
        $gateWay = new GateWayFactory($this->transactionController);
        $result = $gateWay->setGateWay($paymentMethod)->verify($request->all());

//        if ($result['status'] && isset($result['data']['order'])) {
//            /** @var Order $order */
//            $order = $result['data']['order'];
//            optional($order->user)->notify(new InvoicePaid($order));
//        }

        Cache::tags('bon')->flush();

        $request->session()->flash('result', $result);

        return redirect(action('OnlinePaymentController@showPaymentStatus', [
            'status' => ($result['status'])?'successful':'failed',
            'paymentMethod' => $paymentMethod,
            'device' => $device
        ]));
    }

    /**
     * @param string $status
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return void
     */
    public function showPaymentStatus(string $status, string $paymentMethod, string $device, Request $request) {
        $result = $request->session()->get('result');
        dd([
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'result' => $result
        ]);
    }
}
