<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertAttributeRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.INSERT_ATTRIBUTE_ACCESS'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        return [
            'name'                => 'required',
            'displayName'         => 'required',
            'attributecontrol_id' => 'required|exists:attributecontrols,id',
        ];
    }
}
