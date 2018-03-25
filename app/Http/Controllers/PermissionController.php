<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditPermissionRequest;
use App\Http\Requests\InsertPermissionRequest;
use App\Permission;
use Illuminate\Support\Facades\Config;
use Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    protected $helper ;
    protected $response ;

    function __construct()
    {
        $this->helper = new Helper();
        $this->response = new Response();

        $this->middleware('permission:'.Config::get('constants.LIST_PERMISSION_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_PERMISSION_ACCESS'),['only'=>'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_PERMISSION_ACCESS'),['only'=>'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_PERMISSION_ACCESS'),['only'=>'edit']);
    }

    public function index(){
        $permissions = Permission::all()->sortByDesc('created_at');
        return view("permission.index", compact('permissions' ));
    }

    public function show($permission){

    }

    public function create(){

    }

    public function store(InsertPermissionRequest $request){

        $permission = new Permission();
        $permission->fill($request->all());

        if ($permission->save()) {
            return $this->response->setStatusCode(200);
        }
        else{
            return $this->response->setStatusCode(503);
        }
    }

    public function edit($permission){
        return view('permission.edit', compact('permission'));
    }

    public function update(EditPermissionRequest $request, $permission){
        $permission->fill($request->all());

        if ($permission->update()) {
            session()->put("success", "اطلاعات دسترسی با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }
        return redirect()->back();
    }

    public function destroy($permission){
        if ($permission->delete()) session()->put('success', 'دسترسی با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back() ;
    }
}
