<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class EditOrderRequest extends FormRequest
{
    use CharacterCommon;
    protected $id;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.EDIT_ORDER_ACCESS'))) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->id = $_REQUEST["id"];
        $rules = [
            'discount' => 'numeric',
            'orderstatus_id' => 'exists:orderstatuses,id',
            'paymentstatus_id' => 'exists:paymentstatuses,id',
        ];
        if(Input::get(['transactionstatus_id']) != Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL")){$rules['transactionID'] = 'max:0';}

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    protected function replaceNumbers()
    {
        $input = $this->request->all() ;
        if(isset($input["discount"]))
        {
            $input["discount"] = preg_replace('/\s+/', '', $input["discount"] ) ;
            $input["discount"] = $this->convertToEnglish($input["discount"]) ;
        }
        $this->replace($input) ;
    }
}
