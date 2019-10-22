<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Section[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $sections = Section::all();
        return view('content.section.index' , compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('section.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $section = Section::create($request->all());
        session()->put('success' , 'سکشن با موفقیت اصلاح شد');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Section $section
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
     * @return Response
     */
    public function edit(Section $section)
    {
        return view('section.create' , compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Section $section
     * @return Response
     */
    public function update(Request $request, Section $section)
    {
        $section->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     * @return Response
     * @throws \Exception
     */
    public function destroy(Section $section)
    {
         $section->delete();
        return redirect()->back();
    }
}
