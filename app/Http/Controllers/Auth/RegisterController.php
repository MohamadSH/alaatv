<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\UserRegisterd;
use App\Traits\CharacterCommon;
use App\Traits\Helper;
use App\User;
use App\Userstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;


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
    protected $redirectTo ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = action("ProductController@search");
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'max:255',
            'lastName' => 'max:255',
            'mobile'   => ['required',
                            'digits:11',
                            Rule::unique('users')->where(function ($query) use ($data) {
                                $query->where('nationalCode', $data["nationalCode"])->where('deleted_at' , null);
                            })
                            ],
//            'password' => 'required|confirmed|min:6',
            'nationalCode'   => ['required',
                                'digits:10',
                                'validate:nationalCode',
                                Rule::unique('users')->where(function ($query) use ($data){
                                    $query->where('mobile', $data["mobile"])->where('deleted_at' , null);
                                })
                                 ],
            'postalCode'    => 'numeric',
            'major_id'   => 'exists:majors,id',
            'gender_id'   => 'exists:genders,id',
//            'photo' => 'required|image|mimes:jpeg,jpg,png|max:200',
//            'rules' => 'required',
//            'g-recaptcha-response' => 'required|recaptcha',
            'email' => 'email'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $softDeletedUsers = User::onlyTrashed()->where("mobile" , $data["mobile"])->where("nationalCode" , $data["nationalCode"])->get();
        if(!$softDeletedUsers->isEmpty())
        {
            $user = $softDeletedUsers->first();
            $user->restore();
            return $user;
        }

        /**
         * Uploading photo
         */
          //Setting default values
          $data["photo"]  = Config::get('constants.PROFILE_DEFAULT_IMAGE');
          $data["userstatus_id"] = Userstatus::all()->where("name" , "active")->first()->id ;
          
//          $password = $this->generateRandomPassword(4);
        if(!isset($data['firstName']) || strlen(preg_replace('/\s+/', '', $data['firstName'])) == 0)  $data['firstName'] = NULL;
        if(!isset($data['lastName']) || strlen(preg_replace('/\s+/', '', $data['lastName'])) == 0)  $data['lastName'] = NULL;
        if(!isset($data['major_id']) || strlen(preg_replace('/\s+/', '', $data['major_id'])) == 0)  $data['major_id'] = NULL;
        if(!isset($data['grade_id']) || strlen(preg_replace('/\s+/', '', $data['grade_id'])) == 0)  $data['grade_id'] = NULL;
        if(!isset($data['gender_id']) || strlen(preg_replace('/\s+/', '', $data['gender_id'])) == 0)  $data['gender_id'] = NULL;
        if(!isset($data['province']) || strlen(preg_replace('/\s+/', '', $data['province'])) == 0)  $data['province'] = NULL;
        if(!isset($data['city']) || strlen(preg_replace('/\s+/', '', $data['city'])) == 0)  $data['city'] = NULL;
        if(!isset($data['address']) || strlen(preg_replace('/\s+/', '', $data['address'])) == 0)  $data['address'] = NULL;
        if(!isset($data['postalCode']) || strlen(preg_replace('/\s+/', '', $data['postalCode'])) == 0)  $data['postalCode'] = NULL;
        if(!isset($data['school']) || strlen(preg_replace('/\s+/', '', $data['school'])) == 0)  $data['school'] = NULL;
        if(!isset($data['email']) || strlen(preg_replace('/\s+/', '', $data['email'])) == 0)  $data['email'] = NULL;
        /**
         * making the order for this new user will be done in \App\Http\Middleware\OrderCheck
         */

        $user =  User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'nationalCode' => $data['nationalCode'],
            'mobile' => $data['mobile'],
            'major_id' => $data['major_id'],
            'grade_id' => $data['grade_id'],
            'gender_id'=>$data['gender_id'],
            'photo' => $data['photo'],
//            'password' => $password['hashPassword'],
            'password' => bcrypt($data['nationalCode']),
            'province' => $data['province'],
            'city' => $data['city'],
            'address' => $data['address'],
            'postalCode' => $data['postalCode'],
            'school' => $data['school'],
            'userstatus_id' => $data["userstatus_id"],
            'email'=>$data['email'],
        ]);
//        $user->notify(new UserRegisterd());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->offsetSet("mobile" ,  $this->convertToEnglish($request->get("mobile")));
        $request->offsetSet("nationalCode" , $this->convertToEnglish($request->get("nationalCode")));

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

}
