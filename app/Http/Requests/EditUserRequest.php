<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
{
    use CharacterCommon;

    protected $userId;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.EDIT_USER_ACCESS'))) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->userId = $this->request->get("id");

        $rules = [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'mobile'   => ['required',
                            'digits:11',
                            Rule::unique('users')->where(function ($query) {
                                $query->where('nationalCode',$this->request->get("nationalCode"))->where('id','<>',$this->userId);
                            })
                        ],
            'nationalCode'   => ['required',
                                'digits:10',
                                'validate:nationalCode',
                                Rule::unique('users')->where(function ($query) {
                                    $query->where('mobile', $this->request->get("mobile"))->where('id','<>',$this->userId);
                                })
                            ],
            'userstatus_id' => 'required|exists:userstatuses,id',
            'photo' => 'image|mimes:jpeg,jpg,png|max:350',
            'postalCode'    => 'numeric',
            'email' => 'email',
            'password' => 'confirmed|min:6',
            'major_id' => 'exists:majors,id',
            'gender_id' => 'exists:genders,id',
            'techCode' => 'alpha_num|max:5|min:5|unique:users,techCode,'.$this->userId.',id',
         ];

        if($this->request->has("major_id") && strcmp($this->request->get("major_id"),"0")!=0) $rules["major_id"] = "exists:majors,id";
        return $rules;
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    protected function replaceNumbers()
    {
        $input = $this->request->all() ;
        if(isset($input["mobile"])) {
            $input["mobile"] = preg_replace('/\s+/', '', $input["mobile"] ) ;
            $input["mobile"] = $this->convertToEnglish($input["mobile"]) ;
        }
        if(isset($input["postalCode"])) {
            $input["postalCode"] = preg_replace('/\s+/', '', $input["postalCode"] ) ;
            $input["postalCode"] = $this->convertToEnglish($input["postalCode"]) ;
        }
        if(isset($input["nationalCode"])) {
            $input["nationalCode"] = preg_replace('/\s+/', '', $input["nationalCode"] ) ;
            $input["nationalCode"] = $this->convertToEnglish($input["nationalCode"]) ;
        }
        if(isset($input["password"])) {
            $input["password"] = $this->convertToEnglish($input["password"]) ;
        }
        $this->replace($input) ;
    }
}
