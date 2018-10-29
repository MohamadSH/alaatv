<?php

namespace App\Http\Controllers;

use App\Belonging;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class BelongingController extends Controller
{

    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . Config::get('constants.LIST_BELONGING_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . Config::get('constants.INSERT_BELONGING_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_BELONGING_ACCESS'), ['only' => 'destroy']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Input::get('userId');
        if (isset($userId)) {
            $user = User::FindOrFail($userId);
            $belongings = $user->belongings->sortByDesc("cearted_at");
        } else $belongings = Belonging::all()->sortByDesc("created_at");

        $pageName = "admin";
        $counter = 1;
        return view('belonging.index', compact('belongings', 'user', 'pageName', 'counter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $belonging = new Belonging();
        $belonging->fill($request->all());

        if (strlen(preg_replace('/\s+/', '', $request->get('name'))) == 0) $belonging->name = null;
        if (strlen(preg_replace('/\s+/', '', $request->get('description'))) == 0) $belonging->description = null;

        if ($request->hasFile("file")) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK12'))->put($fileName, File::get($file))) {
                $belonging->file = $fileName;
            }
        }

        if ($belonging->save()) {
            if ($request->has("userId")) $this->attachUserBelonging($request, $belonging);
            session()->put("success", "اسناد فنی با موفقیت درج شد!");
        } else {
            session()->put("success", "خطای پایگاه داده");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Belonging $belonging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Belonging $belonging)
    {
        if ($belonging->delete()) session()->put('success', 'اسناد فنی با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return response([
            'sessionData' => session()->all()
        ]);
    }

    /**
     * Attaching a belonging to a user
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @param  \App\Belonging $belonging
     * @return \Illuminate\Http\Response
     */
    public function attachUserBelonging(Request $request, Belonging $belonging)
    {
        $belonging->users()->attach($request->get("userId"));
    }
}
