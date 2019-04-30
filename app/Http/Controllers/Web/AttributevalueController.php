<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Attributevalue;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\EditAttributevalueRequest;
use App\Http\Requests\InsertAttributevalueRequest;

class AttributevalueController extends Controller
{
    protected $response;
    
    function __construct()
    {
        $this->middleware('permission:'.Config::get('constants.LIST_ATTRIBUTEVALUE_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_ATTRIBUTEVALUE_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_ATTRIBUTEVALUE_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_ATTRIBUTEVALUE_ACCESS'), ['only' => 'edit']);
        
        $this->response = new Response();
    }

    public function store(InsertAttributevalueRequest $request)
    {
        $attributevalue = new Attributevalue();
        $attributevalue->fill($request->all());

        if ($attributevalue->save()) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
        
        return redirect()->back();
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
        
        return redirect(action('AttributeController@edit', $attribute));
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
