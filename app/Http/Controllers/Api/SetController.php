<?php

namespace App\Http\Controllers\Api;

use App\Contentset;
use App\Http\Controllers\Controller;

class SetController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Contentset  $set
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Contentset $set)
    {
        return response()->json($set);
    }
}
