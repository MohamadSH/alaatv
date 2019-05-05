<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class EditContentRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth()
            ->user()
            ->can(config('constants.EDIT_EDUCATIONAL_CONTENT'))) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        $file1ExtraRule = "";
        if (Input::hasFile("file1")) {
            $file1ExtraRule = "mimes:pdf";
        }
    
        $file2ExtraRule = "";
        if (Input::hasFile("file2")) {
            $file2ExtraRule = "mimes:pdf";
        }
    
        return [
            //            'order' => 'required|numeric',
            'name'  => 'required',
            //            'grades'=>'required|exists:grades,id',
            //            'majors'=>'required|exists:majors,id',
            //            'contenttypes'=>'required|exists:contenttypes,id',
            'file1' => $file1ExtraRule,
            'file2' => $file2ExtraRule,
        ];
    }
}
