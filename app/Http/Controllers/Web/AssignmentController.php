<?php

namespace App\Http\Controllers\Web;

use App\Assignment;
use App\Assignmentstatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAssignmentRequest;
use App\Http\Requests\InsertAssignmentRequest;
use App\Major;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    protected $response;
    
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.LIST_ASSIGNMENT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_ASSIGNMENT_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.REMOVE_ASSIGNMENT_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_ASSIGNMENT_ACCESS'), ['only' => 'edit']);
        
        $this->response = new Response();
    }

    public function index()
    {
        $assignments = Assignment::all()
            ->sortByDesc('created_at');
        $pageName    = "admin";
        
        return view("assignment.index", compact("assignments", "pageName"));
    }

    public function create()
    {
        return view("assignment.create");
    }

    public function store(InsertAssignmentRequest $request)
    {
        $assignment = new Assignment();
        $assignment->fill($request->all());
        if ($request->hasFile("questionFile")) {
            $file      = $request->file('questionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK2'))
                ->put($fileName, File::get($file))) {
                $assignment->questionFile = $fileName;
            }
        }
        
        if ($request->hasFile("solutionFile")) {
            $file      = $request->file('solutionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            
            if (Storage::disk('assignmentSolutionFile')
                ->put($fileName, File::get($file))) {
                $assignment->solutionFile = $fileName;
            }
        }
        
        if (strlen($request->get("analysisVideoLink")) > 0) {
            if (!preg_match("/^http:\/\//", $assignment->analysisVideoLink) && !preg_match("/^https:\/\//",
                    $assignment->analysisVideoLink)) {
                $assignment->analysisVideoLink = "https://".$assignment->analysisVideoLink;
            }
        }
        
        if ($assignment->save()) {
            $assignment->majors()
                ->sync($request->get('majors', []));
            
            return $this->response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function edit($assignment)
    {
        $majors             = Major::pluck('name', 'id')
            ->toArray();
        $assignmentMajors   = $assignment->majors->pluck('id')
            ->toArray();
        $assignmentStatuses = Assignmentstatus::pluck('name', 'id')
            ->toArray();
        
        return view("assignment.edit", compact("assignment", "majors", "assignmentStatuses", "assignmentMajors"));
    }

    public function update(EditAssignmentRequest $request, $assignment)
    {
        $questionFile = $assignment->questionFile;
        $solutionFile = $assignment->solutionFile;
        
        $assignment->fill($request->all());
        if ($request->hasFile("questionFile")) {
            $file      = $request->file('questionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK2'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK2'))
                    ->delete($questionFile);
                $assignment->questionFile = $fileName;
            }
        }
        
        if ($request->hasFile("solutionFile")) {
            $file      = $request->file('solutionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            
            if (Storage::disk('assignmentSolutionFile')
                ->put($fileName, File::get($file))) {
                Storage::disk('assignmentSolutionFile')
                    ->delete($solutionFile);
                $assignment->solutionFile = $fileName;
            }
        }
        
        if (strlen($request->get("analysisVideoLink")) > 0) {
            if (!preg_match("/^http:\/\//", $assignment->analysisVideoLink) && !preg_match("/^https:\/\//",
                    $assignment->analysisVideoLink)) {
                $assignment->analysisVideoLink = "https://".$assignment->analysisVideoLink;
            }
        }
        
        if ($assignment->update()) {
            session()->put('success', 'اصلاح تمرین با موفقیت انجام شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }

    public function destroy($assignment)
    {
        if ($assignment->delete()) {
            session()->put('success', 'تمرین با موفقیت حذف شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }
}
