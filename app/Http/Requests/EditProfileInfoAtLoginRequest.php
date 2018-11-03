<?php

namespace App\Http\Requests;

use App\Afterloginformcontrol;
use Illuminate\Foundation\Http\FormRequest;

class EditProfileInfoAtLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->isUserProfileLocked())
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
        $afterLoginFields = Afterloginformcontrol::getFormFields()
                ->pluck('name', 'id')
                ->toArray();

        $rules = [];
        foreach ($afterLoginFields as $afterLoginField)
        {
            if (strcmp($afterLoginField, "email") == 0)
                $rules[$afterLoginField] = "required|email";
            elseif (strcmp($afterLoginField, "photo") == 0)
                $rules[$afterLoginField] = "required|image|mimes:jpeg,jpg,png|max:512";
            elseif (strcmp($afterLoginField, "major_id") == 0)
                $rules[$afterLoginField] = "required|exists:majors,id";
            elseif (strcmp($afterLoginField, "gender_id") == 0)
                $rules[$afterLoginField] = "required|exists:genders,id";
            else
                $rules[$afterLoginField] = "required|max:255";
        }

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
