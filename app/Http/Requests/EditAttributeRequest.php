<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAttributeRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.EDIT_ATTRIBUTE_ACCESS'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        return [
            'name'                => 'required',
            'displayName'         => 'required',
            'attributecontrol_id' => 'exists:attributecontrols,id',
        ];
    }
}
