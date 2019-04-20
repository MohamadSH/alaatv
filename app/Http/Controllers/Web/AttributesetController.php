<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Attributeset;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAttributesetRequest;
use App\Http\Requests\InsertAttributesetRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class AttributesetController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->response = new Response();

        $this->middleware('permission:'.Config::get('constants.LIST_ATTRIBUTESET_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_ATTRIBUTESET_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_ATTRIBUTESET_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_ATTRIBUTESET_ACCESS'), ['only' => 'edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributesets = Attributeset::all()->sortByDesc('created_at');

        return view('attributeset.index', compact('attributesets'));
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertAttributesetRequest $request)
    {
        $attributeset = new Attributeset();
        $attributeset->fill($request->all());

        if ($attributeset->save()) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Attributeset $attributeset)
    {
        //        $attributegroups = $attributeset->attributegroups;
        $attributes = Attribute::pluck('displayName', 'id')->toArray();

        return view('attributeset.edit', compact('attributeset', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditAttributesetRequest $request, Attributeset $attributeset)
    {
        $attributeset->fill($request->all());

        if ($attributeset->update()) {
            session()->put("success", "اطلاعات دسته صفت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attributeset $attributeset)
    {
        if ($attributeset->delete()) {
            session()->put('success', ' دسته صفت با موفقیت اصلاح شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
