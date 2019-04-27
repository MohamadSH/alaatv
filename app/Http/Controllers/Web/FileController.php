<?php

namespace App\Http\Controllers\Web;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertFileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    protected $response;
    
    function __construct()
    {
        $this->response = new Response();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\InsertFileRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertFileRequest $request)
    {
        $file = new File();
        $file->fill($request->all());
        if ($file->save()) {
            if ($request->has("disk_id")) {
                $file->disks()
                    ->attach($request->get("disk_id"));
            }
            
            return $file->id;
        }
        else {
            return false;
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
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
     * @param  \App\File  $file
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($file)
    {
        if ($file->delete()) {
            session()->put('success', 'فایل با موفقیت اصلاح شد');
            
            return $this->response->setStatusCode(200);
        }
        else {
            //            session()->put('error', 'خطای پایگاه داده');
            return $this->response->setStatusCode(503);
        }
    }
}
