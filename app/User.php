<?php

namespace App;

use App\Classes\Taggable;
use App\Classes\Verification\MustVerifyMobileNumber;
use App\Collection\ContentCollection;
use App\Collection\UserCollection;
use App\Traits\APIRequestCommon;
use App\Traits\DateTrait;
use App\Traits\HasWallet;
use App\Traits\Helper;
use App\Traits\MustVerifyMobileNumberTrait;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\{Auth, Cache, Config, DB};
use Laratrust\Traits\LaratrustUserTrait;
use Schema;


/**
 * App\User
 *
 * @property int
 *               $id
 * @property string|null
 *               $firstName                نام کوچک
 * @property string|null
 *               $lastName                 نام خانوادگی
 * @property string|null
 *               $mobile                   شماره موبایل
 * @property string|null
 *               $phone                    شماره تلفن ثابت
 * @property string|null
 *               $whatsapp                 اکانت واتس اپ
 * @property string|null
 *               $skype                    اکانت اسکایپ
 * @property int
 *               $mobileNumberVerification شماره تماس تایید شده است یا خیر
 * @property string|null
 *               $nationalCode             کد ملی
 * @property string
 *               $password                 رمز عبور
 * @property int
 *               $userstatus_id            آیدی مشخص کننده وضعیت کاربر
 * @property int
 *               $lockProfile              قفل بودن با نبودن پروفایل
 * @property string|null
 *               $photo                    عکس شخصی
 * @property string|null
 *               $province                 استان محل سکونت
 * @property string|null
 *               $city                     شهر محل سکونت
 * @property string|null
 *               $address                  آدرس محل سکونت
 * @property string|null
 *               $postalCode               کد پستی محل سکونت
 * @property string|null
 *               $school                   مدرسه ی محل تحصیل
 * @property int|null
 *               $major_id                 آیدی رشته تحصیل کاربر
 * @property int|null
 *               $grade_id                 آی دی مشخص کننده مقطع
 * @property int|null
 *               $gender_id                آیدی جنیست کاربر
 * @property string|null
 *               $birthdate                تاریخ تولد
 * @property string|null
 *               $remember_token
 * @property string|null
 *               $passwordRegenerated_at   تاریخ آخرین تولید خودکار(بازیابی) رمز عبور
 * @property \Carbon\Carbon|null
 *               $created_at
 * @property \Carbon\Carbon|null
 *               $updated_at
 * @property \Carbon\Carbon|null
 *               $deleted_at
 * @property string|null
 *               $email                    ایمیل کاربر
 * @property string|null
 *               $bio                      معرفی کاربر
 * @property string|null
 *               $introducedBy             نحوه ی آشنایی با شرکت
 * @property int|null
 *               $bloodtype_id             گروه خونی
 * @property string|null
 *               $allergy                  آلرژی به ماده خاص
 * @property string|null
 *               $medicalCondition         بیماری یا شرایط پزشکی خاص
 * @property string|null
 *               $diet                     رژیم غذایی خاص
 * @property string|null
 *               $techCode                 کد تکنسین
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bankaccount[]
 *                    $bankaccounts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Belonging[]
 *                    $belongings
 * @property-read \App\Bloodtype|null
 *                    $bloodtype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[]
 *                    $contacts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[]
 *                    $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employeeschedule[]
 *                    $employeeschedules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employeetimesheet[]
 *                    $employeetimesheets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Eventresult[]
 *                    $eventresults
 * @property-read \App\Gender|null
 *                    $gender
 * @property-read mixed
 *                    $full_name
 * @property-read \App\Grade|null
 *                    $grade
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Lottery[]
 *                    $lotteries
 * @property-read \App\Major|null
 *                    $major
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Mbtianswer[]
 *                    $mbtianswers
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[]
 *                    $openOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[]
 *                    $orderTransactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ordermanagercomment[]
 *                    $ordermanagercomments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[]
 *                    $orderproducts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[]
 *                    $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[]
 *                    $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productvoucher[]
 *                    $productvouchers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[]
 *                    $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Websitepage[]
 *                    $seensitepages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[]
 *                    $transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userbon[]
 *                    $userbons
 * @property-read \App\Userstatus
 *                    $userstatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Usersurveyanswer[]
 *                    $usersurveyanswers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userupload[]
 *                    $useruploads
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Verificationmessage[]
 *                    $verificationmessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[]
 *                    $walletTransactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Wallet[]
 *                    $wallets
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAllergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBloodtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIntroducedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLockProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMedicalCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobileNumberVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNationalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePasswordRegeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleIs($role = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTechCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWhatsapp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User role($roles)
 * @property string|null
 *               $nameSlug                 اسلاگ شده نام
 * @property-read mixed
 *                    $full_name_reverse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNameSlug($value)
 * @property string|null
 *               $mobile_verified_code     کد تایید شماره موبایل
 * @property string|null
 *               $mobile_verified_at       تاریخ تایید شماره موبایل
 * @property-read \App\Collection\ContentCollection|\App\Content[]
 *                    $favoredContent
 * @property-read \App\Collection\ProductCollection|\App\Product[]
 *                    $favoredProduct
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contentset[]
 *                    $favoredSet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobileVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobileVerifiedCode($value)
 */
class User extends Authenticatable implements Taggable, MustVerifyMobileNumber
{
    use MustVerifyMobileNumberTrait;
    use Helper;
    use DateTrait;
    use SoftDeletes, CascadeSoftDeletes;
    use LaratrustUserTrait;
    use HasWallet;
    use Notifiable;
    use APIRequestCommon;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $cascadeDeletes = [
        'orders',
        'userbons',
        'useruploads',
        'bankaccounts',
        'contacts',
        'mbtianswers',
        'favorables',
    ];
    /**      * The attributes that should be mutated to dates.        */
    protected $dates       = [
        'created_at',
        'updated_at',
        'deleted_at',
        'birthdate',
    ];
    protected $lockProfile = [
        "province",
        "city",
        "address",
        "postalCode",
        "school",
        "gender_id",
        "major_id",
        "email",
    ];
    //columns being used for locking user's profile
    protected $completeInfo = [
        "photo",
        "province",
        "city",
        "address",
        "postalCode",
        "school",
        "gender_id",
        "major_id",
        "grade_id",
        "phone",
        "bloodtype_id",
        "allergy",
        "medicalCondition",
        "diet",
    ];
    protected $medicalInfo  = [
        "bloodtype_id",
        "allergy",
        "medicalCondition",
        "diet",
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'nameSlug',
        'mobile',
        'password',
        'nationalCode',
        'photo',
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'major_id',
        'grade_id',
        'birthdate',
        'gender_id',
        'userstatus_id',
        'email',
        'bio',
        'introducedBy',
        'phone',
        'whatsapp',
        'skype',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | scope methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return UserCollection
     */
    public static function getTeachers(): UserCollection
    {
        $key = "getTeachers";
        return Cache::tags(["teachers"])
                    ->remember($key, config("constants.CACHE_600"), function () {
                        $authors = User::select()
                                       ->role([config('constants.ROLE_TEACHER')])
                                       ->orderBy('lastName')
                                       ->get();
                        return $authors;
                    });
    }

    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */

    /**
     * @return UserCollection
     */
    public static function getEmployee(): UserCollection
    {
        $key = "getEmployee";
        return Cache::tags(["employee"])
                    ->remember($key, config("constants.CACHE_600"), function () {
                        $employees = User::select()
                                         ->role([config('constants.ROLE_EMPLOYEE')])
                                         ->orderBy('lastName')
                                         ->get();
                        return $employees;
                    });
    }

    public static function orderStatusFilter($users, $orderStatusesId)
    {
        $key = "user:orderStatusFilter:" . implode($users->pluck('id')
                                                         ->toArray()) . "-" . $orderStatusesId;

        return Cache::remember($key, Config::get("constants.CACHE_3"), function () use ($users, $orderStatusesId) {

            return $users->whereIn('id', Order::whereIn("orderstatus_id", $orderStatusesId)
                                              ->pluck('user_id'));
        });

    }

    public function scopeRole($query, array $roles)
    {
        return $query->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn("id", $roles);
        });
    }

    public function major()
    {
        return $this->belongsTo('App\Major');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function userstatus()
    {
        return $this->belongsTo('App\Userstatus');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function openOrders()
    {
        return $this->hasMany('App\Order')
                    ->where("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
    }

    public function userbons()
    {
        return $this->hasMany('\App\Userbon');
    }

    public function useruploads()
    {
        return $this->hasMany('\App\Userupload');
    }

    //Site pages that user has seen

    public function bankaccounts()
    {
        return $this->hasMany('\App\Bankaccount');
    }

    public function contacts()
    {
        return $this->hasMany('\App\Contact');
    }

    public function mbtianswers()
    {
        return $this->hasMany('\App\Mbtianswer');
    }

    public function usersurveyanswers()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }

    public function eventresults()
    {
        return $this->hasMany('\App\Eventresult');
    }

    public function belongings()
    {
        return $this->belongsToMany('\App\Belonging');
    }

    public function employeeschedules()
    {
        return $this->hasMany("\App\Employeeschedule");
    }

    public function employeetimesheets()
    {
        return $this->hasMany("\App\Employeetimesheet");
    }

    public function lotteries()
    {
        return $this->belongsToMany("\App\Lottery")
                    ->withPivot("rank", "prizes");
    }

    public function bloodtype()
    {
        return $this->belongsTo("\App\Bloodtype");
    }

    public function grade()
    {
        return $this->belongsTo("\App\Grade");
    }

    public function contents()
    {
        return $this->hasMany("\App\Content", "author_id", "id");
    }

    public function orderproducts()
    {
        return $this->hasManyThrough("\App\Orderproduct", "\App\Order");
    }

    /**
     * Retrieve only order ralated transactions of this user
     */
    public function orderTransactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Order");
    }

    /**
     * Retrieve only order ralated transactions of this user
     */
    public function walletTransactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Wallet");
    }

    /**
     * Retrieve all transactions of this user
     */
    public function transactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Wallet");
    }

    /**
     * Retrieve all product vouchers of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productvouchers()
    {
        return $this->hasMany("\App\Productvoucher");
    }

    public function ordermanagercomments()
    {
        return $this->hasMany('App\Ordermanagercomment');
    }

    public function favoredContent()
    {
        return $this->morphedByMany('App\Content', 'favorable')
                    ->withTimestamps();
    }

    public function favoredSet()
    {
        return $this->morphedByMany('App\Contentset', 'favorable')
                    ->withTimestamps();
    }

    public function favoredProduct()
    {
        return $this->morphedByMany('App\Product', 'favorable')
                    ->withTimestamps();
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return UserCollection
     */
    public function newCollection(array $models = [])
    {
        return new UserCollection($models);
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function products()
    {
        $result = DB::table('products')
                    ->join('orderproducts', function ($join) {
                        $join->on('products.id', '=', 'orderproducts.product_id')
                             ->whereNull('orderproducts.deleted_at');
                    })
                    ->join('orders', function ($join) {
                        $join->on('orders.id', '=', 'orderproducts.order_id')
                             ->whereIn('orders.orderstatus_id', [
                                 Config::get("constants.ORDER_STATUS_CLOSED"),
                                 Config::get("constants.ORDER_STATUS_POSTED"),
                                 Config::get("constants.ORDER_STATUS_READY_TO_POST"),
                             ])
                             ->whereNull('orders.deleted_at');
                    })
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->select([

                                 "products.*",
                             ])
                    ->where('users.id', '=', $this->getKey())
                    ->whereNull('products.deleted_at')
                    ->distinct()
                    ->get();
        $result = Product::hydrate($result->toArray());

        return $result;
    }

    /**
     * @param string $bonName
     *
     * @return int
     */
    public function userHasBon($bonName): int
    {
        $key = "user:userHasBon:" . $this->cacheKey() . "-" . $bonName;

        return Cache::tags('bon')
                    ->remember($key, Config::get("constants.CACHE_60"), function () use ($bonName) {

                        $bon = Bon::all()
                                  ->where('name', $bonName)
                                  ->where('isEnable', '=', 1);
                        if ($bon->isEmpty())
                            return false;
                        $userbons = $this->userbons
                            ->where("bon_id", $bon->first()->id)
                            ->where("userbonstatus_id", Config::get("constants.USERBON_STATUS_ACTIVE"));
                        $totalBonNumber = 0;
                        foreach ($userbons as $userbon) {
                            $totalBonNumber = $totalBonNumber + $userbon->validateBon();
                        }
                        return $totalBonNumber;

                    });

    }

    //TODO:// add cache

    public function cacheKey()
    {
        $key = $this->getKey();
        $time = isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }

    /**
     * returns user valid bons of the specified bons
     *
     * @param \app\Bon  $bon
     * @param \app\User $user
     *
     * @return  \Illuminate\Database\Eloquent\Collection a collection of user valid bons of specified bon
     */
    public function userValidBons(Bon $bon)
    {
        $key = "user:userValidBons:" . $this->cacheKey() . "-" . (isset($bon) ? $bon->cacheKey() : "");

        return Cache::tags('bon')
                    ->remember($key, Config::get("constants.CACHE_60"), function () use ($bon) {
                        return Userbon::where("user_id", $this->id)
                                      ->where("bon_id", $bon->id)
                                      ->where("userbonstatus_id", Config::get("constants.USERBON_STATUS_ACTIVE"))
                                      ->whereColumn('totalNumber', '>', 'usedNumber')
                                      ->where(function ($query) {
                                          $query->whereNull("validSince")
                                                ->orwhere("validSince", "<", Carbon::now());
                                      })
                                      ->where(function ($query) {
                                          $query->whereNull("validUntil")
                                                ->orwhere("validUntil", ">", Carbon::now());
                                      })
                                      ->get();
                    });

    }

    /**
     * Makes payload for Disqus SSo
     *
     * @return string
     */
    public function disqusSSO()
    {
        if (isset($this->firstName) && isset($this->lastName) && isset($this->mobile)) {
            if (isset($this->photo) && strlen($this->photo) > 0) {
                $data = [
                    "id"       => $this->mobile,
                    "username" => $this->firstName . " " . $this->lastName,
                    "email"    => $this->mobile . "@takhtekhak.com",
                    "avatar"   => route('image', [
                        'category' => '1',
                        'w'        => '39',
                        'h'        => '39',
                        'filename' => $this->photo,
                    ]),
                ];
            } else {
                $data = [
                    "id"       => $this->mobile,
                    "username" => $this->firstName . " " . $this->lastName,
                    "email"    => $this->mobile . "@takhtekhak.com",
                ];
            }
            $message = base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE));
            $timestamp = time();
            $data = $message . ' ' . $timestamp;
            $key = config('constants.DISQUS_PRIVATE_KEY');

            $blocksize = 64;
            $hashfunc = 'sha1';
            if (strlen($key) > $blocksize)
                $key = pack('H*', $hashfunc($key));
            $key = str_pad($key, $blocksize, chr(0x00));
            $ipad = str_repeat(chr(0x36), $blocksize);
            $opad = str_repeat(chr(0x5c), $blocksize);
            $hmac = pack(
                'H*', $hashfunc(
                        ($key ^ $opad) . pack(
                            'H*', $hashfunc(
                                    ($key ^ $ipad) . $data
                                )
                        )
                    )
            );
            $hmac = bin2hex($hmac);
            //            dd($message." ".$hmac." ".$timestamp);
            return $message . " " . $hmac . " " . $timestamp;
        }
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function Birthdate_Jalali()
    {
        $explodedDateTime = explode(" ", $this->birthdate);
        $explodedDate = $explodedDateTime[0];
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($explodedDate, "toJalali");
    }

    public function returnLockProfileItems()
    {
        return $this->lockProfile;
    }

    public function returnCompletionItems()
    {
        return $this->completeInfo;
    }

    public function returnMedicalItems()
    {
        return $this->medicalInfo;
    }

    public function completion($type = "full", $columns = [])
    {
        $tableColumns = Schema::getColumnListing("users");
        switch ($type) {
            case "full":
                $importantColumns = [
                    "firstName",
                    "lastName",
                    "mobile",
                    "nationalCode",
                    "province",
                    "city",
                    "address",
                    "postalCode",
                    "gender_id",
                    "mobile_verified_at",
                ];
                break;
            case "fullAddress":
                $importantColumns = [
                    "firstName",
                    "lastName",
                    "mobile",
                    "nationalCode",
                    "province",
                    "city",
                    "address",
                ];
                break;
            case "lockProfile":
                $customColumns = $this->lockProfile;
                $importantColumns = array_unique(array_merge($customColumns, Afterloginformcontrol::getFormFields()
                                                                                                  ->pluck('name', 'id')
                                                                                                  ->toArray()));
                break;
            case "afterLoginForm" :
                $importantColumns = Afterloginformcontrol::getFormFields()
                                                         ->pluck('name', 'id')
                                                         ->toArray();
                break;
            case "completeInfo":
                $importantColumns = $this->completeInfo;
                break;
            case "custom":
                $importantColumns = $columns;
                break;
            default:
                $importantColumns = [];
                break;
        }

        $numberOfColumns = count($importantColumns);
        $unsetColumns = 0;
        if ($numberOfColumns > 0) {
            foreach ($tableColumns as $tableColumn) {
                if (in_array($tableColumn, $importantColumns)) {
                    if (strcmp($tableColumn, "photo") == 0 && strcmp(Auth::user()->photo, Config::get('constants.PROFILE_DEFAULT_IMAGE')) == 0) {
                        $unsetColumns++;
                    }
                    if (!isset($this->$tableColumn) || strlen(preg_replace('/\s+/', '', $this->$tableColumn)) == 0) {
                        $unsetColumns++;
                    } else if (strcmp($tableColumn, "mobile_verified_at") == 0 && !is_null($this->$tableColumn)) {
                        $unsetColumns++;
                    }
                }

            }

            return (1 - ($unsetColumns / $numberOfColumns)) * 100;
        } else return 100;

    }

    public function getfullName($mode = "firstNameFirst")
    {
        $fullName = "";
        switch ($mode) {
            case "firstNameFirst":
                if (isset($this->firstName[0]) || isset($this->lastName[0])) {
                    if (isset($this->firstName[0]))
                        $fullName .= $this->firstName . " ";
                    if (isset($this->lastName[0]))
                        $fullName .= $this->lastName;

                }
                break;
            case "lastNameFirst":
                if (isset($this->firstName[0]) || isset($this->lastName[0])) {
                    if (isset($this->firstName[0]))
                        $fullName .= $this->lastName . " ";
                    if (isset($this->lastName[0]))
                        $fullName .= $this->firstName;
                }
                break;
            default:
                break;
        }

        return $fullName;
    }

    public function getFullNameAttribute($value)
    {
        return ucfirst($this->firstName) . ' ' . ucfirst($this->lastName);
    }

    public function getFullNameReverseAttribute($value)
    {
        return ucfirst($this->lastName) . ' ' . ucfirst($this->firstName);
    }

    public function routeNotificationForPhoneNumber()
    {
        return ltrim($this->mobile, '0');
    }

    /**  Determines whether user has this content or not
     *
     * @param  $contentId
     *
     * @return bool
     */
    public function hasContent($contentId)
    {
        return true;
    }

    public function seen($path)
    {
        $path = "/" . ltrim($path, "/");

        $SeenCount = 0;
        $websitepage = Websitepage::firstOrNew(["url" => $path]);
        if (!isset($websitepage->id)) {
            $websitepage->save();
        }
        if (isset($websitepage->id)) {
            if (!$this->seensitepages->contains($websitepage->id))
                $this->seensitepages()
                     ->attach($websitepage->id);
            else {
                $this->seensitepages()
                     ->updateExistingPivot($websitepage->id, [
                         "numberOfVisit" => $this->seensitepages()
                                                 ->where("id", $websitepage->id)
                                                 ->first()->pivot->numberOfVisit + 1,
                         "updated_at"    => Carbon::now(),
                     ]);
            }
            $SeenCount = $websitepage->userschecked()
                                     ->count();
        }

        return $SeenCount;
    }

    public function seensitepages()
    {
        return $this->belongsToMany('\App\Websitepage', 'userseensitepages', 'user_id', 'websitepage_id')
                    ->withPivot("created_at", "numberOfVisit");
    }

    public function CanSeeCounter(): bool
    {
        return $this->hasRole("admin") ? true : false;
    }

    public function retrievingTags()
    {
        /**
         *      Retrieving Tags
         */
        $response = $this->sendRequest(
            config("constants.TAG_API_URL") . "id/author/" . $this->id,
            "GET"
        );

        if ($response["statusCode"] == 200) {
            $result = json_decode($response["result"]);
            $tags = $result->data->tags;
        } else {
            $tags = [];
        }

        return $tags;
    }

    public function getTaggableTags()
    {
        $userContents = $this->contents;
        return $this->mergeContentTags($userContents);
    }

    /**
     * @param $userContents
     *
     * @return array
     */
    private function mergeContentTags(ContentCollection $userContents): array
    {
        $tags = [];
        foreach ($userContents as $content) {
            $tags = array_merge($tags, $content->tags->tags);
        }
        $tags = array_values(array_unique($tags));
        return $tags;
    }

    public function getTaggableId()
    {
        return $this->id;
    }

    public function getTaggableScore()
    {
        return null;
    }

    public function isTaggableActive(): bool
    {
        $userContents = $this->contents;
        if (count($userContents) == 0) {
            return false;
        }
        return true;
    }
}
