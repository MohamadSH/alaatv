<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class SubmitCouponRequest extends FormRequest
{
    use CharacterCommon;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code'      => 'required_without:coupon|string',
            'coupon'    => 'required_without:code',
            'order_id'  => 'required_without:openOrder',
            'openOrder' => 'required_without:order_id',
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
        if (isset($input['code'])) {
            $input['code'] = preg_replace('/\s+/', '', $input['code']);
            $input['code'] = $this->convertToEnglish($input['code']);
        }
        $this->replace($input);
    }
}
