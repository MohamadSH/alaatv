<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Attributegroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAttributegroupRequest;
use App\Http\Requests\InsertAttributegroupRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributegroupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_ATTRIBUTEGROUP_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_ATTRIBUTEGROUP_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_ATTRIBUTEGROUP_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_ATTRIBUTEGROUP_ACCESS'), ['only' => 'edit']);
    }

    public function index(Request $request)
    {
        $attributesetId  = $request->get('attributeset_id');
        $attributegroups = Attributegroup::where('attributeset_id', $attributesetId)
            ->get();

        return view('attributegroup.index', compact('attributegroups'));
    }

    public function store(InsertAttributegroupRequest $request)
    {
        $attributegroup = new Attributegroup();
        $attributegroup->fill($request->all());

        if ($attributegroup->save()) {
            $attributegroup->attributes()
                ->sync($request->get('attributes', []));

            return response()->json();
        }

        return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function edit(Attributegroup $attributegroup)
    {
        $attributeset    = $attributegroup->attributeset_id;
        $attributes      = Attribute::pluck('displayName', 'id')
            ->toArray();
        $groupAttributes = $attributegroup->attributes()
            ->pluck('id')
            ->toArray();

        return view('attributegroup.edit', compact('attributegroup', 'attributeset', 'groupAttributes', 'attributes'));
    }

    public function update(EditAttributegroupRequest $request, Attributegroup $attributegroup)
    {
        $attributeset = $attributegroup->attributeset_id;
        $attributegroup->fill($request->all());
        $attributegroup->attributes()
            ->sync($request->get('attributes', []));

        if ($attributegroup->update()) {
            session()->put("success", "اطلاعات گروه صفت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect(action("Web\AttributesetController@edit", $attributeset));
    }

    public function destroy(Attributegroup $attributegroup)
    {
        if ($attributegroup->delete()) {
            session()->put('success', 'گروه صفت با موفقیت حذف شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
