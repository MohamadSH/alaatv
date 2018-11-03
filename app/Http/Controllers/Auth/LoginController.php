<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CompleteInfo;
use App\Traits\CharacterCommon;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    use CharacterCommon;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->redirectTo = action("HomeController@index");
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {

        /**  ///////Converting mobile and password numbers to English////////*/
        $request->offsetSet("mobile" ,  $this->convertToEnglish($request->get("mobile")));
        $request->offsetSet("password" , $this->convertToEnglish($request->get("password")));
        /**  /////////////////////////////////////////////////////*/

        /** ////////Validating mobile and password strings/////////*/
        $validator = Validator::make($request->all(), [
            'mobile' => 'required', 'password' => 'required',
        ]);

        if ($validator->fails()) {
             return redirect()->back()
                 ->withInput($request->only('mobile', 'remember'))
                 ->withErrors([
                     'validation' => 'خطای ورودی ها'
                 ],"login");
        }
        /** //////////////////////////////////////////////////////*/


        /** ////////Login or register this new user/////////*/
        ///
        $remember = true;
//        Snippet for remember me checkbox
//        if($request->has("remember"))
//            $remember = true;
//        else
//            $remember = false;
        $intendedUsers = User::where("mobile" , $request->get("mobile"))->get();
        foreach ($intendedUsers as $user)
        {
            if (Auth::attempt(['id'=>$user->id,'mobile' => $user->mobile, 'password' => $request->get("password")] , $remember)) {
                if (strcmp(Auth::user()->userstatus->name, "inactive") == 0) {
                    Auth::logout();
                    Session::flush();
                    return redirect()->back()
                        ->withInput($request->only('mobile', 'remember'))
                        ->withErrors([
                            'inActive' => 'حساب کاربری شما غیر فعال شده است!'
                        ], "login");
                }
                break;
            }
        }
        if(!Auth::check())
        {
            //Try to register this new user and login him
            if(User::where("mobile" , $request->get("mobile"))->where("nationalCode" , $request->get("password"))->get()->isEmpty())
            {
                $registerRequest = new Request();
                $registerRequest->offsetSet("mobile" ,  $request->get("mobile"));
                $registerRequest->offsetSet("nationalCode" , $request->get("password"));
                $registerRequest->offsetSet("photo" , config('constants.PROFILE_DEFAULT_IMAGE'));
                $registerRequest->offsetSet("userstatus_id" , 1); //ToDo : to be replaced with constants
                $registerController = new RegisterController(new UserController());
                $registerController->register($registerRequest);
            }else
            {
                return redirect()->back()
                    ->withInput($request->only('mobile', 'remember'))
                    ->withErrors([
                        'credential' => 'اطلاعات وارد شده معتبر نمی باشند '
                    ],"login");
            }
        }

        // At this point it is either a new user who just was registered or an old user who logged in using his credentials
        $user = Auth::user();

        /** ///////////////////////////////////////////////////////*/


        /** ////////Determine where to redirect this user/////////*/
        $baseUrl = url("/");
        $targetUrl = redirect()->intended()->getTargetUrl();
        if(strcmp($targetUrl , $baseUrl) == 0)
        {// Indicates a strange situation when target url is the home page despite
        // the fact that there is a probability that user must be redirected to another page except home page

            if(strcmp(URL::previous() , route('login')) != 0)
                // User first had opened a page and then went to login
                $this->redirectTo = URL::previous() ;
        }else
        {
            $this->redirectTo = $targetUrl ;
        }
        /** //////////////////////////////////////////////////////////*/

        if($user->completion("afterLoginForm") != 100)
        {
            if(strcmp(URL::previous() , action("OrderController@checkoutAuth")) == 0)
            {
                return redirect(action("OrderController@checkoutCompleteInfo"));
            }else
            {
                session()->put("redirectTo" , $this->redirectTo );
                return redirect(action("UserController@completeRegister"));
            }

        }

        return redirect($this->redirectTo);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login3' );
    }
}
