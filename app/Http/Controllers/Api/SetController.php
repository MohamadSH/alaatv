<?php

namespace App\Http\Controllers\Api;

use App\Contentset;
use App\Http\Controllers\Controller;

class SetController extends Controller
{
    public function show(Contentset $set)
    {
        return response()->json($set);
    }
}
