<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class EditPermissionRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth()
            ->user()
            ->can(config('constants.EDIT_PERMISSION_ACCESS'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        $permission = $this->route('permission');
    
        return [
            'name'         => 'required|unique:permissions,name,'.$permission->id.',id',
            'display_name' => 'required',
        ];
    }
}
