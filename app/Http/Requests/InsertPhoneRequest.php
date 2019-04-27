<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class InsertPhoneRequest extends FormRequest
{
    use CharacterCommon;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth()
            ->user()
            ->can(Config::get('constants.INSERT_CONTACT_ACCESS'))) {
            return true;
        }
        
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
            'phoneNumber'  => 'required|numeric',
            'priority'     => 'numeric',
            'contact_id'   => 'exists:contacts,id',
            'phonetype_id' => 'exists:phonetypes,id',
        ];
    }
    
    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }
    
    protected function replaceNumbers()
    {
        $input = $this->request->all();
        if (isset($input["phoneNumber"])) {
            $input["phoneNumber"] = preg_replace('/\s+/', '', $input["phoneNumber"]);
            $input["phoneNumber"] = $this->convertToEnglish($input["phoneNumber"]);
        }
        
        if (isset($input["priority"])) {
            $input["priority"] = preg_replace('/\s+/', '', $input["priority"]);
            $input["priority"] = $this->convertToEnglish($input["priority"]);
        }
        $this->replace($input);
    }
}
