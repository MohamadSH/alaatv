<?php

namespace App\Http\Controllers\Web;

use App\Belonging;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Lang;

class BelongingController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_BELONGING_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_BELONGING_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:' . config('constants.REMOVE_BELONGING_ACCESS'), ['only' => 'destroy']);
    }

    public function index(Request $request)
    {
        $userId = $request->get('userId');
        if (isset($userId)) {
            $user       = User::FindOrFail($userId);
            $belongings = $user->belongings->sortByDesc("cearted_at");
        } else {
            $belongings = Belonging::all()
                ->sortByDesc("created_at");
        }

        $pageName = "admin";
        $counter  = 1;

        return view('belonging.index', compact('belongings', 'user', 'pageName', 'counter'));
    }

    public function store(Request $request)
    {
        $belonging = new Belonging();
        $belonging->fill($request->all());

        if (strlen(preg_replace('/\s+/', '', $request->get('name'))) == 0) {
            $belonging->name = null;
        }
        if (strlen(preg_replace('/\s+/', '', $request->get('description'))) == 0) {
            $belonging->description = null;
        }

        if ($request->hasFile("file")) {
            $file      = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(config('constants.DISK12'))
                ->put($fileName, File::get($file))) {
                $belonging->file = $fileName;
            }
        }

        if ($belonging->save()) {
            if ($request->has("userId")) {
                $this->attachUserBelonging($request, $belonging);
            }
            session()->put("success", "اسناد فنی با موفقیت درج شد!");
        } else {
            session()->put("success", Lang::get("responseText.Database error."));
        }

        return redirect()->back();
    }

    /**
     * Attaching a belonging to a user
     *
     * @param Request   $request
     * @param User      $user
     * @param Belonging $belonging
     *
     * @return Response
     */
    public function attachUserBelonging(Request $request, Belonging $belonging)
    {
        $belonging->users()
            ->attach($request->get("userId"));
    }

    public function destroy(Belonging $belonging)
    {
        if ($belonging->delete()) {
            session()->put('success', 'اسناد فنی با موفقیت حذف شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return response([
            'sessionData' => session()->all(),
        ]);
    }
}
