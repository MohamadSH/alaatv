<?php

namespace App\Http\Requests;

use App\Rules\FilesArray;
use Illuminate\Foundation\Http\FormRequest;

class InsertContentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules()
    {
        return [
            'order'          => 'required|numeric',
            'name'           => 'required',
            'contenttype_id' => 'required|exists:contenttypes,id',
            'contentset_id' =>  'required|exists:contentsets,id',
            'fileName'       => 'required',
        ];
    }
}
