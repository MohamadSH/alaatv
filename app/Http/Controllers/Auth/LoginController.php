<?php

namespace App\Http\Controllers\Auth;

use App\Events\Authenticated;
use App\Http\Controllers\{Controller};
use App\Http\Resources\User as UserResource;
use App\Traits\CharacterCommon;
use App\Traits\RedirectTrait;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        $this->middleware('auth:web', ['only' => 'logout']);

        $this->middleware('convert:mobile|password|nationalCode');
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        $login        = true;
        $voucher      = false;
        $verifyMobile = false;
        $redirectUrl  = route('web.index');

        return view('auth.voucherLogin', compact('redirectUrl', 'verifyMobile', 'voucher', 'login'));
        return view('auth.login3');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request            $request
     * @param RegisterController $registerController
     *
     * @return RedirectResponse|Response|void
     *
     * @throws ValidationException
     */
    public function login(Request $request, RegisterController $registerController)
    {
        $request->offsetSet('nationalCode', substr($request->get('password'), 0, 10));
        $request->offsetSet('userstatus_id', config('constants.USER_STATUS_ACTIVE'));
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
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     *
     * @return Response
     */
    protected function sendLoginResponse(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param mixed   $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
    {
        event(new Authenticated($user));
        if (!$request->expectsJson()) {
            return redirect($this->redirectTo($request));
        }
        if ($user->userstatus_id == config('constants.USER_STATUS_INACTIVE')) {
            return response()->json([
                'message' => 'User account has been deactivated',
            ], Response::HTTP_FORBIDDEN);
        }

        if (Str::contains($request->path(), 'v2')) {
            return $this->authenticatedV2($request, $user);
        }
        return $this->authenticatedV1($request, $user);
    }

    protected function authenticatedV2(Request $request, User $user)
    {
        $token = $user->getAppToken();
        $data  = array_merge([
            'user'       => new UserResource($user),
            'redirectTo' => $this->redirectTo($request),
        ], $token);
        return response()->json([
            'data' => $data,
        ], Response::HTTP_OK);
    }

    protected function authenticatedV1(Request $request, User $user)
    {
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
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        $this->guard()
            ->logout();

        $request->session()
            ->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
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
