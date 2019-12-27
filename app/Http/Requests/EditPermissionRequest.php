<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPermissionRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
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
            'name'         => 'required|unique:permissions,name,' . $permission->id . ',id',
            'display_name' => 'required',
        ];
    }
}
