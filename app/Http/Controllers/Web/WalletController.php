<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    protected $response;
    
    public function __construct()
    {
        $this->response = new Response();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
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
                return $this->response->setStatusCode(200)
                    ->setContent(["wallet" => $wallet]);
            }
            else {
                return $this->response->setStatusCode(503);
            }
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wallet               $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        $wallet->fill($request->all());
        $done = false;
        if ($wallet->update()) {
            $done = true;
        }
        
        if ($request->expectsJson()) {
            if ($done) {
                return $this->response->setStatusCode(200);
            }
            else {
                return $this->response->setStatusCode(503);
            }
        }
    }
}
