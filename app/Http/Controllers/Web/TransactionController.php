<?php

namespace App\Http\Controllers\Web;

use App\Order;
use App\Product;
use App\Repositories\TransactionGatewayRepo;
use Carbon\Carbon;
use App\Transaction;
use App\Orderproduct;
use App\Paymentmethod;
use App\Traits\Helper;
use Zarinpal\Zarinpal;
use App\Transactionstatus;
use App\Traits\OrderCommon;
use App\Transactiongateway;
use Illuminate\Http\Request;
use App\Traits\RequestCommon;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Repositories\TransactionRepo;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\EditTransactionRequest;
use App\Http\Requests\InsertTransactionRequest;

class TransactionController extends Controller
{
    use OrderCommon;
    use Helper;
    use RequestCommon;

    function __construct()
    {
        $this->middleware('permission:'.config('constants.LIST_TRANSACTION_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.SHOW_TRANSACTION_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:'.config('constants.EDIT_TRANSACTION_ACCESS'), ['only' => 'update']);
        $this->middleware('role:admin', ['only' => 'getUnverifiedTransactions']);
        //        $this->middleware('permission:'.config('constants.INSERT_TRANSACTION_ACCESS'),['only'=>'store']);
    }

    public function index(Request $request)
    {
        try {
            $transactions = Transaction::orderBy('created_at', 'Desc');
            
            $createdSinceDate  = $request->get('createdSinceDate');
            $createdTillDate   = $request->get('createdTillDate');
            $createdTimeEnable = $request->get('createdTimeEnable');
            if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
                $transactions = $this->timeFilterQuery($transactions, $createdSinceDate, $createdTillDate,
                    'completed_at');
            }
            
            $deadlineSinceDate  = $request->get('DeadlineSinceDate');
            $deadlineTillDate   = $request->get('DeadlineTillDate');
            $deadlineTimeEnable = $request->get('DeadlineTimeEnable');
            if (strlen($deadlineSinceDate) > 0 && strlen($deadlineTillDate) > 0 && isset($deadlineTimeEnable)) {
                $transactions = $this->timeFilterQuery($transactions, $deadlineSinceDate, $deadlineTillDate,
                    'deadline_at');
            }
            
            if ($request->has('transactionStatus')) {
                $transactionStatusFilter = $request->get('transactionStatus');
                $transactions            = $transactions->where('transactionstatus_id', $transactionStatusFilter);
            }

            $transactionGatewayFilter = $request->get('transactiongateway_id');
            if (isset($transactionGatewayFilter)) {
                $transactions            = $transactions->where('transactiongateway_id', $transactionGatewayFilter);
            }

            $transactionCode = trim($request->get('transactionCode'));
            if (isset($transactionCode[0])) {
                $transactions = $transactions->where(function ($q) use ($transactionCode) {
                    $q->where('traceNumber', 'like', '%'.$transactionCode.'%')
                        ->orWhere('referenceNumber', 'like',
                            '%'.$transactionCode.'%')
                        ->orWhere('paycheckNumber', 'like', '%'.$transactionCode.'%')
                        ->orWhere('transactionID', 'like',
                            '%'.$transactionCode.'%');
                });
            }
            
            $transactionManagerComment = $request->get('transactionManagerComment');
            if (isset($transactionManagerComment[0])) {
                $transactions = $transactions->where(function ($q) use ($transactionManagerComment) {
                    $q->where('managerComment', 'like', '%'.$transactionManagerComment.'%');
                });
            }
            
            $firstName = trim($request->get('firstName'));
            if (isset($firstName) && strlen($firstName) > 0) {
                $transactions = $transactions->whereHas('order', function ($query) use ($firstName) {
                    $query->whereHas('user', function ($q) use ($firstName) {
                        $q->where('firstName', 'like', '%'.$firstName.'%');
                    });
                });
            }
            
            $lastName = trim($request->get('lastName'));
            if (isset($lastName) && strlen($lastName) > 0) {
                $transactions = $transactions->whereHas('order', function ($query) use ($lastName) {
                    $query->whereHas('user', function ($q) use ($lastName) {
                        $q->where('lastName', 'like', '%'.$lastName.'%');
                    });
                });
            }
            
            $nationalCode = trim($request->get('nationalCode'));
            if (isset($nationalCode) && strlen($nationalCode) > 0) {
                $transactions = $transactions->whereHas('order', function ($query) use ($nationalCode) {
                    $query->whereHas('user', function ($q) use ($nationalCode) {
                        $q->where('nationalCode', 'like', '%'.$nationalCode.'%');
                    });
                });
            }
            
            $mobile = trim($request->get('mobile'));
            if (isset($mobile) && strlen($mobile) > 0) {
                $transactions = $transactions->whereHas('order', function ($query) use ($mobile) {
                    $query->whereHas('user', function ($q) use ($mobile) {
                        $q->where('mobile', 'like', '%'.$mobile.'%');
                    });
                });
            }

            $extraAttributevaluesId = $request->get('extraAttributes');
            if (isset($extraAttributevaluesId)) {
                $transactions = $transactions->whereIn('order_id',
                    Orderproduct::whereHas('attributevalues', function ($q) use ($extraAttributevaluesId) {
                        $q->whereIn('value_id', $extraAttributevaluesId);
                    })
                        ->pluck('order_id'));
            }
            
            if ($request->has('paymentMethods')) {
                $paymentMethodsId = $request->get('paymentMethods');
                $transactions     = $transactions->whereIn('paymentmethod_id', $paymentMethodsId);
            }
            
            if ($request->has('orderStatuses')) {
                $orderStatusesId = $request->get('orderStatuses');
                //            $orders = Order::orderStatusFilter($orders, $orderStatusesId);
                $transactions = $transactions->whereHas('order', function ($q) use ($orderStatusesId) {
                    $q->whereIn('orderstatus_id', $orderStatusesId);
                });
            }
            
            if ($request->has('paymentStatuses')) {
                $paymentStatusesId = $request->get('paymentStatuses');
                $transactions      = $transactions->whereHas('order', function ($q) use ($paymentStatusesId) {
                    $q->whereIn('paymentstatus_id', $paymentStatusesId);
                });
            }
            
            $transactionType = $request->get('transactionType');
            if (isset($transactionType) && strlen($transactionType) > 0) {
                if ($transactionType == 0) {
                    $transactions = $transactions->where('cost', '>', 0);
                }
                else {
                    if ($transactionType == 1) {
                        $transactions = $transactions->where('cost', '<', 0);
                    }
                }
            }
            
            $transactions = $transactions->get();
            
            $totaolCost = number_format($transactions->sum('cost'));
            
            return json_encode([
                'index'                      => View::make('transaction.index',
                    compact('transactions'))
                    ->render(),
                'totalCost'                  => $totaolCost,
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception    $e) {
            return response()->json([
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ] , Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
    
    /**
     * @param  Transaction  $transaction
     * @param  array        $data
     *
     * @return array
     */
    public function modify(Transaction $transaction, array $data)
    {
        $result = [
            'statusCode'  => Response::HTTP_OK,
            'message'     => '',
            'transaction' => $transaction,
        ];
        
        $transaction->fill($data);
        $props = [
            'referenceNumber',
            'traceNumber',
            'transactionID',
            'authority',
            'paycheckNumber',
            'managerComment',
            'paymentmethod_id',
        ];
        
        foreach ($props as $prop) {
            if (strlen($transaction->$prop) == 0) {
                $transaction->$prop = null;
            }
        }
        
        if (isset($data['deadline_at']) && strlen($data['deadline_at']) > 0) {
            $transaction->deadline_at = Carbon::parse($data['deadline_at'])
                ->addDay()
                ->format('Y-m-d');
        }
        
        if (isset($data['completed_at']) && strlen($data['completed_at']) > 0) {
            $transaction->completed_at = Carbon::parse($data['completed_at'])
                ->addDay()
                ->format('Y-m-d');
        }
        
        if ($transaction->update()) {
            $result['statusCode'] = Response::HTTP_OK;
            $result['message']    = 'تراکنش با موفقیت اصلاح شد';
        }
        else {
            $result['statusCode'] = Response::HTTP_SERVICE_UNAVAILABLE;
            $result['message']    = 'خطای پایگاه داده';
        }
        
        $result['transaction'] = $transaction;
        
        return $result;
    }

    public function store(InsertTransactionRequest $request)
    {
        $order = Order::find($request->get('order_id'));
        if (!isset($order)) {
            $result = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message'    => 'سفارش شما یافت نشد.',
            ];
            
            return response()->json([
                'error' => $result['message'],
            ], $result['statusCode']);
        }
        
        // ToDo: just admin can insert payed transaction (check request and user permission)
        
        $canInsertTransaction = $request->user()
            ->can(config('constants.INSERT_TRANSACTION_ACCESS'));
        $isOrderOwner         = ($order->user_id == $request->user()->id);
        
        if (!$canInsertTransaction && !$isOrderOwner) {
            $result = [
                'statusCode' => Response::HTTP_FORBIDDEN,
                'message'    => 'سفارش مورد نظر متعلق به شما نمی باشد',
            ];
            
            return response()->json([
                'error' => $result['message'],
            ], $result['statusCode']);
        }

        $result = $this->new($request->all());

        if($request->ajax() || $request->expectsJson())
            return response()->json([
                'error' => $result['message'],
            ], $result['statusCode']);

        if($result['statusCode'] == Response::HTTP_OK)
            session()->flash('success' , $result['message']);
        else
            session()->flash('error' , $result['message']);

        return redirect()->back();
    }
    
    /**
     * @param  array  $data
     *
     * @return array
     */
    public function new(array $data)
    {
        $result = [
            'statusCode'  => Response::HTTP_OK,
            'message'     => '',
            'transaction' => null,
        ];
        
        $transaction = new Transaction();
        $transaction->fill($data);
        
        if ($transaction->save()) {
            $result['statusCode']  = Response::HTTP_OK;
            $result['message']     = 'تراکنش با موفقیت ثبت شد.';
            $result['transaction'] = $transaction;
        }
        else {
            $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['message']    = 'خطای پایگاه داده در ثبت تراکنش';
        }
        
        return $result;
    }

    public function edit(Transaction $transaction)
    {
        $transactionPaymentmethods = Paymentmethod::pluck('displayName', 'id')
            ->toArray();
        $transactionStatuses       = Transactionstatus::where('name', '<>', 'transferredToPay')
            ->orderBy('order')
            ->pluck('displayName', 'id')
            ->toArray();
        $deadlineAt = null;
        if (isset($transaction->deadline_at)) {
            $deadlineAt = Carbon::parse($transaction->deadline_at)
                ->format('Y-m-d');
        }
        $completedAt=null;
        if (isset($transaction->completed_at)) {
            $completedAt = Carbon::parse($transaction->completed_at)
                ->format('Y-m-d');
        }

        $transactionGateways = TransactionGatewayRepo::getTransactionGateways(['enable'=>1])->get()->pluck('displayName' , 'id');
        
        return view('transaction.edit',
            compact('transaction', 'transactionPaymentmethods', 'transactionStatuses',
                'deadlineAt', 'completedAt' , 'transactionGateways'));
    }

    public function limitedUpdate(Request $request, Transaction $transaction)
    {
        $order = Order::FindOrFail($request->get('order_id'));
        if (!$this->checkOrderAuthority($order)) {
            abort(404);
        }
        if ($order->id != $transaction->order_id) {
            abort(404);
        }
        
        $editRequest = new EditTransactionRequest();
        
        $paymentImplied = false;
        if ($request->has('referenceNumber')) {
            $editRequest->offsetSet('referenceNumber', $request->get('referenceNumber'));
            $paymentImplied = true;
        }
        if ($request->has('traceNumber')) {
            $editRequest->offsetSet('traceNumber', $request->get('traceNumber'));
            $paymentImplied = true;
        }
        
        if ($request->has('paymentmethod_id')) {
            $editRequest->offsetSet('paymentmethod_id', $request->get('paymentmethod_id'));
        }
        
        if ($paymentImplied) {
            $editRequest->offsetSet('transactionstatus_id', config('constants.TRANSACTION_STATUS_PENDING'));
            $editRequest->offsetSet('completed_at', Carbon::now());
            $editRequest->offsetSet('apirequest', true);
            $response = $this->update($editRequest, $transaction);
            if ($response->getStatusCode() == Response::HTTP_OK) {
                session()->put('success', 'تراکنش با موفقیت ثبت شد');
            }
            else {
                if ($response->getStatusCode() == Response::HTTP_SERVICE_UNAVAILABLE) {
                    session()->put('error', 'خطای پایگاه داده ، لطفا مجددا اقدام نمایید.');
                }
                else {
                    session()->put('error', 'خطای نا مشخص');
                }
            }
        }
        
        return redirect()->back();
    }

    public function update(EditTransactionRequest $request, Transaction $transaction)
    {
        $result = [];
    
    
        $this->checkOffsetDependency($request, 'deadlineAtEnable', 'deadline_at');
        $this->checkOffsetDependency($request, 'completedAtEnable', 'completed_at');

        if (TransactionRepo::modify($request->all(), $transaction->id)) {
            $result['statusCode'] = Response::HTTP_OK;
            $result['message']    = 'تراکنش با موفقیت اصلاح شد';
        }
        else {
            $result['statusCode'] = Response::HTTP_SERVICE_UNAVAILABLE;
            $result['message']    = 'خطای پایگاه داده';
        }
        
        if ($request->expectsJson()) {
            return response()->json([],$result['statusCode']);
        }
        session()->put('success', $result['message']);
        
        return redirect()->back();
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) {
            session()->put('success', 'تراکنش با موفقیت حذف شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        //        $transaction->delete();
        return response()->json([
            'sessionData' => session()->all(),
        ]);
    }
    
    public function getUnverifiedTransactions()
    {
        try {
            $merchant     = config('Zarinpal.merchantID');

            $zarinPal     = new Zarinpal($merchant);
            $result       = $zarinPal->getDriver()->unverifiedTransactions(['MerchantID'=>$merchant]);

            $error=null;
            $transactions = collect();
            if ($result['Status'] == 'success') {
                $authorities = $result['Authorities'];
                foreach ($authorities as $authority) {
                    /** @var Transaction $transaction */
                    $transaction = TransactionRepo::getTransactionByAuthority($authority['Authority'])->getValue(null);;
                    $userId= null;
                    $firstName   = '';
                    $lastName    = '';
                    $mobile      = '';
                    $jalaliCreatedAt  = '';
                    if (!is_null($transaction)) {
                        $jalaliCreatedAt = $transaction->jalali_created_at;
                        $user       = optional($transaction->order)->user;
                        if (isset($user)) {
                            $userId    = $user->id;
                            $firstName = $user->firstName;
                            $lastName  = $user->lastName;
                            $mobile    = $user->mobile;
                        }
                    }
                    
                    $transactions->push([
                        'userId'     => $userId,
                        'firstName'  => $firstName,
                        'lastName'   => $lastName,
                        'mobile'     => $mobile,
                        'authority'  => $authority['Authority'],
                        'amount'     => $authority['Amount'],
                        'created_at' => $jalaliCreatedAt,
                    ]);
                }
            }
            else {
                $error = $result['error'];
            }
            $pageName = 'admin';
            
            return view('transaction.unverifiedTransactions', compact('transactions', 'error', 'pageName'));
        } catch (\Exception    $e) {
            return response()->json([
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ] , Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
    
    public function convertToDonate(Transaction $transaction)
    {
        if ($transaction->cost >= 0 || isset($transaction->traceNumber)) {
            return response()->json( ['message' => 'این تراکنش بازگشت هزینه نمی باشد'] , Response::HTTP_SERVICE_UNAVAILABLE);
        }

        $order = Order::FindOrFail($transaction->order->id);
        $donateOrderproduct = new Orderproduct();
        $donateOrderproduct->order_id = $order->id;
        $donateOrderproduct->product_id = 182;
        $donateOrderproduct->cost = -$transaction->cost;

        if (!$donateOrderproduct->save()) {
            return response()->json( ['message' => 'خطا در ایجاد آیتم کمک مالی . لطفا دوباره اقدام نمایید.'] , Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if (!$transaction->forceDelete()) {
            return response()->json( ['message' => 'خطا در بروز رسانی تراکنش . لطفا تراکنش را دستی اصلاح نمایید.'] , Response::HTTP_SERVICE_UNAVAILABLE);
        }

        $newOrder = Order::where('id', $order->id)->get()->first();
        $orderCostArray = $newOrder->obtainOrderCost(true, false, 'REOBTAIN');
        $newOrder->cost = $orderCostArray['rawCostWithDiscount'];
        $newOrder->costwithoutcoupon = $orderCostArray['rawCostWithoutDiscount'];
        if ($newOrder->update()) {
            return response()->json(['message' => 'عملیات تبدیل با موفقیت انجام شد.']);
        } else {
            return response()->json( ['message' => 'خطا در بروز رسانی سفارش . لطفا سفارش را دستی اصلاح نمایید.'] , Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
    
    public function completeTransaction(\Illuminate\Http\Request $request, Transaction $transaction)
    {
        if (isset($transaction->traceNumber)) {
            return;
        }

        $transaction->traceNumber = $request->get('traceNumber');
        $transaction->paymentmethod_id = config('constants.PAYMENT_METHOD_ATM');
        $transaction->managerComment = $transaction->managerComment.'شماره کارت مقصد: \n'.$request->get('managerComment');
        if ($transaction->update()) {
            return response()->json(['message' => 'اطلاعات تراکنش با موفقیت ذخیره شد']);
        } else {
            return response()->json( ['message' => 'خطا در ذخیره اطلاعات . لفطا مجددا اقدام نمایید'] , Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

}
