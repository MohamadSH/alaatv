<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function debug()
    {
        return response()->json([
            'debug' => 2,
        ]);
    }

    public function authTest(Request $request)
    {
        return response()->json([
            'User' => $request->user(),
        ]);
    }
}
