<?php

namespace App\Http\Controllers\Auth;

use App\Traits\CharacterCommon;
use App\User;
use App\Userstatus;
use App\Helpers\Helper;
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
    protected $helper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = action("ProductController@search");
        $this->helper = new Helper();
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
          
//          $password = $this->helper->generateRandomPassword(4);

        if(!isset($data['firstName']) || strlen(preg_replace('/\s+/', '', $data['firstName'])) == 0)  $data['firstName'] = NULL;
        if(!isset($data['lastName']) || strlen(preg_replace('/\s+/', '', $data['lastName'])) == 0)  $data['lastName'] = NULL;
        if(!isset($data['major_id']) || strlen(preg_replace('/\s+/', '', $data['major_id'])) == 0)  $data['major_id'] = NULL;
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


        $smsInfo = array();
        $smsInfo["to"] = array(ltrim($user->mobile, '0'));
		$smsInfo["from"] = getenv("SMS_PROVIDER_DEFAULT_NUMBER");
//        /**
//         * Sending auto generated password through SMS
//         */
//
//        $smsInfo["message"] = "سلام به تخته خاک خوش آمدید\n نام کاربری: ".$user->mobile."\nرمزعبور: ".$password["rawPassword"] ;
        $smsInfo["message"] = "سلام به تخته خاک خوش آمدید\n نام کاربری: ".$user->mobile."رمز عبور: \n". $data['nationalCode'];
        $response = $this->helper->medianaSendSMS($smsInfo);
////          $response = array("error"=>false , "message"=>"ارسال موفقیت آمیز بود");
//        if(!$response["error"]){
//            $user->passwordRegenerated_at = Carbon::now();
//            $user->update();
//            session()->put("welcomePasswordMessage" , "رمز عبور شما به شماره موبایلتان پیامک شد. در صورت عدم دریافت پیامک پس از ۵ دقیقه، می توانید با رفتن به تغییر رمز عبور در پروفایل خود، درخواست ارسال رمز جدید نمایید.");
//        }else{
//            session()->put("welcomePasswordMessage" , "ارسال پیامک حاوی رمز عبور با مشکل مواجه شد! لطفا با مراجعه به تغییر رمز عبور در پروفایل خود، درخواست ارسال رمز جدید نمایید.");
//        }
//        /**
//         *    end
//         */
//
//        /**
//         * Sending account verification code through SMS
//         */
//        $verificationCode = rand(1000,99999);
//        $smsInfo["message"] = "کد احراز هویت شما: ".$verificationCode."\n تخته خاک";
//        $response = $this->helper->medianaSendSMS($smsInfo);
////        $response = array("error"=>false , "message"=>"ارسال موفقیت آمیز بود");
//        if(!$response["error"]){
//            $verificationMessageStatusSent = Verificationmessagestatuse::all()->where("name","sent")->first();
//            $request = new Request();
//            $request->offsetSet("user_id" ,  $user->id);
//            $request->offsetSet("code" ,  $verificationCode);
//            $request->offsetSet("verificationmessagestatus_id" ,  $verificationMessageStatusSent->id);
//            $request->offsetSet("expired_at" ,   Carbon::now()->addMinutes(Config::get('constants.MOBILE_VERIFICATION_TIME_LIMIT')));
//            $verificationMessageController = new VerificationmessageController();
//            if($verificationMessageController->store($request))
//            {
//                session()->put("welcomeVerifyCodeMessage" , "کد احراز هویت شما به شماره موبایلتان پیامک شد. شما ۳۰ دقیقه فرصت دارید با رفتن به پروفایل خود کد دریافتی را در قسمت مشخص شده وارد نموده و بدین وسیله حساب کاربری خود را تایید نمایید. در صورت عدم دریافت پیامک پس از ۵ دقیقه ،  می توانید با رفتن به پروفایل خود درخواست ارسال کد جدید نمایید.");
//            }else{
//                session()->put("welcomeVerifyCodeMessage" , "در ارسال کد احراز هویت شما خطایی رخ داد . لطفا با رفتن به پروفایل خود درخواست ارسال کد جدید نمایید.اگر در این فاصله پیامکی دریافت کردید لطفا آن را در نظر نگیرید");
//            }
//        }else{
//            session()->put("welcomeVerifyCodeMessage" , "ارسال پیامک احراز هویت شما با مشکل مواجه شد! لطفا با رفتن به پروفایل خود درخواست ارسال کد جدید نمایید.");
//        }
//        /**
//         *    end
//         */
//


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
