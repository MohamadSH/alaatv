<?php

namespace App\Http\Controllers\Web;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertFileRequest;
use Illuminate\Http\Response;

class FileController extends Controller
{
    protected $response;

    function __construct()
    {
        $this->response = new Response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InsertFileRequest $request
     *
     * @return Response
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
        } else {
            return false;
        }
    }

    public function destroy($file)
    {
        if ($file->delete()) {
            session()->put('success', 'فایل با موفقیت اصلاح شد');

            return $this->response->setStatusCode(Response::HTTP_OK);
        } else {
            //            session()->put('error', 'خطای پایگاه داده');
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
