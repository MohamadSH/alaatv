<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:34 PM
 */

namespace App\Classes\Payment\Gateway;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Exception;

abstract class Gateway
{
    /**
     * @var array $result
     */
    private $result;

    abstract protected function getPaymentRequestInputRules(array $data): array;

    abstract protected function getPaymentRequestToken(array $data):?string ;

    final public function paymentRequest(array $data): array {
        $this->refreshResult();
        $rules = $this->getPaymentRequestInputRules($data);
        $this->dataValidation($data, $rules);
        if (!$this->getResultStatus())
            return $this->getResult();

        $authority = $this->getPaymentRequestToken($data);
        if (isset($authority)) {
            $this->setResultStatus(true);
            $this->addResultMessage('درخواست پرداخت با موفقیت ارسال و نتیجه آن دریافت شد.');
            $this->setResultData('Authority', $authority);
        } else {
            $this->setResultStatus(false);
            $this->addResultMessage('مشکل در برقراری ارتباط با درگاه زرین پال');
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

    protected function dataValidation(array $data , array $rules){
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $this->setResultStatus(false);
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $this->addResultMessage($messages);
            }
            $this->setResultData('WrongInput',$data);
        }
    }

    /********************************
     * manipulate Result
     ********************************/




    /**
     * @param bool $status
     */
    final protected function setResultStatus(bool $status): void {
        $this->result['status'] = $status;
    }

    /**
     * @param string $message
     */
    final protected function addResultMessage(string $message): void {
        $this->result['message'][] = $message;
    }

    /**
     * @param string $key
     * @param $value
     */
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

    /**
     * @param bool $refreshResult
     * @return array
     */
    final public function getResult(bool $refreshResult=false): array {
        if ($refreshResult) {
            $this->refreshResult();
        }
        return $this->result;
    }
}