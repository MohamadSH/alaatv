<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:34 PM
 */

namespace App\Classes\Payment\Gateway;

use mysql_xdevapi\Exception;

abstract class Gateway
{
    /**
     * @var array $result
     */
    private $result;

    abstract protected function gatewayPaymentRequest(array $data);

    abstract protected function getAuthority(): string;

    final public function paymentRequest(array $data): array {
        $this->refreshResult();
        $this->gatewayPaymentRequest($data);
        $authority = $this->getAuthority();
        if (isset($authority)) {
            $this->setResultData('Authority', $authority);
        } else {
            throw new Exception('Authority not set in class');
        }
        return $this->getResult();
    }


    abstract protected function gatewayRedirectUrl(array $data): string;
    abstract protected function gatewayRedirectMethod(array $data): string;
    abstract protected function gatewayRedirectInputs(array $data): array;

    final public function getRedirectData(array $data): array {
        $redirectUrl = $this->gatewayRedirectUrl($data);
        $redirectInputs = $this->gatewayRedirectInputs($data);
        $redirectMethod = $this->gatewayRedirectMethod($data);
        if(!isset($redirectUrl)) {
            throw new Exception('RedirectUrl not set in class');
        }
        if(!isset($redirectInputs)) {
            throw new Exception('RedirectInputs not set in class');
        }
        if(!isset($redirectMethod)) {
            throw new Exception('RedirectMethod not set in class');
        }
        $redirectData = [
            'url' => $redirectUrl,
            'input' => $redirectInputs,
            'method' => $redirectMethod
        ];
        return $redirectData;
    }



    abstract public function readCallbackData(array $data): array;

    abstract public function verify(array $data): array;


    /********************************
     * manipulate Result
     *********************************/
    final protected function setResultStatus(bool $status): void {
        $this->result['status'] = $status;
    }

    final protected function addResultMessage(string $message): void {
        $this->result['message'][] = $message;
    }

    final protected function setResultData(string $key, $value): void {
        $this->result['data'][$key] = $value;
    }

    final protected function refreshResult(): void{
        $this->result = [
            'status' => true,
            'message' => [],
            'data' => [],
        ];
    }

    final protected function getResultStatus(): bool {
        return $this->result['status'];
    }

    final public function getResult(bool $refreshResult=false): array {
        $result = $this->result;
        if ($refreshResult) {
            $this->refreshResult();
        }
        return $result;
    }
}