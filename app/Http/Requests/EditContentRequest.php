<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class EditContentRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
            ->user()
            ->can(config('constants.EDIT_EDUCATIONAL_CONTENT'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        return [
            //            'order' => 'required|numeric',
            'name'  => 'required',
            //            'grades'=>'required|exists:grades,id',
            //            'majors'=>'required|exists:majors,id',
            //            'contenttypes'=>'required|exists:contenttypes,id',
        ];
    }
}
