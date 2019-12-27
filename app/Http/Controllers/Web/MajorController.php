<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertMajorRequest;
use App\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index(Request $request)
    {

        $majors = Major::orderBy('name');

        $majotIds = $request->get('ids');
        if (strcmp(gettype($majotIds), 'string') == 0) {
            $majotIds = json_decode($majotIds);
        }
        if (isset($majotIds)) {
            $majors = $majors->whereIn('id', $majotIds);
        }

        $majorCodes    = $request->get('majorCode');
        $majorParentId = $request->get('majorParent');
        if (isset($majorCodes) && $majorParentId) {
            $majors = $majors->whereHas('parents', function ($q) use ($majorCodes, $majorParentId) {
                $q->where('major1_id', $majorParentId)
                    ->whereIn('majorCode', $majorCodes);
            });
        }

        $parentIds = $request->get('parents');
        if (isset($parentIds)) {
            $majors = $majors->whereHas('parents', function ($q) use ($parentIds) {
                $q->whereIn('major1_id', $parentIds);
            });
        }

        return $majors->get();
    }

    public function store(InsertMajorRequest $request)
    {
        $major = Major::where('name', 'like', $request->get('name'))
            ->get()
            ->first();
        $flag  = true;
        if (!isset($major)) {
            $flag  = false;
            $major = new Major();
            $major->fill($request->all());
            if ($major->save()) {
                $flag = true;
            }
        }

        if ($flag) {
            $parentMajorId = $request->get('parent');
            if (!in_array($parentMajorId, [
                1,
                2,
                3,
            ])) {
                session()->put('error', 'رشته والد باید ریاضی یا تجربی یا انسانی باشد');

                return redirect()->back();
            }
            if ($major->parents()
                ->where('major1_id', $parentMajorId)
                ->get()
                ->isEmpty()) {
                $majorCode = $request->get('majorCode');
                $major->parents()
                    ->attach($parentMajorId, [
                        'relationtype_id' => 1,
                        'majorCode'       => $majorCode,
                    ]);
                session()->put('success', 'رشته با موفقیت درج شد');
            } else {
                $parentMajor = Major::FindOrFail($parentMajorId);
                session()->put('warning', 'این رشته برای ' . $parentMajor->name . ' قبلا درج شده است');
            }
        } else {
            session()->put('success', 'خطای پایگاه داده در درج رشته');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $parentMajorId = $request->get('parentMajorId');
        $parentMajor   = Major::FindOrFail($parentMajorId);
        $majorCodes    = $request->get('majorCodes');
        foreach ($majorCodes as $key => $majorCode) {
            if (strlen($majorCode) > 0) {
                $parentMajor->children()
                    ->updateExistingPivot($key, ['majorCode' => $majorCode]);
            }
        }
        session()->put('success', 'درج کدهای رشته ها با موفقیت انجام شد!');

        return redirect()->back();
    }
}
