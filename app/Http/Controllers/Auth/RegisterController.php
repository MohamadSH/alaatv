<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\{CharacterCommon, Helper, UserCommon};
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Validator;


class RegisterController extends Controller
{
    use CharacterCommon;
    use Helper;
    use UserCommon;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('convert:mobile|passport|nationalCode');
    }

    /**
     * overriding method
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.login3');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $totalUserrules = $this->getInsertUserValidationRules($data);
        $rules = [
            "mobile" => $totalUserrules["mobile"],
            "nationalCode" => $totalUserrules["nationalCode"],
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $response = $this->callUserControllerStore($data);
        $responseContent = json_decode($response->getContent(), true);
        $user = $responseContent["user"];
        return User::hydrate($user)->first();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($request->expectsJson())
            return response()->json([
                'status' => 1,
                'msg' => 'user registered',
                'redirectTo' => $this->redirectTo(),
                'data' => [
                    '   user' => $user
                ]
            ], Response::HTTP_OK);
    }

    protected function redirectTo()
    {
        $baseUrl = url("/");
        $targetUrl = redirect()
            ->intended()
            ->getTargetUrl();
        $redirectTo = $baseUrl;
        if (strcmp($targetUrl, $baseUrl) == 0) {
            // Indicates a strange situation when target url is the home page despite
            // the fact that there is a probability that user must be redirected to another page except home page

            if (strcmp(URL::previous(), route('login')) != 0)
                // User first had opened a page and then went to login
                $redirectTo = URL::previous();
        } else {
            $redirectTo = $targetUrl;
        }

        if (Auth::user()->completion("afterLoginForm") != 100) {
            if (strcmp(URL::previous(), action("OrderController@checkoutAuth")) == 0) {
                $redirectTo = action("OrderController@checkoutCompleteInfo");
            } else {
                $redirectTo = action("UserController@completeRegister", ["redirect" => $redirectTo]);
            }
        }
        return $redirectTo;
    }
}
