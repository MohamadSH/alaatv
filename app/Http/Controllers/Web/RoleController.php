<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\InsertRoleRequest;
use App\Permission;
use App\Role;
use Exception;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $roles = Role::all()
            ->sortByDesc('created_at');

        return view("role.index", compact('roles'));
    }

    public function store(InsertRoleRequest $request)
    {
        $role = new Role();
        $role->fill($request->all());

        if ($role->save()) {
            $role->attachPermissions($request->get('permissions', []));

            return response()->json();
        } else {
            return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function edit(Role $role, ErrorPageController $errorPageController)
    {
        if ($role->isDefault) {

            $message = "این نقش قابل اصلاح نمی باشد";

            return $errorPageController->errorPage($message);
        }
        $permissions     = Permission::pluck('display_name', 'id')
            ->toArray();
        $rolePermissions = $role->permissions->pluck('id')
            ->toArray();

        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(EditRoleRequest $request, Role $role, ErrorPageController $errorPageController)
    {
        if ($role->isDefault) {
            $message = "این نقش قابل اصلاح نمی باشد";

            return $errorPageController->errorPage($message);
        }
        if ($role) {
            $role->fill($request->all());
        }

        if ($role->update()) {
            $role->permissions()
                ->sync($request->get('permissions', []));
            session()->put("success", "اطلاعات نقش با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }

    public function destroy(Role $role, ErrorPageController $errorPageController)
    {
        if ($role->isDefault) {
            $message = "این نقش قابل حذف نمی باشد";

            return $errorPageController->errorPage($message);
        }
        try {
            if ($role->delete()) {
                session()->put('success', 'نقش با موفقیت حذف شد');
            } else {
                session()->put('error', 'خطای پایگاه داده');
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error on deleting role',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect()->back();
    }
}
