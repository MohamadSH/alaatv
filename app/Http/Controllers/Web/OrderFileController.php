<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Orderfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderFileController extends Controller
{
    public function store(Request $request)
    {
        $orderFile = new Orderfile();
        $orderFile->fill($request->all());
        if ($orderFile->save()) {
            return response()->json();
        } else {
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
