<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Attributevalue;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAttributevalueRequest;
use App\Http\Requests\InsertAttributevalueRequest;
use Illuminate\Http\Response;

class AttributevalueController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_ATTRIBUTEVALUE_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_ATTRIBUTEVALUE_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_ATTRIBUTEVALUE_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_ATTRIBUTEVALUE_ACCESS'), ['only' => 'edit']);
    }

    public function store(InsertAttributevalueRequest $request)
    {
        $attributevalue = new Attributevalue();
        $attributevalue->fill($request->all());

        if ($attributevalue->save()) {
            return response()->json();
        }
        return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function edit(Attributevalue $attributevalue)
    {
        $attribute = Attribute::findOrFail($attributevalue->attribute_id);

        return view('attributevalue.edit', compact('attribute', 'attributevalue'));
    }

    public function update(EditAttributevalueRequest $request, Attributevalue $attributevalue)
    {
        $attribute = Attribute::findOrFail($attributevalue->attribute_id);
        $attributevalue->fill($request->all());
        if ($attributevalue->update()) {
            session()->put("success", "اطلاعات مقدار صفت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect(action('Web\AttributeController@edit', $attribute));
    }

    public function destroy(Attributevalue $attributevalue)
    {
        if ($attributevalue->delete()) {
            session()->put('success', 'مقدار صفت با موفقیت حذف شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
