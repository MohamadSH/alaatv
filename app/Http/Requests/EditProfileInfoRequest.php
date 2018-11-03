<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use App\Traits\UserCommon;
use Illuminate\Foundation\Http\FormRequest;

class EditProfileInfoRequest extends FormRequest
{
    use UserCommon ;
    use CharacterCommon;

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
        $rules = [
            'postalCode' => 'numeric',
            'email' => 'email',
            'photo' => 'image|mimes:jpeg,jpg,png|max:800', //ToDo: it needs to be required but will conflict with profile update
        ];

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
