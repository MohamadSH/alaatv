<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    use CharacterCommon;

    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.EDIT_PRODUCT_ACCESS'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        return [
            'name'            => 'required',
            'basePrice'       => 'required|numeric',
//            'order'           => 'numeric',
//            'discount'        => 'numeric',
            'amount'          => 'required_if:amountLimit,1',
            'image'           => 'image|mimes:jpeg,jpg,png',
            'file'            => 'file',
            'attributeset_id' => 'required|exists:attributesets,id',
            'bonPlus'         => 'nullable|numeric',
            'bonDiscount'     => 'nullable|numeric',
        ];
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    protected function replaceNumbers()
    {
        $input = $this->request->all();
        if (isset($input["order"])) {
            $input["order"] = preg_replace('/\s+/', '', $input["order"]);
            $input["order"] = $this->convertToEnglish($input["order"]);
        }

        if (isset($input["discount"])) {
            $input["discount"] = preg_replace('/\s+/', '', $input["discount"]);
            $input["discount"] = $this->convertToEnglish($input["discount"]);
        }

        if (isset($input["amount"])) {
            $input["amount"] = preg_replace('/\s+/', '', $input["amount"]);
            $input["amount"] = $this->convertToEnglish($input["amount"]);
        }
        $this->replace($input);
    }
}
