<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class InsertContentRequest extends FormRequest
{
    use CharacterCommon;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS')))
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules()
    {
        throw new \Exception("update File Format Request!");
        $fileExtraRule = "";
        if(Input::hasFile("file")) $fileExtraRule = "|mimes:pdf,rar";

        $file2ExtraRule = "";
        if(Input::hasFile("file2")) $file2ExtraRule = "mimes:pdf,rar";


        return [
//            'order' => 'required|numeric',
            'name'=>'required',
            'contenttype_id'=>'required|exists:contenttypes,id',
            'file'=>'required'.$fileExtraRule,
            'file2'=> $file2ExtraRule,
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
        if(isset($input["order"]))
        {
            $input["order"] = preg_replace('/\s+/', '', $input["order"] ) ;
            $input["order"] = $this->convertToEnglish($input["order"]) ;
        }

        $this->replace($input) ;
    }
}
