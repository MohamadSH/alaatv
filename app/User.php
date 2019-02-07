<?php

namespace App;

use App\Classes\Taggable;
use App\Classes\Verification\MustVerifyMobileNumber;
use App\Collection\ContentCollection;
use App\Collection\UserCollection;
use App\Traits\APIRequestCommon;
use App\Traits\CharacterCommon;
use App\Traits\DateTrait;
use App\Traits\HasWallet;
use App\Traits\Helper;
use App\Traits\MustVerifyMobileNumberTrait;
use App\Traits\OrderCommon;
use Carbon\Carbon;
use Hash;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\{Auth, Cache, Config, DB, Log};
use Kalnoy\Nestedset\QueryBuilder;
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
 * @property string|null $email_verified_at
 * @property-read mixed $reverse_full_name
 * @property-write mixed $first_name
 * @property-write mixed $last_name
 * @property-write mixed $medical_condition
 * @property-write mixed $postal_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @property-read \App\Collection\OrderproductCollection|\App\Orderproduct[] $closedorderproducts
 * @property mixed mobile
 * @property string lastName
 * @property string firstName
 * @property int id
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static select()
 * @property-read mixed                                                      $number_of_products_in_basket
 * @property-read mixed                                                      $short_name
 * @property-read mixed                                                      $completion_info
 * @property-read mixed                                                      $gender_info
 * @property-read mixed                                                      $grade_info
 * @property-read mixed                                                      $major_info
 * @property-read mixed                                                      $wallet_info
 */
class User extends Authenticatable implements Taggable, MustVerifyMobileNumber, MustVerifyEmail
{
    use MustVerifyMobileNumberTrait;
    use Helper;
    use DateTrait;
    use SoftDeletes, CascadeSoftDeletes;
    use LaratrustUserTrait;
    use HasWallet;
    use Notifiable;
    use APIRequestCommon;
    use CharacterCommon;
    use OrderCommon;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'majorInfo',
        'gradeInfo',
        'genderInfo',
        'walletInfo',
        'completionInfo'
        ];

    protected $cascadeDeletes = [
        'orders',
        'userbons',
        'useruploads',
        'bankaccounts',
        'contacts',
        'mbtianswers',
//        'favorables',
    ];
    /**      * The attributes that should be mutated to dates.        */
    protected $dates       = [
        'created_at',
        'updated_at',
        'deleted_at',
        'birthdate',
        'mobile_verified_code',
        'email_verified_at',
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
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'major_id',
        'grade_id',
        'birthdate',
        'gender_id',
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
        'id',
        'major',
        'major_id',
        'grade',
        'grade_id',
        'gender_id',
        'mobile_verified_code',
        'mobileNumberVerification',
        'phone',
        'userstatus_id',
        'birthdate',
        'passwordRegenerated_at',
        'deleted_at',
        'techCode',
        'password',
        'remember_token',
        'wallets',
        'full_name',
        'photo',
    ];

    private static $secureFillable = [
        "firstName",
        "lastName",
        "password",
        "nationalCode",
        "nameSlug",
        "mobile",
        "userstatus_id",
        "techCode",
    ];

    private static $beProtected = [
        "roles",
    ];


    /** Setter mutator for major_id
     *
     * @param $value
     */
    public function setFirstNameAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["firstName"] = null;
        else
            $this->attributes["firstName"] = $value;

    }

    /** Setter mutator for major_id
     *
     * @param $value
     */
    public function setLastNameAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["lastName"] = null;
        else
            $this->attributes["lastName"] = $value;
    }

    /** Setter mutator for major_id
     *
     * @param $value
     */
    public function setMajorIdAttribute($value): void
    {
        if ($value == 0)
            $this->attributes["major_id"] = null;
        else
            $this->attributes["major_id"] = $value;
    }

    /** Setter mutator for bloodtype_id
     *
     * @param $value
     */
    public function setBloodtypeIdAttribute($value): void
    {
        if ($value == 0)
            $this->attributes["bloodtype_id"] = null;
        else
            $this->attributes["bloodtype_id"] = $value;
    }

    /** Setter mutator for grade_id
     *
     * @param $value
     */
    public function setGenderIdAttribute($value): void
    {
        if ($value == 0)
            $this->attributes["gender_id"] = null;
        else
            $this->attributes["gender_id"] = $value;
    }

    /** Setter mutator for grade_id
     *
     * @param $value
     */
    public function setGradeIdAttribute($value): void
    {
        if ($value == 0)
            $this->attributes["grade_id"] = null;
        else
            $this->attributes["grade_id"] = $value;
    }

    /** Setter mutator for email
     *
     * @param $value
     */
    public function setEmailAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["email"] = null;
        else
            $this->attributes["email"] = $value;
    }

    /** Setter mutator for phone
     *
     * @param $value
     */
    public function setPhoneAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["phone"] = null;
        else
            $this->attributes["phone"] = $value;
    }

    /** Setter mutator for city
     *
     * @param $value
     */
    public function setCityAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["city"] = null;
        else
            $this->attributes["city"] = $value;
    }

    /** Setter mutator for province
     *
     * @param $value
     */
    public function setProvinceAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["province"] = null;
        else
            $this->attributes["province"] = $value;
    }

    /** Setter mutator for address
     *
     * @param $value
     */
    public function setAddressAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["address"] = null;
        else
            $this->attributes["address"] = $value;
    }

    /** Setter mutator for postalCode
     *
     * @param $value
     */
    public function setPostalCodeAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["postalCode"] = null;
        else
            $this->attributes["postalCode"] = $value;
    }

    /** Setter mutator for school
     *
     * @param $value
     */
    public function setSchoolAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["school"] = null;
        else
            $this->attributes["school"] = $value;
    }

    /** Setter mutator for allergy
     *
     * @param $value
     */
    public function setAllergyAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["allergy"] = null;
        else
            $this->attributes["allergy"] = $value;
    }

    /** Setter mutator for medicalCondition
     *
     * @param $value
     */
    public function setMedicalConditionAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["medicalCondition"] = null;
        else
            $this->attributes["medicalCondition"] = $value;
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setDietAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $this->attributes["diet"] = null;
        else
            $this->attributes["diet"] = $value;
    }


    /*
    |--------------------------------------------------------------------------
    | scope methods
    |--------------------------------------------------------------------------
    */
    /**
     * Get user's orders that he is allowed to see
     *
     * @return HasMany
     */
    public function getClosedOrders(): HasMany
    {
        return $this->orders()
                    ->whereNotIn("orderstatus_id", Order::OPEN_ORDER_STATUSES);
    }

    /**
     * Gets user's transactions that he is allowed to see
     *
     * @return HasManyThrough
     */
    public function getShowableTransactions(): HasManyThrough
    {
        $showableTransactionStatuses = [
            config("constants.TRANSACTION_STATUS_SUCCESSFUL"),
            config("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL"),
            config("constants.TRANSACTION_STATUS_PENDING"),
        ];
        $transactions = $this->orderTransactions()
                             ->whereDoesntHave("parents")
                             ->where(function ($q) use ($showableTransactionStatuses) {
                                 /** @var QueryBuilder $q */
                                 $q->whereIn("transactionstatus_id", $showableTransactionStatuses);
                             });
        return $transactions;
    }

    /**
     * Gets user's instalments
     *
     * @return HasManyThrough
     */
    public function getInstalments(): HasManyThrough
    {
        //ToDo : to be tested
        return $this->orderTransactions()
                    ->whereDoesntHave("parents")
                    ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_UNPAID"));
    }

    /**
     *
     */
    public function getReverseFullNameAttribute()
    {
        return ucfirst($this->lastName) . ' ' . ucfirst($this->firstName);
    }

    public function getLottery()
    {
        $exchangeAmount = 0;
        $userPoints = 0;
        $userLottery = null;
        $prizeCollection = collect();
        $lotteryRank = null;
        $lottery = null;
        $lotteryMessage = "";
        $lotteryName = "";

        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $startTime2 = Carbon::create(2018, 06, 15, 07, 00, 00, 'Asia/Tehran');
        $endTime2 = Carbon::create(2018, 06, 15, 23, 59, 30, 'Asia/Tehran');
        $flag2 = ($now->between($startTime2, $endTime2));
        if ($flag2) {
            $bon = Bon::where("name", Config::get("constants.BON2"))
                      ->first();
            $userPoints = 0;
            if (isset($bon)) {
                $userPoints = $this->userHasBon($bon->name);
                $exchangeAmount = $userPoints * config("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT");
            }
            if ($userPoints <= 0) {
                $lottery = Lottery::where("name", Config::get("constants.LOTTERY_NAME"))
                                  ->get()
                                  ->first();
                if (isset($lottery)) {
                    $userLottery = $this->lotteries()
                                        ->where("lottery_id", $lottery->id)
                                        ->get()
                                        ->first();
                    if (isset($userLottery)) {
                        $lotteryName = $lottery->displayName;
                        $lotteryMessage = "شما در قرعه کشی " . $lotteryName . " شرکت داده شدید و متاسفانه برنده نشدید.";
                        if (isset($userLottery->pivot->prizes)) {
                            $lotteryRank = $userLottery->pivot->rank;
                            if ($lotteryRank == 0) {
                                $lotteryMessage = "شما از قرعه کشی " . $lotteryName . " انصراف دادید.";
                            } else {
                                $lotteryMessage = "شما در قرعه کشی " . $lotteryName . " برنده " . $lotteryRank . " شدید.";
                            }

                            $prizes = json_decode($userLottery->pivot->prizes)->items;
                            $prizeCollection = collect();
                            foreach ($prizes as $prize) {
                                if (isset($prize->objectId)) {
                                    $id = $prize->objectId;
                                    $model_name = $prize->objectType;
                                    $model = new $model_name;
                                    $model->find($id);

                                    $prizeCollection->push(["name" => $prize->name]);
                                } else {
                                    $prizeCollection->push(["name" => $prize->name]);
                                }
                            }
                        }

                    }
                }
            }
        }

        return [
            $exchangeAmount,
            $userPoints,
            $userLottery,
            $prizeCollection,
            $lotteryRank,
            $lottery,
            $lotteryMessage,
            $lotteryName,
        ];
    }

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
        /** @var User $users */
        $key = "user:orderStatusFilter:" . implode($users->pluck('id')
                                                         ->toArray()) . "-" . $orderStatusesId;

        return Cache::remember($key, Config::get("constants.CACHE_3"), function () use ($users, $orderStatusesId) {

            return $users->whereIn('id', Order::whereIn("orderstatus_id", $orderStatusesId)
                                              ->pluck('user_id'));
        });

    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $roles
     * @return mixed
     */
    public function scopeRole($query, array $roles)
    {
        return $query->whereHas('roles', function ($q) use ($roles) {
            /** @var QueryBuilder $q */
            $q->whereIn("id", $roles);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where("userstatus_id" , config("constants.USER_STATUS_ACTIVE"));
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
                    ->where("orderstatus_id",config("constants.ORDER_STATUS_OPEN"));
    }

    public function getNumberOfProductsInBasketAttribute(){
        return $this->openOrders->getNumberOfProductsInThisOrderCollection();
    }

    public function userbons()
    {
        return $this->hasMany('\App\Userbon');
    }

    public function useruploads()
    {
        return $this->hasMany('\App\Userupload');
    }

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

    public function closedorderproducts()
    {
        return $this->hasManyThrough("\App\Orderproduct", "\App\Order")
                    ->whereNotIn("orders.orderstatus_id", Order::OPEN_ORDER_STATUSES);
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

    /*public function getRememberToken()
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
    }*/

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
//                    ->orderBy("products.created_at")
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
    public function userHasBon($bonName = null): int
    {
        if(is_null($bonName ))
            $bonName = config("constants.BON1");
        $key = "user:userHasBon:" . $this->cacheKey() . "-" . $bonName;

        return Cache::tags('bon')
                    ->remember($key, Config::get("constants.CACHE_60"), function () use ($bonName) {

                        $bon = Bon::all()
                                  ->where('name', $bonName)
                                  ->where('isEnable', '=', 1);
                        if ($bon->isEmpty())
                            return false;
                        /** @var Userbon $userbons */
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
        $time = isset($this->update_at) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s:%s-%s",
            $this->getTable(),
            $key,
            $time
        );
    }

    /**
     * returns user valid bons of the specified bons
     *
     * @param \app\Bon  $bon
     * @param User $user
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
                                          /** @var QueryBuilder $query */
                                          $query->whereNull("validSince")
                                                ->orwhere("validSince", "<", Carbon::now());
                                      })
                                      ->where(function ($query) {
                                          /** @var QueryBuilder $query */
                                          $query->whereNull("validUntil")
                                                ->orwhere("validUntil", ">", Carbon::now());
                                      })
                                      ->get();
                    });

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

    public function getPhotoAttribute($value)
    {
        $profileImage = ($value != null ? $value : Config::get('constants.PROFILE_DEFAULT_IMAGE'));
        $profileImage = route('image', ['category'=>'1','w'=>'39' , 'h'=>'39' ,  'filename' =>  $profileImage ]);

        return $profileImage;
    }

    public function getShortNameAttribute()
    {
        if(isset($this->firstName))
            return ucfirst($this->firstName);
        if(isset($this->lastName))
            return ucfirst($this->lastName);
        return 'کاربر آلایی';
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

    /**
     * Locks user's profile
     */
    public function lockProfile(): void
    {
        $this->lockProfile = 1;
    }

    /**
     * Compares user's password with a new password
     *
     * @param $password
     *
     * @return bool
     *  True : equal / False : not equal
     */
    public function compareWithCurrentPassword($password): bool
    {
        if (Hash::check($password, $this->password)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @param $newPassword
     */
    public function changePassword($newPassword): void
    {
        $this->fill(['password' => bcrypt($newPassword)]);
    }

    /**
     *  Determines whether user's profile is locked or not
     *
     * @return bool
     */
    public function isUserProfileLocked(): bool
    {
        return $this->lockProfile == 1;
    }

    /**
     * @return array
     */
    public static function getSecureFillable(): array
    {
        return self::$secureFillable;
    }

    /**
     * @return array
     */
    public static function getBeProtected(): array
    {
        return self::$beProtected;
    }

    public function getMajorInfoAttribute()
    {
        $major = $this->major;
        if (isset($major)) {
            $majorReturn = [
                'id'   => $major->id,
                'name' => $major->name,
                'description' => $major->description,
            ];
        } else {
            $majorReturn = null;
        }
        return $majorReturn;
    }

    public function getGradeInfoAttribute()
    {
        $grade = $this->grade;
        if (isset($grade)) {
            $gradeReturn = [
                'id'   => $grade->id,
                'name' => $grade->name,
                'hint' => $grade->displayName,
                'description' => $grade->description,
            ];
        } else {
            $gradeReturn = null;
        }
        return $gradeReturn;
    }

    public function getGenderInfoAttribute()
    {
        $gender = $this->gender;
        if (isset($gender)) {
            $genderReturn = [
                'id'   => $gender->id,
                'name' => $gender->name,
                'description' => $gender->description
            ];
        } else {
            $genderReturn = null;
        }
        return $genderReturn;
    }

    public function getCompletionInfoAttribute()
    {
        return (int)$this->completion();
    }

    public function getWalletInfoAttribute()
    {
        $wallets = $this->wallets()->with('walletType')->get();
        $walletsArrayForReturn = [];
        foreach ($wallets as $wallet) {
            array_push($walletsArrayForReturn, [
                'id' => $wallet->id,
                'name' => $wallet->walletType->name,
                'hint' => $wallet->walletType->displayName,
                'balance' => $this->getWalletBalance($wallet->wallettype_id)
            ]);
        }
        return $walletsArrayForReturn;
    }

    public function getOpenOrder(): Order {
        $openOrder = $this->firstOrCreateOpenOrder($this);
        return $openOrder;
    }
}
