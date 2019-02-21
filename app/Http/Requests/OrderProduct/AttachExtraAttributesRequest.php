<?php

namespace App\Http\Requests\OrderProduct;

use Illuminate\Foundation\Http\FormRequest;

class AttachExtraAttributesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth()->user();
        if ($user) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'extraAttribute' => 'required|array',
            'extraAttribute.*' => 'required|array',
            'extraAttribute.*.id' => 'required|numeric',
            'extraAttribute.*.cost' => 'required|numeric'
        ];
        return $rules;
    }
}
