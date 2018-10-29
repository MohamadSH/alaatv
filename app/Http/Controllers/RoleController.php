<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\InsertRoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Response;
use Zizaco\Entrust\Entrust;

class RoleController extends Controller
{

    protected $response;

    function __construct()
    {
        $this->response = new Response();

        $this->middleware('role:admin');
    }

    public function index()
    {
        $roles = Role::all()->sortByDesc('created_at');;
        return view("role.index", compact('roles'));
    }

    public function show()
    {

    }

    public function create()
    {

    }

    public function store(InsertRoleRequest $request)
    {
        $role = new Role();
        $role->fill($request->all());

        if ($role->save()) {
            $role->attachPermissions($request->get('permissions', []));
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    public function edit($role)
    {
        if ($role->isDefault) {
            $homeController = new HomeController();
            $message = "این نقش قابل اصلاح نمی باشد";
            return $homeController->errorPage($message);
        }
        $permissions = Permission::pluck('display_name', 'id')->toArray();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(EditRoleRequest $request, $role)
    {
        if ($role->isDefault) {
            $homeController = new HomeController();
            $message = "این نقش قابل اصلاح نمی باشد";
            return $homeController->errorPage($message);
        }
        if ($role)
            $role->fill($request->all());

        if ($role->update()) {
            $role->permissions()->sync($request->get('permissions', []));
            session()->put("success", "اطلاعات نقش با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }
        return redirect()->back();
    }

    public function destroy($role)
    {
        if ($role->isDefault) {
            $homeController = new HomeController();
            $message = "این نقش قابل حذف نمی باشد";
            return $homeController->errorPage($message);
        }
        if ($role->delete()) session()->put('success', 'نقش با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back();
    }
}
