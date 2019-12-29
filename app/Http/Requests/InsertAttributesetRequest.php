<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertAttributesetRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.INSERT_ATTRIBUTESET_ACCESS'))) {
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
