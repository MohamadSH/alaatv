<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class AttacheUserBonRequest extends FormRequest
{
    use CharacterCommon ;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.ATTACHE_USER_BON_ACCESS'))) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'totalNumber' => 'required|numeric'
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
        if(isset($input["totalNumber"]))
        {
            $input["totalNumber"] = preg_replace('/\s+/', '', $input["totalNumber"] ) ;
            $input["totalNumber"] = $this->convertToEnglish($input["totalNumber"]) ;
        }
        $this->replace($input) ;
    }
}
