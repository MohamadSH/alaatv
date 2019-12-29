<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPermissionRequest;
use App\Http\Requests\InsertPermissionRequest;
use App\Permission;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_PERMISSION_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_PERMISSION_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_PERMISSION_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_PERMISSION_ACCESS'), ['only' => 'edit']);
    }

    public function index()
    {
        $permissions = Permission::all()
            ->sortByDesc('created_at');

        return view("permission.index", compact('permissions'));
    }

    public function store(InsertPermissionRequest $request)
    {

        $permission = new Permission();
        $permission->fill($request->all());

        if ($permission->save()) {
            return response()->json();
        }

        return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function edit($permission)
    {
        return view('permission.edit', compact('permission'));
    }

    public function update(EditPermissionRequest $request, $permission)
    {
        $permission->fill($request->all());

        if ($permission->update()) {
            session()->put("success", "اطلاعات دسترسی با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }

    public function destroy($permission)
    {
        if ($permission->delete()) {
            session()->put('success', 'دسترسی با موفقیت حذف شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
