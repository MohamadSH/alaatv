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
        return [
            'rank'              => 'required',
//            'participationCode' => 'unique:eventresults:'.Hash::check(),
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
