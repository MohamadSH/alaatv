<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-08
 * Time: 18:41
 */

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

trait RedirectTrait
{
    protected function redirectTo(Request $request)
    {
        $baseUrl = url("/");
        $targetUrl = redirect()->intended()->getTargetUrl();
        $redirectTo = $baseUrl;
        if (strcmp($targetUrl, $baseUrl) == 0) {
            // Indicates a strange situation when target url is the home page despite
            // the fact that there is a probability that user must be redirected to another page except home page

            if (strcmp(URL::previous(), route('login')) != 0) // User first had opened a page and then went to login
            {
                $redirectTo = URL::previous();
            }
        } else {
            $redirectTo = $targetUrl;
        }

        if (auth()->user()->completion("afterLoginForm") != 100) {
            if (strcmp(URL::previous(), action("Web\OrderController@checkoutAuth")) == 0) {
                $redirectTo = action("Web\OrderController@checkoutCompleteInfo");
            } else {
                if ($request->expectsJson()) {
                    $redirectTo = action("Web\IndexPageController");
                } else {
                    $redirectTo = action("Web\UserController@completeRegister", ["redirect" => $redirectTo]);
                }
            }
        }

        return $redirectTo;
    }
}