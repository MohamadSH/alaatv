<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\{Controller};
use Illuminate\Http\Request;
use App\Traits\RedirectTrait;
use Illuminate\Http\Response;
use App\Traits\CharacterCommon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use CharacterCommon;
    use RedirectTrait;
    
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
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        
        $this->middleware('guest')
            ->except('logout');
        
        $this->middleware('convert:mobile|password|nationalCode');
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()
            ->logout();
        
        if ($request->expectsJson()) {
            //TODO:// revoke all apps!!!
            $request->user()
                ->token()
                ->revoke();
        }
        else {
            $request->session()
                ->invalidate();
        }
        
        return $this->loggedOut($request) ?: redirect('/');
    }
    
    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'     => 1,
                'msg'        => 'user sign out.',
                'redirectTo' => action("Web\IndexPageController"),
            ], Response::HTTP_OK);
        }
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request                       $request
     *
     *
     * @param  \App\Http\Controllers\Auth\RegisterController  $registerController
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request, RegisterController $registerController)
    {
        $request->offsetSet('nationalCode', substr($request->get('password'), 0, 10));
        $request->offsetSet('userstatus_id', 1);
        /**
         * Validating mobile and password strings
         */
        $this->validateLogin($request);
        /**
         * Login or register this new user
         */
        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            
            $this->fireLockoutEvent($request);
            
            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            if ($this->guard()
                    ->user()->userstatus_id === 1) {
                return $this->sendLoginResponse($request);
            }
    
            return redirect()
                ->back()
                ->withInput($request->only('mobile', 'remember'))
                ->withErrors([
                    'inActive' => 'حساب کاربری شما غیر فعال شده است!',
                ], 'login');
        }
        
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

//        Log::error('LoginController login 7');
        return $registerController->register($request);
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        if (!$request->expectsJson()) {
            $request->session()
                ->regenerate();
        }
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()
            ->user()) ?: redirect()->intended($this->redirectPath());
    }
    
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed                     $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$request->expectsJson()) {
            return redirect($this->redirectTo($request));
        }
        
        $token = $user->getAppToken();
        $data  = array_merge([
            'user' => $user,
        ], $token);
        return response()->json([
            'status'     => 1,
            'msg'        => 'user sign in.',
            'redirectTo' => $this->redirectTo($request),
            'data'       => $data,
        ], Response::HTTP_OK);
    }
    
    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login3');
    }
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'nationalCode', 'password');
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'mobile';
    }
}
