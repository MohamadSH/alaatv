<?php

namespace App\Http\Controllers\Web;

use App\Afterloginformcontrol;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AfterLoginFormController extends Controller
{

    public function index(Request $request)
    {
        $afterLoginFormFields = Afterloginformcontrol::all()
            ->sortBy("order");

        $sideBarMode = "closed";
        $section     = "afterLoginForm";

        if ($request->expectsJson()) {
            return response([
                'afterLoginFormFields' => $afterLoginFormFields,
            ], Response::HTTP_OK);
        } else {
            $availableFields = [];

            return view("admin.siteConfiguration.afterLoginForm",
                compact("afterLoginFormFields", "availableFields", "sideBarMode", "section"));
        }
    }

    public function store(Request $request)
    {
        $afterLoginFormField = new Afterloginformcontrol();
        $afterLoginFormField->fill($request->all());

        if ($afterLoginFormField->save()) {
            session()->put("success", "فیلد با موفقیت اضافه شد");
        } else {
            session()->flash("error", "خطای پایگاه داده");
        }

        return redirect()->back();
    }

    public function destroy(Afterloginformcontrol $field)
    {
        if ($field->delete()) {
            session()->put("success", "فیلد با موفقیت حذف شد");
        } else {
            session()->put("error", "خطای پایگاه داده");
        }

        return response([
            'sessionData' => session()->all(),
        ]);
    }
}
