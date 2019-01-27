<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:34 PM
 */

namespace App\Classes\Payment\GateWay;

interface GateWay
{
    public function paymentRequest(array $data): array;

    public function redirect(array $data): void;

    public function getCallbackData(array $data): array;

    public function verify(array $data): array;
}