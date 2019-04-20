<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class EditConsultationRequest extends FormRequest
{
    use CharacterCommon;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth()->user()->can(Config::get('constants.EDIT_CONSULTATION_ACCESS'))) {
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
            'majors' => 'required|exists:majors,id',
            'consultationstatus_id' => 'required|exists:consultationstatuses,id',
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
        if (isset($input["order"])) {
            $input["order"] = preg_replace('/\s+/', '', $input["order"]);
            $input["order"] = $this->convertToEnglish($input["order"]);
        }
        $this->replace($input);
    }
}
