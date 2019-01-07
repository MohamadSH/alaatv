<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CheckoutPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRules();
    }

    /**
     * @return array
     */
    private function getRules():array
    {
        $user = Auth::user();
        if(isset($user))
            $rules = [
                "order_id" => "required",
            ] ;
        else
            $rules = [];

        return $rules;
    }
}
