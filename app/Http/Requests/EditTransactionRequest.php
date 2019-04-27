<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class EditTransactionRequest extends FormRequest
{
    use CharacterCommon;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $transaction = $this->route('transaction');
        $rules       = [
            'cost'            => 'required|integer',
            'referenceNumber' => 'unique:transactions,referenceNumber,'.$transaction->id.',id,deleted_at,NULL|numeric|nullable',
            'traceNumber'     => 'unique:transactions,traceNumber,'.$transaction->id.',id,deleted_at,NULL|numeric|nullable',
            'transactionID'   => 'unique:transactions,transactionID,'.$transaction->id.',id,deleted_at,NULL|numeric|nullable',
            'authority'       => 'unique:transactions,authority,'.$transaction->id.',id,deleted_at,NULL|numeric|nullable',
            'paycheckNumber'  => 'unique:transactions,paycheckNumber,'.$transaction->id.',id,deleted_at,NULL|nullable',
        ];
        
        return $rules;
    }
    
    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }
    
    protected function replaceNumbers()
    {
        $input = $this->request->all();
        if (isset($input["cost"])) {
            $input["cost"] = preg_replace('/\s+/', '', $input["cost"]);
            if (strlen($input["cost"]) > 0) {
                $input["cost"] = (int) $this->convertToEnglish($input["cost"]);
            }
        }
        
        if (isset($input["referenceNumber"])) {
            $input["referenceNumber"] = preg_replace('/\s+/', '', $input["referenceNumber"]);
            if (strlen($input["referenceNumber"]) > 0) {
                $input["referenceNumber"] = (int) $this->convertToEnglish($input["referenceNumber"]);
            }
        }
        
        if (isset($input["traceNumber"])) {
            $input["traceNumber"] = preg_replace('/\s+/', '', $input["traceNumber"]);
            if (strlen($input["traceNumber"]) > 0) {
                $input["traceNumber"] = (int) $this->convertToEnglish($input["traceNumber"]);
            }
        }
        
        if (isset($input["transactionID"])) {
            $input["transactionID"] = preg_replace('/\s+/', '', $input["transactionID"]);
            if (strlen($input["transactionID"]) > 0) {
                $input["transactionID"] = (int) $this->convertToEnglish($input["transactionID"]);
            }
        }
        
        if (isset($input["authority"])) {
            $input["authority"] = preg_replace('/\s+/', '', $input["authority"]);
            if (strlen($input["authority"]) > 0) {
                $input["authority"] = (int) $this->convertToEnglish($input["authority"]);
            }
        }
        
        if (isset($input["paycheckNumber"])) {
            if (strlen($input["paycheckNumber"]) > 0) {
                $input["paycheckNumber"] = (int) $this->convertToEnglish($input["paycheckNumber"]);
            }
        }
        if (isset($input["managerComment"])) {
            if (strlen($input["managerComment"]) > 0) {
                $input["managerComment"] = $this->convertToEnglish($input["managerComment"]);
            }
        }
        $this->replace($input);
    }
}
