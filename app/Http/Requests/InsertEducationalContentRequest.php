<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class InsertEducationalContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'))) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $fileExtraRule = "";
        if(Input::hasFile("file")) $fileExtraRule = "|mimes:pdf";

        $file2ExtraRule = "";
        if(Input::hasFile("file2")) $file2ExtraRule = "mimes:pdf";


        return [
//            'order' => 'required|numeric',
            'name'=>'required',
            'grades'=>'required|exists:grades,id',
            'majors'=>'required|exists:majors,id',
            'contenttypes'=>'required|exists:contenttypes,id',
            'file'=>'required'.$fileExtraRule,
            'file2'=> $file2ExtraRule
        ];
    }
}
