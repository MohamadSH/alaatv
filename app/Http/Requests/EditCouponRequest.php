<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class EditCouponRequest extends FormRequest
{
    use CharacterCommon;

    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.EDIT_COUPON_ACCESS'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        return [
            'name'          => 'required',
            'code'          => 'required',
            'discount'      => 'numeric',
            'usageNumber'   => 'numeric',
            'usageLimit'    => 'required_if:limitStatus,1|numeric',
            'coupontype_id' => 'required|exists:coupontypes,id',
            'products'      => 'required_if:coupontype_id,2',
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
        if (isset($input["code"])) {
            $input["code"] = preg_replace('/\s+/', '', $input["code"]);
            $input["code"] = $this->convertToEnglish($input["code"]);
        }

        if (isset($input["discount"])) {
            $input["discount"] = preg_replace('/\s+/', '', $input["discount"]);
            $input["discount"] = $this->convertToEnglish($input["discount"]);
        }

        if (isset($input["usageNumber"])) {
            $input["usageNumber"] = preg_replace('/\s+/', '', $input["usageNumber"]);
            $input["usageNumber"] = $this->convertToEnglish($input["usageNumber"]);
        }

        if (isset($input["usageLimit"])) {
            $input["usageLimit"] = preg_replace('/\s+/', '', $input["usageLimit"]);
            $input["usageLimit"] = $this->convertToEnglish($input["usageLimit"]);
        }

        $this->replace($input);
    }
}
