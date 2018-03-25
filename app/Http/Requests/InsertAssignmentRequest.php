<?php

namespace App\Http\Requests;

use App\Traits\CharacterCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class InsertAssignmentRequest extends FormRequest
{
    use CharacterCommon ;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth()->user()->can(Config::get('constants.INSERT_ASSIGNMENT_ACCESS'))) return true;
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
            'questionFile' => 'file|mimes:pdf,rar,zip',
            'solutionFile' => 'file|mimes:pdf,rar,zip',
            'majors' => 'required|exists:majors,id',
            'assignmentstatus_id' => 'required|exists:assignmentstatuses,id',
            'numberOfQuestions' => 'integer|min:1',
        ];
    }

    public function prepareForValidation()
    {
        $this->replaceNumbers();
        parent::prepareForValidation();
    }

    protected function replaceNumbers()
    {
        $input = $this->request->all() ;
        if(isset($input["numberOfQuestions"]))
        {
            $input["numberOfQuestions"] = preg_replace('/\s+/', '', $input["numberOfQuestions"] ) ;
            $input["numberOfQuestions"] = $this->convertToEnglish($input["numberOfQuestions"]) ;
        }

        if(isset($input["order"]))
        {
            $input["order"] = preg_replace('/\s+/', '', $input["order"] ) ;
            $input["order"] = $this->convertToEnglish($input["order"]) ;
        }
        $this->replace($input) ;
    }
}
