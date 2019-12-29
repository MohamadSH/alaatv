<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAttributegroupRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.EDIT_ATTRIBUTEGROUP_ACCESS'))) {
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
