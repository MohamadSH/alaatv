<?php

namespace App;

use Hash;
use Carbon\Carbon;
use App\Traits\Helper;
use App\Classes\Taggable;
use App\Traits\DateTrait;
use App\Traits\HasWallet;
use App\Traits\OrderCommon;
use App\Traits\CharacterCommon;
use App\HelpDesk\AgentInterface;
use App\Traits\APIRequestCommon;
use App\HelpDesk\Models\Category;
use App\Collection\UserCollection;
use Kalnoy\Nestedset\QueryBuilder;
use Laravel\Passport\HasApiTokens;
use App\HelpDesk\Traits\AgentTrait;
use App\Collection\ProductCollection;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Traits\MustVerifyMobileNumberTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use App\Classes\Verification\MustVerifyMobileNumber;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\User\{BonTrait,
    TrackTrait,
    LotteryTrait,
    MutatorTrait,
    PaymentTrait,
    ProfileTrait,
    TeacherTrait,
    VouchersTrait,
    DashboardTrait,
    TaggableUserTrait};

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
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAllergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBloodtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIntroducedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLockProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMedicalCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobileNumberVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordRegeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTechCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWhatsapp($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles)
 * @property string|null
 *               $nameSlug                 اسلاگ شده نام
 * @property-read mixed
 *                    $full_name_reverse
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNameSlug($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobileVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobileVerifiedCode($value)
 * @property string|null                                                              $email_verified_at
 * @property-read mixed                                                               $reverse_full_name
 * @property-write mixed                                                              $first_name
 * @property-write mixed                                                              $last_name
 * @property-write mixed                                                              $medical_condition
 * @property-write mixed                                                              $postal_code
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @property-read \App\Collection\OrderproductCollection|\App\Orderproduct[]          $closedorderproducts
 * @property mixed                                                                    mobile
 * @property string                                                                   lastName
 * @property string                                                                   firstName
 * @property int                                                                      id
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static select()
 * @property-read mixed                                                               $number_of_products_in_basket
 * @property-read mixed                                                               $short_name
 * @property-read mixed                                                               $completion_info
 * @property-read mixed                                                               $gender_info
 * @property-read mixed                                                               $grade_info
 * @property-read mixed                                                               $major_info
 * @property-read mixed                                                               $wallet_info
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read mixed                                                               $info
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[]  $tokens
 * @property mixed                                                                    openOrders
 * @property mixed                                                                    nameSlug
 * @property mixed                                                                    nationalCode
 * @property mixed                                                                    userstatus_id
 * @property mixed                                                                    techCode
 * @property string                                                                   password
 * @property int                                                                      lockProfile
 * @property string                                                                   photo
 * @property mixed                                                                    roles
 * @property static|null                                                              mobile_verified_at
 * @property mixed                                                                    closed_orders
 * @property mixed                                                                    email
 * @property-read \App\Collection\OrderCollections|\App\Order[]                       $closedOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Firebasetoken[]       $firebasetokens
 * @property-read mixed                                                               $user_status
 * @property mixed updated_at
 * @property mixed created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User orWhereRoleIs($role = '', $team = null)
 * @property string|null                                                        $lastServiceCall آخرین تماس کارمندان روابط عمومی با کاربر
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastServiceCall($value)
 */
class User extends Authenticatable implements Taggable, MustVerifyMobileNumber, MustVerifyEmail , AgentInterface
{
    use HasApiTokens;
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

    use DashboardTrait, MutatorTrait, TeacherTrait, LotteryTrait, PaymentTrait, BonTrait, VouchersTrait, TaggableUserTrait, ProfileTrait, TrackTrait;
    use AgentTrait;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'info',
        'full_name',
        'userstatus',
        'roles',
        'totalBonNumber',
        'jalaliCreatedAt',
        'jalaliUpdatedAt',
        'editLink',
        'removeLink',
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
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'birthdate',
        'email_verified_at',
    ];

    protected $lockProfileColumns = [
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'gender_id',
        'major_id',
        'email',
    ];

    //columns being used for locking user's profile
    protected $completeInfoColumns = [
        'photo',
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'gender_id',
        'major_id',
        'grade_id',
        'phone',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];

    protected $medicalInfoColumns = [
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile',
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
        'firstName',
        'lastName',
        'nationalCode',
        'nameSlug',
        'mobile',
        'userstatus_id',
        'techCode',
        'mobile_verified_code',
        'password' //For registering user
    ];

    protected $fillableByPublic = [
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
        'major',
        'major_id',
        'grade',
        'grade_id',
        'gender',
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
        'userbons'
    ];

    public static function getNullInstant($visibleArray = [])
    {
        $user = new User();
        foreach ($visibleArray as $key) {
            $user->$key = null;
        }
        return $user;
    }

    public static function roleFilter($users ,$rolesId){
        $users =  $users->whereHas('roles', function($q) use ($rolesId) {$q->whereIn("id", $rolesId);});
        return $users;
    }

    public static function majorFilter($users ,$majorsId){

        if (in_array(0, $majorsId))
            $users = $users->whereDoesntHave("major");
        else
            $users = $users->whereIn("major_id", $majorsId);

        return $users;
    }

    public function getAppToken()
    {
        $tokenResult = $this->createToken('Alaa App.');

        return [
            'access_token'     => $tokenResult->accessToken,
            'token_type'       => 'Bearer',
            'token_expires_at' => Carbon::parse($tokenResult->token->expires_at)
                ->toDateTimeString(),
        ];
    }

    public function routeNotificationForPhoneNumber()
    {
        return ltrim($this->mobile, '0');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return UserCollection
     */
    public function newCollection(array $models = [])
    {
        return new UserCollection($models);
    }


    /*
    |--------------------------------------------------------------------------
    | scope methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array                                  $roles
     *
     * @return mixed
     */
    public function scopeRole($query, array $roles)
    {
        return $query->whereHas('roles', function ($q) use ($roles) {
            /** @var QueryBuilder $q */
            $q->whereIn('id', $roles);
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @param  string                                 $roleName
     *
     * @return mixed
     */
    public function scopeRoleName($query, string $roleName)
    {
        $query->whereHas('roles', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     *
     * @param  string                                 $permissionName
     *
     * @return mixed
     */
    public function scopePermissionName($query, string $permissionName)
    {
        $query->whereHas('permissions', function ($q) use ($permissionName) {
            $q->where('name', $permissionName);
        });
    }



    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('userstatus_id', config('constants.USER_STATUS_ACTIVE'));
    }

    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */

    public function useruploads()
    {
        return $this->hasMany(Userupload::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function mbtianswers()
    {
        return $this->hasMany(Mbtianswer::class);
    }

    public function usersurveyanswers()
    {
        return $this->hasMany(Usersurveyanswer::class);
    }

    public function eventresults()
    {
        return $this->hasMany(Eventresult::class);
    }

    public function contracts(){
        return $this->hasMany(Contract::Class);
    }

    public function firebasetokens()
    {
        return $this->hasMany(Firebasetoken::class);
    }

    public function lotteries()
    {
        return $this->belongsToMany(Lottery::Class)
            ->withPivot("rank", "prizes");
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

    public function getOpenOrder(): Order
    {
        $openOrder = $this->firstOrCreateOpenOrder($this);

        return $openOrder;
    }

    /**
     * @param $products
     *
     * @return mixed
     */
    public function getOrdersThatHaveSpecificProduct(ProductCollection $products)
    {
        $validOrders = $this->orders()
            ->whereHas('orderproducts', function ($q) use ($products) {
                $q->whereIn('product_id', $products->pluck('id'));
            })
            ->whereIn('orderstatus_id', [
                config('constants.ORDER_STATUS_CLOSED'),
                config('constants.ORDER_STATUS_POSTED'),
                config('constants.ORDER_STATUS_READY_TO_POST'),
            ])
            ->whereIn('paymentstatus_id', [
                config('constants.PAYMENT_STATUS_PAID'),
            ])
            ->get();
        return $validOrders;
    }

    public function cacheKey()
    {
        $key  = $this->getKey();
        $time = (optional($this->updated_at)->timestamp ?: optional($this->created_at)->timestamp) ?: 0;

        return sprintf('%s:%s-%s', $this->getTable(), $key, $time);
    }

    /**
     * Get userstatus that belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userstatus()
    {
        return $this->belongsTo(Userstatus::class);
    }

    /**
     * Get related help categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function helpCategories()
    {
        return $this->belongsToMany(Category::class, 'help_categories_users',  'user_id','category_id');
    }
}
