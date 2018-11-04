<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\InsertUserRequest;
use App\Traits\{CharacterCommon, Helper, UserCommon};
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @param UserController $userController
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = action("ProductController@search");
    }

    /**
     * overriding method
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return redirect(action("HomeController@index"));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->offsetSet("mobile", $this->convertToEnglish($request->get("mobile")));
        $request->offsetSet("nationalCode", $this->convertToEnglish($request->get("nationalCode")));

        $this->validator($request->all())
             ->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()
             ->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
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
        $totalUserrules = $this->getInsertUserValidationRules();
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
        $responseContent = json_decode($response->getContent());
        $user = $responseContent->user;

        return $user;
    }

}
