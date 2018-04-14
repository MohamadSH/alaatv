<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Attributecontrol;
use App\Attributevalue;
use App\Http\Requests\EditAttributeRequest;
use App\Http\Requests\InsertAttributeRequest;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributeController extends Controller
{
    protected $helper ;
    protected $response ;

    function __construct()
    {
        $this->helper = new Helper();
        $this->response = new Response();

        $this->middleware('permission:'.Config::get('constants.LIST_ATTRIBUTE_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_ATTRIBUTE_ACCESS'),['only'=>'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_ATTRIBUTE_ACCESS'),['only'=>'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_ATTRIBUTE_ACCESS'),['only'=>'edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::all()->sortByDesc('created_at');
        return view('attribute.index' , compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertAttributeRequest $request)
    {
        $attribute = new Attribute();
        $attribute->fill($request->all());
        if(strlen($attribute->attributecontrol_id) == 0) $attribute->attributecontrol_id = null;

        if ($attribute->save()) {
            return $this->response->setStatusCode(200);
        }
        else{
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        $attributecontrols = Attributecontrol::pluck('name' , 'id')->toArray();

//        $attributevalues = Attributevalue::where('attribute_id' , $attribute->id)->get();
        $attributevalues = $attribute->attributevalues;

        return view('attribute.edit' , compact('attribute' , 'attributecontrols' , 'attributevalues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAttributeRequest $request, Attribute $attribute)
    {
        $attribute->fill($request->all());
        if(strlen($attribute->attributecontrol_id) == 0) $attribute->attributecontrol_id = null;

        if ($attribute->update()) {
            session()->put("success", "اطلاعات صفت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        if ($attribute->delete()) session()->put('success', 'صفت با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back() ;
    }
}
