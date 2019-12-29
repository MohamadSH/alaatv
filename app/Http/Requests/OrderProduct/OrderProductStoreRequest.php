<?php

namespace App\Http\Requests\OrderProduct;

use Illuminate\Foundation\Http\FormRequest;

class OrderProductStoreRequest extends FormRequest
{
    private $hasPermission = false;


    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'order_id'            => 'required|numeric',
            'product_id'          => 'required|numeric',
            'products'            => 'sometimes|required|array',
            'products.*'          => 'sometimes|required|numeric',
            'attribute'           => 'sometimes|required|array',
            'attribute.*'         => 'sometimes|required|numeric',
            'extraAttribute'      => 'sometimes|required|array',
            'extraAttribute.*'    => 'sometimes|required|array',
            'extraAttribute.*.id' => 'sometimes|required|numeric',
            'withoutBon'          => 'sometimes|required|boolean',
        ];

        return $rules;
    }
}
