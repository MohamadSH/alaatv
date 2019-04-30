<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class InsertUserUploadRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth::user()
                ->completion() == 100) {
            return true;
        } else {
            return false;
        }
    }

    public function rules()
    {
        return [
            'title'                    => 'required|max:255',
            'consultingAudioQuestions' => 'required|file|mimes:mp3,mpga|max:20480',
        ];
    }
}
