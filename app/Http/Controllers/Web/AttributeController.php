<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Attributecontrol;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAttributeRequest;
use App\Http\Requests\InsertAttributeRequest;
use Illuminate\Http\Response;

class AttributeController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_ATTRIBUTE_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_ATTRIBUTE_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_ATTRIBUTE_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_ATTRIBUTE_ACCESS'), ['only' => 'edit']);
    }

    public function index()
    {
        $attributes = Attribute::all()
            ->sortByDesc('created_at');

        return view('attribute.index', compact('attributes'));
    }

    public function store(InsertAttributeRequest $request)
    {
        $attribute = new Attribute();
        $attribute->fill($request->all());
        if (strlen($attribute->attributecontrol_id) == 0) {
            $attribute->attributecontrol_id = null;
        }

        if ($attribute->save()) {
            return response()->json();
        } else {
            return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function edit(Attribute $attribute)
    {
        $attributecontrols = Attributecontrol::pluck('name', 'id')
            ->toArray();

        //        $attributevalues = Attributevalue::where('attribute_id' , $attribute->id)->get();
        $attributevalues = $attribute->attributevalues;

        return view('attribute.edit', compact('attribute', 'attributecontrols', 'attributevalues'));
    }

    public function update(EditAttributeRequest $request, Attribute $attribute)
    {
        $attribute->fill($request->all());
        if (strlen($attribute->attributecontrol_id) == 0) {
            $attribute->attributecontrol_id = null;
        }

        if ($attribute->update()) {
            session()->put("success", "اطلاعات صفت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }

    public function destroy(Attribute $attribute)
    {
        if ($attribute->delete()) {
            session()->put('success', 'صفت با موفقیت حذف شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
