<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ErrorPageController extends Controller
{
    /**
     * Show the not found page.
     *
     * @return Response
     */
    public function error404()
    {
        return abort(404);
    }

    /**
     * Show forbidden page.
     *
     * @return Response
     */
    public function error403()
    {
        return abort(403);
    }

    /**
     * Show general error page.
     *
     * @return Response
     */
    public function error500()
    {
        return abort(500);
    }

    /**
     * Show the general error page.
     *
     * @param  string  $message
     *
     * @return Response
     */
    public function errorPage($message)
    {
        //        $message = Input::get("message");
        if (strlen($message) <= 0) {
            $message = '';
        }

        return view('errors.errorPage', compact('message'));
    }
}
