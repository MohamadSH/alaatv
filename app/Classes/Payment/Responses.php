<?php

namespace App\Classes\Payment;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class Responses
{
    /**
     * @param string $msg
     * @param int $statusCode
     * @return JsonResponse
     */
    private static function sendErrorResponse(string $msg, int $statusCode)
    {
        return response()->json(['message' => $msg], $statusCode);
    }

    public static function noResponseFromBackError()
    {
        return self::sendErrorResponse('پاسخی از بانک دریافت نشد', Response::HTTP_SERVICE_UNAVAILABLE);
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
}