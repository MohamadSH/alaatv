<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class RegisterForSanatiSharifHighSchoolRequest extends FormRequest
{
    use CharacterCommon;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        if ($this->request->has("firstName")) {
            $rules["firstName"] = "required";
        } else {
            $rules["firstName"] = "";
        }

        if ($this->request->has("lastName")) {
            $rules["lastName"] = "required";
        } else {
            $rules["lastName"] = "";
        }

        if ($this->request->has("mobile")) {
            $rules["mobile"] = "required|digits:11|phone:AUTO,IR,mobile";
        } else {
            $rules["mobile"] = "";
        }

        if ($this->request->has("nationalCode")) {
            $rules["nationalCode"] = "required|digits_between:0,15";
        } else {
            $rules["nationalCode"] = "";
        }

        return [
            "firstName"    => $rules["firstName"],
            "lastName"     => $rules["lastName"],
            "mobile"       => $rules["mobile"],
            "nationalCode" => $rules["nationalCode"],
            "grade_id"     => "required|exists:grades,id",
            "major_id"     => "required|exists:majors,id",
            //            "score" => "required",
            "score"        => [
                'required',
                'regex:/[0-9]\.*/',
            ],
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
        if (isset($input["mobile"])) {
            $input["mobile"] = preg_replace('/\s+/', '', $input["mobile"]);
            $input["mobile"] = $this->convertToEnglish($input["mobile"]);
        }

        if (isset($input["nationalCode"])) {
            $input["nationalCode"] = preg_replace('/\s+/', '', $input["nationalCode"]);
            $input["nationalCode"] = $this->convertToEnglish($input["nationalCode"]);
        }

        if (isset($input["score"])) {
            $input["score"] = preg_replace('/\s+/', '', $input["score"]);
            $input["score"] = $this->convertToEnglish($input["score"]);
        }

        $this->replace($input);
    }
}
