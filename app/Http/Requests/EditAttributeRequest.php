<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class EditAttributeRequest extends FormRequest
{

    public function authorize()
    {
        if (Auth()
            ->user()
            ->can(Config::get('constants.EDIT_ATTRIBUTE_ACCESS'))) {
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
