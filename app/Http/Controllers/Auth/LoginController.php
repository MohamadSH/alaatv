<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\{Controller};
use Illuminate\Http\Request;
use App\Traits\RedirectTrait;
use Illuminate\Http\Response;
use App\Events\Authenticated;
use App\Traits\CharacterCommon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
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

        $this->middleware('guest', ['except' => 'logout']);

        $this->middleware('convert:mobile|password|nationalCode');
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        return view('auth.login3');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  Request             $request
     * @param  RegisterController  $registerController
     *
     * @return RedirectResponse|Response|JsonResponse
     *
     * @throws ValidationException
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
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {

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
     * Log the user out of the application.
     *
     * @param  Request  $request
     *
     * @return Response
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
        } else {
            $request->session()
                ->invalidate();
        }

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  Request  $request
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
     * The user has been authenticated.
     *
     * @param  Request  $request
     * @param  mixed    $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        event(new Authenticated($user));
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
