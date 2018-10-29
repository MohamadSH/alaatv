<?php

namespace App\Http\Requests;

use App\Rules\FilesArray;
use Illuminate\Foundation\Http\FormRequest;

class InsertContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
//        dd($this->request->get('files'));
        //TODO:// contenttypes,id exists on contentType
        return [
              'order' => 'numeric',
              'name'=>'required',
              'contenttype_id'=>'required',
              'files' => [ new FilesArray]
        ];

    }
}
