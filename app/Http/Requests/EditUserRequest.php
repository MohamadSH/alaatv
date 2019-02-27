<?php

namespace App\Http\Requests;

use App\Afterloginformcontrol;
use App\Traits\CharacterCommon;
use App\Traits\RequestCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
{
    use CharacterCommon;
    use RequestCommon ;

    const USER_UPDATE_TYPE_TOTAL    = "total" ;
    const USER_UPDATE_TYPE_PROFILE  = "profile" ;
    const USER_UPDATE_TYPE_ATLOGIN  = "atLogin" ;
    const USER_UPDATE_TYPE_PASSWORD = "password" ;
    const USER_UPDATE_TYPE_PHOTO    = "photo" ;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //ToDo : Has put at the begining of UserController@update . Needs to be refactored

        /*$user = $this->user();
        $updateType = $this->request->get("updateType");
        $authorized = true;
        switch ($updateType)
        {
            case self::USER_UPDATE_TYPE_TOTAL :
                if (!$user->can(config('constants.EDIT_USER_ACCESS')))
                    $authorized = false;
                break;
            case self::USER_UPDATE_TYPE_PASSWORD :
            case self::USER_UPDATE_TYPE_ATLOGIN :
            case self::USER_UPDATE_TYPE_PHOTO :
            case self::USER_UPDATE_TYPE_PROFILE :
                $isRequestedUserAndAuthSame = $this->hasRequestAuthUser($user , $this);
                if(!$isRequestedUserAndAuthSame)
                    $authorized = false;

                if($user->isUserProfileLocked())
                    $authorized = false;
                break;
            default:
                break;
        }

        return $authorized;*/
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->request->get("id");

        $updateType = $this->request->get("updateType" , self::USER_UPDATE_TYPE_TOTAL);
        switch ($updateType)
        {
            case self::USER_UPDATE_TYPE_TOTAL :
                $rules = [
                    'firstName'     => 'required|max:255',
                    'lastName'      => 'required|max:255',
                    'mobile'        => [
                        'required',
                        'digits:11',
                        Rule::phone()->mobile()->country('AUTO,IR'),
                        Rule::unique('users')
                            ->where(function ($query) use ($userId){
                                $query->where('nationalCode', $this->request->get("nationalCode"))
                                    ->where('id','<>',$userId)
                                    ->where('deleted_at', null);
                            }),
                    ],
                    'nationalCode'  => [
                        'required',
                        'digits:10',
                        'validate:nationalCode',
                        Rule::unique('users')
                            ->where(function ($query) use($userId) {
                                $query->where('mobile', $this->request->get("mobile"))
                                    ->where('id','<>',$userId)
                                    ->where('deleted_at', null);
                            }),
                    ],
                    'userstatus_id' => 'required|exists:userstatuses,id',
                    'photo'         => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:512',
                    'postalCode'    => 'sometimes|nullable|numeric',
                    'email'         => 'sometimes|nullable|email',
                    'password'      => 'sometimes|nullable|confirmed|min:6',
                    'major_id'      => 'sometimes|nullable|exists:majors,id',
                    'gender_id'     => 'sometimes|nullable|exists:genders,id',
                    'techCode'      => 'sometimes|nullable|alpha_num|max:5|min:5|unique:users,techCode,' . $userId . ',id',
                ];
                break;
            case self::USER_UPDATE_TYPE_PROFILE :
                $rules = [
                    'postalCode' => 'sometimes|nullable|numeric',
                    'email'      => 'sometimes|nullable|email',
                    'photo'      => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:800',
                    //ToDo: it needs to be required but will conflict with profile update
                ];
                break;
            case self::USER_UPDATE_TYPE_PHOTO :
                $rules = [
                    'photo'      => 'required|image|mimes:jpeg,jpg,png|max:800',
                ];
                break;
            case self::USER_UPDATE_TYPE_ATLOGIN :
                $afterLoginFields = $this->getAfterLoginFields();

                //ToDo : Could be refactored to be more dynamic
                $rules = [];
                foreach ($afterLoginFields as $afterLoginField) {
                    if (strcmp($afterLoginField, "email") == 0)
                        $rules[$afterLoginField] = "required|email";
                    else if (strcmp($afterLoginField, "photo") == 0)
                        $rules[$afterLoginField] = "required|image|mimes:jpeg,jpg,png|max:512";
                    else if (strcmp($afterLoginField, "major_id") == 0)
                        $rules[$afterLoginField] = "required|exists:majors,id";
                    else if (strcmp($afterLoginField, "gender_id") == 0)
                        $rules[$afterLoginField] = "required|exists:genders,id";
                    else
                        $rules[$afterLoginField] = "required|max:255";
                }
                break;
            case self::USER_UPDATE_TYPE_PASSWORD :
                $rules =  [
                    'password'    => 'required|confirmed|min:6',
                    'oldPassword' => 'required',
                ];
                break;
            default:
                $rules = [];
                break;
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    private function replaceNumbers()
    {
        $input = $this->request->all();
        if (isset($input["mobile"])) {
            $input["mobile"] = preg_replace('/\s+/', '', $input["mobile"]);
            $input["mobile"] = $this->convertToEnglish($input["mobile"]);
        }
        if (isset($input["postalCode"])) {
            $input["postalCode"] = preg_replace('/\s+/', '', $input["postalCode"]);
            $input["postalCode"] = $this->convertToEnglish($input["postalCode"]);
        }
        if (isset($input["nationalCode"])) {
            $input["nationalCode"] = preg_replace('/\s+/', '', $input["nationalCode"]);
            $input["nationalCode"] = $this->convertToEnglish($input["nationalCode"]);
        }
        if (isset($input["password"])) {
            $input["password"] = $this->convertToEnglish($input["password"]);
        }
        if (isset($input["email"])) {
            $input["email"] = preg_replace('/\s+/', '', $input["email"]);
            $input["email"] = $this->convertToEnglish($input["email"]);
        }
        $this->replace($input);
    }

    /**
     * @return array
     */
    private function getAfterLoginFields(): array
    {
        $afterLoginFields = Afterloginformcontrol::getFormFields()->pluck('name', 'id')->toArray();
        return $afterLoginFields;
    }
}
