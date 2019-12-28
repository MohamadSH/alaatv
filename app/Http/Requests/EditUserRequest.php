<?php

namespace App\Http\Requests;

use App\Afterloginformcontrol;
use App\Traits\CharacterCommon;
use App\Traits\RequestCommon;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
{
    use CharacterCommon;
    use RequestCommon;

    const USER_UPDATE_TYPE_TOTAL = 'total';

    const USER_UPDATE_TYPE_PROFILE = 'profile';

    const USER_UPDATE_TYPE_ATLOGIN = 'atLogin';

    const USER_UPDATE_TYPE_PASSWORD = 'password';

    const USER_UPDATE_TYPE_PHOTO = 'photo';

    const PHOTO_RULE = '|image|mimes:jpeg,jpg,png|max:512';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $authenticatedUser = $request->user();
        $userId            = $this->getUserIdFromRequestBody($request)->getValue(false);

        if (!in_array($this->request->get('updateType'), [self::USER_UPDATE_TYPE_TOTAL, self::USER_UPDATE_TYPE_PROFILE, self::USER_UPDATE_TYPE_ATLOGIN, self::USER_UPDATE_TYPE_PASSWORD, self::USER_UPDATE_TYPE_PASSWORD])) {
            return false;
        }

        if ($this->isHeUpdatingHisOwnProfile($userId, $authenticatedUser))//He is updating his own profile
            return true;

        if ($this->hasUserAuthorityForEditAction($authenticatedUser))
            return true;

        return false;
    }

    private function getUserIdFromRequestBody(Request $request)
    {
        $userId = $request->segment(2);
        if ((int)$userId == 0) {
            $userId = null;
        }

        return nullable($userId);

    }

    /**
     * @param      $userId
     * @param User $authenticatedUser
     *
     * @return bool
     */
    private function isHeUpdatingHisOwnProfile($userId, User $authenticatedUser): bool
    {
        return !$userId || $userId !== $authenticatedUser->id;
    }

    /**
     * @param User $authenticatedUser
     *
     * @return bool
     */
    private function hasUserAuthorityForEditAction(User $authenticatedUser): bool
    {
        return $authenticatedUser->can(config('constants.EDIT_USER_ACCESS'));
    }

    public function rules()
    {
        $userId = $this->request->get('id');

        $updateType = $this->request->get('updateType', self::USER_UPDATE_TYPE_TOTAL);
        switch ($updateType) {
            case self::USER_UPDATE_TYPE_TOTAL :
                $rules = [
                    'firstName'     => 'required|max:255',
                    'lastName'      => 'required|max:255',
                    'mobile'        => [
                        'required',
                        'digits:11',
                        Rule::phone()
                            ->mobile()
                            ->country('AUTO,IR'),
                        Rule::unique('users')
                            ->where(function ($query) use ($userId) {
                                $query->where('nationalCode', $this->request->get('nationalCode'))
                                    ->where('id', '<>', $userId)
                                    ->where('deleted_at', null);
                            }),
                    ],
                    'nationalCode'  => [
                        'required',
                        'digits:10',
                        'validate:nationalCode',
                        Rule::unique('users')
                            ->where(function ($query) use ($userId) {
                                $query->where('mobile', $this->request->get('mobile'))
                                    ->where('id', '<>', $userId)
                                    ->where('deleted_at', null);
                            }),
                    ],
                    'password'      => 'sometimes|nullable|min:10|confirmed',
                    'userstatus_id' => 'required|exists:userstatuses,id',
                    'photo'         => 'sometimes|nullable' . self::PHOTO_RULE,
                    'postalCode'    => 'sometimes|nullable|numeric',
                    'email'         => 'sometimes|nullable|email',
                    'major_id'      => 'sometimes|nullable|exists:majors,id',
                    'gender_id'     => 'sometimes|nullable|exists:genders,id',
                    'techCode'      => 'sometimes|nullable|alpha_num|max:5|min:5|unique:users,techCode,' . $userId . ',id',
                ];
                break;
            case self::USER_UPDATE_TYPE_PROFILE :
                $rules = [
                    'postalCode' => 'sometimes|nullable|numeric',
                    'email'      => 'sometimes|nullable|email',
                    'photo'      => 'sometimes|nullable' . self::PHOTO_RULE,
                ];
                break;
            case self::USER_UPDATE_TYPE_PHOTO :
                $rules = [
                    'photo' => 'required' . self::PHOTO_RULE,
                ];
                break;
            case self::USER_UPDATE_TYPE_ATLOGIN :
                $afterLoginFields = $this->getAfterLoginFields();

                $this->refineAfterLoginRequest($afterLoginFields);

                $rules = [];
                foreach ($afterLoginFields as $afterLoginField) {
                    $rule = 'required';
                    if (strcmp($afterLoginField, 'email') == 0) {
                        $rule .= '|email';
                    } else {
                        if (strcmp($afterLoginField, 'photo') == 0) {
                            $rule .= self::PHOTO_RULE;
                        } else {
                            $rule .= '|max:255';
                        }
                    }

                    $rules[$afterLoginField] = $rule;
                }
                break;
            case self::USER_UPDATE_TYPE_PASSWORD :
                $rules = [
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

    /**
     * @return array
     */
    private function getAfterLoginFields(): array
    {
        $afterLoginFields = Afterloginformcontrol::getFormFields()
            ->pluck('name', 'id')
            ->toArray();

        return $afterLoginFields;
    }

    private function refineAfterLoginRequest(array $baseFields)
    {

        $input = $this->request->all();

        foreach ($input as $key => $value) {
            if (!in_array($key, $baseFields) && $value != self::USER_UPDATE_TYPE_ATLOGIN) {
                Arr::pull($input, $key);
            }
        }

        $this->replace($input);
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    private function replaceNumbers()
    {
        $input = $this->request->all();

        if (isset($input['mobile'])) {
            $input['mobile'] = preg_replace('/\s+/', '', $input['mobile']);
            $input['mobile'] = $this->convertToEnglish($input['mobile']);
        }
        if (isset($input['postalCode'])) {
            $input['postalCode'] = preg_replace('/\s+/', '', $input['postalCode']);
            $input['postalCode'] = $this->convertToEnglish($input['postalCode']);
        }
        if (isset($input['nationalCode'])) {
            $input['nationalCode'] = preg_replace('/\s+/', '', $input['nationalCode']);
            $input['nationalCode'] = $this->convertToEnglish($input['nationalCode']);
        }
        if (isset($input['password'])) {
            $input['password'] = $this->convertToEnglish($input['password']);
        }
        if (isset($input['email'])) {
            $input['email'] = preg_replace('/\s+/', '', $input['email']);
            $input['email'] = $this->convertToEnglish($input['email']);
        }
        $this->replace($input);
    }
}
