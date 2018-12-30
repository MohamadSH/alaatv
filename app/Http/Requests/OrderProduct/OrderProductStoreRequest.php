<?php

namespace App\Http\Requests\OrderProduct;

use Illuminate\Foundation\Http\FormRequest;

class OrderProductStoreRequest extends FormRequest
{
    private $hasePermition = false;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth()->user();

        if ($user) {
            if($user->can(config("constants.INSERT_ORDERPRODUCT_ACCESS"))) {
                $this->hasePermition = true;
            } else {
                $this->hasePermition = false;
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
        if($this->hasePermition) {
            return [
                'order_id'       => 'required|exists:orders,id',
                'product_id'     => 'required|exists:products,id',
                'products'       => 'sometimes|exists:products,id',
                'attribute'      => 'sometimes|exists:attributevalues,id',
                'extraAttribute' => 'sometimes|exists:attributevalues,id',
                'withoutBon'     => 'sometimes|boolean'
            ];
        } else {
            return [
                'product_id'     => 'required|exists:products,id',
                'products'       => 'sometimes|exists:products,id',
                'attribute'      => 'sometimes|exists:attributevalues,id',
                'extraAttribute' => 'sometimes|exists:attributevalues,id',
                'withoutBon'     => 'sometimes|boolean'
            ];
        }
    }
}
