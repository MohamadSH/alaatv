<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class InsertTransactionRequest extends FormRequest
{
    use CharacterCommon;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'order_id'             => 'required',
            'cost'                 => 'required|integer',
            'transactionstatus_id' => 'required|exists:transactionstatuses,id',
            'referenceNumber'      => 'sometimes|nullable|string|min:2',
            'traceNumber'          => 'sometimes|nullable|string|min:2',
            'authority'            => 'sometimes|nullable|string|min:2',
            'paycheckNumber'       => 'sometimes|nullable|string|min:2',
            'completed_at'         => 'sometimes|date_format:Y-n-j',
            'deadline_at'          => 'sometimes|date_format:Y-n-j',
        ];

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->initiateValues();
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    protected function initiateValues()
    {
        $input = $this->request->all();
        if (isset($input["paymentMethodName"])) {
            $paymentMethod = $input["paymentMethodName"];
            switch ($paymentMethod) {
                case "online":
                    $input["paymentmethod_id"] = 1;
                    if (!isset($input["transactionstatus_id"])) {
                        $input["transactionstatus_id"] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
                    }
                    if (!isset($input["transactiongateway_id"])) {
                        $input["transactiongateway_id"] = 1;
                    }
                    break;
                case "ATM":
                    $input["paymentmethod_id"] = 2;
                    if (!isset($input["transactionstatus_id"])) {
                        $input["transactionstatus_id"] = config("constants.TRANSACTION_STATUS_PENDING");
                    }
                    break;
                case "POS":
                    $input["paymentmethod_id"] = 3;
                    if (!isset($input["transactionstatus_id"])) {
                        $input["transactionstatus_id"] = config("constants.TRANSACTION_STATUS_PENDING");
                    }
                    break;
                case "paycheck":
                    $input["paymentmethod_id"] = 4;
                    if (!isset($input["transactionstatus_id"])) {
                        $input["transactionstatus_id"] = config("constants.TRANSACTION_STATUS_PENDING");
                    }
                    break;
                //            case "cash":
                //                $this->request->set("paymentmethod_id" , 5);
                ////                $this->request->set("transactionstatus_id" , config("constants.TRANSACTION_STATUS_SUCCESSFUL"));
                //                break;
                default:
                    break;
            }
        }
        $input["destinationBankAccount_id"] = 1;
        $this->replace($input);
    }
    
    protected function replaceNumbers()
    {
        $input = $this->request->all();
        if (isset($input["cost"])) {
            $input["cost"] = preg_replace('/\s+/', '', $input["cost"]);
            $input["cost"] = $this->convertToEnglish($input["cost"]);
        }
        if (isset($input["referenceNumber"])) {
            $input["referenceNumber"] = preg_replace('/\s+/', '', $input["referenceNumber"]);
            $input["referenceNumber"] = $this->convertToEnglish($input["referenceNumber"]);
        }
        if (isset($input["traceNumber"])) {
            $input["traceNumber"] = preg_replace('/\s+/', '', $input["traceNumber"]);
            $input["traceNumber"] = $this->convertToEnglish($input["traceNumber"]);
        }
        if (isset($input["transactionID"])) {
            $input["transactionID"] = preg_replace('/\s+/', '', $input["transactionID"]);
            $input["transactionID"] = $this->convertToEnglish($input["transactionID"]);
        }
        if (isset($input["authority"])) {
            $input["authority"] = preg_replace('/\s+/', '', $input["authority"]);
            $input["authority"] = $this->convertToEnglish($input["authority"]);
        }
        if (isset($input["paycheckNumber"])) {
            $input["paycheckNumber"] = preg_replace('/\s+/', '', $input["paycheckNumber"]);
            $input["paycheckNumber"] = $this->convertToEnglish($input["paycheckNumber"]);
        }
        if (isset($input["managerComment"])) {
            if (strlen($input["managerComment"]) > 0) {
                $input["managerComment"] = $this->convertToEnglish($input["managerComment"]);
            }
        }
        $this->replace($input);
    }
}
