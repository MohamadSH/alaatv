<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ErrorPageController extends Controller
{
    /**
     * Show the not found page.
     *
     * @return void
     */
    public function error404()
    {
        return abort(Response::HTTP_NOT_FOUND);
    }

    /**
     * Show forbidden page.
     *
     * @return void
     */
    public function error403()
    {
        return abort(Response::HTTP_FORBIDDEN);
    }

    /**
     * Show general error page.
     *
     * @return void
     */
    public function error500()
    {
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Show the general error page.
     *
     * @param string $message
     *
     * @return Factory|View
     */
    public function errorPage($message)
    {
        //        $message = $request->get("message");
        if (strlen($message) <= 0) {
            $message = '';
        }

        return view('errors.errorPage', compact('message'));
    }
}
