<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Assignmentstatus;
use App\Major;
use App\Http\Requests\EditAssignmentRequest;
use App\Http\Requests\InsertAssignmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;

class AssignmentController extends Controller
{
    protected $response;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:' . Config::get('constants.LIST_ASSIGNMENT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . Config::get('constants.INSERT_ASSIGNMENT_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_ASSIGNMENT_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . Config::get('constants.SHOW_ASSIGNMENT_ACCESS'), ['only' => 'edit']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::all()->sortByDesc('created_at');
        $pageName = "admin";
        return view("assignment.index", compact("assignments", "pageName"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("assignment.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \app\Http\Requests\AssignmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertAssignmentRequest $request)
    {
        $assignment = new Assignment();
        $assignment->fill($request->all());
        if ($request->hasFile("questionFile")) {
            $file = $request->file('questionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK2'))->put($fileName, File::get($file))) {
                $assignment->questionFile = $fileName;
            }
        }

        if ($request->hasFile("solutionFile")) {
            $file = $request->file('solutionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;

            if (Storage::disk('assignmentSolutionFile')->put($fileName, File::get($file))) {
                $assignment->solutionFile = $fileName;
            }
        }

        if (strlen($request->get("analysisVideoLink")) > 0)
            if (!preg_match("/^http:\/\//", $assignment->analysisVideoLink) && !preg_match("/^https:\/\//", $assignment->analysisVideoLink))
                $assignment->analysisVideoLink = "https://" . $assignment->analysisVideoLink;

        if ($assignment->save()) {
            $assignment->majors()->sync($request->get('majors', []));
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function show($assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit($assignment)
    {
        $majors = Major::pluck('name', 'id')->toArray();
        $assignmentMajors = $assignment->majors->pluck('id')->toArray();
        $assignmentStatuses = Assignmentstatus::pluck('name', 'id')->toArray();
        return view("assignment.edit", compact("assignment", "majors", "assignmentStatuses", "assignmentMajors"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \app\Http\Requests\AssignmentRequest $request
     * @param  Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(EditAssignmentRequest $request, $assignment)
    {
        $questionFile = $assignment->questionFile;
        $solutionFile = $assignment->solutionFile;

        $assignment->fill($request->all());
        if ($request->hasFile("questionFile")) {
            $file = $request->file('questionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK2'))->put($fileName, File::get($file))) {
                Storage::disk(Config::get('constants.DISK2'))->delete($questionFile);
                $assignment->questionFile = $fileName;
            }
        }

        if ($request->hasFile("solutionFile")) {
            $file = $request->file('solutionFile');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;

            if (Storage::disk('assignmentSolutionFile')->put($fileName, File::get($file))) {
                Storage::disk('assignmentSolutionFile')->delete($solutionFile);
                $assignment->solutionFile = $fileName;
            }
        }

        if (strlen($request->get("analysisVideoLink")) > 0)
            if (!preg_match("/^http:\/\//", $assignment->analysisVideoLink) && !preg_match("/^https:\/\//", $assignment->analysisVideoLink))
                $assignment->analysisVideoLink = "https://" . $assignment->analysisVideoLink;

        if ($assignment->update()) {
            session()->put('success', 'اصلاح تمرین با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($assignment)
    {
        if ($assignment->delete()) session()->put('success', 'تمرین با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back();
    }
}
