<?php

namespace App\Http\Requests\OrderProduct;

use Illuminate\Foundation\Http\FormRequest;

class OrderProductStoreRequest extends FormRequest
{
    private $hasPermission = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth()->user();

        if ($user) {
            if ($user->can(config("constants.INSERT_ORDERPRODUCT_ACCESS"))) {
                $this->hasPermission = true;
            } else {
                $this->hasPermission = false;
            }
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
        return [];
        $rules = [
            'product_id' => 'required|exists:products,id|activeProduct',
            'products.*' => 'sometimes|exists:products,id|activeProduct',
            'attribute.*' => 'sometimes|exists:attributevalues,id',
            'extraAttribute.*.id' => 'sometimes|exists:attributevalues,id',
            'withoutBon' => 'sometimes|boolean'
        ];
        if ($this->hasPermission) {
            $rules['order_id'] = 'required|exists:orders,id';
            $rules['product_id'] = 'required|exists:products,id';
            $rules['products.*'] = 'sometimes|exists:products,id';
        }
        return $rules;
    }
}
