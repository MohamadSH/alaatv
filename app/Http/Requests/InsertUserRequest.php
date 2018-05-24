<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class InsertUserRequest extends FormRequest
{
    use CharacterCommon;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.INSERT_USER_ACCESS'))) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'mobile'    => ['required',
                            'digits:11',
                            Rule::unique('users')->where(function ($query) {
                                $query->where('nationalCode', $_REQUEST["nationalCode"])->where('deleted_at' , null);
                            })
                        ],
            'password' => 'required|min:6',
            'nationalCode'   => ['required',
                                 'digits:10',
                                 'validate:nationalCode',
                                Rule::unique('users')->where(function ($query) {
                                    $query->where('mobile', $_REQUEST["mobile"])->where('deleted_at' , null);
                                })
                                 ],
            'userstatus_id' => 'required|exists:userstatuses,id',
            'photo' => 'image|mimes:jpeg,jpg,png|max:512',
            'postalCode'    => 'numeric',
            'major_id' => 'exists:majors,id',
            'gender_id' => 'exists:genders,id',
            'email' => 'email'
        ];

        if(isset($_REQUEST["major_id"]) && strcmp($_REQUEST["major_id"],"0")!=0) $rules["major_id"] = "exists:majors,id";

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
        if(isset($input["email"])) {
            $input["email"] = preg_replace('/\s+/', '', $input["email"] ) ;
            $input["email"] = $this->convertToEnglish($input["email"]) ;
        }
        $this->replace($input) ;
    }
}
