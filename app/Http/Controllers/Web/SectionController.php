<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Section;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Section[]|Collection
     */
    public function index()
    {
        $sections = Section::all();
        return view('content.section.index', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $section = Section::create($request->all());
        if (isset($section)) {
            session()->put('success', 'سکشن با موفقیت درج شد');
        } else {
            session()->put('error', 'خطا در درج سکشن');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Section $section
     *
     * @return Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Section $section
     *
     * @return Response
     */
    public function edit(Section $section)
    {
        return view('content.section.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Section $section
     *
     * @return Response
     */
    public function update(Request $request, Section $section)
    {
        $updateResult = $section->update($request->all());
        if (isset($updateResult)) {
            session()->put('success', 'سکشن با موفقیت اصلاح شد');
        } else {
            session()->put('error', 'خطا در اصلاح سکشن');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->back();
    }
}
