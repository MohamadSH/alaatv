<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class InsertEventResultRequest extends FormRequest
{
    use CharacterCommon;

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
        $rules = [];
        if ($this->request->has("firstName"))
            $rules["firstName"] = "required";
        else $rules["firstName"] = "";

        if ($this->request->has("lastName"))
            $rules["lastName"] = "required";
        else $rules["lastName"] = "";

        if ($this->request->has("major_id"))
            $rules["major_id"] = "required|exists:majors,id";
        else $rules["major_id"] = "";

        if ($this->request->has("enableReportPublish"))
            $rules["participationCode"] = "required";
        else {
            $rules["participationCode"] = "";
        }

        //        if($this->request->has("participationCode")) {
        //            if(strlen(preg_replace('/\s+/', '', $this->request->get("participationCode"))) != 0)
        //                $rules["participationCode"] .= "unique:eventresults:".Hash::check();
        //        }
        //        else {
        //            $rules["participationCode"] = "" ;
        //        }

        return [
            'firstName'         => $rules["firstName"],
            'lastName'          => $rules["lastName"],
            'major_id'          => $rules["major_id"],
            'rank'              => 'required',
            'participationCode' => $rules["participationCode"],
            'event_id'          => 'required|exists:events,id',
            'reportFile'        => 'required|mimes:jpeg,jpg,png,pdf,rar,zip',
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
        if (isset($input["participationCode"])) {
            $input["participationCode"] = preg_replace('/\s+/', '', $input["participationCode"]);
            $input["participationCode"] = $this->convertToEnglish($input["participationCode"]);
        }
        if (isset($input["rank"])) {
            $input["rank"] = preg_replace('/\s+/', '', $input["rank"]);
            $input["rank"] = $this->convertToEnglish($input["rank"]);
        }
        if (strlen(preg_replace('/\s+/', '', $input['comment'])) == 0)
            $input['comment'] = null;

        $this->replace($input);
    }
}
