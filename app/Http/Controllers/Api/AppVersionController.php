<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;

class AppVersionController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'android' => [
                'last_version' => 51,
                'type'         => [
                    'code' => 1,
                    'hint' => 'force',
                ],
                'url'          => [
                    'play_store' => 'https://play.google.com/store/apps/details?id=ir.sanatisharif.android.konkur96',
                    'bazaar'     => '',
                    'direct'     => '',
                ],
            ],
            'ios'     => [
                'last_version' => 2,
                'type'         => [
                    'code' => 2,
                    'hint' => 'optional',
                ],
                'url'          => [
                    'app_store' => '',
                    'direct'    => '',
                ],
            ],
        ]);
    }

    /**
     * API Version 2
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showV2(Request $request)
    {
        return response()->json([
            'android' => [
                'last_version' => 51,
                'type'         => [
                    'code' => 1,
                    'hint' => 'force',
                ],
                'url'          => [
                    'play_store' => 'https://play.google.com/store/apps/details?id=ir.sanatisharif.android.konkur96',
                    'bazaar'     => '',
                    'direct'     => '',
                ],
            ],
            'ios'     => [
                'last_version' => 2,
                'type'         => [
                    'code' => 2,
                    'hint' => 'optional',
                ],
                'url'          => [
                    'app_store' => '',
                    'direct'    => '',
                ],
            ],
        ]);
    }
}
