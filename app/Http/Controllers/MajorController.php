<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertMajorRequest;
use App\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $majors = Major::orderBy("name");

        $majotIds = Input::get("ids");
        if (strcmp(gettype($majotIds), "string") == 0)
            $majotIds = json_decode($majotIds);
        if (isset($majotIds)) {
            $majors = $majors->whereIn("id", $majotIds);
        }

        $majorCodes = Input::get("majorCode");
        $majorParentId = Input::get("majorParent");
        if (isset($majorCodes) && $majorParentId) {
            $majors = $majors->whereHas("parents", function ($q) use ($majorCodes, $majorParentId) {
                $q->where("major1_id", $majorParentId)
                  ->whereIn("majorCode", $majorCodes);
            });
        }

        $parentIds = Input::get("parents");
        if (isset($parentIds)) {
            $majors = $majors->whereHas("parents", function ($q) use ($parentIds) {
                $q->whereIn("major1_id", $parentIds);
            });
        }
        return $majors->get();
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
     * @param  \App\Http\Requests\InsertMajorRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertMajorRequest $request)
    {
        $major = Major::where("name", "like", $request->get("name"))
                      ->get()
                      ->first();
        $flag = true;
        if (!isset($major)) {
            $flag = false;
            $major = new Major();
            $major->fill($request->all());
            if ($major->save())
                $flag = true;
        }

        if ($flag) {
            $parentMajorId = Input::get("parent");
            if (!in_array($parentMajorId, [
                1,
                2,
                3,
            ])) {
                session()->put("error", "رشته والد باید ریاضی یا تجربی یا انسانی باشد");
                return redirect()->back();
            }
            if ($major->parents()
                      ->where("major1_id", $parentMajorId)
                      ->get()
                      ->isEmpty()) {
                $majorCode = $request->get("majorCode");
                $major->parents()
                      ->attach($parentMajorId, [
                          "relationtype_id" => 1,
                          "majorCode"       => $majorCode,
                      ]);
                session()->put("success", "رشته با موفقیت درج شد");
            } else {
                $parentMajor = Major::FindOrFail($parentMajorId);
                session()->put("warning", "این رشته برای " . $parentMajor->name . " قبلا درج شده است");
            }

        } else session()->put("success", "خطای پایگاه داده در درج رشته");

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
        $parentMajorId = $request->get("parentMajorId");
        $parentMajor = Major::FindOrFail($parentMajorId);
        $majorCodes = $request->get("majorCodes");
        foreach ($majorCodes as $key => $majorCode) {
            if (strlen($majorCode) > 0)
                $parentMajor->children()
                            ->updateExistingPivot($key, ["majorCode" => $majorCode]);
        }
        session()->put("success", "درج کدهای رشته ها با موفقیت انجام شد!");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
