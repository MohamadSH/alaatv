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
            'code'     => 'required|string',
            'order_id' => 'required',
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
        if (isset($input["coupon"])) {
            $input["coupon"] = preg_replace('/\s+/', '', $input["coupon"]);
            $input["coupon"] = $this->convertToEnglish($input["coupon"]);
        }
        $this->replace($input);
    }
}
