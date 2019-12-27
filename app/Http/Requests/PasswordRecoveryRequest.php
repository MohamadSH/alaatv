<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRecoveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!Auth::check()) {
            $rules = ["mobileNumber" => "required"];
        } else {
            $rules = [];
        }

        return $rules;
    }
}
