<?php

namespace App\Http\Controllers\Api;

use App\Contentset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Contentset $set)
    {
        dd("here");
    }
}
