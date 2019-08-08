<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;

class InsertEventResultRequest extends FormRequest
{
    use CharacterCommon;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'rank'       => 'required',
            //            'participationCode' => 'unique:eventresults,'.Hash::make($this->request->get('participationCode')),
            'event_id'   => 'required|exists:events,id',
            'reportFile' => 'required|mimes:jpeg,jpg,png,pdf,rar,zip',
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

        $this->replace($input);
    }
}
