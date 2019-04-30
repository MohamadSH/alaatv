<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class InsertAttributesetRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth()
            ->user()
            ->can(Config::get('constants.INSERT_ATTRIBUTESET_ACCESS'))) {
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
