<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Orderfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderFileController extends Controller
{
    protected $response;
    
    function __construct()
    {
        $this->response = new Response();
    }

    public function store(Request $request)
    {
        $orderFile = new Orderfile();
        $orderFile->fill($request->all());
        if ($orderFile->save()) {
            return $this->response->setStatusCode(200);
        }
        else {
            return $this->response->setStatusCode(503);
        }
    }
}
