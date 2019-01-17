<?php

namespace App\Http\Controllers;

use App\Afterloginformcontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AfterLoginFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $afterLoginFormFields = Afterloginformcontrol::all()
                                                     ->sortBy("order");
        $availableFields = Schema::getColumnListing("users");
        foreach ($availableFields as $key => $availableField) {
            unset($availableFields[$key]);
            if (strcmp(Schema::getColumnType("users", $availableField), "string") == 0)
                $availableFields[$availableField] = $availableField;
            else if (strpos($availableField, "_id"))
                $availableFields[$availableField] = $availableField;
        }
        $availableFields = array_diff($availableFields, [
            "remember_token",
            "password",
            "mobile",
            "nationalCode",
        ]);
        $sideBarMode = "closed";
        $section = "afterLoginForm";

        if ($request->ajax()) {
            return response([
                'afterLoginFormFields' => $afterLoginFormFields,
                'availableFields' => $availableFields
            ], Response::HTTP_OK);
        } else {
            return view("admin.siteConfiguration.afterLoginForm", compact("afterLoginFormFields", "availableFields", "sideBarMode", "section"));
        }
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
    public function store(Request $request)
    {
        $afterLoginFormField = new Afterloginformcontrol();
        $afterLoginFormField->fill($request->all());

        if ($afterLoginFormField->save())
            session()->put("success", "فیلد با موفقیت اضافه شد");
        else session()->flash("error", "خطای پایگاه داده");

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Afterloginformcontrol $field
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Afterloginformcontrol $field)
    {
        if ($field->delete())
            session()->put("success", "فیلد با موفقیت حذف شد");
        else session()->put("error", "خطای پایگاه داده");
        return response([
                            'sessionData' => session()->all(),
                        ]);
    }
}
