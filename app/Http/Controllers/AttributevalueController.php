<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Attributevalue;
use App\Http\Requests\EditAttributevalueRequest;
use App\Http\Requests\InsertAttributevalueRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class AttributevalueController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . Config::get('constants.LIST_ATTRIBUTEVALUE_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . Config::get('constants.INSERT_ATTRIBUTEVALUE_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_ATTRIBUTEVALUE_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . Config::get('constants.SHOW_ATTRIBUTEVALUE_ACCESS'), ['only' => 'edit']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Attributevalue $attributevalue
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Attributevalue $attributevalue)
    {
        $attribute = Attribute::findOrFail($attributevalue->attribute_id);
        return view('attributevalue.edit', compact('attribute', 'attributevalue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attributevalue $attributevalue)
    {
        if ($attributevalue->delete())
            session()->put('success', 'مقدار صفت با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back();
    }
}
