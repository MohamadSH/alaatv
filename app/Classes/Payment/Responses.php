<?php

namespace App\Classes\Payment;

use App\Order;
use Illuminate\Http\Response;

class Responses
{
    public static function noResponseFromBankError($msg)
    {
        return self::sendErrorResponse('پاسخی از بانک دریافت نشد.', Response::HTTP_SERVICE_UNAVAILABLE);
    }
    
    /**
     * @param  string  $msg
     * @param  int     $statusCode
     *
     * @return JsonResponse
     */
    private static function sendErrorResponse(string $msg, int $statusCode)
    {
        return response()->json(['message' => $msg], $statusCode);
    }
    
    public static function editTransactionError()
    {
        return self::sendErrorResponse('مشکلی در ویرایش تراکنش رخ داده است.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    
    public static function gateWayNotFoundError()
    {
        return self::sendErrorResponse('درگاه مورد نظر یافت نشد', Response::HTTP_BAD_REQUEST);
    }
    
    public static function transactionNotFoundError()
    {
        return self::sendErrorResponse('تراکنشی متناظر با شماره تراکنش ارسالی یافت نشد.', Response::HTTP_BAD_REQUEST);
    }
    
    /**
     * @param  string  $device
     * @param  Order   $order
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function sendToOfflinePaymentProcess(string $device, Order $order)
    {
        return redirect()->action('Web\OfflinePaymentController@verifyPayment', [
            'device'        => $device,
            'paymentMethod' => 'wallet',
            'coi'           => isset($order) ? $order->id : null,
        ]);
        
    }
}