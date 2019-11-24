<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNewBlockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
//            'order'  => 'required|numeric',
            'title'     => 'required|string',
//            'customUrl'   => 'string',
//            'class' => 'string',
            'type' => 'required|numeric',
//            'tags' => 'string',
        ];
    }
}
