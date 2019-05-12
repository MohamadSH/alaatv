<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class InsertAttributevalueRequest extends FormRequest
{

    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.INSERT_ATTRIBUTEVALUE_ACCESS'))) {
            return true;
        }
        
        return false;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
