<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNewBlockRequest extends FormRequest
{
    public function authorize()
    {
        if (auth()
            ->user()
            // ->can(config('constants.INSERT_CONTACT_ACCESS'))
        ) {
            return true;
        }
        
        return false;
    }
    
    public function rules()
    {
        return [
            'order'  => 'required|numeric',
//            'title'     => 'required|string',
//            'customUrl'   => 'string',
//            'class' => 'string',
//            'type' => 'required|numeric',
//            'tags' => 'string',
        ];
    }
}
