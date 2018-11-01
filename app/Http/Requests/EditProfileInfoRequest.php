<?php

namespace App\Http\Requests;

use App\Afterloginformcontrol;
use App\Traits\CharacterCommon;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class EditProfileInfoRequest extends FormRequest
{
    use CharacterCommon;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->lockProfile)
            return false;
        else
            return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'postalCode' => 'numeric',
            'email' => 'email',
            'photo' => 'image|mimes:jpeg,jpg,png|max:800', //ToDo: it needs to be required but will conflict with profile update
        ];

        if (
            (strcmp(url()->previous(), action("UserController@show", $this->user()) . '/') != 0) &&
            (strcmp(url()->previous(), action("UserController@show", $this->user())) != 0) &&
            (strcmp(url()->previous() . '/', action("UserController@show", $this->user()) . '/') != 0) &&
            (strcmp(url()->previous() . '/', action("UserController@show", $this->user())) != 0)
        ) {
            $afterLoginFields = Afterloginformcontrol::getFormFields()->pluck('name', 'id')->toArray();

            foreach ($afterLoginFields as $afterLoginField) {
                if (strcmp($afterLoginField, "email") == 0) $rules[$afterLoginField] = "required|email";
                elseif (strcmp($afterLoginField, "photo") == 0) $rules[$afterLoginField] = "required|image|mimes:jpeg,jpg,png|max:512";
                elseif (strcmp($afterLoginField, "major_id") == 0) $rules[$afterLoginField] = "required|exists:majors,id";
                elseif (strcmp($afterLoginField, "gender_id") == 0) $rules[$afterLoginField] = "required|exists:genders,id";
                else $rules[$afterLoginField] = "required|max:255";
            }
        }

//        if(isset($_REQUEST["gender_id"]) && strcmp($_REQUEST["gender_id"],"0")!=0) $rules["gender_id"] = "exists:genders,id";

//        $rules =[
//
//        ];
        return $rules;
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    protected function replaceNumbers()
    {
        $input = $this->request->all();
        if (isset($input["email"])) {
            $input["email"] = preg_replace('/\s+/', '', $input["email"]);
            $input["email"] = $this->convertToEnglish($input["email"]);
        }
        if (isset($input["postalCode"])) {
            $input["postalCode"] = preg_replace('/\s+/', '', $input["postalCode"]);
            $input["postalCode"] = $this->convertToEnglish($input["postalCode"]);
        }
        $this->replace($input);
    }

}
