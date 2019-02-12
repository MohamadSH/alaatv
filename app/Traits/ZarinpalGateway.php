<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 2/10/2019
 * Time: 11:15 AM
 */

namespace App\Traits;


trait Gateway
{

    /**
     * @param $gatewayComposer
     * @param string $callbackUrl
     * @param int $amount
     * @param string $description
     * @return string
     */
    public function paymentRequest($gatewayComposer  , string $callbackUrl , int $amount , string $description): string {
        $zarinpalResponse = $gatewayComposer->request($callbackUrl, $amount, $description);
        $authority = $zarinpalResponse['Authority'];
        if (isset($authority[0]))
            return $authority;
        else
            return null;
    }

    /**
     * @param string $redirectUrl
     * @return array
     */
    public function getRedirectData(string $redirectUrl): array {
        $redirectData = [
            'url' => $redirectUrl,
            'input' => [],
            'method' => 'GET'
        ];
        return $redirectData;
    }

    public function verify($gatewayComposer , int $amount , array $paymentData): array
    {
        $result = $gatewayComposer->verify($paymentData["Status"], $amount, $paymentData["Authority"]);
        $this->setResultData('zarinpalVerifyResult', $result);

        if (!isset($result)) {
            $this->setResultStatus(false);
            $this->addResultMessage('مشکل در برقراری ارتباط با زرین پال');
            return $this->getResult();
        }

        if (isset($result['RefID']) && strcmp($result['Status'], 'success') == 0) {
            $this->setResultStatus(true);
            $this->setResultData('RefID', $result['RefID']);
            $this->setResultData('cardPanMask', isset($result['ExtraDetail']['Transaction']['CardPanMask'])?$result['ExtraDetail']['Transaction']['CardPanMask']:null);
            $this->addResultMessage('پرداخت کاربر تایید شد.');
        } else {
            $this->setResultStatus(false);
            if (strcmp($result['Status'], 'canceled') == 0) {
                $this->addResultMessage('کاربر از پرداخت انصراف داده است.');
            } else if (strcmp($result['Status'], 'verified_before') ==0) {
                $this->addResultMessage(self::EXCEPTION[101]);
            } else {
                $this->addResultMessage('خطایی در پرداخت رخ داده است.');
                if (isset($result['error'])) {
                    $this->addResultMessage(self::EXCEPTION[$result['error']]);
                }
            }
        }
        return $this->getResult();
    }
}