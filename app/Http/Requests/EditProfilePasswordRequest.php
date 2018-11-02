<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class EditProfilePasswordRequest extends FormRequest
{
    use CharacterCommon;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth()
            ->user()
            ->can(Config::get('constants.EDIT_USER_ACCESS')))
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        session()->put("tab", "tab_1_3");
        return [
            'password'    => 'required|confirmed|min:6',
            'oldPassword' => 'required',
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
        if (isset($input["password"])) {
            $input["password"] = $this->convertToEnglish($input["password"]);
        }
        $this->replace($input);
    }
}
