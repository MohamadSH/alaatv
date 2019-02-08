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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wallet = new Wallet();
        $wallet->fill($request->all());

        $done = false;
        if ($wallet->save())
            $done = true;

        if ($done) {
            if ($request->expectsJson()) {
                return $this->response
                    ->setStatusCode(200)
                    ->setContent(["wallet" => $wallet]);
            } else {

            }
        } else {
            if ($request->expectsJson()) {
                return $this->response
                    ->setStatusCode(503);
            } else {

            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Wallet              $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        $wallet->fill($request->all());
        $done = false;
        if ($wallet->update())
            $done = true;

        if ($done) {
            if ($request->expectsJson()) {
                return $this->response
                    ->setStatusCode(200);
            } else {

            }
        } else {
            if ($request->expectsJson()) {
                return $this->response
                    ->setStatusCode(503);
            } else {

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
