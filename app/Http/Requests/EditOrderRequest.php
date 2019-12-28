<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class EditOrderRequest extends FormRequest
{
    use CharacterCommon;

    protected $id;

    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.EDIT_ORDER_ACCESS'))) {
            return true;
        }

        return false;
    }

    public function rules(\Illuminate\Http\Request $request)
    {
        $this->id = $_REQUEST["id"];
        $rules    = [
            'discount'         => 'numeric',
            'orderstatus_id'   => 'exists:orderstatuses,id',
            'paymentstatus_id' => 'exists:paymentstatuses,id',
        ];
        if ($request->get('transactionstatus_id') != config("constants.TRANSACTION_STATUS_SUCCESSFUL")) {
            $rules['transactionID'] = 'max:0';
        }

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
        if (isset($input["discount"])) {
            $input["discount"] = preg_replace('/\s+/', '', $input["discount"]);
            $input["discount"] = $this->convertToEnglish($input["discount"]);
        }
        $this->replace($input);
    }
}
