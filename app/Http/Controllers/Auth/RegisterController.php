<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Traits\{Helper, UserCommon, RequestCommon, RedirectTrait, CharacterCommon};

class RegisterController extends Controller
{
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
    
    use CharacterCommon;
    use Helper;
    use UserCommon;
    use RegistersUsers;
    use RequestCommon;
    use RedirectTrait;
    
    /**
     * Create a new controller instance.
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest');
        $this->middleware('convert:mobile|password|nationalCode');
        $request->offsetSet('userstatus_id', $request->get('userstatus_id', 2));
    }
    
    /**
     * overriding method
     * Show the application registration form.
     *
     * @return Response
     */
    public function showRegistrationForm()
    {
        return view('auth.login3');
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $totalUserrules = $this->getInsertUserValidationRules($data);
        $rules          = [
            'mobile'       => $totalUserrules['mobile'],
            'nationalCode' => $totalUserrules['nationalCode'],
        ];
        
        return Validator::make($data, $rules);
    }
    
    protected function create(array $data)
    {
//        dd(array_get($data,'password'));
        return User::create([
            'firstName'     => array_get($data, 'firstName'),
            'lastName'      => array_get($data, 'lastName'),
            'mobile'        => array_get($data, 'mobile'),
            'email'         => array_get($data, 'email'),
            'nationalCode'  => array_get($data, 'nationalCode'),
            'userstatus_id' => 1,
            'photo'         => array_get($data, 'photo', config('constants.PROFILE_DEFAULT_IMAGE')),
            'password'      => bcrypt(array_get($data, 'password', array_get($data, 'nationalCode'))),
            'major_id'      => array_get($data, 'major_id'),
            'gender_id'     => array_get($data, 'gender_id'),
        ]);
    }
    
    /**
     * The user has been registered.
     *
     * @param  Request  $request
     * @param  mixed    $user
     *
     * @return mixed
     */
    protected function registered(Request $request, User $user)
    {
        event(new Registered($user));
        $this->guard()
            ->login($user);
        
        if ($request->expectsJson()) {
            $token = $user->getAppToken();
            $data  = array_merge([
                'user' => $user,
            ], $token);
            
            return response()->json([
                'status'     => 1,
                'msg'        => 'user registered',
                'redirectTo' => $this->redirectTo($request),
                'data'       => $data,
            ], Response::HTTP_OK);
        }
    }
}
