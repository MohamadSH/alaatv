<?php

namespace App\Http\Controllers\Api;

use App\Firebasetoken;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertFireBaseTokenRequest;
use App\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class FirebasetokenController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param InsertFireBaseTokenRequest $request
     * @param User                       $user
     *
     * @return ResponseFactory|Response
     */
    public function store(InsertFireBaseTokenRequest $request, User $user)
    {
        $token  = $request->get('token');
        $tokens = Firebasetoken::where('token', $token)->where('user_id', $user->id)->get();
        if ($tokens->isNotEmpty()) {
            $responseContent = [
                'message' => 'Token saved successfully',
            ];
            return response($responseContent, Response::HTTP_OK);
        }


        $fireBaseToken = new Firebasetoken();
        $fireBaseToken->fill($request->all());
        $fireBaseToken->user_id = $user->id;
        $result                 = $fireBaseToken->save();

        if ($result) {
            $responseContent = [
                'message' => 'Token saved successfully',
            ];
        } else {
            $responseContent = [
                'error' => [
                    'code'    => Response::HTTP_SERVICE_UNAVAILABLE,
                    'message' => 'Database error',
                ],
            ];
        }

        return response($responseContent, Response::HTTP_OK);
    }
}
