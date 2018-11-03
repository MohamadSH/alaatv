<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\UserController;
use App\Http\Requests\InsertUserRequest;
use App\Traits\{CharacterCommon, Helper};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

use App\User;
use Validator;


class RegisterController extends Controller
{
    use CharacterCommon;
    use Helper;
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
    protected $userController;

    /**
     * Create a new controller instance.
     *
     * @param UserController $userController
     */
    public function __construct(UserController $userController)
    {
        $this->middleware('guest');
        $this->redirectTo = action("ProductController@search");
        $this->userController = $userController ;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //ToDo : Should be included from a common file with UserController@store
            'mobile' => [
                'required',
                'digits:11',
                'phone:AUTO,IR,mobile',
                Rule::unique('users')->where(function ($query) use ($data) {
                    $query->where('nationalCode', $data["nationalCode"])->where('deleted_at', null);
                })
            ],
            'nationalCode' => [
                'required',
                'digits:10',
                'validate:nationalCode',
                Rule::unique('users')->where(function ($query) use ($data) {
                    $query->where('mobile', $data["mobile"])->where('deleted_at', null);
                })
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $storeUserRequest = new InsertUserRequest();
        $storeUserRequest->merge($data);
        $storeUserRequest->headers->add([ "X-Requested-With" =>"XMLHttpRequest"]); //ToDo : to be tested
        $response =  $this->userController->store($storeUserRequest);
        $responseContent = json_decode($response->getContent()) ;
        $user = $responseContent->user;

        return $user;
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
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->offsetSet("mobile", $this->convertToEnglish($request->get("mobile")));
        $request->offsetSet("nationalCode", $this->convertToEnglish($request->get("nationalCode")));

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

}
