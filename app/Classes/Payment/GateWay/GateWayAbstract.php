<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:34 PM
 */

namespace App\Classes\Payment\GateWay;

use App\Http\Requests\Request;

abstract class GateWayAbstract
{

    /**
     * @var array $result
     */
    protected $result;

    /**
     * @var Request $request
     */
    protected $request;


    public function __construct()
    {
        $this->request = app('request');
        $this->result = [
            'status' => true,
            'message' => [],
            'data' => []
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PaymentRequest
    |--------------------------------------------------------------------------
    */

    /**
     * @param int $amount
     * @param string $callbackUrl
     * @param string|null $description
     * @return array
     */
    abstract public function paymentRequest(int $amount, string $callbackUrl, string $description = null): array;

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    abstract public function redirect(): void;

    /*
    |--------------------------------------------------------------------------
    | Verify
    |--------------------------------------------------------------------------
    */

    abstract public function getCallbackData(): array;

    /**
     * @param int $amount
     * @param array|null $data
     * @return array
     */
    abstract public function verify(int $amount, array $data=null): array;
}