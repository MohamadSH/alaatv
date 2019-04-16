<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class InsertContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth()->user()->can(Config::get('constants.INSERT_CONTACT_ACCESS'))) {
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
        if ($this->request->get("relative_id") == 0) {
            $this->request->set("relative_id", null);
        }
        $userId = $this->get('user_id');

        return [
            'name' => 'required',
            'contacttype_id' => 'exists:contacttypes,id',
            'relative_id' => 'unique:contacts,relative_id,NULL,id,deleted_at,NULL,user_id,'.$userId,
            'user_id' => 'exists:users,id',
        ];
    }
}
