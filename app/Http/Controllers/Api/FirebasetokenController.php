<?php

namespace App\Http\Controllers\Api;

use App\Firebasetoken;
use App\Http\Requests\InsertFireBaseTokenRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class FirebasetokenController extends Controller
{
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
     * @param InsertFireBaseTokenRequest $request
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(InsertFireBaseTokenRequest $request , User $user = null)
    {
        $fireBaseToken = new Firebasetoken();
        $fireBaseToken->fill($request->all());
        $fireBaseToken->user_id = $user->id;
        $result = $fireBaseToken->save();

        if($result)
            $responseContent = [
                'message'   =>  'Token saved successfully'
            ];
        else
            $responseContent = [
                'error'  => [
                    'code'   =>  Response::HTTP_SERVICE_UNAVAILABLE,
                    'message'=>  'Database error'
                ]
            ] ;

        return response($responseContent , Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
