<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Attributegroup;
use App\Http\Requests\EditAttributegroupRequest;
use App\Http\Requests\InsertAttributegroupRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class AttributegroupController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . Config::get('constants.LIST_ATTRIBUTEGROUP_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . Config::get('constants.INSERT_ATTRIBUTEGROUP_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_ATTRIBUTEGROUP_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . Config::get('constants.SHOW_ATTRIBUTEGROUP_ACCESS'), ['only' => 'edit']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributesetId = Input::get('attributeset_id');
        $attributegroups = Attributegroup::where('attributeset_id', $attributesetId)
                                         ->get();
        return view('attributegroup.index', compact('attributegroups'));
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertAttributegroupRequest $request)
    {
        $attributegroup = new Attributegroup();
        $attributegroup->fill($request->all());

        if ($attributegroup->save()) {
            $attributegroup->attributes()
                           ->sync($request->get('attributes', []));
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Attributegroup $attributegroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Attributegroup $attributegroup)
    {
        $attributeset = $attributegroup->attributeset_id;
        $attributes = Attribute::pluck('displayName', 'id')
                               ->toArray();
        $groupAttributes = $attributegroup->attributes()
                                          ->pluck('id')
                                          ->toArray();
        return view('attributegroup.edit', compact('attributegroup', 'attributeset', 'groupAttributes', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
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
        return redirect(action("AttributesetController@edit", $attributeset));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attributegroup $attributegroup)
    {
        if ($attributegroup->delete())
            session()->put('success', 'گروه صفت با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back();
    }
}
