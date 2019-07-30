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
        
        $this->middleware('permission:'.config('constants.LIST_ATTRIBUTESET_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_ATTRIBUTESET_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.REMOVE_ATTRIBUTESET_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_ATTRIBUTESET_ACCESS'), ['only' => 'edit']);
    }

    public function index()
    {
        $attributesets = Attributeset::all()
            ->sortByDesc('created_at');
        
        return view('attributeset.index', compact('attributesets'));
    }

    public function store(InsertAttributesetRequest $request)
    {
        $attributeset = new Attributeset();
        $attributeset->fill($request->all());
        
        if ($attributeset->save()) {
            return $this->response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function edit(Attributeset $attributeset)
    {
        //        $attributegroups = $attributeset->attributegroups;
        $attributes = Attribute::pluck('displayName', 'id')
            ->toArray();
        
        return view('attributeset.edit', compact('attributeset', 'attributes'));
    }

    public function update(EditAttributesetRequest $request, Attributeset $attributeset)
    {
        $attributeset->fill($request->all());
        
        if ($attributeset->update()) {
            session()->put("success", "اطلاعات دسته صفت با موفقیت اصلاح شد");
        }
        else {
            session()->put("error", "خطای پایگاه داده.");
        }
        
        return redirect()->back();
    }

    public function destroy(Attributeset $attributeset)
    {
        if ($attributeset->delete()) {
            session()->put('success', ' دسته صفت با موفقیت اصلاح شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }
}
