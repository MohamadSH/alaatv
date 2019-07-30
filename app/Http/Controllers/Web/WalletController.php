<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{

    public function store(Request $request)
    {
        $wallet = new Wallet();
        $wallet->fill($request->all());
        
        $done = false;
        if ($wallet->save()) {
            $done = true;
        }
        
        if ($request->expectsJson()) {
            if ($done) {
                return response()->json(["wallet" => $wallet]);
            }
            else {
                return response()->json( [] , Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
    }

    public function update(Request $request, Wallet $wallet)
    {
        $wallet->fill($request->all());
        $done = false;
        if ($wallet->update()) {
            $done = true;
        }
        
        if ($request->expectsJson()) {
            if ($done) {
                return response()->json();
            }
            else {
                return response()->json([] , Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
    }
}
