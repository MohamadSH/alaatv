<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsFormRequest extends FormRequest
{
    use CharacterCommon ;
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
     */
    public function rules()
    {
        return [
            'email'=>'email',
            'fullName' => 'required|max:255',
            'phone' => 'numeric',
            'message' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }


    protected function replaceNumbers()
    {
        $input = $this->request->all() ;
        if(isset($input["phone"]))
        {
            $input["phone"] = preg_replace('/\s+/', '', $input["phone"] ) ;
            $input["phone"] = $this->convertToEnglish($input["phone"]) ;
        }
        if(isset($input["email"]))
        {
            $input["email"] = preg_replace('/\s+/', '', $input["email"] ) ;
            $input["email"] = $this->convertToEnglish($input["email"]) ;
        }
        $this->replace($input) ;
    }
}
