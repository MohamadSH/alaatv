<?php

namespace App\Http\Controllers\Api;

use App\Contentset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetController extends Controller
{
    public function show(Request $request,  Contentset $set)
    {
        if (!is_null($set->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($set->redirectUrl),
                Response::HTTP_FOUND, $request->headers->all());
        }

        return response()->json($set);
    }
}
